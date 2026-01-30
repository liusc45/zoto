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
                <th></th>
                <th></th>
                <th>id</th>
                <th>Fecha</th>
                <th>Nombre(s)</th>
                <th>Apellidos</th>
                <th>Dirección</th>
                <th>Artículos p/entregar</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script>
    console.log('Deliver JS loaded')
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
    $(function(){

        // All sales datatable
        dt_basic = dt_basic_table.DataTable({
            ajax: {
                url: '/delivery',
                dataSrc: ""
            },
            columns: [
                { data: '' },
                { data: 'sale' },
                { data: 'sale' },
                { data: 'created_at', render:function (data){
                        let date = data.date.split(' ');
                        return date[0];
                    }
                },
                { data: 'customer_name'},
                { data: 'last_name'},
                { data: 'address'},
                { data: 'article_names' },
                { data: 'delivery', render:function (data){
                        let badge;
                        if (data === 'store' || data === 'delivered'){
                            badge = `<span class="badge rounded-pill bg-label-secondary">Entregado</span>`
                        } else {
                            badge = `<span class="badge rounded-pill bg-label-warning">Por entregar</span>`
                        }
                        return badge;
                    }
                },
                { data: '', render: function (data, type, row){
                        let saleJson = JSON.stringify(row);
                        return `
                            <a href="javascript:void(0);" onclick='confirmDelivery(${saleJson})'
                                class='btn btn-sm btn-text-secondary rounded-pill  btn-icon item-edit'>
                                <i class='mdi mdi-check-bold'></i>
                            </a>
                            <a href="/ticket/${row.uuid}" target="_blank"
                                class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'>
                                <i class='mdi mdi-receipt-text'></i>
                            </a>
                                `
                    }
                }
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    orderable: false,
                    searchable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    searchable: false,
                    responsivePriority: 3,
                    checkboxes: true,
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                    },
                    checkboxes: {
                        selectAllRender: '<input type="checkbox" class="form-check-input">'
                    }
                },
                {
                    targets: 2,
                    searchable: false,
                    visible: false
                },
                {
                    responsivePriority: 1,
                    targets: 4
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Acciones',
                    orderable: false,
                    searchable: false,
                }
            ],
            order: [[2, 'desc']],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 7,
            lengthMenu: [7,10, 25, 50, 75, 100],
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
                            return 'Detalles de la tienda ';
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
        $('div.head-label').html('<h5 class="card-title mb-0">Entregas por realizar</h5>');

    });

    function confirmDelivery(delivery) {
        console.log(delivery);
        Swal.fire({
            title: '¿Confirmas la entrega?',
            text: "Una vez confirmada, no podrás ver esta entrega.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, confirmar la entrega!',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                cancelButton: 'btn btn-outline-secondary waves-effect'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: '/sale/'+delivery.sale,
                    data: {
                        '_method': 'PATCH',
                        'delivery': 'delivered'
                    },
                    dataType: 'JSON',
                }).done(function(response){
                    Swal.fire({
                        icon: 'success',
                        title: '¡Entrega confirmada!',
                        customClass: {
                            confirmButton: 'btn btn-success waves-effect'
                        }
                    });
                    dt_basic.ajax.reload();
                })
            }
        });
    }
</script>

<?= $this->endSection() ?>
