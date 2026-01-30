<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
    <h4 class="py-3 col-lg-9">
        <span class="text-muted fw-light"><?= env('app.title')?> /</span> Ventas
    </h4>
    <div class="form-floating col-lg-3 form-floating-outline">
        <input type="text" id="bs-rangepicker-range" class="form-control" />
        <label for="bs-rangepicker-range">Fechas</label>
    </div>
</div>


<?=$this->include('partials/alerts');?>

<div class="card mt-4">
    <div class="card-datatable table-responsive pt-0">
        <table id="salesDatatable" class="datatables-basic table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th>Folio</th>
                <th>Fecha</th>
                <th>Paciente</th>
                <th>Artículos</th>
                <th>Tipo de venta</th>
                <th>Tipo de pago</th>
                <th>Monto</th>
                <th>Vendedor</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<div class="modal fade" id="commissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comisión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="commissionDetails">Calculando...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
<script src="/assets/vendor/libs/moment/moment.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script>
    var allStores = <?= json_encode(session("stores"))?>;
    let toDeliver;
    let saleTypes = {
        "cash" :"Contado",
        "aside":"Apartado",
        "credit":"Crédito"
    }
    let payment_types = {
        "cash"  :"Efectivo",
        "card"  :"Tarjeta",
        "transfer":"Transferencia"
    }
    
    indexedStores = allStores.reduce((acc,current)=>{
        acc[current.id] = current
        return acc
    },[]);
    console.log('All sales js loaded');
    var dt_basic_table = $('.datatables-basic'), dt_basic;
    let paymentType;
    let users;
    let deliverCounter = 0;
    $(function(){

        // All sales datatable
        dt_basic = dt_basic_table.DataTable({
            ajax: {
                url: '/sale'+location.search,
                dataSrc: ""
            },
            columns: [
                { data: 'id' },
                { data: 'id' ,render:function (data){
                        return ` <a href="/nueva-orden/venta/${data}"
                                class='btn btn-sm btn-text-primary rounded-pill  btn-icon item-edit'>
                                ${data}
                                <i class='mdi mdi-application-export'></i>
                            </a>`
                    }},
                { data: 'created_at', render:function (data){
                        let date = data.date.split(' ');
                        return date[0];
                    }
                },

                { data: 'patients' ,render: (data, type, row, meta)=>{
                    return `<a href="paciente/${row.patient}">${data}</a>`
                    } },
                { data: 'sold_items' },
                { data: 'type', render:function (data){
                        if(saleTypes[data] === undefined){
                            return "Por definir"
                        }
                        return saleTypes[data];
                    
                    }
                },
                { data: 'payment_type', render:function (data){
                        if(payment_types[data] === undefined){
                            return "Por definir"
                        }
                        return payment_types[data];
                    }
                },

                { data: 'amount', render:function (data){
                        return formatMoney(data);
                    }
                },

                { data: 'username'},
                { data: '', render: function (data, type, row){
                        let saleJson = JSON.stringify(row);
                        return `
                            <a href="javascript:void(0);" onclick='openSaleModal(${saleJson})'
                                class='btn btn-sm btn-text-secondary rounded-pill disabled btn-icon item-edit'
                                data-bs-toggle="modal" data-bs-target="#editStore">
                                <i class='mdi mdi-pencil-outline'></i>
                            </a>
                            <a href="/ticket/${row.uuid}" target="_blank"
                                class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'>
                                <i class='mdi mdi-receipt-text'></i>
                            </a>
                            <a href="javascript:void(0);" onclick='deleteSale(${saleJson})'
                                class='btn btn-sm btn-text-secondary rounded-pill  btn-icon item-edit'>
                                <i class='mdi mdi-delete'></i>
                            </a>

                            <a href="/nueva-orden/venta/${row.id}/paciente/${row.patient}"
                                class='btn btn-sm btn-text-secondary rounded-pill  btn-icon item-edit'>
                                <i class='mdi mdi-application-export'></i>
                            </a>
                            <a href="javascript:void(0);" onclick='openCommission(${saleJson})'
                                class='btn btn-sm btn-text-primary rounded-pill  btn-icon item-edit' title='Comisión'>
                                <i class='mdi mdi-cash'></i>
                            </a>
                            <a href="javascript:void(0);" onclick='payCommission(${saleJson})'
                                class='btn btn-sm btn-text-success rounded-pill  btn-icon item-edit' title='Marcar como pagada'>
                                <i class='mdi mdi-cash-check'></i>
                            </a>
                            <a href="/facturas?sale=${row.id}&customer=${encodeURIComponent(row.patients || '')}" 
                                class='btn btn-sm btn-text-primary rounded-pill  btn-icon item-edit' title='Facturar'>
                                <i class='mdi mdi-file-document-outline'></i>
                            </a>`
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
                // {
                //     // For Checkboxes
                //     targets: 1,
                //     orderable: false,
                //     searchable: false,
                //     responsivePriority: 3,
                //     checkboxes: true,
                //     render: function () {
                //         return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                //     },
                //     checkboxes: {
                //         selectAllRender: '<input type="checkbox" class="form-check-input">'
                //     }
                // },
                
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
            displayLength: 10,
            lengthMenu: [7,10, 25, 50, 75, 100],
            buttons: [
                // Tickets button
                {
                    className: 'btn btn-label-primary me-2',
                    text: '<i class="mdi mdi-calendar me-sm-1"></i> <span class="d-none d-sm-inline-block">Tickets</span>',
                    action: function ( e, dt, node, config ) {
                        getTickets();
                    }
                },
                // Export button
                {
                        extend: 'collection',
                        className: 'btn btn-label-primary dropdown-toggle me-2',
                        text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">Exportar</span>',
                        buttons: [
                            {
                                extend: 'csv',
                                text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1,2,3,4,5,6,7,9]
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [1,2,3,4,5,6,7,9],
                                }
                            }
                        ]
                    }
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
        $('div.head-label').html('<h5 class="card-title mb-0">Histórico de ventas</h5>');

    });

    function blocking()
    {
        $('#card-block').block({
            message: '<div class="spinner-border text-primary" role="status"></div>',
            timeout: 2000,
            css: {
                backgroundColor: 'transparent',
                border: '0'
            },
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8
            }
        });
    }

    function deleteSale(sale)
    {
        console.log(sale);
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No serás capaz de recuperar esta venta y el artículo regresará al inventario de la tienda",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar venta!',
            cancelButtonText: 'Regresar',
            customClass: {
                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                cancelButton: 'btn btn-outline-secondary waves-effect'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'POST',
                    url: '/sale/'+sale.id,
                    data: {
                        '_method': 'DELETE'
                    },
                    dataType: 'JSON'
                }).done(function(response){
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: '¡Venta cancelada!',
                        customClass: {
                            confirmButton: 'btn btn-success waves-effect'
                        }
                    });
                    dt_basic.ajax.reload();
                })
            }
        });
    }


    function getTickets()
    {
        let params = location.search;
        window.open('/tickets'+params, '_blank');
    }


    function openCommission(row){
        $('#commissionDetails').html('Calculando...');
        var modal = new bootstrap.Modal(document.getElementById('commissionModal'));
        modal.show();
        $.getJSON('/commission/calculate/'+row.id).done(function(data){
            $('#commissionDetails').html(`
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between"><span>Vendedor</span><strong>${row.username}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Comisionable</span><strong>${formatMoney(data.commissionable_amount)}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Impuestos</span><strong>${formatMoney(data.taxes_amount)}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Comisión bancaria</span><strong>${formatMoney(data.bank_commission_amount)}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Neto</span><strong>${formatMoney(data.net_amount)}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Comisión a pagar</span><strong>${formatMoney(data.commission_amount)}</strong></li>
                    <li class="list-group-item d-flex justify-content-between"><span>Estatus</span><strong>${data.status}</strong></li>
                </ul>
            `);
        }).fail(function(xhr){
            $('#commissionDetails').html('<div class="alert alert-danger">No fue posible calcular la comisión</div>');
        });
    }
    function payCommission(row){
        $.post('/commission/pay/'+row.id).done(function(){
            Swal.fire({icon:'success', title:'Comisión marcada como pagada'});
        }).fail(function(xhr){
            Swal.fire({icon:'error', title: xhr.responseJSON?.messages?.error || 'No se pudo marcar como pagada'});
        });
    }
</script>
<?= $this->endSection() ?>





