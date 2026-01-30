<div class="tab-pane" id="eye-health-tab" role="tabpanel">
    <form class="consulting" id="form-visual-background">
        <input
                type="hidden"
                name="patient"
                value="<?=htmlspecialchars($patient->id ?? '')?>"
        />
        <input type="hidden" name="consultation" class="consultation-id"  value="<?=htmlspecialchars($consultation->visual_background->consultation ?? '')?>">

        <div class="row mt-3">
            <div class="col-12 col-lg-2">
                <label class="form-label d-block">¿Ha usado anteojos?</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="glasses" id="used_glasses_yes" value="1" <?=((string)($consultation->visual_background->glasses ?? '') === '1') ? 'checked' : ''?>>
                    <label class="form-check-label" for="used_glasses_yes">Sí</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="glasses" id="used_glasses_no" value="0" <?=((string)($consultation->visual_background->glasses ?? '') === '0') ? 'checked' : ''?>>
                    <label class="form-check-label" for="used_glasses_no">No</label>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="form-floating form-floating-outline">
                    <input  id="last-check-date" name="last_check_date"  class=" form-control" placeholder="YYYY-MM-DD" value="<?=htmlspecialchars($consultation->visual_background?->last_check_date?->toDateString() ?? '')?>">
                    <label for="last_exam_date">Último examen</label>
                </div>
            </div>

            <?php
            if(isset($lastPrescription))://si tiene una prescripción previa
                ?>
                <div class="col-12 col-lg-8">
                    <div class="table-responsive">

                        <table id="last_rx_table" class="table mb-0 mt-2">
                            <caption > RX Anterior</caption>
                            <thead>
                            <tr>
                                <th></th>
                                <th>Esfera</th>
                                <th>Cilindro</th>
                                <th>Eje</th>
                                <th>Adición</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>O.D.</td>
                                <td><input type="number" step=".25" onchange="setFloatingPoint(this)" name="rx_prev_right_sphere" class="form-control form-control-sm" value="<?=htmlspecialchars($consultation->visual_background->rx_prev_right_sphere ?? '')?>"></td>
                                <td><input type="number" step=".25" onchange="setFloatingPoint(this)" name="rx_prev_right_cylinder" class="form-control form-control-sm" value="<?=htmlspecialchars($consultation->visual_background->rx_prev_right_cylinder ?? '')?>"></td>
                                <td><input type="number" step=".25" onchange="setFloatingPoint(this)" name="rx_prev_right_axis" class="form-control form-control-sm" value="<?=htmlspecialchars($consultation->visual_background->rx_prev_right_axis ?? '')?>"></td>
                                <td><input type="number" step=".25" onchange="setFloatingPoint(this)" name="rx_prev_right_add" class="form-control form-control-sm" value="<?=htmlspecialchars($consultation->visual_background->rx_prev_right_add ?? '')?>"></td>
                            </tr>
                            <tr>
                                <td>O.I.</td>
                                <td><input type="number" step=".25" onchange="setFloatingPoint(this)" name="rx_prev_left_sphere" class="form-control form-control-sm" value="<?=htmlspecialchars($consultation->visual_background->rx_prev_left_sphere ?? '')?>"></td>
                                <td><input type="number" step=".25" onchange="setFloatingPoint(this)" name="rx_prev_left_cylinder" class="form-control form-control-sm" value="<?=htmlspecialchars($consultation->visual_background->rx_prev_left_cylinder ?? '')?>"></td>
                                <td><input type="number" step=".25" onchange="setFloatingPoint(this)" name="rx_prev_left_axis" class="form-control form-control-sm" value="<?=htmlspecialchars($consultation->visual_background->rx_prev_left_axis ?? '')?>"></td>
                                <td><input type="number" step=".25" onchange="setFloatingPoint(this)" name="rx_prev_left_add" class="form-control form-control-sm" value="<?=htmlspecialchars($consultation->visual_background->rx_prev_left_add ?? '')?>"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="row mt-2">
            <div class="col-12 col-lg-2 mt-2 mb-2">
                <div class="form-check ">
                    <input class="form-check-input" type="checkbox"  name="fatigue" id="eye_fatigue" <?=($consultation->visual_background->fatigue ?? false) ? 'checked' : ''?> >
                    <label class="form-check-label" for="eye_fatigue"> Fatiga ocular  </label>
                </div>
            </div>
            <div class="col-12 col-lg-2 mt-2 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"  name="burning" id="burning" <?=($consultation->visual_background->burning ?? false) ? 'checked' : ''?> >
                    <label class="form-check-label" for="burning"> Ardor  </label>
                </div>
            </div>
            <div class="col-12 col-lg-2 mt-2 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"  name="itching" id="itchy" <?=($consultation->visual_background->itching ?? false) ? 'checked' : ''?> >
                    <label class="form-check-label" for="itchy"> Comezón  </label>
                </div>
            </div>
            <div class="col-12 col-lg-2 mt-2 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"  name="photophobia" id="photophobia" <?=($consultation->visual_background->photophobia ?? false) ? 'checked' : ''?> >
                    <label class="form-check-label" for="photophobia"> Fotofobia  </label>
                </div>
            </div>
            <div class="col-12 col-lg-2 mt-2 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"  name="redness" id="redness" <?=($consultation->visual_background->redness ?? false) ? 'checked' : ''?> >
                    <label class="form-check-label" for="redness"> Ojo Rojo  </label>
                </div>
            </div>
        </div>
        <div class="row mt-2 ">
            <div class="col-12 col-lg-4 mt-2 ">
                <div class="form-floating form-floating-outline mt-5">
                    <select name="blurry[]" id="blurry" class="select2" multiple  data-style="btn">
                        <option value="close" <?= (isset($consultation->visual_background->blurry) && ((is_array($consultation->visual_background->blurry) && in_array('close', $consultation->visual_background->blurry)) || ($consultation->visual_background->blurry === 'close'))) ? 'selected' : '' ?>>Visión Borrosa Cerca</option>
                        <option value="far" <?= (isset($consultation->visual_background->blurry) && ((is_array($consultation->visual_background->blurry) && in_array('far', $consultation->visual_background->blurry)) || ($consultation->visual_background->blurry === 'far'))) ? 'selected' : '' ?>>Visión Borrosa Lejos</option>
                        <option value="double" <?= (isset($consultation->visual_background->blurry) && ((is_array($consultation->visual_background->blurry) && in_array('double', $consultation->visual_background->blurry)) || ($consultation->visual_background->blurry === 'double'))) ? 'selected' : '' ?>>Visión Doble</option>
                    </select>
                    <label for="blurry">Visión Borrosa</label>
                </div>
            </div>
            <div class="col-12 col-lg-4 mt-2 ">
                <div class="form-floating form-floating-outline mt-5">
                    <select name="headache[]" id="headache" class="select2 w-100 " multiple  data-style="btn">
                        <option value="frontal" <?= (isset($consultation->visual_background->headache) && ((is_array($consultation->visual_background->headache) && in_array('frontal', $consultation->visual_background->headache)) || ($consultation->visual_background->headache === 'frontal'))) ? 'selected' : '' ?>>Frontal</option>
                        <option value="parietal" <?= (isset($consultation->visual_background->headache) && ((is_array($consultation->visual_background->headache) && in_array('parietal', $consultation->visual_background->headache)) || ($consultation->visual_background->headache === 'parietal'))) ? 'selected' : '' ?>>Parietal</option>
                        <option value="temporal" <?= (isset($consultation->visual_background->headache) && ((is_array($consultation->visual_background->headache) && in_array('temporal', $consultation->visual_background->headache)) || ($consultation->visual_background->headache === 'temporal'))) ? 'selected' : '' ?>>Temporal</option>
                        <option value="occipital" <?= (isset($consultation->visual_background->headache) && ((is_array($consultation->visual_background->headache) && in_array('occipital', $consultation->visual_background->headache)) || ($consultation->visual_background->headache === 'occipital'))) ? 'selected' : '' ?>>Occipital</option>
                    </select>
                    <label for="headache">Cefalea</label>
                </div>
            </div>
            <div class="col-12 col-lg-4 mt-2 ">
                <div class="form-floating form-floating-outline mt-5">
                    <select name="secretion[]"  id="secretion" class="select2 w-100 "  data-style="btn">
                        <option value=""></option>
                        <option value="white" <?= (isset($consultation->visual_background->secretion) && ((is_array($consultation->visual_background->secretion) && in_array('white', $consultation->visual_background->secretion)) || ($consultation->visual_background->secretion === 'white'))) ? 'selected' : '' ?>>Blanca</option>
                        <option value="transparent" <?= (isset($consultation->visual_background->secretion) && ((is_array($consultation->visual_background->secretion) && in_array('transparent', $consultation->visual_background->secretion)) || ($consultation->visual_background->secretion === 'transparent'))) ? 'selected' : '' ?>>Transparente</option>
                        <option value="yellow" <?= (isset($consultation->visual_background->secretion) && ((is_array($consultation->visual_background->secretion) && in_array('yellow', $consultation->visual_background->secretion)) || ($consultation->visual_background->secretion === 'yellow'))) ? 'selected' : '' ?>>Amarilla</option>
                        <option value="green" <?= (isset($consultation->visual_background->secretion) && ((is_array($consultation->visual_background->secretion) && in_array('green', $consultation->visual_background->secretion)) || ($consultation->visual_background->secretion === 'green'))) ? 'selected' : '' ?>>Verde</option>
                    </select>
                    <label for="secretion">Secreción</label>
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-12 mt-2 mb-3">
                <div class="form-floating form-floating-outline">

                    <textarea id="other_conditions" name="other_conditions" class="form-control" placeholder="Antecedentes Patológicos Oculares"><?=htmlspecialchars($consultation->visual_background->other_conditions ?? '')?></textarea>
                    <label for="other_conditions">Antecedentes Patológicos Oculares</label>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="form-floating form-floating-outline">

                    <textarea name="comments" id="visual_other" class="form-control" placeholder="Otro" style="height: 80px"><?=htmlspecialchars($consultation->visual_background->comments ?? '')?></textarea>
                    <label for="visual_other">Otro</label>
                </div>
            </div>
        </div>
    </form>
    <?php if(!$edit):?>
        <button  onclick="saveVisualBackground()" class="btn btn-primary mt-4">Guardar</button>
    <?php endif;?>
</div>
