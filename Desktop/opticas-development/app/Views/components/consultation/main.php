<?php

use App\Entities\Consultation;

?>
<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
<link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light"><?= env('app.title')?> /</span><?=$path?>
</h4>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tarjeta informativa</h5>
                    <div class="d-flex flex-column float-end">
                        <small class="text-body float-end">Consulta: <span id="consultation-id-display"><?= $edit ? $consultation->id : 'Nueva' ?></span></small>
                        <small class="text-body float-end">Convenio: <span>{{xxx}}</span></small>
                    </div>
                </div>
                <div class="card-body">
                    <form id="patient-form">
                        <div class="row">
                            <div class="col-12 col-lg-9">
                                <div class="form-floating form-floating-outline mb-6">
                                   <a href="/paciente/<?= $patient->id?>">
                                       <?=$patient->name." ".$patient->last_name ?>
                                   </a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="created_at" class="form-control" placeholder="YYYY-MM-DD" value="<?=$consultation?->created_at??date('Y-m-d H:i:s')?>" id="flatpickr-date" />
                                    <label for="flatpickr-date">Fecha</label>
                                </div>
                            </div>
                        </div><div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    Atendido por:
                                    <?php if($edit):?>
                                    <input type="text" class="form-control-plaintext" readonly name="doctor" value="<?=$doctor?->name??''?>">
                                    <?php else:?>
                                    <select name='attended_by'  id="select-doctor" class="selectpicker w-100" data-style="btn">

                                        <option >Propia</option>
                                        <?php
                                        foreach($doctors as $doctor):?>
                                        <option value="<?=$doctor->id?>"><?=$doctor->name. " ".$doctor->last_name ?></option>
                                        <?php endforeach; endif;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!--   tabs -->
                    <div class="mt-4">
                        <div class="card-header p-0">
                            <div class="nav-align-top">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button
                                                type="button"
                                                class="nav-link active "
                                                role="tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#general-background-tab"
                                                aria-controls="general-background-tab"
                                                aria-selected="true">
                                            <span class="d-none d-sm-block">
                                                <i class="tf-icons ri-home-smile-line me-2"></i>
                                              Antecedentes Generales
                                            </span>
                                            <i class="ri-home-smile-line ri-20px d-sm-none"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button
                                                type="button"
                                                class="nav-link "
                                                role="tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#eye-health-tab"
                                                aria-controls="eye-health-tab"
                                                aria-selected="true">
                                            <span class="d-none d-sm-block">
                                                <i class="tf-icons ri-home-smile-line me-2"></i>
                                                Antecedentes Visuales
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
                                                data-bs-target="#visual-evaluation-tab"
                                                aria-controls="visual-evaluation-tab"
                                                aria-selected="false">
                                            <span class="d-none d-sm-block">
                                                <i class="tf-icons ri-user-3-line me-2"></i>
                                                Evaluación Visual
                                            </span>
                                            <i class="ri-user-3-line ri-20px d-sm-none"></i>
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button
                                                type="button"
                                                class="nav-link "
                                                role="tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#navs-justified-messages"
                                                aria-controls="navs-justified-messages"
                                                aria-selected="false">
                                            <span class="d-none d-sm-block">
                                                <i class="tf-icons ri-message-2-line me-2"></i>
                                                Lentes de contacto
                                            </span>
                                            <i class="ri-message-2-line ri-20px d-sm-none"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!--Antecedentes Generales -->
                               <?=$this->include('components/consultation/general_background')?>
                                <!--Salud Ocular -->
                                <?=$this->include('components/consultation/visual_background')?>
                                <!--Evaluación visual-->
                                <?=$this->include('components/consultation/visual_evaluation')?>

                                <!--RX actual-->
                                <div class="tab-pane fade" id="navs-actual-rx" role="tabpanel">
                                    <form class="consulting" id="prescription">
                                        <input type="hidden" name="patient" value="<?=$patient->id?>">
                                    </form>
                                </div>

                                <!--contacto-->
                                <?=$this->include('components/consultation/contact_lenses')?>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/moment/moment.js"></script>
<script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="/assets/vendor/libs/toastr/toastr.js"></script>
<script src="/assets/vendor/libs/select2/select2.js"></script>
<script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="/assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="/js/global.js"></script>
<script src="/assets/js/custom/consultation.js"></script>

<?php if($edit):?>
<script src="/assets/js/custom/consultation-edit.js"></script>
<?php endif;?>
<script>
    let consulting = <?=!is_null($consultation)?
                        json_encode($consultation):
                        json_encode(new Consultation([
                                "patient"=> $patient->id,
                                "visual_evaluation"=>new \App\Entities\VisualEvaluation()
                        ]) )
            ?>
    ;
    let imageFromDb = consulting?.visual_evaluation?.anomalies_image?.length > 0;

    const radiusConversion = 337.50;

    let inputKeratometry = $(".keratometry");
    //onload
    $(function () {

        inputKeratometry.on('input', function(e){
           let input = e.target;
            let result = radiusConversion/parseFloat(input.value);

            $("#calculated_"+input.id).val(result.toFixed(3));
        });


    });

    function setFloatingPoint(element)
    {
        // Handle the input value properly
        let valueToProcess = element.value;

        // If the value starts with a '+', remove it for parsing
        if (valueToProcess.startsWith('+')) {
            valueToProcess = valueToProcess.substring(1);
        }

        // Parse the value and format it to 2 decimal places
        let val = parseFloat(valueToProcess);
        if (isNaN(val)) {
            val = 0;
        }
        val = val.toFixed(2);

        let sphereOrCylinder = element.id.includes("...") || element.id.includes("...");
        let formatted = Intl.NumberFormat('es-MX', {signDisplay: 'always'}).format(val);

        element.type = sphereOrCylinder ?'text':'number';
        element.value = sphereOrCylinder ? formatted : val;
    }



</script>
<?= $this->endSection() ?>
