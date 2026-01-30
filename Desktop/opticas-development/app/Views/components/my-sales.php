<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/css/pages/page-profile.css" />
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Perfil del usuario:</span><span id="user-name"></span></h4>

<!-- Header -->
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mt-4">
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    <img
                        src="/assets/img/avatars/1.png"
                        alt="user image"
                        class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                    <div
                        class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                        <div class="user-profile-info">
                            <h4 id="user-name2"></h4>
                            <ul
                                class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                <li class="list-inline-item">
                                    <i class="mdi mdi-account-outline me-1 mdi-20px"></i
                                    ><span class="fw-medium" id="user"></span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="mdi mdi-map-marker-outline me-1 mdi-20px"></i
                                    ><span class="fw-medium" id="store"></span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="mdi mdi-calendar-blank-outline me-1 mdi-20px"></i
                                    ><span class="fw-medium"> Alta April 2021</span>
                                </li>
                            </ul>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary">
                            <i class="mdi mdi-account-check-outline me-1"></i>Conectado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Header -->

<!-- Navbar pills -->
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-sm-row mb-4">
            <li class="nav-item">
                <a class="nav-link" href="/perfil"
                ><i class="mdi mdi-account-outline me-1 mdi-20px"></i>Perfil</a
                >
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="pages-profile-teams.html"
                ><i class="mdi mdi-finance me-1 mdi-20px"></i>Estadisticas</a
                >
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/mis-ventas"
                ><i class="mdi mdi-archive me-1 mdi-20px"></i>Historial</a
                >
            </li>
        </ul>
    </div>
</div>
<!--/ Navbar pills -->

<div class="card mt-4">
    <div class="card-datatable table-responsive pt-0">
        <table id="storeDatatable" class="datatables-basic table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th>id</th>
                <th>Fecha</th>
                <th>Tienda</th>
                <th>Artículos</th>
                <th>Tipo de pago</th>
                <th>Descuento</th>
                <th>Monto</th>
                <th>Estatus</th>
                <th>Vendedor</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script>
    console.log('My Sles JS loaded');
    var allStores = <?= json_encode($stores)?>;

    indexedStores = allStores.reduce((acc,current)=>{
        acc[current.id] = current
        return acc
    },[]);

    var dt_basic_table = $('.datatables-basic'), dt_basic;

    $(function () {

        $.ajax({
            method: 'GET',
            url: '/user/'+<?=session()->user['id']?>,
            dataType: 'JSON'
        }).done(function(user){
            $('#user-name, #user-name2, #user-name3').text(user.name + ' ' + user.last_name);
            $('#user').text(user.username);
            $('#store').text(user.store);
            if (user.active === true){
                $('#active').text('Activo');
            }else {
                $('#active').text('Desactivado');
            }
        })

        // All sales datatable
        dt_basic = dt_basic_table.DataTable({
            ajax: {
                url: '/sale/user/'+<?=session()->user['id']?>,
                dataSrc: ""
            },
            columns: [
                { data: '' },
                { data: 'id' },
                { data: 'id' },
                { data: 'created_at', render:function (data){
                        let date = data.date.split(' ');
                        return date[0];
                    }
                },
                { data: 'store', render:function (data){
                        return indexedStores[data].name;
                    }},
                { data: 'items' },
                { data: 'payment_type', render:function (data){
                        switch (data) {
                            case 'cash':
                                paymentType = 'Efectivo'
                                break;
                            case 'card':
                                paymentType = 'Tarjeta'
                                break;
                            case 'transfer':
                                paymentType = 'Transferencia'
                                break;
                            case 'credit':
                                paymentType = 'Crédito'
                                break;
                            default:
                                paymentType = 'Por confirmar'
                        }
                        return paymentType;
                    }
                },
                { data: 'discount', render:function (data){
                        let badge;
                        if (data === null){
                            badge = `<span class="badge rounded-pill bg-label-secondary">Sin descuento</span>`
                        } else {
                            let discountFormat = '$'+formatMoney(data);
                            badge = `<span class="badge rounded-pill bg-label-primary">${discountFormat}</span>`
                        }
                        return badge;
                    }
                },
                { data: 'amount', render:function (data){
                        let amountFormat = '$'+formatMoney(data);
                        return amountFormat;
                    }
                },
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
                { data: 'username'},
                { data: '', render: function (data, type, row){
                        let storeJson = JSON.stringify(row);
                        return `
                            <a href="javascript:void(0);" onclick='openStoreModal(${storeJson})'
                                class='btn btn-sm btn-text-secondary rounded-pill disabled btn-icon item-edit'
                                data-bs-toggle="modal" data-bs-target="#editStore">
                                <i class='mdi mdi-pencil-outline'></i>
                            </a>
                            <a href="/ticket/${row.uuid}" target="_blank"
                                class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'>
                                <i class='mdi mdi-receipt-text'></i>
                            </a>
                            <a href="javascript:void(0);" onclick='deleteStore(${storeJson})'
                                class='btn btn-sm btn-text-secondary rounded-pill disabled btn-icon item-edit'>
                                <i class='mdi mdi-delete'></i>
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
            }
        });
        $('div.head-label').html('<h5 class="card-title mb-0">Historico de ventas</h5>');
    });


</script>
<?= $this->endSection() ?>
