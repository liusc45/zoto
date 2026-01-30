<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> Órdenes</h4>

    <div class="card mt-4">
        <div class="card-datatable table-responsive pt-0">
            <table id="ordersDatatable" class="datatables-basic table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Laboratorio</th>
                    <th>Estado</th>
                    <th>Enviado</th>
                    <th>Recibido</th>
                    <th>Entregado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <?= $this->include('modals/editOrder')?>
<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <script>
        console.log('Orders JS loaded')
        var dt_basic_table = $('.datatables-basic'), dt_basic;

        // Check if consultation_id is provided
        const consultationId = <?= isset($consultation_id) ? "'".$consultation_id."'" : 'null' ?>;

        $(function(){
            // Pre-fill form if consultation_id is provided
            if (consultationId) {
                console.log('Consultation ID provided:', consultationId);
                // Fetch consultation data
                $.ajax({
                    method: "GET",
                    url: `/consultation/${consultationId}`,
                    success: function(consultation) {
                        console.log('Consultation data:', consultation);
                        // Pre-fill form with consultation data
                        // You may need to adjust this based on your actual data structure

                        // Set patients_number to 1 by default for a consultation
                        $("#patients_number").val(1);

                        // Set status to pending by default
                        $("#select2Status").val("pending").trigger('change');

                        // You can add more pre-filling logic here based on the consultation data
                        // For example, if the consultation has a sale associated with it:
                        // if (consultation.sale) {
                        //     $("#select2Sale").val(consultation.sale).trigger('change');
                        // }
                    },
                    error: function(error) {
                        console.error('Error fetching consultation data:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudo cargar la información de la consulta',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            }

            // Orders form
            $("form#orderForm").on("submit", function(e){
                e.preventDefault();
                blocking();
                let orderData = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url: "/order",
                    data: orderData,
                    success: function(response){
                        console.log(response);
                        dt_basic.ajax.reload();
                        $("form#orderForm").trigger("reset");
                        unblocking();


                    },
                    error: function(error){
                        console.error(error);
                        unblocking();
                        toastAlert('error','Error', 'Ha ocurrido un error al crear la orden')

                    }
                });
            });

            // DataTable initialization
            if (dt_basic_table.length) {
                dt_basic = dt_basic_table.DataTable({
                    ajax: {
                        url: '/order',
                        dataSrc: ''
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'id' },
                        { data: 'id' },
                        { data: '',render: function (data, type, full, meta) {
                            return full.patient_name + " " + full.patient_lastname
                            } },
                        { data: 'lab_name' },
                        { data: 'status' },
                        { data: 'lab_sent' },
                        { data: 'lab_received' },
                        { data: 'delivered' },
                        { data: 'id' }
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
                            // Status
                            targets: 5,
                            render: function (data, type, full, meta) {
                                let statusClasses = {
                                    'pending': 'bg-label-warning',
                                    'processing': 'bg-label-info',
                                    'to_delivery': 'bg-label-primary',
                                    'delivered': 'bg-label-success',
                                    'completed': 'bg-label-success',
                                    'warranty': 'bg-label-danger'
                                };

                                let statusNames = {
                                    'pending': 'Pendiente',
                                    'processing': 'En proceso',
                                    'to_delivery': 'Para entrega',
                                    'delivered': 'Entregado',
                                    'completed': 'Completado',
                                    'warranty': 'Garantía'
                                };

                                return (
                                    '<span class="badge ' + statusClasses[data] + '">' + statusNames[data] + '</span>'
                                );
                            }
                        },
                        {
                            // Actions
                            targets: -1,
                            title: 'Acciones',
                            orderable: false,
                            searchable: false,
                            render: function (data, type, full, meta) {
                                return (
                                    '<div class="d-inline-block">' +
                                    '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>' +
                                    '<div class="dropdown-menu dropdown-menu-end">' +
                                    '<a href="javascript:;" class="dropdown-item edit-record" data-id="' + full.id + '">Editar</a>' +
                                    '<a href="javascript:;" class="dropdown-item delete-record" data-id="' + full.id + '">Eliminar</a>' +
                                    '</div>' +
                                    '</div>'
                                );
                            }
                        }
                    ],
                    order: [[2, 'desc']],
                    dom: '<"card-header"<"head-label text-center"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    displayLength: 10,
                    lengthMenu: [10, 25, 50, 75, 100],
                    buttons: [
                        {
                            extend: 'collection',
                            className: 'btn btn-label-primary dropdown-toggle me-2',
                            text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">Exportar</span>',
                            buttons: [
                                {
                                    extend: 'print',
                                    text: '<i class="mdi mdi-printer-outline me-1" ></i>Imprimir',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7, 8, 9]
                                    }
                                },
                                {
                                    extend: 'csv',
                                    text: '<i class="mdi mdi-file-document-outline me-1" ></i>Csv',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7, 8, 9]
                                    }
                                },
                                {
                                    extend: 'excel',
                                    text: '<i class="mdi mdi-file-excel-outline me-1" ></i>Excel',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7, 8, 9]
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    text: '<i class="mdi mdi-file-pdf-box me-1" ></i>Pdf',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7, 8, 9]
                                    }
                                },
                                {
                                    extend: 'copy',
                                    text: '<i class="mdi mdi-content-copy me-1" ></i>Copiar',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [3, 4, 5, 6, 7, 8, 9]
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
                                    return 'Detalles de la orden';
                                }
                            }),
                            type: 'column',
                            renderer: function (api, rowIdx, columns) {
                                var data = $.map(columns, function (col, i) {
                                    return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                        ? '<tr data-dt-row="' +
                                        col.rowIdx +
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
            }

            // Delete Record
            $(document).on('click', '.delete-record', function () {
                var id = $(this).data('id'),
                    title = $(this).data('name');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: 'DELETE',
                            url: '/order/' + id,
                            success: function () {
                                dt_basic.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Eliminado!',
                                    text: 'La orden ha sido eliminada.',
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                            },
                            error: function (error) {
                                console.error(error);
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Ha ocurrido un error al eliminar la orden',
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                });
                            }
                        });
                    }
                });
            });

            // Edit Record
            $(document).on('click', '.edit-record', function () {
                var id = $(this).data('id');

                $.ajax({
                    type: 'GET',
                    url: '/order/' + id,
                    success: function (response) {
                        $('#editOrderModal').modal('show');
                        $('#editOrderForm #id').val(response.id);
                        $('#editOrderForm #sale').val(response.sale);
                        $('#editOrderForm #lab').val(response.lab);
                        $('#editOrderForm #patients_number').val(response.patients_number);
                        $('#editOrderForm #status').val(response.status);

                        // Format dates if they exist
                        if (response.lab_sent) {
                            $('#editOrderForm #lab_sent').val(response.lab_sent.split(' ')[0]);
                        }
                        if (response.lab_received) {
                            $('#editOrderForm #lab_received').val(response.lab_received.split(' ')[0]);
                        }
                        if (response.delivered) {
                            $('#editOrderForm #delivered').val(response.delivered.split(' ')[0]);
                        }
                    },
                    error: function (error) {
                        console.error(error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al cargar los datos de la orden',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            });

            // Update Order
            $('#editOrderForm').on('submit', function (e) {
                e.preventDefault();
                var id = $('#editOrderForm #id').val();
                var formData = $(this).serialize();

                $.ajax({
                    type: 'PUT',
                    url: '/order/' + id,
                    data: formData,
                    success: function (response) {
                        $('#editOrderModal').modal('hide');
                        dt_basic.ajax.reload();
                        Swal.fire({
                            title: 'Orden actualizada',
                            text: 'La orden ha sido actualizada correctamente',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    },
                    error: function (error) {
                        console.error(error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al actualizar la orden',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    }
                });
            });
        });

        function blocking() {
            $('#card-block').block({
                message: '<div class="spinner-border text-white" role="status"></div>',
                timeout: 1000,
                css: {
                    backgroundColor: 'transparent',
                    border: '0'
                },
                overlayCSS: {
                    backgroundColor: '#000',
                    opacity: 0.1
                }
            });
        }

        function unblocking() {
            $('#card-block').unblock();
        }
    </script>
<?= $this->endSection() ?>
