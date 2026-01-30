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

<div class="card mt-4">
    <div class="card-datatable table-responsive pt-0">
        <table id="birthdaysDatatable" class="datatables-basic table table-bordered">
            <thead>
            <tr>
                <th></th>
                <th>Tarjetón</th>
                <th>Nombre(s)</th>
                <th>Fecha de nacimiento</th>
                <th>Contacto</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($birthdays as $patient): ?>
                <tr>
                    <td><?= $patient->id ?></td>
                    <td><?= $patient->card_id ?></td>
                    <td><?= $patient->name . " ". $patient->last_name ?></td>
                    <td><?= $patient->dob ?></td>
                    <td><?= $patient->main_phone ?></td>
                    <td>
                        <a href="/paciente/<?=$patient->id?>"><i class="mdi mdi-details"></i></a>
                    </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/moment/moment.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script>
    var dt_basic_table = $('.datatables-basic'), dt_basic;

    $(function(){
        dt_basic = dt_basic_table.DataTable({

            columns: [
                { data: 'id' },
                { data: 'card_id' },
                { data: 'name'},
                {data:'dob',
                    render: function (data, type, row){
                        let badge = isTodayBirthday(row)? `<span class="badge rounded-pill bg-label-info">🎂🥳</span>`:''
                        return data!=null?
                            moment(data).format('DD/MM/YYYY')+badge: ''
                    }
                },
                { data: 'main_phone',
                    render: function (data, type, row){
                        if(data == null) return '';
                        let validPhone = data.replace(/[^0-9]/g,'');
                        if(validPhone.length < 10) return '';
                        console.log(validPhone)
                        let html = `<a target="_blank" href="https://wa.me?phone=${validPhone}">${validPhone}</a>`
                        if(isTodayBirthday(row))
                        {
                            html+=`<a
                                     target="_blank"
                                     href="https://wa.me?phone=${validPhone}&text=felicidades%20en%20tu%20cumpleaños">
                                        <span class="badge rounded-pill bg-label-info">🎂🥳</span>
                                    </a>`
                        }
                        return html
                    }
                },
                { data: '', render: function (data, type, row){
                        let customerJson = JSON.stringify(row);
                        let patientId = row.id === null?0:row.id;
                        return `
                            <a href="/nueva-consulta/${patientId}?person=${row.person}"
                                class='btn btn-sm btn-text-secondary rounded-pill btn-icon'>
                                <i class='mdi mdi-prescription'></i>
                            </a>
                            <a href="paciente/${patientId}?person=${row.person}"
                                class='btn btn-sm btn-text-secondary rounded-pill btn-icon'>
                                <i class='mdi mdi-details'></i>
                            </a>
                        `
                    }   }
            ],
            columnDefs: [
                {
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
                    orderable: true,
                    searchable: true,
                    targets: 1,
                },
                {
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
            buttons: [],
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
        $('div.head-label').html('<h5 class="card-title mb-0">Cumpleañeros de hoy</h5>');
    });

    function isTodayBirthday(patient) {
        debugger;
        let isBirthday = false;
        if(patient.dob === null) return false;
        let birthDate = new Date(patient.dob);
        const today = new Date();
        const birthDay = birthDate.getDate();
        const birthMonth = birthDate.getMonth();
        if (today.getDate() === birthDay && today.getMonth() === birthMonth) {
            isBirthday= true;
        }
        return isBirthday;
    }
</script>
<?= $this->endSection() ?>
