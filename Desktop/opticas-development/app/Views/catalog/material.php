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
<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> Materiales</h4>

<div id="card-block" class="card">
    <div class="card-header d-flex flex-column">
        <h5 class="mb-0">Nueva material</h5>
    </div>
    <div class="card-body">
        <form id="MaterialForm" class="needs-validation" >
            <div class="row">
                <div class="col-md-12">
                    <!-- Title -->
                    <div class="input-group input-group-merge mb-4">
                      <span id="basic-icon-default-fullname2" class="input-group-text">
                          <i class="mdi mdi-text-box-edit-outline"></i>
                      </span>
                        <div class="form-floating form-floating-outline">
                            <input
                                required
                                type="text"
                                class="form-control"
                                id="material"
                                name="material"
                                placeholder="Titanio"
                                aria-label="Titanio"
                                aria-describedby="basic-icon-default-fullname2" />
                            <label for="basic-icon-default-fullname">Material</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save button -->
            <button class="btn btn-primary btn-card-block-overlay">Guardar</button>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-datatable table-responsive pt-0">
        <table id="occupationDatatable" class="datatables-basic table table-bordered">
            <thead>
            <tr>
                <th>id</th>
                <th>Material</th>
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
    console.log('Material js loaded');
    var dt_basic_table = $('.datatables-basic'), dt_basic;

    $(function(){
        // Transaction form
        $("form").on("submit",function(e){
            e.preventDefault();
            blocking();
            let materialData = $(this).serializeArray();

            $.ajax({
                method: "POST",
                url: "/material",
                dataType: "JSON",
                data: materialData,
            }).done(function(material){
                if(material.id != null){
                    toastAlert('success','Material creado','Material guardado exitosamente');
                    $('#MaterialForm')[0].reset();
                    dt_basic.ajax.reload();
                }else{
                    toastAlert('error','Error','Ocurrió un problema al guardar');
                }
            });
        });

        // Category datatable
        dt_basic = dt_basic_table.DataTable({
            ajax: {
                url: '/material',
                dataSrc: ""
            },
            columns: [
                { data: 'id' },
                { data: 'material' },
                { data: '', render: function (data, type, row){
                        let materialJson = JSON.stringify(row);
                        return `
                            <a href="javascript:void(0);" onclick='deleteOccupation(${materialJson})'
                                class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'>
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
                                ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                                        <td>${col.title}:</td>
                                        <td>${col.data}</td>
                                   </tr>`
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            }
        });
        $('div.head-label').html('<h5 class="card-title mb-0">Relación de lineas</h5>');
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

    function deleteOccupation(material)
    {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No serás capaz de recuperar esta material",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, borrar material!',
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
                    url: '/material/'+material.id,
                    data: { '_method': 'DELETE'},
                    dataType: 'JSON'
                }).done(function(response){
                    toastAlert('success','Material borrado','Sigamos con el buen trabajo');
                    dt_basic.ajax.reload();
                })
            }
        });
    }
</script>
<?= $this->endSection() ?>
