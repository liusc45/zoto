<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"
          xmlns="http://www.w3.org/1999/html"/>
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?=$this->include('partials/breadcrumb');?>


<div class="col-12">
    <div class="card mb-6">
        <div class="card-header p-0">
            <div class="nav-align-top">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-justified-home"
                                aria-controls="navs-justified-home"
                                aria-selected="true">
                            <span class="d-none d-sm-block">
                                  <i class="tf-icons ri-home-smile-line me-2"></i> Micas
                            </span>
                            <i class="ri-home-smile-line ri-20px d-sm-none"></i>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-justified-profile"
                                aria-controls="navs-justified-profile"
                                aria-selected="false">
                              <span class="d-none d-sm-block">
                                  <i class="tf-icons ri-user-3-line me-2"></i> Tratamientos
                              </span>
                            <i class="ri-user-3-line ri-20px d-sm-none"></i>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-justified-messages"
                                aria-controls="navs-justified-messages"
                                aria-selected="false">
                              <span class="d-none d-sm-block">
                                  <i class="tf-icons ri-message-2-line me-2"></i> Adicionales
                              </span>
                            <i class="ri-message-2-line ri-20px d-sm-none"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content p-0">
                <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                    <?=$this->include('partials/lens')?>
                </div>
                <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                    CONTENIDO DOS
                </div>
                <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                    CONTENIDO TRES
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="card mt-4">
        <div class="card-datatable table-responsive pt-0">
            <table id="lensDatatable" class="datatables-basic table table-bordered">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Corrección Óptica</th>
                    <th>Material</th>
                    <th>Tipo</th>
                    <th>Color</th>
                    <th>Tipo Corrección</th>
                    <th>Tratamiento</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>id</th>
                    <th>Corrección Óptica</th>
                    <th>Material</th>
                    <th>Tipo</th>
                    <th>Color</th>
                    <th>Tipo Corrección</th>
                    <th>Tratamiento</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

<?= $this->include('modals/editLens')?>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
    <script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="/assets/js/custom/lens-datatable.js"></script>
    <script>
        console.log('Lens js loaded');
        let dt_basic_table = $('#lensDatatable'), dt_basic;

        $(".select2").select2({tags:true})
        $(function(){
            lensDatatable(dt_basic_table);
            // Transaction form
            $("form").on("submit",function(e){
                e.preventDefault();
                blocking();
                let lensData = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url: "/lens",
                    dataType: "JSON",
                    data: lensData,
                }).done(function(lens){
                    if(lens.id != null){
                        toastAlert('success', 'Lente guardado', 'La configuración del lente se guardo correctamente');
                        $('#lensForm')[0].reset();
                        dt_basic.ajax.reload();
                    }else{
                        toastAlert('error', 'Ocurrió un problema', 'Por favor, intentalo nuevamente');
                    }
                });
            });

            // Lens datatable
            $('div.head-label').html('<h5 class="card-title mb-0">Relación de micas</h5>');

            $("#editLensForm").on("submit", event=>{
                event.preventDefault();
            })

            $("#editLensForm input").on("change",event=>{
                let postData = {
                    '_method': 'PATCH'
                };
                postData[event.currentTarget.name]=event.currentTarget.value;
                let updatedCell = event.currentTarget.name+$('#modalEditLensID').val();
                editLens(postData, updatedCell, event.currentTarget.name);
            });

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

        function openLensModal(lens)
        {
            document.getElementById("modalEditLensID").value = lens.id;
            document.getElementById("modalEditLensCost").value = lens.cost;
            document.getElementById("modalEditLensPrice").value = lens.price;
        }

        function editLens(postData)
        {
            $.ajax({
                method: 'POST',
                url: '/lens/'+$('#modalEditLensID').val(),
                data: postData,
                dataType: 'JSON',
            }).done(function(response){
                if(response){
                    toastAlert('success', 'Mica actualizada', 'La información se actualizó correctamente');
                    dt_basic.ajax.reload();
                } else{
                    toastAlert('error', 'Algo salió mal', 'Por favor, intentalo nuevamente');
                }
            });
        }

        function deleteLens(lens)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No serás capaz de recuperar este lente",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, borrar lente!',
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
                        url: '/lens/'+lens.id,
                        data: { '_method': 'DELETE'},
                        dataType: 'JSON'
                    }).done(function(response){
                        toastAlert('info', 'Lente borrado', 'El lente se borró satisfactoriamente');
                        dt_basic.ajax.reload();
                    })
                }
            });
        }
    </script>
<?= $this->endSection() ?>
