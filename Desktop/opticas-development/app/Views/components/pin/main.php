<?= $this->extend('app') ?>

<?= $this->section('content') ?>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?= esc($title ?? 'PIN de descuento') ?></h4>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex flex-column">
                    <h5 class="mb-0">PIN actual</h5>
                    <small class="text-body">Este es el PIN de autorización de descuento configurado actualmente.</small>
                </div>
                <div class="card-body">
                    <div class="display-6 fw-bold" id="pin-display">
                        <?= esc($pin ?? '1111') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex flex-column">
                    <h5 class="mb-0">Actualizar PIN</h5>
                    <small class="text-body">Ingresa un nuevo PIN numérico de 4 a 6 dígitos.</small>
                </div>
                <div class="card-body">
                    <form id="update-pin" method="post" action="/descuentos/pin" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        <div class="form-floating form-floating-outline mb-3">
                            <input
                                required
                                type="password"
                                inputmode="numeric"
                                pattern="^\d{4,6}$"
                                class="form-control"
                                id="pin"
                                name="pin"
                                placeholder="Nuevo PIN"
                                aria-label="Nuevo PIN"
                                minlength="4"
                                maxlength="6"
                            />
                            <label for="pin">Nuevo PIN</label>
                            <div class="invalid-feedback">El PIN debe ser numérico de 4 a 6 dígitos.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
<?= $this->section('componentScripts') ?>
<script>
    $(function(){

        $("#update-pin").on("submit", function(e){
            e.preventDefault();

            $pinData = $(this).serializeArray();
            console.log($pinData);

            $.ajax({
                method: "PATCH",
                url: "/pin",
                data:$pinData,
                dataType: "JSON",
                statusCode: {
                    400: function(xhr){
                        console.log()
                        toastAlert("error", "error",xhr.responseJSON.messages.error,);
                    }
                }

            }).done(function(response){
                toastAlert("success", "PIN actualizado correctamente", "success");
                $("#pin-display").text(response.pin);
            })
        })
    });
</script>
<?= $this->endSection() ?>