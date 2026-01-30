<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"
      xmlns="http://www.w3.org/1999/html"/>

<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?=$this->include('partials/breadcrumb');?>

<div id="card-block" class="card">
    <div class="card-header d-flex flex-column">
        <h5 class="mb-0">Nuevo Empleado</h5>
        <small class="text-body float-end">Algunos campos son obligatorios</small>
    </div>
   <?=$this->include('partials/person');?>

</div>

<div class="card mt-4">
    <div class="card-datatable table-responsive pt-0">
        <table id="suppliersDatatable" class="datatables-basic table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th>id</th>
                <th>usuario</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<?= $this->include('modals/editSupplier')?>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/moment/moment.js"></script>
<script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="/assets/vendor/libs/select2/select2.js"></script>
<script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

<script>
    const flatpickrOptions = {

        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        locale: "es",
        onChange: function(selectedDates, dateStr, instance) {
            console.log(instance)
            if(instance.input.id === 'modal-flatpickr-date') {
                let postData = {
                    '_method': 'PATCH',
                    dob: dateStr
                };
                editCustomer(postData);
            }
        },

    }
    console.log('Suppliers js loaded');
    var dt_basic_table = $('#suppliersDatatable'), dt_basic;
    $(function(){
        $("#person-dob").flatpickr(flatpickrOptions);

        // Transaction form
        $("form").on("submit",function(e){
            e.preventDefault();
            blocking();
            let employeeData = $(this).serializeArray();

            $.ajax({
                method: "POST",
                url: "/employee",
                dataType: "JSON",
                data: employeeData,
            }).done(function(employee){

                toastAlert("success","Información guardada","Empleado guardado exitosamente");
                $("#card-block").unblock();
                dt_basic.ajax.reload();

            });
        });

        // Store datatable
        dt_basic = dt_basic_table.DataTable({
            ajax: {
                url: '/employee',
                dataSrc: ""
            },
            columns: [
                { data: '' },
                { data: 'employee' },
                { data: 'username' },
                { data: 'name' ,
                render: function (data, type, row, ) {
                    return `<a href="javascript:void(0);" onclick="openPersonModal('+JSON.stringify(row)+')" class="user-name">${data??'sin nombre'} ${row.last_name??''}</a>`;
                }},
                { data: 'email' },
                { data: 'main_phone' },
                { data: '', render: function (data, type, row){
                        let supplierJson = JSON.stringify(row);
                        return `
                                    <a href="javascript:void(0);" onclick='openPersonModal(${supplierJson})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'
                                        data-bs-toggle="modal" data-bs-target="#editSupplier">
                                        <i class='mdi mdi-pencil-outline'></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick='deletePerson(${supplierJson})'
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
            order: [[3, 'asc']],
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
                            return 'Detalles del proveedor';
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
        $('div.head-label').html('<h5 class="card-title mb-0">Relación de Empleados</h5>');

        $("#editSupplierForm").on("submit", event=>{
            event.preventDefault();
        })

        $("#editSupplierForm input").on("change",event=>{
            let postData = {
                '_method': 'PATCH'
            };
            postData[event.currentTarget.name]=event.currentTarget.value;
            let updatedCell = event.currentTarget.name+$('#modalEditStoreID').val();
            editSupplier(postData, updatedCell, event.currentTarget.name);
        });
    });

    function blocking()
    {
        $('#card-block').block({
            message: '<div class="spinner-border text-primary" role="status"></div>',
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

    function openPersonModal(supplier)
    {
        document.getElementById("modalEditSupplierID").value = supplier.id;
        document.getElementById("modalEditSupplierName").value = supplier.name;
        document.getElementById("modalEditSupplierAddress").value = supplier.address;
        document.getElementById("modalEditSupplierPhone").value = supplier.phone;
    }

    function editSupplier(postData, updatedCell, updated)
    {
        $.ajax({
            method: 'POST',
            url: '/supplier/'+$('#modalEditSupplierID').val(),
            data: postData,
            dataType: 'JSON',
        }).done(function(response){
            if(response){
                $('#editSuccessAlertText').text('Proveedor actualizado exitosamente');
                $('#editSuccessAlert').removeClass('d-none');
                setTimeout(function(){
                    $('#editSuccessAlert').addClass('d-none');
                }, 2000);
                dt_basic.ajax.reload();
            } else{
                $('#editFailAlertText').text('Ocurrió un problema al actualizar');
                $('#editFailAlert').removeClass('d-none');
                setTimeout(function(){
                    $('#editFailAlert').addClass('d-none');
                }, 2000);
            }
        });
    }

    function deletePerson(supplier)
    {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No serás capaz de recuperar este proveedor",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, borrar proveedor!',
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
                    url: '/supplier/'+supplier.id,
                    data: { '_method': 'DELETE'},
                    dataType: 'JSON'
                }).done(function(response){
                    Swal.fire({
                        icon: 'success',
                        title: '¡Proveedor borrado!',
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
