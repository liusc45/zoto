<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> Gastos</h4>

    <?=$this->include('partials/alerts');?>

    <div id="card-block" class="card">
        <div class="card-header d-flex flex-column">
            <h5 class="mb-0">Nuevo gasto</h5>
            <small class="text-body float-end">Todos los campos son obligatorios</small>
        </div>
        <div class="card-body">
            <form id="transactionForm" class="needs-validation">
                <div class="row">
                    <div class="col-md-2">
                        <!-- Amount -->
                        <div class="input-group input-group-merge mb-4">
                      <span id="basic-icon-default-fullname2" class="input-group-text">
                        <i class="mdi mdi-cash-multiple"></i>
                      </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="number"
                                        class="form-control"
                                        id="amount"
                                        name="amount"
                                        placeholder="99.99 MXN"
                                        aria-label="99.99 MXN"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Monto</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <!-- Concept -->
                        <div class="input-group input-group-merge mb-4">
                      <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="mdi mdi-text-box-edit-outline"></i
                          ></span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="text"
                                        class="form-control"
                                        id="concept"
                                        name="concept"
                                        placeholder="Pago de servicio"
                                        aria-label="Pago de servicio"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Concepto</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <!-- Category Select2 -->
                        <div class="input-group input-group-merge mb-4">
                            <div class="form-floating form-floating-outline">
                                <select
                                        id="select2Expenses"
                                        name="category"
                                        class="form-select"
                                       >
                                    <option value="">Seleccionar opción</option>
                                    <?php foreach($categories as $key => $category):?>
                                        <option value="<?= $category->id;?>">
                                            <?=$category->name; ?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                                <label for="select2Basic">Categoría</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <!-- Date -->
                        <div class="input-group input-group-merge mb-4">
                  <span id="basic-icon-default-fullname2" class="input-group-text">
                    <i class="mdi mdi-calendar-month-outline"></i>
                  </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        type="text"
                                        class="form-control flatpickr-input"
                                        placeholder="YYYY-MM-DD"
                                        id="flatpickr-date"
                                        name="applied"
                                        readonly="readonly"
                                        value="<?=$today?>">
                                <label for="flatpickr-date">Fecha</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Responsible -->
                <div class="input-group input-group-merge mb-4">
                    <div class="form-floating form-floating-outline">
                        <select
                                id="responsible"
                                name="responsible"
                                class="select2 form-select "
                                data-allow-clear="true">

                           <?php foreach($users as $key => $user):?>
                                <option value="<?= $user->id;?>" <?= $user->id === session()->get('id_user') ? 'selected' : ''?>>
                                    <?= $user->name . " " . $user->last_name ?>
                                </option>
                            <?php endforeach;?>
                        </select>
                        <label for="responsible">Responsable</label>
                    </div>
                </div>

                <!-- Comment -->
                <div class="input-group input-group-merge mb-4">
                  <span id="basic-icon-default-message2" class="input-group-text"
                  ><i class="mdi mdi-message-outline"></i
                      ></span>
                    <div class="form-floating form-floating-outline">
                    <textarea
                            id="comments"
                            name="comments"
                            class="form-control"
                            placeholder="Información relevante para la transacción"
                            aria-label="Información relevante para la transacción"
                            aria-describedby="basic-icon-default-message2"
                            style="height: 60px"></textarea>
                        <label for="basic-icon-default-message">Comentario</label>
                    </div>
                </div>
                <!-- Save button -->
                <input type="hidden" value="<?=auth()->getUser()->id?>" name="created_by">
                <button class="btn btn-primary btn-card-block-overlay">Guardar</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-datatable table-responsive pt-0">
            <table id="expensesDatatable" class="datatables-basic table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>id</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Concepto</th>
                    <th>Comentarios</th>
                    <th>Categoría</th>
                    <th>Responsable</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

