<form id="orderForm" class="needs-validation">
    <div class="row">
        <!-- Sale -->
        <div class="col-md-6">
            <div class="mb-6">
                <div class="form-floating form-floating-outline">
                    <select
                        name="sale"
                        id="select2Sale"
                        class="select2 form-select form-select-lg"
                        data-allow-clear="true">
                        <option value="">Seleccione una venta</option>
                        <?php if(isset($sales)): ?>
                            <?php foreach($sales as $sale):?>
                                <option value="<?= $sale->id;?>">
                                    <?= $sale->id; ?> -<?=$sale->patient_name. " ". $sale->patient_lastname?> <?= date('d/m/Y', strtotime($sale->created_at)); ?>
                                </option>
                            <?php endforeach;?>
                        <?php endif; ?>
                    </select>
                    <label for="select2Sale">Venta</label>
                </div>
            </div>
        </div>

        <!-- Lab -->
        <div class="col-md-6">
            <div class="mb-6">
                <div class="form-floating form-floating-outline">
                    <select
                        name="lab"
                        id="select2Lab"
                        class="select2 form-select form-select-lg"
                        data-allow-clear="true">
                        <option value="">Seleccione un laboratorio</option>
                        <?php if(isset($labs)): ?>
                            <?php foreach($labs as $lab):?>
                                <option value="<?= $lab->id;?>">
                                    <?= $lab->company->name; ?>
                                </option>
                            <?php endforeach;?>
                        <?php endif; ?>
                    </select>
                    <label for="select2Lab">Laboratorio</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Patients Number -->
        <div class="col-md-4">
            <div class="input-group input-group-merge mb-4">
                <span id="basic-icon-default-patients" class="input-group-text">
                    <i class="mdi mdi-account-group"></i>
                </span>
                <div class="form-floating form-floating-outline">
                    <input
                        type="number"
                        class="form-control"
                        id="patients_number"
                        name="patients_number"
                        placeholder="1"
                        aria-label="1"
                        aria-describedby="basic-icon-default-patients" />
                    <label for="patients_number">Número de pacientes</label>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="col-md-4">
            <div class="mb-6">
                <div class="form-floating form-floating-outline">
                    <select
                        name="status"
                        id="select2Status"
                        class="select2 form-select form-select-lg"
                        data-allow-clear="true">
                        <option value="pending">Pendiente</option>
                        <option value="processing">En proceso</option>
                        <option value="to_delivery">Para entrega</option>
                        <option value="delivered">Entregado</option>
                        <option value="completed">Completado</option>
                        <option value="warranty">Garantía</option>
                    </select>
                    <label for="select2Status">Estado</label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-6">
                <div class="form-floating form-floating-outline">
                    <input type="text"
                           class="form-control"
                           id="lab_folio"
                           name="lab_folio"
                           placeholder="Folio Laboratorio"
                           aria-label="1"
                           aria-describedby="basic-icon-default-patients"/>
                    <label for="select2Status">Folio Laboratorio</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <!-- Lab Sent -->
        <div class="col-md-4">
            <div class="input-group input-group-merge mb-4">
                <span id="basic-icon-default-lab-sent" class="input-group-text">
                    <i class="mdi mdi-calendar"></i>
                </span>
                <div class="form-floating form-floating-outline">
                    <input
                        type="date"
                        class="form-control"
                        id="lab_sent"
                        name="lab_sent"
                        aria-describedby="basic-icon-default-lab-sent" />
                    <label for="lab_sent">Fecha de envío al laboratorio</label>
                </div>
            </div>
        </div>

        <!-- Lab Received -->
        <div class="col-md-4">
            <div class="input-group input-group-merge mb-4">
                <span id="basic-icon-default-lab-received" class="input-group-text">
                    <i class="mdi mdi-calendar-check"></i>
                </span>
                <div class="form-floating form-floating-outline">
                    <input
                        type="date"
                        class="form-control"
                        id="lab_received"
                        name="lab_received"
                        aria-describedby="basic-icon-default-lab-received" />
                    <label for="lab_received">Fecha de recepción del laboratorio</label>
                </div>
            </div>
        </div>

        <!-- Delivered -->
        <div class="col-md-4">
            <div class="input-group input-group-merge mb-4">
                <span id="basic-icon-default-delivered" class="input-group-text">
                    <i class="mdi mdi-calendar-check"></i>
                </span>
                <div class="form-floating form-floating-outline">
                    <input
                        type="date"
                        class="form-control"
                        id="delivered"
                        name="delivered"
                        aria-describedby="basic-icon-default-delivered" />
                    <label for="delivered">Fecha de entrega al cliente</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Save button -->
    <input type="hidden" value="<?=auth()->getUser()->id?>" name="created_by">
    <button class="btn btn-primary btn-card-block-overlay mt-4">Guardar</button>
</form>
