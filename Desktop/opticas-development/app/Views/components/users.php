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

<?=$this->include('partials/alerts');?>
    <div id="card-block" class="card">
        <div class="card-header d-flex flex-column">
            <h5 class="mb-0">Nuevo usuario</h5>
            <small class="text-body float-end">Algunos campos son obligatorios</small>
        </div>
        <div class="card-body">
            <form id="userForm" class="needs-validation">
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-4">
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-account-tie"></i
                              ></span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        name="name"
                                        placeholder="Christian Guillermo"
                                        aria-label="Christian Guillermo"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Nombre(s)</label>
                            </div>
                        </div>
                    </div>
                    <!-- Last Name -->
                    <div class="col-md-4">
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-account-tie"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="text"
                                        class="form-control"
                                        id="last_name"
                                        name="last_name"
                                        placeholder="Hernández Landa"
                                        aria-label="Hernández Landa"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Apellidos</label>
                            </div>
                        </div>
                    </div>
                    <!-- Store -->
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" name="store" id="storeStockSelect2" aria-label="Default select example"></select>
                            <label for="exampleFormControlSelect1">Tienda</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Phone -->
                    <div class="col-md-4">
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-cellphone"></i
                              ></span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="text"
                                        class="form-control"
                                        id="phone"
                                        name="phone"
                                        placeholder="5544231212"
                                        aria-label="5544231212"
                                        minlength="10"
                                        maxlength="10"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Teléfono</label>
                            </div>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="col-md-4">
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-email"></i
                              ></span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        type="text"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        placeholder="chernandez@outlook.com"
                                        aria-label="chernandez@outlook.com"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Email</label>
                            </div>
                        </div>
                    </div>
                    <!-- User -->
                    <div class="col-md-4">
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-account-plus"></i
                              ></span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="text"
                                        class="form-control"
                                        id="username"
                                        name="username"
                                        placeholder="chernandez"
                                        aria-label="chernandez"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Usuario</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Pass -->
                    <div class="col-md-6">
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-lock"></i
                              ></span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="password"
                                        class="form-control"
                                        id="password"
                                        name="password"
                                        placeholder="********"
                                        aria-label="********"
                                        minlength="8"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Contraseña (Mínimo 8)</label>
                            </div>
                        </div>
                    </div>

                    <!-- PassConfirm -->
                    <div class="col-md-6">
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-lock"></i
                              ></span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="password"
                                        class="form-control"
                                        id="password_confirm"
                                        name="password_confirm"
                                        onblur="checkPass()"
                                        placeholder="********"
                                        aria-label="********"
                                        minlength="8"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Confirmar contraseña</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="passFail" class="alert d-none alert-solid-danger d-flex align-items-center" role="alert">
                    <i class="mdi mdi-alert-circle-outline me-2"></i>
                    <span id="passFailText"></span>
                </div>
                <div id="serverFailResponse"></div>

                <div class="row">
                    <!-- UserType -->
                    <div class="col-md-4">
                        <div class="form-check form-check-primary mt-3">
                            <input class="form-check-input" type="checkbox" name="group" value="admin" id="adminCheckbox">
                            <label class="form-check-label" for="customCheckPrimary">¿Es administrador?</label>
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
            <table id="usersDatatable" class="datatables-basic table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>id</th>
                    <th>Nombre(s)</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <?= $this->include('modals/editUser')?>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>

    <script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script>
        console.log('Users js loaded');
        var dt_basic_table = $('#usersDatatable'), dt_basic;
        $(function(){
            select2Catalogs('tiendas');
            // User form
            $("form").on("submit",function(e){
                e.preventDefault();
                saleBlock()
                let userData = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url: "/user",
                    dataType: "JSON",
                    data: userData,
                    statusCode:{
                        400: function (response){
                            $.unblockUI();
                            let errors = response.responseJSON.messages;
                            console.log(errors);
                            let messageError = '';
                            for (let error in errors){
                                messageError += `
                            <div class="alert alert-solid-danger d-flex align-items-center" role="alert">
                                <i class="mdi mdi-alert-circle-outline me-2"></i>
                                <span class="small">${errors[error]}</span>
                            </div>
                            `
                            }
                            $('#serverFailResponse').append(messageError);
                            setTimeout(function(){
                                $('#serverFailResponse').addClass('d-none');
                            }, 4000);
                        }
                    }
                }).done(function(user){
                    if(user.id != null){
                        $.unblockUI();
                        $('#primaryAlertText').text('Usuario guardado exitosamente');
                        $('#primaryAlert').removeClass('d-none');
                        $('#userForm')[0].reset();
                        setTimeout(function(){
                            $('#primaryAlert').addClass('d-none');
                        }, 2000);
                        dt_basic.ajax.reload();
                    }else{
                        $.unblockUI();
                        $('#failAlertText').text('Ocurrió un problema al guardar');
                        $('#failAlert').removeClass('d-none');
                        setTimeout(function(){
                            $('#failAlert').addClass('d-none');
                        }, 2000);
                    }
                });
            });

            // Users datatable
            dt_basic = dt_basic_table.DataTable({
                ajax: {
                    url: '/user',
                    dataSrc: ""
                },
                columns: [
                    { data: '' },
                    { data: 'id' },
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'last_name' },
                    { data: 'username' },
                    { data: 'phone' },
                    { data: 'email' },
                    { data: '', render: function (data, type, row){
                            return `
                                    <a href="javascript:void(0);" onclick='openUserModal(${JSON.stringify(row)})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'
                                        data-bs-toggle="modal" data-bs-target="#editUser">
                                        <i class='mdi mdi-pencil-outline'></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick='deleteUser(${JSON.stringify(row)})'
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
                                return 'Detalles del usuario';
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
            $('div.head-label').html('<h5 class="card-title mb-0">Relación de usuarios</h5>');

            $("#editUserForm").on("submit", event=>{
                event.preventDefault();
            })

            $("#editUserForm input").on("change",event=>{
                let postData = {
                    '_method': 'PATCH'
                };
                postData[event.currentTarget.name]=event.currentTarget.value;
                let updatedCell = event.currentTarget.name+$('#modalEditUserID').val();
                editUser(postData, updatedCell, event.currentTarget.name);
            });
        });

        function openUserModal(user)
        {
            document.getElementById("modalEditUserID").value = user.id;
            document.getElementById("modalEditUserName").value = user.name;
            document.getElementById("modalEditUserLastName").value = user.last_name;
            document.getElementById("modalEditUserUsername").value = user.username;
            document.getElementById("modalEditUserEmail").value = user.email;
            document.getElementById("modalEditUserPhone").value = user.phone;
        }

        function editUser(postData,)
        {
            $.ajax({
                method: 'POST',
                url: '/user/'+$('#modalEditUserID').val(),
                data: postData,
                dataType: 'JSON',
            }).done(function(response){
                if(response){
                    $('#editSuccessAlertText').text('Usuario actualizado exitosamente');
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

        function deleteUser(user)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No serás capaz de recuperar este usuario",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, borrar usuario!',
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
                        url: '/user/'+user.id,
                        data: {
                            '_method': 'DELETE'
                        },
                        dataType: 'JSON',
                    }).done(function(response){
                        Swal.fire({
                            icon: 'success',
                            title: '¡Usuario borrado!',
                            customClass: {
                                confirmButton: 'btn btn-success waves-effect'
                            }
                        });
                        dt_basic.ajax.reload();
                    })
                }
            });
        }

        function checkPass()
        {
            var p1 = document.getElementById("password").value;
            var p2 = document.getElementById("password_confirm").value;
            if (p1 !== p2) {
                $('#password, #password_confirm').val('');
                $('#passFailText').text('Las contraseñas no coinciden');
                $('#passFail').removeClass('d-none');
                setTimeout(function(){
                    $('#passFail').addClass('d-none');
                }, 2000);

            }
            if (p1.length === 0 || p2.length === 0) {
                $('#passFailText').text('Debes confirmar la contraseña');
                $('#passFail').removeClass('d-none');
                setTimeout(function(){
                    $('#passFail').addClass('d-none');
                }, 2000);
            }
        }
    </script>

<?= $this->endSection() ?>