<?= $this->include('modals/editExpense')?>
<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
    <script src="/assets/vendor/libs/moment/moment.js"></script>
    <script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="/assets/vendor/libs/toastr/toastr.js"></script>
    <script src="/assets/js/ui-toasts.js"></script>
    <script src="/assets/vendor/libs/select2/select2.js"></script>
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script>
        console.log('Expenses js loaded');
        var dt_basic_table = $('.datatables-basic'), dt_basic;
        const select2 = $('#select2Expenses');
        const select2Responsible = $('#responsibleSelectUpdate');
        const selectUpdate = $('#select2ExpensesUpdate')
        $(function(){
            select2.select2({
                tags: true
            });
            $('#responsible').select2();
            
            select2Responsible.wrap('<div class="position-relative"></div>').select2({
              
                dropdownParent: select2Responsible.parent()
            });
            selectUpdate.wrap('<div class="position-relative"></div>').select2({
                dropdownParent: selectUpdate.parent()
            });
            
            
            select2Responsible.on("select2:select", function (event){
                let postData = {
                    '_method': 'PATCH'
                };
                postData[event.currentTarget.name]=event.currentTarget.value;
                let updatedCell = event.currentTarget.name+$('#modalEditStoreID').val();
                editExpense(postData);
            })
            
            
            selectUpdate.on("select2:select", function (event){
                let postData = {
                    '_method': 'PATCH'
                };
                postData[event.currentTarget.name]=event.currentTarget.value;
                let updatedCell = event.currentTarget.name+$('#modalEditStoreID').val();
                editExpense(postData);
            })
           

            // Flat Picker
            const flatpickrDate = document.querySelector('#flatpickr-date');
            var section = $('#section-block'),
                cardSection = $('#card-block'),
                cardBlockOverlay = $('.btn-card-block-overlay'),
                cardBlock = $('.btn-card-block');

            // Date
            if (flatpickrDate) {
                flatpickrDate.flatpickr({
                    monthSelectorType: 'static'
                });
            }

            // Transaction form
            $("form").on("submit",function(e){
                e.preventDefault();
                blocking();
                let expenseData = $(this).serializeArray();
                console.log(expenseData);
                $.ajax({
                    method: "POST",
                    url: "/expenses",
                    dataType: "JSON",
                    data: expenseData,
                }).done(function(expense){
                    if(expense.id != null){
                        $('#primaryAlertText').text('Gasto guardado exitosamente');
                        $('#primaryAlert').removeClass('d-none');
                        $('#transactionForm')[0].reset();
                        $('#select2Expenses').val(null).trigger('change');
                        setTimeout(function(){
                            $('#primaryAlert').addClass('d-none');
                        }, 2000);
                        dt_basic.ajax.reload();
                    }else{
                        $('#failAlertText').text('Ocurrió un problema al guardar');
                        $('#failAlert').removeClass('d-none');
                        setTimeout(function(){
                            $('#failAlert').addClass('d-none');
                        }, 2000);
                    }
                });
            });

            // DataTable
                dt_basic = dt_basic_table.DataTable({
                    ajax: {
                        url: '/expenses',
                        dataSrc: ""
                    },
                    columns: [
                        { data: '' },
                        { data: 'id' },
                        { data: 'id' },
                        { data: 'applied', render: function (data, type, row){
                                let date = data.split(' ');
                                return date[0];
                            }
                        },
                        { data: 'amount' },
                        { data: 'concept' },
                        { data: 'comments' },
                        { data: 'category_name' },
                        { data: 'responsible' },
                        { data: '', render: function (data, type, row){
                                let expenseJson = JSON.stringify(row);
                                return `
                                    <a href="javascript:void(0);" onclick='authorizeExpense(${row.id})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'>
                                        <i class='mdi mdi-check-bold'></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick='openExpenseModal(${expenseJson})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'
                                        data-bs-toggle="modal" data-bs-target="#editExpense">
                                        <i class='mdi mdi-pencil-outline'></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick='deleteExpense(${row.id})'
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
                    order: [[3, 'desc']],
                    dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    displayLength: 10,
                    lengthMenu: [10, 25, 50, 75, 100],
                    buttons: [
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
                                        columns: [3, 4, 5, 6, 7,8]
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7,8]
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
                                    return 'Detalles del gasto ';
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
                $('div.head-label').html('<h5 class="card-title mb-0">Relación de <gastos></gastos></h5>');

            $("#editExpenseForm input,textarea").on("change",event=>{
                let postData = {
                    '_method': 'PATCH'
                };
                postData[event.currentTarget.name]=event.currentTarget.value;
                let updatedCell = event.currentTarget.name+$('#modalEditStoreID').val();
                editExpense(postData);
            });
        
            
            
        });

        function authorizeExpense(id)
        {
            console.log('Autorizando la transacción ' + id);
            $.ajax({
                method: 'POST',
                url: '/expenses/'+id,
                data : {
                    '_method':'PATCH',
                    'reconciled': '<?=date('Y-m-d')?>'
                },
                dataType: 'JSON'
            }).done(function(response){
                $('#primaryAlertText').text('Gasto autorizado exitosamente');
                $('#primaryAlert').removeClass('d-none');
                setTimeout(function(){
                    $('#primaryAlert').addClass('d-none');
                }, 2000);
                dt_basic.ajax.reload();
            })
        }
        

        function deleteExpense(id)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No serás capaz de recuperar este gasto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, borrar gasto!',
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
                        url: '/expenses/'+id,
                        data : {'_method':'DELETE'},
                        dataType: 'JSON'
                    }).done(function(response){
                        console.log(response);
                        dt_basic.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Gasto borrado!',
                            customClass: {
                                confirmButton: 'btn btn-success waves-effect'
                            }
                        });
                    })
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

        function openExpenseModal(expense)
        {
            console.log(expense);
            document.getElementById("amountExpenseUpdate").value = expense.amount;
            document.getElementById("conceptExpenseUpdate").value = expense.concept;
            document.getElementById("commentsExpenseUpdate").value = expense.comments;
            document.getElementById("modalExpenseUpdateID").value = expense.id;

            $('#select2ExpensesUpdate').val(expense.category).trigger('change');

            $('#responsibleSelectUpdate > option').each(function(k,v) {
                if (expense.responsible === v.text){
                    $('#responsibleSelectUpdate').val(v.value).trigger('change');
                }
            })

        }

        function editExpense(postData)
        {
            $.ajax({
                method: 'POST',
                url: '/expenses/'+$('#modalExpenseUpdateID').val(),
                data: postData,
                dataType: 'JSON',
            }).done(function(response){
                if(response){
                    toastAlert('success','Gasto actualizado','El gasto se actualizó satisfactoriamente');
                    dt_basic.ajax.reload();
                } else{
                    toastAlert('error','Error','Ocurrió un problema, por favor intenta nuevamente');
                }
            });
        }
    </script>
<?= $this->endSection() ?>
