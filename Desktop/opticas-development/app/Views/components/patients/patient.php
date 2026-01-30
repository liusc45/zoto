<div class="card mb-6">
    <div class="card-body pt-12">
        <div class="user-avatar-section">
            <div class="d-flex align-items-center flex-column">
                <div class="user-info text-center">
                    <h5><?= $patient->name . ' '. $patient->last_name ?></h5>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-around flex-wrap my-6 gap-0 gap-md-3 gap-lg-4">
            <div class="d-flex align-items-center gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="mdi mdi-face-woman-profile"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0"><?=$patient->id?></h5>
                    <span>Identificador</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-4">
                <div class="avatar">
                    <div class="avatar-initial bg-label-primary rounded-3">
                        <i class="mdi mdi-account-card"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0"><?=$patient->card_id?></h5>
                    <span>Tarjetón</span>
                </div>
            </div>
        </div>
        <h5 class="pb-2 border-bottom mb-3 mt-4">Detalles</h5>
        <div class="info-container">
            <ul class="list-unstyled mb-6">
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Nombre(s):</span>
                    <span><?=$patient->name?></span>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Apellidos:</span>
                    <span><?=$patient->last_name?></span>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Correo:</span>
                    <span><?=$patient->email?></span>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Fecha de Nac:</span>
                    <?php if(!is_null($patient->dob)):?>

                    <span><?=str_replace(" "," de ", $patient->dob?->toLocalizedString("d MMMM Y")??'')?> (<?=$patient->dob?->getAge() ?> ) años</span>
                    <?php endif;?>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Domicilio:</span>
                    <span><span><?=$patient->street?></span></span>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Ciudad:</span>
                    <span><span><?=$patient->city?></span></span>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Estado:</span>
                    <span><span><?=$patient->state?></span> </span>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">CP:</span>
                    <span><span><?=$patient->postal_code?></span></span>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Ciudad:</span>
                    <span><?=$patient->city?></span>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Teléfono:</span>
                    <span><?=$patient->main_phone?></span>
                </li>
                <?php if(!empty($patient->phones)):?>
                <h6 class="pb-2 border-bottom mb-1 mt-2">Otros teléfonos:</h6>

                <?php foreach($patient->phones as $key => $phone):?>
                    <li class="mb-2">
                        <span class="fw-medium text-heading me-2"><?=$phone->type?>:</span>
                        <span><?=$phone->number?></span>
                        <i class="mdi mdi-trash-can-outline" onclick="deletePhone(<?=$phone->id?>,this)"></i>

                    </li>
                <?php endforeach; endif;?>
            </ul>
            <?php if(!empty($taxInfo)):
                foreach($taxInfo as $key => $taxPerson):?>

                    <div class="col-md">
                        <div class="card card-action mb-4">
                            <div class="card-header">
                                <div class="card-action-title"><?=$taxPerson->nickname?></div>
                                <div class="card-action-element">
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons mdi mdi-chevron-up"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="collapse " style="">
                                <div class="card-body">
                                    <ul class="p-0 m-0">

                                        <li class="d-flex mb-4 pb-1">

                                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-1">RFC</h6>
                                                </div>
                                                <div class="user-progress d-flex align-items-center gap-1">
                                                    <h6 class="mb-0"><?=$taxPerson?->rfc?></h6>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4 pb-1">
                                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-1">Razón Social</h6>
                                                </div>
                                                <div class="user-progress d-flex align-items-center gap-1">
                                                    <h6 class="mb-0"><?=$taxPerson?->tax_name?></h6>
                                                </div>
                                            </div>

                                        </li>
                                    </ul>
                                    <div class="btn-group w-100">
                                        <button type="button"
                                                data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasTaxID"
                                                class="btn btn-primary btn-sm"
                                                onclick='editTaxInfo(<?= json_encode($taxPerson)?>)'>
                                        <i class="mdi mdi-pencil-outline me-1"></i>Editar
                                        </button>
                                        <button type="button"
                                                class="btn btn-danger btn-sm"
                                                onclick="deleteTaxInfo(<?=$taxPerson->id?>)">
                                            <i class="tf-icons ri-delete-bin-line me-1"></i>Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; endif;?>
            <div class="d-flex  justify-content-center">
                <a href="javascript:;"
                   onclick='openEditCustomerModal(<?=json_encode($patient)?>)'
                   class="btn btn-sm btn-primary me-2 mt-2 col-2"
                   data-bs-target="#editCustomer"
                   data-bs-toggle="modal">
                    <i class="mdi mdi-pencil"></i>
                </a>
                <a href="javascript:;"
                   class="btn btn-sm btn-primary me-2 mt-2 col-2 "
                   data-bs-toggle="modal"
                   data-bs-target="#newPhoneModal"
                   aria-controls="newPhoneModal">
                    <i class="mdi mdi-phone-plus"></i>
                </a>
                <a href="javascript:;"
                   onclick="clearForm()"
                   class="btn btn-sm btn-primary me-2 mt-2 col-2"
                   data-bs-toggle="offcanvas"
                   data-bs-target="#offcanvasTaxID"
                   aria-controls="offcanvasTaxID">
                    <i class="mdi mdi-file-document-edit"></i>
                </a>
                <a href="/nueva-consulta/<?=$patient->id?>"
                   class="btn btn-sm me-2 mt-2 btn-primary col-2 ">
                    <i class='mdi mdi-prescription'></i>

                </a>
                <a href="javascript:;"
                   class="btn btn-sm me-2 mt-2 btn-primary col-2"
                   id="newPrescription"
                   data-patient-id="<?=$patient->id?>">
                    <i class="mdi mdi-eye-plus-outline"></i>
                </a>

            </div>
        </div>
    </div>
</div>
