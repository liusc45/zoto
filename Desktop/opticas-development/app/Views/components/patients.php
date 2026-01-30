<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

<div id="card-block" class="card">
    <div class="card-header d-flex flex-column">
        <div class="row">
            <div>
                <h5 class="mb-0">Nuevo Paciente</h5>
                <small class="text-body">Algunos campos son obligatorios</small>
            </div>
            <div class="float-end">
                <input class="form-check-input" type="checkbox" value="" id="workCheckInput" />
                <label class="form-check-label" for="defaultCheck1"> ¿Pertenece a una empresa? </label>
            </div>
        </div>
    </div>
   <?=$this->include('partials/person')?>
</div>

<div class="card mt-4">
    <div class="card-datatable table-responsive pt-0">
        <table id="customersDatatable" class="datatables-basic table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th>Tarjetón</th>
                <th>Nombre(s)</th>
                <th>Ciudad</th>
                <th>Fecha de nacimiento</th>
                <th>Contacto</th>
                <th>email</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<?= $this->include('modals/editCustomer')?>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/moment/moment.js"></script>
<script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="/assets/vendor/libs/select2/select2.js"></script>
<script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="/assets/js/custom/patient-edit.js"></script>

<script>
    console.log('Patients JS loaded');
    const dt_basic_table = $('.datatables-basic');
        let dt_basic,
            editPerson;

    $(function(){

        setMethodsOnLoad();
        // Transaction form
        $("form").on("submit",function(e){
            e.preventDefault();
            blocking();
            let valid = validateDate();
            if(valid || true ){
                let customerData = $(this).serializeArray();
                $.ajax({
                    method: "POST",
                    url: "/patient",
                    dataType: "JSON",
                    data: customerData,
                    statusCode: {
                        201: function(data){
                            toastAlert('success', 'Paciente registrado', 'En breve se mostrará la información');
                            dt_basic.ajax.reload();
                        },
                        500: function(data){
                            toastAlert('error', 'Ocurrió un error', 'Por favor, intentalo más tarde');
                        }
                    }
                }).done(function(patient){

                    $('#personForm')[0].reset();

                    let cardId = patient.card_id +1 ;
                    $("#card_id").val(  cardId);

                });
            }else {
                toastAlert('warning', 'Datos incompletos', 'Por favor introduce una fecha de nacimiento');
                return false;
            }
        });

        // Customer datatable
        dt_basic = dt_basic_table.DataTable({
            ajax: {
                url: '/patient',
                dataSrc: ""
            },
            columns: [
                { data: 'card_id' },
                { data: 'card_id' },
                { data: 'name',render: function (data, type, row){
                    if(data != null) {
                        return row.name + " " + row.last_name
                    }else{
                        return '';
                    }
                    
                    }},
                {data:'city'},
                {data:'dob',
                render: function (data, type, row){
                    let badge = isTodayBirthday(row)? `<span class="badge rounded-pill bg-label-info">🎂🥳</span>`:''
                    return data!=null?
                        moment(data.date).format('DD/MM/YYYY')+badge: ''
                }
                },
                { data: 'main_phone',
                    render: function (data, type, row){
                    if(data == null) return '';
                    let validPhone = data.replace(/[^0-9]/g,'');
                    let html = `<a target="_blank" href="https://wa.me?phone=${validPhone}">${validPhone}</a>`
                    
                    if(isTodayBirthday(row))
                    {
                        html+=`<a
                                 target="_blank"
                                 href="https://wa.me?phone=${validPhone}&text=felicidades%20en%20tu20%cumpleaños">
                                    <span class="badge rounded-pill bg-label-info">🎂🥳</span>
                                </a>`
                    }
                      return html
                    }
                },
                { data: 'email' },
               
                { data: '', render: function (data, type, row){
                        let customerJson = JSON.stringify(row);
                        let patientId = row.id === null?0:row.id;
                        return `
                            <a href="/nueva-consulta/${patientId}?person=${row.person}"
                                class='btn btn-sm btn-text-secondary rounded-pill btn-icon'>
                                <i class='mdi mdi-prescription'></i>
                            </a>
                            <a href="javascript:void(0);" onclick='openEditCustomerModal(${customerJson})'
                                class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'
                                data-bs-toggle="modal" data-bs-target="#editCustomer">
                                <i class='mdi mdi-pencil-outline'></i>
                            </a>
                            <a href="paciente/${patientId}?person=${row.person}"
                                class='btn btn-sm btn-text-secondary rounded-pill btn-icon'>
                                <i class='mdi mdi-details'></i>
                            </a>
                            <a href="javascript:void(0);" onclick='deleteCustomer(${customerJson})'
                                class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'>
                                <i class='mdi mdi-delete'></i>
                            </a>
                        `
                    }   }
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
                    // For Id
                    orderable: true,
                    searchable: true,
                    targets: 1,
                    //title:'tarjeton'
                },
                {
                    // For Id
                    orderable: false,
                    searchable: true,
                    visible: false,
                    targets: -2,
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Acciones',
                    orderable: false,
                    searchable: false,

                }
            ],
            order: [[1, 'desc']],
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
                            return 'Detalles del cliente';
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
        $('div.head-label').html('<h5 class="card-title mb-0">Relación de pacientes</h5>');


        $('#workCheckInput').on('change', function() {
            if ($(this).is(':checked')) {
                $('#WorkEmployeeSection').removeClass('d-none');
            } else {
                $('#WorkEmployeeSection').addClass('d-none');
            }
        });

        $("input.searchable").on("change", function () {
            this.value
        })

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

    function isTodayBirthday(patient) {
        
        let isBirthday = false;
        if(patient.dob === null) return false;
        
        let birthDate = new Date(patient.dob.date);
        const today = new Date();
        const birthDay = birthDate.getDate();
        const birthMonth = birthDate.getMonth();

        if (today.getDate() === birthDay && today.getMonth() === birthMonth) {
            isBirthday= true;
        }
   
        return isBirthday;
    }

    function validateDate() {
        let dateValue = $('#person-dob').val();
        return !(!dateValue || dateValue.trim() === '');
    }
</script>

<?= $this->endSection() ?>
