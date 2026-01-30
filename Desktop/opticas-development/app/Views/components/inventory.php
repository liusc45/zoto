<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

    <?php if (in_array("admin",auth()->user()->getGroups())) :?>
        <?= $this->include('partials/inventoryStats')?>
    <?php endif; ?>

    <div class="card mt-4">
        <div class="card-datatable table-responsive pt-0">
            <table id="inventoryDatatable" class="datatables-basic table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>id</th>
                    <th>Código</th>
                    <th>Artículo</th>
                    <th>Tienda</th>
                    <th>Unidades</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
<?= $this->include('modals/transferArticle')?>
<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>

<script>
    var allStores = <?= json_encode($stores??[])?>

    select2Catalogs('tiendas');
    indexedStores = allStores.reduce((acc,current)=>{
        acc[current.id] = current
        return acc
    },[]);
    console.log('Inventory js loaded');
    var dt_basic_table = $('.datatables-basic'), dt_basic;
    $(function(){
        // Inventory datatable
        dt_basic = dt_basic_table.DataTable({
            ajax: {
                url: '/stock/store/<?=session("store")->id?>',
                dataSrc: ""
            },
            columns: [
                { data: '' },
                { data: 'item' },
                { data: 'item' },
                { data: 'code' },
                { data: 'item_name' },
                { data: 'store', render:function (data){
                        return 'Tienda por definir';
                    }
                    },
                { data: 'stock' },
                { data: '', render: function (data, type, row){
                        let articleJson = JSON.stringify(row);
                        return `
                                    <a href="javascript:void(0);" onclick='openStoreModal(${articleJson})'
                                        class='btn disabled btn-sm btn-text-secondary rounded-pill btn-icon item-edit'
                                        data-bs-toggle="modal" data-bs-target="#editStore">
                                        <i class='mdi mdi-pencil-outline'></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick='transferArticle(${articleJson})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit <?=(in_array("admin",auth()->user()->getGroups())) ? '' : 'disabled' ?>'
                                        data-bs-toggle="modal" data-bs-target="#transferArticle">
                                        <i class='mdi mdi-transfer'></i>
                                    </a>
                                    <a href="inventario/tienda/${row.store}/articulo/${row.item}"
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon'>
                                        <i class='mdi mdi-clipboard-list-outline'></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick='deleteStore(${articleJson})'
                                        class='btn disabled btn-sm btn-text-secondary rounded-pill btn-icon item-edit'>
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
            order: [[4, 'asc']],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 7,
            lengthMenu: [7,10, 25, 50, 75, 100],
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-label-primary dropdown-toggle me-2',
                    text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">Exportar</span>',
                    buttons: [
                        {
                            extend: 'csv',
                            text: '<i class="mdi mdi-file-excel-outline me-1"></i>CSV',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [3, 4, 5, 6],
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [3, 4, 5, 6]
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
                            return 'Detalles del artículo ';
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ?
                                `
                                <tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                                    <td>${col.title}:</td><td>${col.data}</td>
                                </tr>
                                `
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
        $('div.head-label').html('<h5 class="card-title mb-0">Inventario general</h5>');


        $("#transferArticleForm").on("submit",function(e){
            e.preventDefault();
            $('#confirmBtn').prop('disabled', true);
            let postData = $(this).serializeArray();
            $.ajax({
                method: "POST",
                url: "/transfer",
                data: postData,
                dataType :"JSON",
                statusCode:{
                    400:function(xhr)
                    {
                        toastAlert('warning','Información incorrecta', xhr.responseJSON.messages.error);
                    },
                    403:function(xhr)
                    {
                        toastAlert('warning','Acción prohibida', xhr.responseJSON.messages.error);
                    },
                    500:function(xhr)
                    {
                        toastAlert('error','Error','Ocurrió un problema, comunicate con el equipo de desarrollo');
                    },
                    201:function(xhr)
                    {
                        toastAlert('success','Transferencia exitosa','La transferencia se realizó correctamente');
                        $('#confirmBtn').prop('disabled', false);
                    }
                }
            }).done(function(response){
                dt_basic.ajax.reload();
            })

        })
    });

    function transferArticle(article)
    {
        console.log(article);
        $('#articlesTransfer').attr({
            "max": article.stock,
        });
        $("#uptotransfer").val(article.stock);
        $("#transferArticleID").val( article.item);
       // $("#inventoryID").val(article.id);
        document.getElementById("originStoreID").value = article.store;
        document.getElementById("articlesName").value = article.item_name;
    }


</script>
<?= $this->endSection() ?>
