```php
<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> Tarjetas de Pago</h4>

<?=$this->include('partials/alerts');?>

<!-- Nueva Cuenta Bancaria -->
<div id="bank-account-block" class="card mb-4">
    <div class="card-header d-flex flex-column">
        <h5 class="mb-0">Nueva Cuenta Bancaria</h5>
        <small class="text-muted">Crea primero una cuenta bancaria; después podrás asignarla a las tarjetas de pago.</small>
    </div>
    <div class="card-body">
        <form id="bankAccountForm" class="needs-validation">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-merge mb-4">
                        <span class="input-group-text"><i class="mdi mdi-bank-outline"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Banco" required>
                            <label for="bank_name">Banco</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge mb-4">
                        <span class="input-group-text"><i class="mdi mdi-alphabetical"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="alias" name="alias" placeholder="Alias" required>
                            <label for="alias">Alias</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge mb-4">
                        <span class="input-group-text"><i class="mdi mdi-card-account-details-outline"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Número de cuenta">
                            <label for="account_number">Número de cuenta</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge mb-4">
                        <span class="input-group-text"><i class="mdi mdi-numeric"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="clabe" name="clabe" placeholder="CLABE">
                            <label for="clabe">CLABE</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge mb-4">
                        <span class="input-group-text"><i class="mdi mdi-account-outline"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Titular de la cuenta">
                            <label for="owner_name">Titular</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-merge mb-4">
                        <span class="input-group-text"><i class="mdi mdi-currency-usd"></i></span>
                        <div class="form-floating form-floating-outline">
                            <select class="select2 form-select" id="currency" name="currency">
                                <option value="MXN" selected>MXN</option>
                                <option value="USD">USD</option>
                            </select>
                            <label for="currency">Moneda</label>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="store" value="<?= session()->store->id ?? '' ?>">
            <button class="btn btn-primary btn-card-block-overlay">Guardar Cuenta</button>
        </form>
    </div>
</div>

<div id="card-block" class="card">
    <div class="card-header d-flex flex-column">
        <h5 class="mb-0">Nueva Tarjeta de Pago</h5>
    </div>
    <div class="card-body">
        <form id="paymentCardForm" class="needs-validation" >
            <input type="hidden" name="store" value="<?= session()->store->id ?? '' ?>">
            <div class="row">
                <div class="col-md-6">
                    <!-- Cuenta bancaria -->
                    <div class="input-group input-group-merge mb-4">
                      <span class="input-group-text">
                          <i class="mdi mdi-bank"></i>
                      </span>
                        <div class="form-floating form-floating-outline">
                            <select class="select2 form-select" id="bank_account" name="bank_account">
                                <option value="">Seleccione una cuenta</option>
                                <?php foreach ($accounts as $account): ?>
                                    <option value="<?= $account->id ?>"><?= $account->bank_name ?> - <?= $account->alias ?> - <?= $account->currency ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="bank_account">Cuenta bancaria</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Tipo de pago bancario -->
                    <div class="input-group input-group-merge mb-4">
                      <span class="input-group-text">
                          <i class="mdi mdi-credit-card-outline"></i>
                      </span>
                        <div class="form-floating form-floating-outline">
                            <select class="select2 form-select" id="bank_payment_modality" name="bank_payment_modality">
                                <option value="1">Débito</option>
                                <option value="2">Crédito 1M</option>
                                <option value="3">Crédito 3M</option>
                                <option value="4">Crédito 6M</option>
                                <option value="5">Crédito 9M</option>
                                <option value="6">Crédito 12M</option>
                                <option value="7">Crédito 18M</option>
                                <option value="8">Crédito 24M</option>
                            </select>
                            <label for="bank_payment_modality">Modalidad</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Name -->
                    <div class="input-group input-group-merge mb-4">
                      <span id="basic-icon-default-name" class="input-group-text">
                          <i class="mdi mdi-credit-card-outline"></i>
                      </span>
                        <div class="form-floating form-floating-outline">
                            <input
                                    required
                                    type="text"
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    placeholder="Visa"
                                    aria-label="Visa"
                                    aria-describedby="basic-icon-default-name" />
                            <label for="name">Nombre</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Commission -->
                    <div class="input-group input-group-merge mb-4">
                      <span id="basic-icon-default-commission" class="input-group-text">
                          <i class="mdi mdi-percent-outline"></i>
                      </span>
                        <div class="form-floating form-floating-outline">
                            <input
                                    required
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    max="100"
                                    class="form-control"
                                    id="commission"
                                    name="commission"
                                    placeholder="3.5"
                                    aria-label="3.5"
                                    aria-describedby="basic-icon-default-commission" />
                            <label for="commission">Comisión (%)</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Active -->
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="active" name="active" value="1" checked>
                        <label class="form-check-label"  for="active">Activo</label>
                    </div>
                </div>
            </div>

            <!-- Save button -->
            <button class="btn btn-primary btn-card-block-overlay">Guardar</button>
        </form>
    </div>
</div>

<div class="card mt-4">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <button
                type="button"
                class="nav-link active"
                role="tab"
                data-bs-toggle="tab"
                data-bs-target="#paymentCardsTab"
                aria-controls="paymentCardsTab"
                aria-selected="true">
                <i class="mdi mdi-credit-card-outline me-1"></i> Tarjetas de Pago
            </button>
        </li>
        <li class="nav-item">
            <button
                type="button"
                class="nav-link"
                role="tab"
                data-bs-toggle="tab"
                data-bs-target="#bankAccountsTab"
                aria-controls="bankAccountsTab"
                aria-selected="false">
                <i class="mdi mdi-bank me-1"></i> Cuentas Bancarias
            </button>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Tarjetas de Pago Tab -->
        <div class="tab-pane fade show active" id="paymentCardsTab" role="tabpanel">
            <div class="card-datatable table-responsive pt-0">
                <table id="paymentCardDatatable" class="datatables-basic table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Comisión</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Cuentas Bancarias Tab -->
        <div class="tab-pane fade" id="bankAccountsTab" role="tabpanel">
            <div class="card-datatable table-responsive pt-0">
                <table id="bankAccountDatatable" class="datatables-accounts table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Banco</th>
                        <th>Alias</th>
                        <th>Número de Cuenta</th>
                        <th>CLABE</th>
                        <th>Titular</th>
                        <th>Moneda</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editPaymentCardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Tarjeta de Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPaymentCardForm">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="edit_name" class="form-label">Nombre</label>
                                <input type="text" id="edit_name" name="name" class="form-control" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="edit_commission" class="form-label">Comisión (%)</label>
                                <input type="number" id="edit_commission" name="commission" class="form-control" step="0.01" min="0" max="100" required>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="edit_active" name="active" value="1">
                                    <label class="form-check-label" for="edit_active">Activo</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveEditBtn">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Bank Account Modal -->
<div class="modal fade" id="editBankAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Cuenta Bancaria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBankAccountForm">
                    <input type="hidden" id="edit_account_id" name="id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_bank_name" class="form-label">Banco</label>
                            <input type="text" id="edit_bank_name" name="bank_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_alias" class="form-label">Alias</label>
                            <input type="text" id="edit_alias" name="alias" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_account_number" class="form-label">Número de Cuenta</label>
                            <input type="text" id="edit_account_number" name="account_number" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_clabe" class="form-label">CLABE</label>
                            <input type="text" id="edit_clabe" name="clabe" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_owner_name" class="form-label">Titular</label>
                            <input type="text" id="edit_owner_name" name="owner_name" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_currency" class="form-label">Moneda</label>
                            <select id="edit_currency" name="currency" class="form-select">
                                <option value="MXN">MXN</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveEditAccountBtn">Guardar</button>
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
    console.log('Payment Cards js loaded');
    console.log('Payment Cards js loaded');
    let dt_accounts_table = $('.datatables-accounts'), dt_accounts;


    let dt_basic_table = $('.datatables-basic'), dt_basic;

    $(function(){
        loadBankAccounts();


        $("#bank_account").on("select2:select", function (e) {
            console.log(e)
        })
        // Payment Card form
        $("#paymentCardForm").on("submit", function(e){
            e.preventDefault();
            blocking();
            let paymentCardData = $(this).serializeArray();
            
            // Handle checkbox
            if (!$("#active").is(":checked")) {
                paymentCardData.push({name: "active", value: "0"});
            }

            $.ajax({
                method: "POST",
                url: "/paymentcard",
                dataType: "JSON",
                data: paymentCardData,
            }).done(function(paymentCard){
                if(paymentCard.id != null){
                    toastAlert('success','Tarjeta creada','Tarjeta de pago guardada exitosamente');
                    $('#paymentCardForm')[0].reset();
                    $("#active").prop("checked", true);
                    dt_basic.ajax.reload();
                }else{
                    toastAlert('error','Error','Ocurrió un problema al guardar');
                }
            });
        });


        // Payment Card datatable
        dt_basic = dt_basic_table.DataTable({
            ajax: {
                url: '/paymentcard',
                dataSrc: ""
            },
            columns: [
                { data: 'id' },
                { data: 'alias' },
                { data: 'commission', render: function(data) {
                    return data + '%';
                }},
                { data: 'active', render: function(data) {
                    return data ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
                }},
                { data: '', render: function (data, type, row){
                    let paymentCardJson = JSON.stringify(row);
                    return `
                        <div class="d-inline-block">
                            <a href="javascript:void(0);" onclick='editPaymentCard(${paymentCardJson})'
                                class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit me-1">
                                <i class="mdi mdi-pencil-outline"></i>
                            </a>
                            <a href="javascript:void(0);" onclick='deletePaymentCard(${paymentCardJson})'
                                class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-delete">
                                <i class="mdi mdi-delete-outline"></i>
                            </a>
                        </div>
                    `
                }}
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
            order: [[0, 'desc']],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 7,
            lengthMenu: [7,10, 25, 50, 75, 100],
            buttons: [],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Detalles de la tarjeta de pago';
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
        $('div.head-label').html('<h5 class="card-title mb-0">Tarjetas de Pago</h5>');
        
        // Edit Payment Card
        $("#saveEditBtn").on("click", function() {
            let id = $("#edit_id").val();
            let formData = $("#editPaymentCardForm").serializeArray();
            
            // Handle checkbox
            if (!$("#edit_active").is(":checked")) {
                formData.push({name: "active", value: "0"});
            }
            
            $.ajax({
                method: "POST",
                url: "/paymentcard/" + id,
                dataType: "JSON",
                data: [...formData, {name: "_method", value: "PUT"}],
            }).done(function(response){
                if(response.id != null){
                    toastAlert('success','Tarjeta actualizada','Tarjeta de pago actualizada exitosamente');
                    $('#editPaymentCardModal').modal('hide');
                    dt_basic.ajax.reload();
                }else{
                    toastAlert('error','Error','Ocurrió un problema al actualizar');
                }
            });
        });

        // Bank Account form
        $('#bankAccountForm').on('submit', function(e){
            e.preventDefault();
            blocking('#bank-account-block');
            const data = $(this).serializeArray();
            $.ajax({
                method: 'POST',
                url: '/bankaccount',
                dataType: 'json',
                data
            }).done(function(resp){
                if (resp && resp.id) {
                    toastAlert('success','Cuenta creada','La cuenta bancaria se guardó correctamente');
                    $('#bankAccountForm')[0].reset();
                    loadBankAccounts();
                    if (dt_accounts) {

                        dt_accounts.ajax.reload();
                    }
                }
                else {
                    toastAlert('error','Error','No se pudo guardar la cuenta bancaria');

                }
            }).fail(function(xhr){
                const msg = xhr.responseJSON?.messages ?? 'Error inesperado';
                toastAlert('error','Error', Array.isArray(msg) ? msg.join(', ') : (typeof msg === 'string' ? msg : ''));
            }).always(function(){
                $.unblockUI();
            });
        });

        // Bank Accounts datatable
        dt_accounts = dt_accounts_table.DataTable({
            ajax: {
                url: '/bankaccount',
                data: function(d) {
                    d.store = '<?= session()->store->id ?? '' ?>';
                },
                dataSrc: ""
            },
            columns: [
                { data: 'id' },
                { data: 'bank_name' },
                { data: 'alias' },
                { data: 'account_number', render: function(data) {
                        return data ? data : '-';
                    }},
                { data: 'clabe', render: function(data) {
                        return data ? data : '-';
                    }},
                { data: 'owner_name', render: function(data) {
                        return data ? data : '-';
                    }},
                { data: 'currency' },
                { data: '', render: function (data, type, row){
                        let accountJson = JSON.stringify(row).replace(/'/g, "&apos;");
                        return `
                            <div class="d-inline-block">
                                <a href="javascript:void(0);" onclick='editBankAccount(${accountJson})'
                                    class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit me-1">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </a>
                                <a href="javascript:void(0);" onclick='deleteBankAccount(${accountJson})'
                                    class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-delete">
                                    <i class="mdi mdi-delete-outline"></i>
                                </a>
                            </div>
                        `
                    }}
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
            order: [[0, 'desc']],
            dom: '<"card-header flex-column flex-md-row"<"head-label-accounts text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 7,
            lengthMenu: [7,10, 25, 50, 75, 100],
            buttons: [],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            return 'Detalles de la cuenta bancaria';
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== ''
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
        $('div.head-label-accounts').html('<h5 class="card-title mb-0">Cuentas Bancarias</h5>');

        // Edit Bank Account
        $("#saveEditAccountBtn").on("click", function() {
            let id = $("#edit_account_id").val();
            let formData = $("#editBankAccountForm").serializeArray();
            formData.push({name: "store", value: '<?= session()->store->id ?? '' ?>'});

            $.ajax({
                method: "POST",
                url: "/bankaccount/" + id,
                dataType: "JSON",
                data: [...formData, {name: "_method", value: "PUT"}],
            }).done(function(response){
                if(response.id != null){
                    toastAlert('success','Cuenta actualizada','Cuenta bancaria actualizada exitosamente');
                    $('#editBankAccountModal').modal('hide');
                    dt_accounts.ajax.reload();
                    loadBankAccounts();
                }else{
                    toastAlert('error','Error','Ocurrió un problema al actualizar');
                }
            }).fail(function(xhr){
                const msg = xhr.responseJSON?.messages ?? 'Error inesperado';
                toastAlert('error','Error', Array.isArray(msg) ? msg.join(', ') : (typeof msg === 'string' ? msg : ''));
            });
        });


    });

    function blocking() {
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
    
    function editPaymentCard(paymentCard) {
        $("#edit_id").val(paymentCard.id);
        $("#edit_name").val(paymentCard.name);
        $("#edit_commission").val(paymentCard.commission);
        $("#edit_active").prop("checked", paymentCard.active);
        
        $('#editPaymentCardModal').modal('show');
    }

    function deletePaymentCard(paymentCard) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No serás capaz de recuperar esta tarjeta de pago",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, borrar tarjeta!',
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
                    url: '/paymentcard/'+paymentCard.id,
                    data: { '_method': 'DELETE'},
                    dataType: 'JSON'
                }).done(function(response){
                    Swal.fire({
                        icon: 'success',
                        title: '¡Tarjeta borrada!',
                        customClass: {
                            confirmButton: 'btn btn-success waves-effect'
                        }
                    });
                    dt_basic.ajax.reload();
                })
            }
        });
    }
    function loadBankAccounts(){
        const storeId = '<?= session()->store->id ?? '' ?>';
        $.getJSON('/bankaccount', {store: storeId}).done(function(accounts){
            const $select = $('#bank_account');
            const currentVal = $select.val();
            $select.empty();
            $select.append('<option value="">Seleccione una cuenta</option>');
            accounts.forEach(acc => {
                const label = [acc.bank_name, acc.alias ? '('+acc.alias+')' : '', acc.currency ? '- '+acc.currency : ''].join(' ').trim();
                $select.append(`<option data-account='${JSON.stringify(acc)}' value="${acc.id}">${label}</option>`);
            });
            if (currentVal) {
                $select.val(currentVal).trigger('change');
            }
        });
    }

    function editBankAccount(account) {
        $("#edit_account_id").val(account.id);
        $("#edit_bank_name").val(account.bank_name);
        $("#edit_alias").val(account.alias);
        $("#edit_account_number").val(account.account_number);
        $("#edit_clabe").val(account.clabe);
        $("#edit_owner_name").val(account.owner_name);
        $("#edit_currency").val(account.currency);

        $('#editBankAccountModal').modal('show');
    }

    function deleteBankAccount(account) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No serás capaz de recuperar esta cuenta bancaria",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, borrar cuenta!',
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
                    url: '/bankaccount/'+account.id,
                    data: { '_method': 'DELETE'},
                    dataType: 'JSON'
                }).done(function(response){
                    Swal.fire({
                        icon: 'success',
                        title: '¡Cuenta borrada!',
                        customClass: {
                            confirmButton: 'btn btn-success waves-effect'
                        }
                    });
                    dt_accounts.ajax.reload();
                    loadBankAccounts();
                }).fail(function(xhr){
                    const msg = xhr.responseJSON?.messages ?? 'Error al eliminar';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: Array.isArray(msg) ? msg.join(', ') : (typeof msg === 'string' ? msg : 'No se pudo eliminar la cuenta'),
                        customClass: {
                            confirmButton: 'btn btn-danger waves-effect'
                        }
                    });
                });
            }
        });
    }

</script>
<?= $this->endSection() ?>

