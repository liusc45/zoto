
<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<link rel="stylesheet" href="/assets/vendor/css/pages/wizard-ex-checkout.css" />
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
    <h4 class="py-3 col-lg-9">
        <span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?>
    </h4>
    <div class="form-floating col-lg-3 form-floating-outline">
        <input type="text" id="bs-rangepicker-range" class="form-control" />
        <label for="bs-rangepicker-range">Fechas</label>
    </div>
</div>

<!-- Invoice List Widget -->

<div class="card mb-4">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-3">
                    <div
                            class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1" id="customerCredit">...</h3>
                            <p class="mb-0">Clientes con créditos</p>
                        </div>
                        <div class="avatar me-sm-4">
                            <span class="avatar-initial rounded bg-label-secondary">
                              <i class="mdi mdi-account-outline text-heading mdi-20px"></i>
                            </span>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none me-4" />
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div
                            class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1 " id="salesCredit">...</h3>
                            <p class="mb-0">Ventas a crédito</p>
                        </div>
                        <div class="avatar me-lg-4">
                            <span class="avatar-initial rounded bg-label-secondary">
                              <i class="mdi mdi-content-paste text-heading mdi-20px"></i>
                            </span>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none" />
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div
                            class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                        <div>
                            <h3 class="mb-1"><span id="amountCredit">...</span></h3>
                            <p class="mb-0">Ventas a crédito</p>
                        </div>
                        <div class="avatar me-sm-4">
                            <span class="avatar-initial rounded bg-label-secondary">
                              <i class="mdi mdi-currency-usd text-heading mdi-20px"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="mb-1"><span id="pendingCredit">...</span></h3>
                            <p class="mb-0">Crédito por cobrar</p>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-secondary">
                              <i class="mdi mdi-currency-usd-off text-heading mdi-20px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice List Table -->
<div class="card">
    <div class="card-datatable table-responsive">
        <table class="invoice-list-table table">
            <thead class="table-light">
            <tr>
                <th></th>
                <th></th>
                <th># de crédito</th>
                <th>Cliente</th>
                <th>Deuda</th>
                <th>Fecha</th>
                <th>Pendiente</th>
                <th class="cell-fit">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>


<?=$this->include('modals/addCreditPayment');?>
<?=$this->include('modals/editCreditPayment');?>
<?= $this->endSection() ?>


<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/moment/moment.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="/assets/vendor/libs/select2/select2.js"></script>
<script src="/assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>



