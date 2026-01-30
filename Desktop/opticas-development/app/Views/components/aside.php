<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

<div class="card mt-4">
	<div class="card-datatable table-responsive pt-0">
		<table id="storeDatatable" class="datatables-basic table table-bordered">
			<thead>
			<tr>
				<th>id</th>
				<th>sale</th>
				<th>Fecha</th>
				<th>Nombre(s)</th>
				<th>Tiempo</th>
				<th>Ult. Pago</th>
                <th>uuid</th>
                <th>Pendiente</th>
                <th>Acciones</th>
			</tr>
			</thead>
			<?php foreach($asides as $key => $aside):?>
                <tr>
                    <td><?=$aside->id?></td>
                    <td><?=$aside->sale?></td>
                    <td><?=$aside->created_at->toDateString()?></td>
                    <td><?=$aside->patient_obj->name ." ".$aside->patient_obj->last_name?></td>
                    <td><?=$aside->last_payment_date->humanize()?></td>
                    <td><?=$aside->days_since?></td>
                    <td><?=$aside->uuid?></td>
                    <td><?=$aside->debt?></td>
                    <td></td>
                </tr>
			<?php endforeach;?>
		</table>
	</div>
</div>


<?=$this->include('modals/addAsidePayment');?>
<?=$this->include('modals/asideItems');?>
<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/moment/moment.js"></script>
<script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script>
    console.log('Aside JS loaded')
    var allStores = <?= json_encode($stores)?>;
    let toDeliver;
    indexedStores = allStores.reduce((acc,current)=>{
        acc[current.id] = current
        return acc
    },[]);
    var dt_basic_table = $('.datatables-basic'), dt_basic;
    let paymentType;
    let users;
    let deliverCounter = 0;
    let saleSentinel = false;
    let asideSentinel = false;
    $(function(){

        // All sales datatable
        dt_basic = dt_basic_table.DataTable({
           columnDefs: [
                {
                    targets: -1,
                    render: function (data, type, row) {
                        let asideJson = JSON.stringify(row);
                        let debt = parseFloat(row[7]);
                        let actionBtn='';
                        if(debt === 0.00){
                            actionBtn = `
                                <a  class="text-body"
                                    onclick='deliverAside(${asideJson})'
                                    title="Cerrar apartado">
                                    <i class="mdi mdi-truck-delivery mdi-20px mx-1"></i>
                                </a>
                            `
                        }
                        return (`
                            <div class="d-flex align-items-center">
                                <a  class="text-body"
                                    data-bs-toggle="modal"
                                    data-bs-target="#asideItems"
                                    onclick='getItemsAside(${asideJson})'
                                    title="Registrar abono">
                                    <i class="mdi mdi-details mdi-20px mx-1"></i>
                                </a>
                                <a  class="text-body"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addNewAsidePayment"
                                    onclick='asideData(${asideJson})'
                                    title="Registrar abono">
                                    <i class="mdi mdi-cash-plus mdi-20px mx-1"></i>
                                </a>
                                <a  class="text-body"
                                    href='/apartado/${row[6]}'
                                    target="_blank"
                                    title="Historial de pagos">
                                    <i class="mdi mdi-format-list-numbered mdi-20px mx-1"></i>
                                </a>
                                ${actionBtn}
                            </div>
                        `);
                    }
                },
                {
                    targets: 5,
                    render: function (data, type, row) {
                        let days = parseInt(data);
                        let color = ['success', 'warning', 'danger'];
                        let bg;
                        if (days >= 0 && days <= 30) {
                            bg = color[0];
                        } else if (days >= 31 && days <= 60) {
                            bg = color[1];
                        }else {
                            bg = color[2];
                        }
                        return (`
                            <span class="badge rounded-pill bg-label-${bg}">${days} días</span>
                        `);
                    }
                },
                {
                    targets: 1,
                    visible: false,
                    searchable: false
                },
                {
                    targets: 6,
                    visible: false,
                    searchable: false
                }
            ],
            order: [[1, 'ASC']],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
            buttons: [
                /*                        {
                                            extend: 'collection',
                                            className: 'btn btn-label-primary dropdown-toggle me-2',
                                            text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">Exportar</span>',
                                            buttons: [
                                                {
                                                    extend: 'pdf',
                                                    text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                                                    className: 'dropdown-item',
                                                    exportOptions: {
                                                        columns: [3, 4, 5, 6, 7],
                                                        // prevent avatar to be display
                                                        format: {
                                                            body: function (inner, coldex, rowdex) {
                                                                if (inner.length <= 0) return inner;
                                                                var el = $.parseHTML(inner);
                                                                var result = '';
                                                                $.each(el, function (index, item) {
                                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                                        result = result + item.lastChild.firstChild.textContent;
                                                                    } else if (item.innerText === undefined) {
                                                                        result = result + item.textContent;
                                                                    } else result = result + item.innerText;
                                                                });
                                                                return result;
                                                            }
                                                        }
                                                    }
                                                },
                                                {
                                                    extend: 'pdf',
                                                    text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                                                    className: 'dropdown-item',
                                                    exportOptions: {
                                                        columns: [3, 4, 5, 6, 7],
                                                        // prevent avatar to be display
                                                        format: {
                                                            body: function (inner, coldex, rowdex) {
                                                                if (inner.length <= 0) return inner;
                                                                var el = $.parseHTML(inner);
                                                                var result = '';
                                                                $.each(el, function (index, item) {
                                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                                        result = result + item.lastChild.firstChild.textContent;
                                                                    } else if (item.innerText === undefined) {
                                                                        result = result + item.textContent;
                                                                    } else result = result + item.innerText;
                                                                });
                                                                return result;
                                                            }
                                                        }
                                                    }
                                                }
                                            ]
                                        }*/
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Detalles del apartado ';
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            },
            language: {
                url: '//cdn.datatables.net/plug-ins/2.0.8/i18n/es-MX.json',
            },
        });
        $('div.head-label').html('<h5 class="card-title mb-0">Apartados realizados</h5>');


        $("form#newAsidePaymentForm").on("submit",function(e){
            e.preventDefault();
            blocking();
            let asidePaymentData = $(this).serializeArray();
            $.ajax({
                method: "POST",
                url: "/payment",
                dataType: "JSON",
                data: asidePaymentData,
            }).done(function(payment){
                if (payment.id){
                    toastAlert('success','Abono registrado','El abono se registró exitosamente, en breve se recargará la página');
                    location.reload();
                }else {
                    toastAlert('error','Error','Ocurrió un problema, por favor intenta nuevamente');
                }
            });
        });
    });

    function asideData(aside)
    {
        document.getElementById("client").value = aside[3];
        document.getElementById("name").value = aside[4];
        document.getElementById("aside").value = aside[0];
        document.getElementById("sale").value = aside[1];
    }

    function calculate()
    {
        let cashPayment = document.getElementById("amount").value;
        let cashReceived = document.getElementById("cash").value;
        let cashback = cashReceived - cashPayment;
        document.getElementById("cashback").value = cashback;
    }

    function deliverAside(aside)
    {
        sale = aside[1];
        aside = aside[0];
        $.ajax({
            method: 'POST',
            url: '/sale/'+sale,
            data: {
                _method: 'PUT',
                'delivery': 'pending'
            },
            dataType: 'JSON',
            statusCode: {
                200: function(response){
                    toastAlert('success', 'Apartado cerrado', 'Articulo listo para ser entregado')
                },
                400: function(response){
                    toastAlert('error', 'Algo salió mal', 'Por favor, intenta de nuevo')
                }
            }
            }).done(function(response){
                saleSentinel = true;
                reloadWatcher();
        })
        $.ajax({
            method: 'POST',
            url: '/aside/'+aside,
            data: {
                _method: 'DELETE'
            },
            dataType: 'JSON',
            }).done(function(response){
                asideSentinel = true;
                reloadWatcher();
        })
    }

    function reloadWatcher()
    {
        if (saleSentinel && asideSentinel){
            location.reload();
        }
    }

    function getItemsAside(aside)
    {
        console.log(aside);
        let items='';
        let item='';
        let itemArray = [];
        $('#asideItemsList').html(' ');
        $.ajax({
            method: 'GET',
            url: '/aside/items/'+aside[0],
            dataType: 'JSON'
            }).done(function(response){
            console.log(response)
                items = response.item_name;
                itemArray = items.split(',');
                for (let itemTxt of itemArray) {
                    item += `
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action waves-effect">${itemTxt}</a>
                    `
                }
                $('#asideItemsList').html(item);
            })
    }
</script>

<?= $this->endSection() ?>
