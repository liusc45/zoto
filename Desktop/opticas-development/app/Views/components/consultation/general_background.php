<div class="tab-pane fade  show active" id="general-background-tab" role="tabpanel">
    <form class="consulting" id="form-general">
        <input
                type="hidden"
                name="patient"
                value="<?=$patient->id ?>"
        />
        <input
                type="hidden"
                name="consultation"
                class="consultation-id"
                value="<?=htmlspecialchars($consultation->id)?>"
        />
        <div class="col-md p-6">
            <label >¿Sano?</label>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input glassCheck"
                    type="radio"
                    name="healthy"
                    id="positive-health"
                    value="1"
                    onInput="displayHealthInfo(false)"
                    <?= !$edit ?'checked' :( $consultation?->general_background?->healthy   ? 'checked' : '') ?>
                />
                <label class="form-check-label" for="inlineRadio1">Sí</label>
            </div>
            <div class="form-check form-check-inline">
                <input
                    class="form-check-input glassCheck"
                    type="radio"
                    name="healthy"
                    id="negative-healt"
                    value="0"
                    onInput="displayHealthInfo(true)"
                        <?=  $edit &&!$consultation?->general_background?->healthy   ? 'checked' : '' ?>
                
                />
                <label class="form-check-label" for="inlineRadio2">No</label>
            </div>
        </div>
        <div class="row  mt-2" id="generalCheckInput" style="display: none">
            <div class="row mt-2">
                <div class="col-12 col-lg-2">
                    <label>¿Diabético?</label>
                    <div class="form-check ">
                        <input class="form-check-input"
                               type="radio" name="diabetes"
                               value="1" <?= $consultation?->general_background?->diabetes  ? 'checked' : '' ?> > Sí
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="radio" name="diabetes" value="0" <?= !$consultation?->general_background?->diabetes ? 'checked' : '' ?> > No
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <input type="date" name="last_glucose_date" class="form-control diabetes" disabled placeholder="YYYY-MM-DD" value="<?=htmlspecialchars($consultation?->general_background?->last_glucose_date?->toDateString() ?? '')?>">
                        <label>Fecha última glucosa</label>
                    </div>
                </div>
           
                <div class="col-12 col-lg-2">
                    <div class="form-floating form-floating-outline">
                        <input type="number" min="0" max="30" name="glucose_date_number" id="approximate_date_number" class="form-control diabetes" disabled placeholder="96" value="<?=htmlspecialchars($consultation->general_background->glucose_date_number ?? '')?>">
                        <label for="approximate_date_number">Aproximadamente</label>
                    </div>
                </div>
                <div class="col-12 col-lg-2">
                    <div class="form-floating form-floating-outline">
                        <select class="form-select select2  diabetes" disabled name="glucose_date_unit" id="approximate_date_unit">
                            <option value="days" <?= (($consultation->general_background->glucose_date_unit ?? '') === 'days') ? 'selected' : '' ?>>días</option>
                            <option value="weeks" <?= (($consultation->general_background->glucose_date_unit ?? '') === 'weeks') ? 'selected' : '' ?>>semanas</option>
                            <option value="months" <?= (($consultation->general_background->glucose_date_unit ?? '') === 'months') ? 'selected' : '' ?>>meses</option>
                            <option value="years" <?= (($consultation->general_background->glucose_date_unit ?? '') === 'years') ? 'selected' : '' ?>>años </option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-lg-2">
                    <div class="form-floating form-floating-outline">
                        <input type="text" name="glucose_level" id="glucose_level" class="form-control diabetes" disabled placeholder="96" value="<?=htmlspecialchars($consultation->general_background->glucose_level ?? '')?>">
                        <label>mg/dL</label>
                    </div>
                </div>
            </div>
            <hr class="mt-2" >
            <div class="row mt-2">
                <div class="col-12 col-lg-2">
                    <label>¿Hipertenso?</label>
                    <div class="form-check ">
                        <input class="form-check-input" type="radio" name="hypertensive" value="1" <?= $consultation?->general_background?->hypertensive  ? 'checked' : '' ?>> Sí
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="radio" name="hypertensive" value="0" <?= !$consultation?->general_background?->hypertensive  ? 'checked' : '' ?>> No
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <input type="date" id="last_blood_pressure_date" name="last_blood_pressure_date" class="form-control hypertensive" disabled placeholder="YYYY-MM-DD" value="<?=htmlspecialchars($consultation->general_background?->last_blood_pressure_date?->toDateString() ?? '')?>">
                        <label>Fecha última medición</label>
                    </div>
                </div>
                <div class="col-12 col-lg-2">
                    <div class="form-floating form-floating-outline">
                        <input type="number" min="0" max="30" name="blood_date_number" id="approximate_date_number" class="form-control hypertensive" disabled placeholder="96" value="<?=htmlspecialchars($consultation->general_background->blood_date_number ?? '')?>">
                        <label for="approximate_date_number">Aproximadamente</label>
                    </div>
                </div>
                <div class="col-12 col-lg-2">
                    <div class="form-floating form-floating-outline">
                        <select class="form-select select2 hypertensive" disabled name="blood_date_unit" id="approximate_date_unit">
                        <option value="days" <?= (($consultation->general_background->blood_date_unit ?? '') === 'days') ? 'selected' : '' ?>>días</option>
                        <option value="weeks" <?= (($consultation->general_background->blood_date_unit ?? '') === 'weeks') ? 'selected' : '' ?>>semanas</option>
                        <option value="months" <?= (($consultation->general_background->blood_date_unit ?? '') === 'months') ? 'selected' : '' ?>>meses</option>
                        <option value="years" <?= (($consultation->general_background->blood_date_unit ?? '') === 'years') ? 'selected' : '' ?>>años </option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-lg-2">
                    <div class="form-floating form-floating-outline">
                        <input type="text" name="blood_pressure_level" class="form-control hypertensive" disabled placeholder="120/80" value="<?=htmlspecialchars($consultation->general_background->blood_pressure_level ?? '')?>">
                        <label>mm Hg</label>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 mt-3 mb-3">
                <div class="form-floating form-floating-outline">
                    <textarea name="comments" id="others" class="form-control" placeholder="Otros" style="height: 60px"><?=htmlspecialchars($consultation->general_background->comments ?? '')?></textarea>
                    <label for="others">Otros</label>
                </div>
            </div>
            <div class="col-12 mt-3 mb-3">
                <div class="form-floating form-floating-outline">
                    <textarea name="observations" id="observations" class="form-control" placeholder="Observaciones" style="height: 60px"><?=htmlspecialchars($consultation->general_background->observations ?? '')?></textarea>
                    <label for="observations">Observaciones</label>
                </div>
            </div>
        </div>
    </form>
    <?php if(!$edit):?>
    <button  onclick="saveGeneralBackground()" class="btn btn-primary mt-4">Guardar</button>
    <?php endif;?>
</div>