<script>
    console.log('Credits JS loaded');
    let totalCredit;
    let customersCredit
    let pendingCredit;
    let salesCredit;
    let paymentType = $("#paymentMethod");
    let paymentsToUpdate = [];

    /**
     * App Invoice List (jquery)
     */

    'use strict';
    var dt_invoice_table = $('.invoice-list-table');

    $(function () {
        $.ajax({
            method: 'GET',
            url: '/credit'+location.search,
            dataType: 'JSON'
        }).done(function(response){
            salesCredit = response.length;
            customersCredit = customersCreditNumber(response)
            totalCredit = response.reduce((amount, obj) => amount + parseInt(obj.amount), 0);
            pendingCredit = response.reduce((amount, obj) => amount + parseInt(obj.rest), 0);
            $("#customerCredit").text(customersCredit);
            $("#amountCredit").text(formatMoney(totalCredit));
            $("#pendingCredit").text(formatMoney(pendingCredit));
            $("#salesCredit").text(salesCredit);
            setCreditsDatatable(response)
        })

        // Invoice datatable


        // Filter form control to default size
        // ? setTimeout used for multilingual table initialization
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm');
            $('.dataTables_length .form-select').removeClass('form-select-sm');
        }, 300);

        $("form#addNewCCForm").on("submit",function(e){
            e.preventDefault();
            blocking();
            let creditPaymentData = $(this).serializeArray();
            console.log(creditPaymentData);
            $.ajax({
                method: "POST",
                url: "/payment",
                dataType: "JSON",
                data: creditPaymentData,
            }).done(function(payment){
                if (payment.id){
                    toastAlert('success','Abono registrado','El abono se registró exitosamente, en breve se recargará la página');
                    location.reload();
                }else {
                    toastAlert('error','Error','Ocurrió un problema, por favor intenta nuevamente');
                }

            });
        });

        paymentType.on("change",function(e) {
            switch (this.value) {
                case "cash" :
                    $("#cashInput, #receivedInput, #cashbackInput").removeClass("d-none");
                    $('#ticketNumberInput').addClass('d-none');
                    break;
                case "card" :
                    $('#cashInput, #ticketNumberInput').removeClass('d-none');
                    $("#receivedInput, #cashbackInput").addClass("d-none");
                    break;
                case "transfer" :
                    $("#cashInput").removeClass("d-none");
                    $('#cashbackInput, #receivedInput, #ticketNumberInput').addClass('d-none');
                    break;
                default : break;
            }
        });

    });

    function setCreditsDatatable(credits)
    {
        var dt_invoice = dt_invoice_table.DataTable({
            data:credits,
            columns: [
                // columns according to JSON
                { data: '' },
                { data: 'id' },
                { data: 'id' },
                { data: 'customer_name' },
                { data: 'financing' },
                { data: 'created_at' },
                { data: 'rest' },
                { data: 'action' }
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    responsivePriority: 2,
                    searchable: false,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input">';
                    },
                    checkboxes: {
                        selectAllRender: '<input type="checkbox" class="form-check-input">'
                    }
                },
                {
                    // Invoice ID
                    targets: 2,
                    render: function (data, type, full, meta) {
                        var uuid = full['uuid'];
                        var id = full['id'];
                        var $row_output = `
                            <a href="ticket/${uuid}" target="_blank"><span>${id}</span></a>
                        `;
                        return $row_output;
                    }
                },
                {
                    // Total Invoice Amount
                    targets: 5,
                    render: function (data, type, full, meta) {
                        var $dateObj = full['created_at'];
                        var $date = $dateObj['date'].split(' ');
                        return `<span>${$date[0]}</span>`;
                    }
                },
                {
                    // Client Balance/Status
                    targets: 6,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        var $balance = full['rest'];
                        if ($balance === '0.00') {
                            var $badge_class = 'bg-label-success';
                            return '<span class="badge rounded-pill ' + $badge_class + '" text-capitalized> Pagado </span>';
                        } else {
                            return '<span class="text-heading">' + $balance + '</span>';
                        }
                    }
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Acciones',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, row) {
                        let creditJson = JSON.stringify(row);
                        return (`
                            <div class="d-flex align-items-center">
                                <a  class="text-body"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addNewCreditPayment"
                                    onclick='creditData(${creditJson})'
                                    title="Registrar pago">
                                    <i class="mdi mdi-cash-plus mdi-20px mx-1"></i>
                                </a>
                                <a  class="text-body"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editCreditPayment"
                                    onclick='editPayment(${creditJson})'
                                    title="Editar pago">
                                    <i class="mdi mdi-pencil mdi-20px mx-1"></i>
                                </a>
                                <a  class="text-body"
                                    href="/abono/${row.uuid}"
                                    target="_blank"
                                    title="Historial de pagos">
                                    <i class="mdi mdi-format-list-numbered mdi-20px mx-1"></i>
                                </a>
                            </div>
                        `);
                    }
                }
            ],
            order: [[2, 'desc']],
            dom:
                '<"row mx-1"' +
                '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-3"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
                '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>' +
                '>t' +
                '<"row mx-2"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            language: {
                sLengthMenu: 'Show _MENU_',
                search: '',
                searchPlaceholder: 'Buscar cliente',
                url: '//cdn.datatables.net/plug-ins/2.0.8/i18n/es-MX.json',
            },
            // Buttons with Dropdown
            buttons: [],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Detalles del crédito';
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

        });

        // On each datatable draw, initialize tooltip
        dt_invoice_table.on('draw.dt', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    boundary: document.body
                });
            });
        });
    }

    function creditData(credit)
    {
        document.getElementById("client").value = credit.customer_name;
        document.getElementById("name").value = credit.item_name;
        document.getElementById("credit").value = credit.id;
        document.getElementById("sale").value = credit.sale;
    }

    function calculate()
    {
        let cashPayment = document.getElementById("amount").value;
        let cashReceived = document.getElementById("cash").value;
        let cashback = cashReceived - cashPayment;
        document.getElementById("cashback").value = cashback;
    }

    function customersCreditNumber(credits)
    {
        let customers = [];

        for(let credit of credits)
        {
            if(!customers.includes(credit.customer) && parseFloat(credit.rest)>0){
                customers.push(credit.customer)
            }
        }
        return customers.length;
    }
    
    function editPayment(credit)
    {
        $.ajax({
            method: 'GET',
            url: '/credit/'+credit.id,
            dataType: 'JSON'
            }).done(function(response){
                console.log(response);
                let partials = response.partials;
                let html = '';
                for(let payment of partials){
                    let date = payment.created_at.date.split(' ');
                    html += `
                        <form action="" id="payment-${payment.id}">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="col-6">
                                    ${date[0]}
                                </div>
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            id="amount-${payment.id}"
                                            onchange="calculateDifference(this)"
                                            name="amount"
                                            class="form-control inputPaymentUpdate"
                                            type="number"
                                            aria-describedby="modalAddCard2"
                                            value= "${payment.amount}" />
                                            <label for="">Monto</label>
                                    </div>
                                </div>
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            id="cash-${payment.id}"
                                            onchange="calculateDifference(this)"
                                            name="cash"
                                            class="form-control inputPaymentUpdate"
                                            type="number"
                                            aria-describedby="modalAddCard2"
                                            value= "${payment.cash}" />
                                            <label for="">Recibido</label>
                                    </div>
                                </div>
                                <input type="hidden" id="difference-${payment.id}" name="cashback" value="">
                                <input type="hidden" name="_method" value="PUT">
                            </li>
                        </form>
                    `
                }
                $('#paymentList').html(html);
                for(let payment of partials){
                    setPaymentForm(payment.id);
                }

            })
    }

    function calculateDifference(input)
    {
        let id = input.id.split('-')[1];
        let amount = $("#amount-"+id).val();
        let cash = $("#cash-"+id).val();
        let difference = parseInt(amount) - parseInt(cash);
        console.log(difference);
        $('#difference-'+id).val(difference);
        paymentsToUpdate.push(id);
    }

    function updatedPaymentCreditData(id, amount, difference)
    {
        let unique = [...new Set(paymentsToUpdate)];
        unique.forEach(function (v,k) {
            console.log(v,k);
            $('#payment-'+v).trigger('submit')
        })

    }

    function setPaymentForm(id)
    {
        $("form#payment-"+id).on("submit",function(e){
            e.preventDefault();
            blocking();
            let creditPaymentData = $(this).serializeArray();
            $.ajax({
                url: '/payment/'+id,
                method: 'POST',
                data: creditPaymentData
            });
            toastAlert('success','Pago actualizado','En breve se recargará la página');
            location.reload();
        });
    }
</script>
<?= $this->endSection() ?>
