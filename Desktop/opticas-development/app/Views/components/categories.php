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
<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> Categorías</h4>

<?=$this->include('partials/alerts');?>

<div id="card-block" class="card">
    <div class="card-header d-flex flex-column">
        <h5 class="mb-0">Nueva categoría</h5>
        <small class="text-body float-end">Algunos campos son obligatorios</small>
    </div>
    <div class="card-body">
        <form id="storeForm" class="needs-validation" >
            <div class="row">
                <div class="col-md-4">
                    <!-- Name -->
                    <div class="input-group input-group-merge mb-4">
                      <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="mdi mdi-text-box-edit-outline"></i
                          ></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                required
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                placeholder="Linea blanca"
                                aria-label="Linea blanca"
                                aria-describedby="basic-icon-default-fullname2" />
                            <label for="basic-icon-default-fullname">Nombre</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- Description -->
                    <div class="input-group input-group-merge mb-4">
                      <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="mdi mdi-text-box-edit-outline"></i
                          ></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                    type="text"
                                    class="form-control"
                                    id="description"
                                    name="description"
                                    placeholder="Linea blanca"
                                    aria-label="Linea blanca"
                                    aria-describedby="basic-icon-default-fullname2" />
                            <label for="basic-icon-default-fullname">Descripción</label>
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
        <table id="storeDatatable" class="datatables-basic table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th>id</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<?= $this->include('modals/editCategory')?>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script>
    console.log('Store js loaded');
    var dt_basic_table = $('.datatables-basic'), dt_basic;
    $(function(){
        // Transaction form
        $("form").on("submit",function(e){
            e.preventDefault();
            blocking();
            let categoryData = $(this).serializeArray();

            $.ajax({
                method: "POST",
                url: "/itemCategory",
                dataType: "JSON",
                data: categoryData,
            }).done(function(category){
                if(category.id != null){
                    toastAlert('success','Categoría creada','Categoría guardada exitosamente');
                    $('#storeForm')[0].reset();
                    dt_basic.ajax.reload();
                }else{
                    toastAlert('error','Error','Ocurrió un problema al guardar');
                }
            });
        });

        // Category datatable
        dt_basic = dt_basic_table.DataTable({
            ajax: {
                url: '/itemCategory',
                dataSrc: ""
            },
            columns: [
                { data: '' },
                { data: 'id' },
                { data: 'id' },
                { data: 'name' },
                { data: 'description' },
                { data: '', render: function (data, type, row){
                    let categoryJson = JSON.stringify(row);
                        return `
                                    <a href="javascript:void(0);" onclick='openCategoryModal(${categoryJson})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'
                                        data-bs-toggle="modal" data-bs-target="#editCategory">
                                        <i class='mdi mdi-pencil-outline'></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick='deleteCategory(${categoryJson})'
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
                    // Label
                    targets: -2,
                    render: function (data, type, full, meta) {
                        var $status_number = full['status'];
                        var $status = {
                            1: { title: 'Current', class: 'bg-label-primary' },
                            2: { title: 'Professional', class: ' bg-label-success' },
                            3: { title: 'Rejected', class: ' bg-label-danger' },
                            4: { title: 'Resigned', class: ' bg-label-warning' },
                            5: { title: 'Applied', class: ' bg-label-info' }
                        };
                        if (typeof $status[$status_number] === 'undefined') {
                            return data;
                        }
                        return (
                            '<span class="badge rounded-pill ' +
                            $status[$status_number].class +
                            '">' +
                            $status[$status_number].title +
                            '</span>'
                        );
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
        $('div.head-label').html('<h5 class="card-title mb-0">Relación de categorías</h5>');


        $("#editItemCategoryForm").on("submit", event=>{
            event.preventDefault();
        })

        $("#editItemCategoryForm input").on("change",event=>{
            let postData = {
                '_method': 'PATCH'
            };
            postData[event.currentTarget.name]=event.currentTarget.value;
            let updatedCell = event.currentTarget.name+$('#modalEditStoreID').val();
            editItemCategory(postData, updatedCell, event.currentTarget.name);
        });
    });

    function openCategoryModal(category)
    {
        document.getElementById("modalEditCategoryID").value = category.id;
        document.getElementById("modalEditCategoryName").value = category.name;
        document.getElementById("modalEditCategoryDescription").value = category.description;
    }

    function editItemCategory(postData, updatedCell, updated)
    {
        $.ajax({
            method: 'POST',
            url: '/itemCategory/'+$('#modalEditCategoryID').val(),
            data: postData,
            dataType: 'JSON',
        }).done(function(response){
            if(response){
                toastAlert('success','Categoría actualizada','Categoría actualizada exitosamente');
                dt_basic.ajax.reload();
            } else{
                toastAlert('error','Error','Ocurrió un problema al guardar');
            }
        });
    }
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

    function deleteCategory(category)
    {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No serás capaz de recuperar esta categoría",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, borrar categoría!',
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
                    url: '/itemCategory/'+category.id,
                    data: { '_method': 'DELETE'},
                    dataType: 'JSON'
                }).done(function(response){
                    Swal.fire({
                        icon: 'success',
                        title: '¡Categoría borrada!',
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
