<div class="tab-pane" id="visual-evaluation-tab" role="tabpanel">
    <form class="consulting" id="form-visual-evaluation">
        <input
            type="hidden"
            name="patient"
            value="<?=$patient->id?>"
        />
        <input type="hidden" name="consultation" class="consultation-id"  value="<?=@$consultation->id?>">

        <div class="row mt-3">
            <div class="col-12 col-lg-4">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                        type="text"
                        id="anterior_segment"
                        name="anterior_segment"
                        class="form-control"
                        placeholder="Segmento Anterior"
                        value="<?=htmlspecialchars($consultation->visual_evaluation->anterior_segment ?? '')?>"
                    />
                    <label for="basic-default-phone">Segmento Anterior</label>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="form-floating form-floating-outline">
                    <select
                        name="cover_test"
                        id="select2CoverTest"
                        class="select2 form-select form-select-lg"
                        data-allow-clear="true">
                        <option value="null" <?= (($consultation->visual_evaluation->cover_test ?? 'null') === 'null') ? 'selected' : '' ?>></option>
                        <option value="ortoforia" <?= (($consultation->visual_evaluation->cover_test ?? '') === 'ortoforia') ? 'selected' : '' ?>>Ortoforia</option>
                        <option value="exoforia" <?= (($consultation->visual_evaluation->cover_test ?? '') === 'exoforia') ? 'selected' : '' ?>>Exoforia</option>
                        <option value="exotropia" <?= (($consultation->visual_evaluation->cover_test ?? '') === 'exotropia') ? 'selected' : '' ?>>Exotropia</option>
                        <option value="endorforia" <?= (($consultation->visual_evaluation->cover_test ?? '') === 'endorforia') ? 'selected' : '' ?>>Endorforia</option>
                        <option value="endotropia" <?= (($consultation->visual_evaluation->cover_test ?? '') === 'endotropia') ? 'selected' : '' ?>>Endotropia</option>
                        <option value="hipertopria" <?= (($consultation->visual_evaluation->cover_test ?? '') === 'hipertopria') ? 'selected' : '' ?>>Hipertopria</option>
                        <option value="hipotropia" <?= (($consultation->visual_evaluation->cover_test ?? '') === 'hipotropia') ? 'selected' : '' ?>>Hipotropía</option>
                        <option value="cicloforia" <?= (($consultation->visual_evaluation->cover_test ?? '') === 'cicloforia') ? 'selected' : '' ?>>Cicloforia</option>
                    </select>
                    <label for="select2Basic">Cover Test</label>
                </div>
            </div>
            <div class="col-12 col-lg-4 ">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                        type="text"
                        id="posterior_segment"
                        name="posterior_segment"
                        class="form-control"
                        placeholder="Segmento Posterior"
                        value="<?=htmlspecialchars($consultation->visual_evaluation->posterior_segment ?? '')?>" />
                    <label for="posterior_segment">Segmento Posterior</label>
                </div>
            </div>
        </div>
        <div class="divider">
            <div class="divider-text">Oftalmoscopia</div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-12 col-lg-12 mt-2">
                <div class="card">
                    <div class="card-body text-center">
                        <canvas id="eyeCanvas" width="600" height="300" style="border:1px solid #ccc; cursor: crosshair;"></canvas>

                        <div class="row">
                            <div class="mt-2 col">
                                <button type="button" class="btn btn-sm btn-secondary" id="clearCanvas">Limpiar dibujo</button>
                            </div>
                            <?php if($edit):?>
                                <div class="mt-2 col">
                                    <button type="button" class="btn btn-sm btn-secondary" id="updateImage">Actualizar dibujo</button>
                                </div>
                            <?php endif;?>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 mt-3 align-content-center">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="text"
                            id="oftalmoscopy"
                            name="oftalmoscopy"
                            class="form-control"
                            placeholder="Oftalmoscopia / Fondo de Ojo"
                            value="<?=htmlspecialchars($consultation->visual_evaluation->oftalmoscopy ?? '')?>"
                    />
                    <label for="oftalmoscopy">Oftalmoscopia / Fondo de Ojo</label>
                </div>
            </div>
            <div class="col-12 col-lg-4 mt-3 align-content-center">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="text"
                            id="others"
                            name="others"
                            class="form-control"
                            placeholder="Otros"
                            value="<?=htmlspecialchars($consultation->visual_evaluation->others ?? '')?>"
                    />
                    <label for="others">Otros</label>
                </div>

            </div>

        </div>

        <div class="row mt-3">

            <!-- AV COLUMN -->
            <div class="col text-center  ">
                <div class="divider">
                    <div class="divider-text">Agudeza Visual</div>
                </div>

                <div class="form-floating form-floating-outline">
                    <select name="right_acuity_before" id="avsa-rigth" class="selectpicker w-100 "  data-style="btn">
                        <option  <?= (($consultation->visual_evaluation->right_acuity_before ?? 'null') === 'null') ? 'selected' : '' ?> >O.D</option>
                        <option value="light_perception" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === 'light_perception') ? 'selected' : '' ?>>Percepción de Luz</option>
                        <option value="fingers" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === 'fingers') ? 'selected' : '' ?>>Cuenta Dedos</option>
                        <option value="0.05" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '0.05') ? 'selected' : '' ?>>0.05</option>
                        <option value="0.1" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '0.1') ? 'selected' : '' ?>>0.1</option>
                        <option value="0.2" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '0.2') ? 'selected' : '' ?>>0.2</option>
                        <option value="0.3" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '0.3') ? 'selected' : '' ?>>0.3</option>
                        <option value="0.4" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '0.4') ? 'selected' : '' ?>>0.4</option>
                        <option value="0.5" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '0.5') ? 'selected' : '' ?>>0.5</option>
                        <option value="0.6" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '0.6') ? 'selected' : '' ?>>0.6</option>
                        <option value="0.7" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '0.7') ? 'selected' : '' ?>>0.7</option>
                        <option value="0.8" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '0.8') ? 'selected' : '' ?>>0.8</option>
                        <option value="0.9" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '0.9') ? 'selected' : '' ?>>0.9</option>
                        <option value="1.0" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '1.0') ? 'selected' : '' ?>>1.0</option>
                        <option value="1.2" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '1.2') ? 'selected' : '' ?>>1.2</option>
                        <option value="1.5" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '1.5') ? 'selected' : '' ?>>1.5</option>
                        <option value="2.0" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '2.0') ? 'selected' : '' ?>>2.0</option>
                        <option value="20/400" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/400') ? 'selected' : '' ?>>20/400</option>
                        <option value="20/300" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/300') ? 'selected' : '' ?>>20/300</option>
                        <option value="20/200" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/200') ? 'selected' : '' ?>>20/200</option>
                        <option value="20/100" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/100') ? 'selected' : '' ?>>20/100</option>
                        <option value="20/80" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/80') ? 'selected' : '' ?>>20/80</option>
                        <option value="20/70" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/70') ? 'selected' : '' ?>>20/70</option>
                        <option value="20/60" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/60') ? 'selected' : '' ?>>20/60</option>
                        <option value="20/50" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/50') ? 'selected' : '' ?>>20/50</option>
                        <option value="20/40" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/40') ? 'selected' : '' ?>>20/40</option>
                        <option value="20/30" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/30') ? 'selected' : '' ?>>20/30</option>
                        <option value="20/25" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/25') ? 'selected' : '' ?>>20/25</option>
                        <option value="20/20" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/20') ? 'selected' : '' ?>>20/20</option>
                        <option value="20/15" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/15') ? 'selected' : '' ?>>20/15</option>
                        <option value="20/10" <?= (($consultation->visual_evaluation->right_acuity_before ?? '') === '20/10') ? 'selected' : '' ?>>20/10</option>
                    </select>
                    <label for="avsa-rigth">Ojo Derecho</label>
                </div>

                <div class="form-floating form-floating-outline mt-2">
                    <select name="left_acuity_before" id="av-l" class="selectpicker w-100 "  data-style="btn">
                        <option value="null" <?= (($consultation->visual_evaluation->left_acuity_before ?? 'null') === 'null') ? 'selected' : '' ?>>O.I.</option>
                        <option value="light_perception" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === 'light_perception') ? 'selected' : '' ?>>Percepción de Luz</option>
                        <option value="fingers" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === 'fingers') ? 'selected' : '' ?>>Cuenta Dedos</option>
                        <option value="0.05" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.05') ? 'selected' : '' ?>>0.05</option>
                        <option value="0.1" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.1') ? 'selected' : '' ?>>0.1</option>
                        <option value="0.2" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.2') ? 'selected' : '' ?>>0.2</option>
                        <option value="0.3" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.3') ? 'selected' : '' ?>>0.3</option>
                        <option value="0.4" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.4') ? 'selected' : '' ?>>0.4</option>
                        <option value="0.5" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.5') ? 'selected' : '' ?>>0.5</option>
                        <option value="0.6" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.6') ? 'selected' : '' ?>>0.6</option>
                        <option value="0.7" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.7') ? 'selected' : '' ?>>0.7</option>
                        <option value="0.8" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.8') ? 'selected' : '' ?>>0.8</option>
                        <option value="0.9" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.9') ? 'selected' : '' ?>>0.9</option>
                        <option value="1.0" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '1.0') ? 'selected' : '' ?>>1.0</option>
                        <option value="1.2" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '1.2') ? 'selected' : '' ?>>1.2</option>
                        <option value="1.5" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '1.5') ? 'selected' : '' ?>>1.5</option>
                        <option value="2.0" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '2.0') ? 'selected' : '' ?>>2.0</option>
                        <option value="20/400" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/400') ? 'selected' : '' ?>>20/400</option>
                        <option value="20/300" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/300') ? 'selected' : '' ?>>20/300</option>
                        <option value="20/200" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/200') ? 'selected' : '' ?>>20/200</option>
                        <option value="20/100" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/100') ? 'selected' : '' ?>>20/100</option>
                        <option value="20/80" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/80') ? 'selected' : '' ?>>20/80</option>
                        <option value="20/70" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/70') ? 'selected' : '' ?>>20/70</option>
                        <option value="20/60" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/60') ? 'selected' : '' ?>>20/60</option>
                        <option value="20/50" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/50') ? 'selected' : '' ?>>20/50</option>
                        <option value="20/40" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/40') ? 'selected' : '' ?>>20/40</option>
                        <option value="20/30" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/30') ? 'selected' : '' ?>>20/30</option>
                        <option value="20/25" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/25') ? 'selected' : '' ?>>20/25</option>
                        <option value="20/20" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/20') ? 'selected' : '' ?>>20/20</option>
                        <option value="20/15" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/15') ? 'selected' : '' ?>>20/15</option>
                        <option value="20/10" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/10') ? 'selected' : '' ?>>20/10</option>
                    </select>
                    <label for="av-l">Ojo Izquierdo </label>
                </div>

            </div>

            <!-- CV COLUMN -->
            <div class="col text-center">

                <div class="divider">
                    <div class="divider-text">Capacidad Visual</div>
                </div>
                <div class="form-floating form-floating-outline">
                    <select name="right_capacity" id="cv-rigth" class="selectpicker w-100 "  data-style="btn">
                        <option value="null" <?= (($consultation->visual_evaluation->right_capacity ?? 'null') === 'null') ? 'selected' : '' ?>>O.D.</option>
                        <option value="light_perception" <?= (($consultation->visual_evaluation->right_capacity ?? '') === 'light_perception') ? 'selected' : '' ?>>Percepción de Luz</option>
                        <option value="fingers" <?= (($consultation->visual_evaluation->right_capacity ?? '') === 'fingers') ? 'selected' : '' ?>>Cuenta Dedos</option>
                        <option value="0.05" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '0.05') ? 'selected' : '' ?>>0.05</option>
                        <option value="0.1" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '0.1') ? 'selected' : '' ?>>0.1</option>
                        <option value="0.2" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '0.2') ? 'selected' : '' ?>>0.2</option>
                        <option value="0.3" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '0.3') ? 'selected' : '' ?>>0.3</option>
                        <option value="0.4" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '0.4') ? 'selected' : '' ?>>0.4</option>
                        <option value="0.5" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '0.5') ? 'selected' : '' ?>>0.5</option>
                        <option value="0.6" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '0.6') ? 'selected' : '' ?>>0.6</option>
                        <option value="0.7" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '0.7') ? 'selected' : '' ?>>0.7</option>
                        <option value="0.8" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '0.8') ? 'selected' : '' ?>>0.8</option>
                        <option value="0.9" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '0.9') ? 'selected' : '' ?>>0.9</option>
                        <option value="1.0" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '1.0') ? 'selected' : '' ?>>1.0</option>
                        <option value="1.2" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '1.2') ? 'selected' : '' ?>>1.2</option>
                        <option value="1.5" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '1.5') ? 'selected' : '' ?>>1.5</option>
                        <option value="2.0" <?= (($consultation->visual_evaluation->right_capacity ?? '') === '2.0') ? 'selected' : '' ?>>2.0</option>
                    </select>
                    <label for="selectpickerBasic">Capacidad Visual</label>
                </div>

                <div class="form-floating form-floating-outline mt-2">
                    <select id="left_capacity" name="left_capacity" class="selectpicker w-100 "  data-style="btn">
                        <option value="null" <?= (($consultation->visual_evaluation->left_capacity ?? 'null') === 'null') ? 'selected' : '' ?>>O.I</option>
                        <option value="light_perception" <?= (($consultation->visual_evaluation->left_capacity ?? '') === 'light_perception') ? 'selected' : '' ?>>Percepción de Luz</option>
                        <option value="fingers" <?= (($consultation->visual_evaluation->left_capacity ?? '') === 'fingers') ? 'selected' : '' ?>>Cuenta Dedos</option>
                        <option value="0.05" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '0.05') ? 'selected' : '' ?>>0.05</option>
                        <option value="0.1" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '0.1') ? 'selected' : '' ?>>0.1</option>
                        <option value="0.2" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '0.2') ? 'selected' : '' ?>>0.2</option>
                        <option value="0.3" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '0.3') ? 'selected' : '' ?>>0.3</option>
                        <option value="0.4" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '0.4') ? 'selected' : '' ?>>0.4</option>
                        <option value="0.5" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '0.5') ? 'selected' : '' ?>>0.5</option>
                        <option value="0.6" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '0.6') ? 'selected' : '' ?>>0.6</option>
                        <option value="0.7" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '0.7') ? 'selected' : '' ?>>0.7</option>
                        <option value="0.8" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '0.8') ? 'selected' : '' ?>>0.8</option>
                        <option value="0.9" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '0.9') ? 'selected' : '' ?>>0.9</option>
                        <option value="1.0" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '1.0') ? 'selected' : '' ?>>1.0</option>
                        <option value="1.2" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '1.2') ? 'selected' : '' ?>>1.2</option>
                        <option value="1.5" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '1.5') ? 'selected' : '' ?>>1.5</option>
                        <option value="2.0" <?= (($consultation->visual_evaluation->left_capacity ?? '') === '2.0') ? 'selected' : '' ?>>2.0</option>
                    </select>
                    <label for="selectpickerBasic">Capacidad Visual</label>
                </div>
            </div>
            <div class="col text-center ">
                <div class="divider">
                    <div class="divider-text">Distancia Interpupilar</div>
                </div>
                <div class="input-group mb-3">
                    <input
                            type="number"
                            onchange="setFloatingPoint(this)"
                            name="interpupilar_distance[0]"
                            value="<?=htmlspecialchars($consultation->visual_evaluation->interpupilar_distance[0] ?? 40)?>"
                            min="40" max="80" step=".1"
                            class="form-control form-control-sm interpupilar_distance">
                    <span class="input-group-text">/</span>
                    <input
                            type="number"
                            onchange="setFloatingPoint(this)"
                            name="interpupilar_distance[1]"
                            value="<?=htmlspecialchars($consultation->visual_evaluation->interpupilar_distance[1] ?? 40)?>"
                            min="40" max="80" step=".1"
                            class="form-control form-control-sm interpupilar_distance">
                </div>
            </div>
            <!-- Altura de Oblea COLUMN -->
            <div class="col text-center">
                <div class="divider">
                    <div class="divider-text">Altura de Oblea</div>
                </div>
                <div class="form-floating form-floating-outline">
                    <input type="number" onchange="setFloatingPoint(this)"  id="right_wafer_height" name="right_wafer_height"  min="5" max="50" step="1" value="<?=htmlspecialchars($consultation->visual_evaluation->right_wafer_height ?? 5)?>" class="form-control form-control-sm">
                    <label for="">Ojo derecho</label>
                </div>
                <div class="form-floating form-floating-outline mt-2">
                    <input type="number" onchange="setFloatingPoint(this)" id="left_wafer_height" name="left_wafer_height"  min="5" max="50" step="1" value="<?=htmlspecialchars($consultation->visual_evaluation->left_wafer_height ?? 5)?>" class="form-control form-control-sm">
                    <label for="">Ojo izquierdo</label>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="divider">
                <div class="divider-text">Examen actual</div>
            </div>
            <!--Last prescription COLUMN -->
            <div class="col-12 col-lg-6">

                <div class="table-responsive">
                    <input
                            type="hidden"
                            name="last_prescription"
                            id="last_prescription"
                            value="1"
                    />
                    <table id="last_rx_table" class=" mb-0 mt-2 table table-sm ">
                        <caption style="caption-side: top" > RX Anterior</caption>
                        <thead>
                        <tr>
                            <th></th>
                            <th>Esfera</th>
                            <th>Cilindro</th>
                            <th>Eje     </th>
                            <th>Adición</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php $final = $prescriptions["last"]->details->final ?? null ?>
                            <td>O.D.</td>
                            <td>
                                <input
                                        type="number"
                                        step=".25"
                                        onchange="setFloatingPoint(this)"
                                        name="prescription[final][right][sphere]"
                                        id="last_right_sphere"
                                        class="form-control form-control-sm last"
                                        data-prescription-detail="<?=htmlspecialchars($final->right->id ?? '')?>"
                                        value="<?=htmlspecialchars($final->right->sphere ?? '')?>"
                                />
                            </td>
                            <td>
                                <input
                                        type="number"
                                        step=".25"
                                        onchange="setFloatingPoint(this)"
                                        name="prescription[final][right][cylinder]"
                                        id="last_right_cylinder"
                                        class="form-control form-control-sm last"
                                        data-prescription-detail="<?=htmlspecialchars($final->right->id ?? '')?>"
                                        value="<?=htmlspecialchars($final->right->cylinder ?? '')?>">
                            </td>
                            <td><input
                                        type="number"
                                        name="prescription[final][right][axis]"
                                        id="last_right_axis"
                                        class="form-control form-control-sm last"
                                        data-prescription-detail="<?=htmlspecialchars($final->right->id ?? '')?>"
                                        value="<?=htmlspecialchars($final->right->axis ?? '')?>" >
                            </td>
                            <td><input
                                        type="number"
                                        step=".25"
                                        onchange="setFloatingPoint(this)"
                                        name="prescription[final][right][addition]"
                                        id="last_right_addition"
                                        class="form-control form-control-sm last"
                                        data-prescription-detail="<?=htmlspecialchars($final->right->id ?? '')?>"
                                        value="<?=htmlspecialchars($final->right->addition ?? '')?>">
                            </td>
                        </tr>
                        <tr>
                            <td>O.I.</td>
                            <td><input type="number"
                                       step=".25"
                                       onchange="setFloatingPoint(this)"
                                       name="prescription[final][left][sphere]"
                                       id="last_left_sphere" class="form-control form-control-sm last"
                                       data-prescription-detail="<?=htmlspecialchars($final->left->id ?? '')?>"
                                       value="<?=htmlspecialchars($final->left->sphere ?? '')?>">
                            </td>
                            <td><input type="number"
                                       step=".25"
                                       onchange="setFloatingPoint(this)"
                                       name="prescription[final][left][cylinder]"
                                       id="last_left_cylinder"
                                       class="form-control form-control-sm last"
                                       data-prescription-detail="<?=htmlspecialchars($final->left->id ?? '')?>"
                                       value="<?=htmlspecialchars($final->left->cylinder ?? '')?>">
                            </td>
                            <td><input type="number"
                                       name="prescription[final][left][axis]"
                                       id="last_left_axis"
                                       class="form-control form-control-sm last"
                                       data-prescription-detail="<?=htmlspecialchars($final->left->id ?? '')?>"
                                       value="<?=htmlspecialchars($final->left->axis ?? '')?>">
                            </td>
                            <td><input type="number"
                                       step=".25"
                                       onchange="setFloatingPoint(this)"
                                       name="prescription[final][left][addition]"
                                       id="last_left_addition" class="form-control form-control-sm last"
                                       data-prescription-detail="<?=htmlspecialchars($final->left->id ?? '')?>"
                                       value="<?=htmlspecialchars($final->left->addition ?? '')?>">
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <div class="form-floating form-floating-outline mt-3 ">
                        <input type="text"
                               class="form-control"
                               placeholder="YYYY-MM-DD"
                               value="<?=htmlspecialchars($prescriptions["last"]?->created_at ?? date('Y-m-d'))?>"
                               id="last_prescription_created_at"
                               name="created_at"
                        />
                        <label for="last_prescription_created_at">Fecha último examen</label>
                    </div>
                    <?php if(isset($lastPrescription)):?>
                    <button onclick="saveLastPrescription()" class="btn btn-primary mt-4 waves-effect waves-light">
                        Guardar
                    </button>
                    <?php endif;?>
                </div>
            </div>
            <!--Total  COLUMN -->
            <div class="col-12 col-lg-6">
                <div class="table-responsive">

                    <table id="last_rx_table" class=" mb-0 mt-2 table table-sm">
                        <caption style="caption-side: top" > RX Total</caption>
                        <thead>
                        <tr>
                            <th>Esfera</th>
                            <th>Cilindro</th>
                            <th>Eje     </th>
                            <th>Adición</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php $total = $prescriptions["current"]->details->total ?? null ?>
                            <td class="col-3">
                                <input
                                        type="number"
                                        step=".25" onchange="setFloatingPoint(this)" id="total_right_sphere"
                                        name="prescription[total][right][sphere]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($total->right->id ?? '')?>"
                                        value="<?=htmlspecialchars($total->right->sphere ?? '')?>">


                            </td>
                            <td class="col-3">
                                <input
                                        type="number"
                                        step=".25" onchange="setFloatingPoint(this)" id="total_right_cylinder"
                                        name="prescription[total][right][cylinder]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($total->right->id ?? '')?>"
                                        value="<?=htmlspecialchars($total->right->cylinder ?? '')?>">


                            </td>
                            <td class="col-3">
                                <input
                                        type="number"
                                        step="5"  min="0" max="180"
                                        id="total_right_axis"
                                        name="prescription[total][right][axis]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($total->right->id ?? '')?>"
                                        value="<?=htmlspecialchars($total->right->axis ?? '')?>">


                            </td>
                            <td class="col-3">
                                <input
                                        type="number"
                                        step=".25" onchange="setFloatingPoint(this)"
                                        id="total_right_addition"
                                        name="prescription[total][right][addition]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($total->right->id ?? '')?>"
                                        value="<?=htmlspecialchars($total->right->addition ?? '')?>">


                            </td>
                        </tr>
                        <tr>
                            <td class="col-3">
                                <input
                                        type="number"
                                        step=".25" onchange="setFloatingPoint(this)"
                                        id="total_left_sphere"
                                        name="prescription[total][left][sphere]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($total->left->id ?? '')?>"
                                        value="<?=htmlspecialchars($total->left->sphere ?? '')?>">


                            </td>
                            <td class="col-3">
                                <input
                                        type="number"
                                        step=".25" onchange="setFloatingPoint(this)"
                                        id="total_left_cylinder"
                                        name="prescription[total][left][cylinder]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($total->left->id ?? '')?>"
                                        value="<?=htmlspecialchars($total->left->cylinder ?? '')?>">


                            </td>
                            <td class="col-3">
                                <input
                                        type="number"
                                        step="5"  min="0" max="180"
                                        id="total_left_axis"
                                        name="prescription[total][left][axis]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($total->left->id ?? '')?>"
                                        value="<?=htmlspecialchars($total->left->axis ?? '')?>">


                            </td>
                            <td class="col-3">
                                <input
                                        type="number"
                                        step=".25" onchange="setFloatingPoint(this)"
                                        id="total_left_addition"
                                        name="prescription[total][left][addition]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($total->left->id ?? '')?>"
                                        value="<?=htmlspecialchars($total->left->addition ?? '')?>">

                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?php if(!$edit):?>
                        <button onclick="setFinalPrescription()" class="btn btn-primary mt-4 waves-effect waves-light">
                            Aplicar
                        </button>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <div class="row">

        </div>
        <div class="row">
            <!--Autorrefractometro COLUMN -->
            <div class="col-12 col-lg-6">
                <div class="table-responsive">

                    <table id="last_rx_table" class=" mb-0 mt-2">
                        <caption style="caption-side: top" > Autorrefractometro</caption>
                        <thead>
                        <tr>
                            <th>Esfera</th>
                            <th>Cilindro</th>
                            <th>Eje     </th>
                            <th>Adición</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php $arf = $prescriptions["current"]->details->autorrefractometer ?? null ?>
                            <td class="col-3">
                                <input type="number"
                                       step=".25"
                                       onchange="setFloatingPoint(this)"
                                       id="total_right_sphere"
                                       name="prescription[autorrefractometer][right][sphere]"
                                       class="form-control form-control-sm current"
                                       data-prescription-detail="<?=htmlspecialchars($arf->right->id ?? '')?>"
                                       value="<?=htmlspecialchars($arf->right->sphere ?? '')?>">


                            </td>
                            <td class="col-3">
                                <input type="number"
                                       step=".25"
                                       onchange="setFloatingPoint(this)"
                                       id="total_right_cylinder"
                                       name="prescription[autorrefractometer][right][cylinder]"
                                       class="form-control form-control-sm current"
                                       data-prescription-detail="<?=htmlspecialchars($arf->right->id ?? '')?>"
                                       value="<?=htmlspecialchars($arf->right->cylinder ?? '')?>">


                            </td>
                            <td class="col-3">
                                <input type="number"
                                       step="1"  min
                                       ="0" max="180"
                                       id="total_right_axis"
                                       name="prescription[autorrefractometer][right][axis]"
                                       class="form-control form-control-sm current"
                                       data-prescription-detail="<?=htmlspecialchars($arf->right->id ?? '')?>"
                                       value="<?=htmlspecialchars($arf->right->axis ?? '')?>">


                            </td>
                            <td class="col-3">
                                <input type="number"
                                       step=".25"
                                       onchange="setFloatingPoint(this)" id="total_right_addition"
                                       name="prescription[autorrefractometer][right][addition]"
                                       class="form-control form-control-sm current"
                                       data-prescription-detail="<?=htmlspecialchars($arf->right->id ?? '')?>"
                                       value="<?=htmlspecialchars($arf->right->addition ?? '')?>">


                            </td>
                        </tr>
                        <tr>
                            <td class="col-3"><input
                                        type="number"
                                        step=".25"
                                        onchange="setFloatingPoint(this)"
                                        id="total_left_sphere"
                                        name="prescription[autorrefractometer][left][sphere]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($arf->left->id ?? '')?>"
                                        value="<?=htmlspecialchars($arf->left->sphere ?? '')?>">


                            </td>
                            <td class="col-3"><input
                                        type="number"
                                        step=".25"
                                        onchange="setFloatingPoint(this)"
                                        id="total_left_cylinder"
                                        name="prescription[autorrefractometer][left][cylinder]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($arf->left->id ?? '')?>"
                                        value="<?=htmlspecialchars($arf->left->cylinder ?? '')?>">


                            </td>
                            <td class="col-3"><input
                                        type="number"
                                        step="1"  min="0" max="180"
                                        id="total_left_axis"
                                        name="prescription[autorrefractometer][left][axis]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($arf->left->id ?? '')?>"
                                        value="<?=htmlspecialchars($arf->left->axis ?? '')?>">



                            </td>
                            <td class="col-3"><input
                                        type="number"
                                        step=".25"
                                        onchange="setFloatingPoint(this)"
                                        id="total_left_addition"
                                        name="prescription[autorrefractometer][left][addition]"
                                        class="form-control form-control-sm current"
                                        data-prescription-detail="<?=htmlspecialchars($arf->left->id ?? '')?>"
                                        value="<?=htmlspecialchars($arf->left->addition ?? '')?>">


                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <?php $currentFinal = $prescriptions["current"]->details->final ?? null ?>
            <!-- ESFERA COLUMN -->

            <div class="col-12 col-lg-6 ">
                <div class="table-responsive">
                    <table id="last_rx_table" class=" mb-0 mt-2">
                        <caption style="caption-side: top" > Rx Final</caption>
                        <thead>
                        <tr>
                            <th>Esfera</th>
                            <th>Cilindro</th>
                            <th>Eje     </th>
                            <th>Adición</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="col-3">
                                <input type="number"
                                       id="final_right_sphere"
                                       onchange="setFloatingPoint(this)"
                                       step=".25"
                                       name="prescription[final][right][sphere]"
                                       class="form-control form-control-sm current"
                                       data-prescription-detail="<?=htmlspecialchars($currentFinal->right->id ?? '')?>"
                                       value="<?=htmlspecialchars($currentFinal->right->sphere ?? '')?>">

                            </td>
                            <td class="col-3">
                                <input type="number" id="final_right_cylinder"
                                       onchange="setFloatingPoint(this)" step=".25"
                                       name="prescription[final][right][cylinder]"
                                       data-prescription-detail="<?=htmlspecialchars($currentFinal->right->id ?? '')?>"
                                       value="<?=htmlspecialchars($currentFinal->right->cylinder ?? '')?>"
                                       class="form-control form-control-sm current">
                            </td>
                            <td class="col-3">
                                <input type="number" step="1"  min="0" max="180"
                                       id="final_right_axis"
                                       name="prescription[final][right][axis]"
                                       data-prescription-detail="<?=htmlspecialchars($currentFinal->right->id ?? '')?>"
                                       value="<?=htmlspecialchars($currentFinal->right->axis ?? '')?>"
                                       class="form-control form-control-sm current">
                            </td>
                            <td class="col-3">
                                <input type="number"
                                       onchange="setFloatingPoint(this)"
                                       step=".25" id="final_right_addition"
                                       name="prescription[final][right][addition]"
                                       data-prescription-detail="<?=htmlspecialchars($currentFinal->right->id ?? '')?>"
                                       value="<?=htmlspecialchars($currentFinal->right->addition ?? '')?>"
                                       class="form-control form-control-sm current">

                            </td>
                        </tr>
                        <tr>
                            <td class="col-3">
                                <input type="number"
                                       id="final_left_sphere"
                                       onchange="setFloatingPoint(this)"
                                       step=".25" name="prescription[final][left][sphere]"
                                       data-prescription-detail="<?=htmlspecialchars($currentFinal->left->id ?? '')?>"
                                       value="<?=htmlspecialchars($currentFinal->left->sphere ?? '')?>"

                                       class="form-control form-control-sm current">
                            </td>
                            <td class="col-3">
                                <input type="number"
                                       id="final_left_cylinder"
                                       onchange="setFloatingPoint(this)" step=".25"
                                       name="prescription[final][left][cylinder]"
                                       data-prescription-detail="<?=htmlspecialchars($currentFinal->left->id ?? '')?>"
                                       value="<?=htmlspecialchars($currentFinal->left->cylinder ?? '')?>"
                                       class="form-control form-control-sm current">
                            </td>
                            <td class="col-3">
                                <input type="number"
                                       step="1" min="0" max="180"
                                       id="final_left_axis"
                                       name="prescription[final][left][axis]"
                                       data-prescription-detail="<?=htmlspecialchars($currentFinal->left->id ?? '')?>"
                                       value="<?=htmlspecialchars($currentFinal->left->axis ?? '')?>"
                                       class="form-control form-control-sm current">
                            </td>
                            <td class="col-3">
                                <input type="number"
                                       onchange="setFloatingPoint(this)" step=".25"
                                       id="final_left_addition"
                                       name="prescription[final][left][addition]"
                                       data-prescription-detail="<?=htmlspecialchars($currentFinal->left->id ?? '')?>"
                                       value="<?=htmlspecialchars($currentFinal->left->addition ?? '')?>"

                                       class="form-control form-control-sm current">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col ">
                <div class="divider">
                    <div class="divider-text">Agudeza Visual Con Corrección</div>
                </div>

                <div class="form-floating form-floating-outline">
                    <select name="right_acuity_after" id="avsa-rigth" class="selectpicker w-100 " data-style="btn">
                        <option value="null" <?= (($consultation->visual_evaluation->right_acuity_after ?? 'null') === 'null') ? 'selected' : '' ?>>O.D.</option>
                        <option value="light_perception" <?= (($consultation->visual_evaluation->right_acuity_after ?? '') === 'light_perception') ? 'selected' : '' ?>>Percepción de Luz</option>
                        <option value="fingers" <?= (($consultation->visual_evaluation->right_acuity_after ?? '') === 'fingers') ? 'selected' : '' ?> > Cuenta Dedos </option>
                        <option value="0.05" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.05') ? 'selected' : '' ?>>0.05</option>
                        <option value="0.1" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.1') ? 'selected' : '' ?>>0.1</option>
                        <option value="0.2" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.2') ? 'selected' : '' ?>>0.2</option>
                        <option value="0.3" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.3') ? 'selected' : '' ?>>0.3</option>
                        <option value="0.4" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.4') ? 'selected' : '' ?>>0.4</option>
                        <option value="0.5" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.5') ? 'selected' : '' ?>>0.5</option>
                        <option value="0.6" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.6') ? 'selected' : '' ?>>0.6</option>
                        <option value="0.7" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.7') ? 'selected' : '' ?>>0.7</option>
                        <option value="0.8" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.8') ? 'selected' : '' ?>>0.8</option>
                        <option value="0.9" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '0.9') ? 'selected' : '' ?>>0.9</option>
                        <option value="1.0" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '1.0') ? 'selected' : '' ?>>1.0</option>
                        <option value="1.2" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '1.2') ? 'selected' : '' ?>>1.2</option>
                        <option value="1.5" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '1.5') ? 'selected' : '' ?>>1.5</option>
                        <option value="2.0" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '2.0') ? 'selected' : '' ?>>2.0</option>
                        <option value="20/400" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/400') ? 'selected' : '' ?>>20/400</option>
                        <option value="20/300" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/300') ? 'selected' : '' ?>>20/300</option>
                        <option value="20/200" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/200') ? 'selected' : '' ?>>20/200</option>
                        <option value="20/100" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/100') ? 'selected' : '' ?>>20/100</option>
                        <option value="20/80" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/80') ? 'selected' : '' ?>>20/80</option>
                        <option value="20/70" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/70') ? 'selected' : '' ?>>20/70</option>
                        <option value="20/60" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/60') ? 'selected' : '' ?>>20/60</option>
                        <option value="20/50" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/50') ? 'selected' : '' ?>>20/50</option>
                        <option value="20/40" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/40') ? 'selected' : '' ?>>20/40</option>
                        <option value="20/30" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/30') ? 'selected' : '' ?>>20/30</option>
                        <option value="20/25" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/25') ? 'selected' : '' ?>>20/25</option>
                        <option value="20/20" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/20') ? 'selected' : '' ?>>20/20</option>
                        <option value="20/15" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/15') ? 'selected' : '' ?>>20/15</option>
                        <option value="20/10" <?= (($consultation->visual_evaluation->left_acuity_before ?? '') === '20/10') ? 'selected' : '' ?>>20/10</option>
                    </select>
                    <label for="selectpickerBasic">Ojo derecho</label>
                </div>

                <div class="form-floating form-floating-outline mt-2">
                    <select name="left_acuity_after" id="av-l" class="selectpicker w-100 "  data-style="btn">
                        <option value="null" <?= (($consultation->visual_evaluation->left_acuity_after ?? 'null') === 'null') ? 'selected' : '' ?>>O.I</option>
                        <option value="light_perception" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === 'light_perception') ? 'selected' : '' ?>>Percepción de Luz</option>
                        <option value="fingers" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === 'fingers') ? 'selected' : '' ?>>Cuenta Dedos</option>
                        <option value="0.05" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '0.05') ? 'selected' : '' ?>>0.05</option>
                        <option value="0.1" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '0.1') ? 'selected' : '' ?>>0.1</option>
                        <option value="0.2" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '0.2') ? 'selected' : '' ?>>0.2</option>
                        <option value="0.3" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '0.3') ? 'selected' : '' ?>>0.3</option>
                        <option value="0.4" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '0.4') ? 'selected' : '' ?>>0.4</option>
                        <option value="0.5" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '0.5') ? 'selected' : '' ?>>0.5</option>
                        <option value="0.6" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '0.6') ? 'selected' : '' ?>>0.6</option>
                        <option value="0.7" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '0.7') ? 'selected' : '' ?>>0.7</option>
                        <option value="0.8" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '0.8') ? 'selected' : '' ?>>0.8</option>
                        <option value="0.9" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '0.9') ? 'selected' : '' ?>>0.9</option>
                        <option value="1.0" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '1.0') ? 'selected' : '' ?>>1.0</option>
                        <option value="1.2" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '1.2') ? 'selected' : '' ?>>1.2</option>
                        <option value="1.5" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '1.5') ? 'selected' : '' ?>>1.5</option>
                        <option value="2.0" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '2.0') ? 'selected' : '' ?>>2.0</option>
                        <option value="20/400" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/400') ? 'selected' : '' ?>>20/400</option>
                        <option value="20/300" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/300') ? 'selected' : '' ?>>20/300</option>
                        <option value="20/200" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/200') ? 'selected' : '' ?>>20/200</option>
                        <option value="20/100" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/100') ? 'selected' : '' ?>>20/100</option>
                        <option value="20/80" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/80') ? 'selected' : '' ?>>20/80</option>
                        <option value="20/70" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/70') ? 'selected' : '' ?>>20/70</option>
                        <option value="20/60" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/60') ? 'selected' : '' ?>>20/60</option>
                        <option value="20/50" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/50') ? 'selected' : '' ?>>20/50</option>
                        <option value="20/40" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/40') ? 'selected' : '' ?>>20/40</option>
                        <option value="20/30" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/30') ? 'selected' : '' ?>>20/30</option>
                        <option value="20/25" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/25') ? 'selected' : '' ?>>20/25</option>
                        <option value="20/20" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/20') ? 'selected' : '' ?>>20/20</option>
                        <option value="20/15" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/15') ? 'selected' : '' ?>>20/15</option>
                        <option value="20/10" <?= (($consultation->visual_evaluation->left_acuity_after ?? '') === '20/10') ? 'selected' : '' ?>>20/10</option>
                    </select>
                    <label for="selectpickerBasic">Ojo izquierdo</label>
                </div>
            </div>
            <div class="col ">
                <div class="divider">
                    <div class="divider-text">AO</div>
                </div>

                <div class="form-floating form-floating-outline">
                    <select name="acuity_ocular" id="avsa-rigth" class="selectpicker w-100 " data-style="btn">
                        <option value="null" <?= (($consultation->visual_evaluation->acuity_ocular ?? 'null') === 'null') ? 'selected' : '' ?>>AO</option>
                        <option value="Percepción de Luz" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === 'Percepción de Luz') ? 'selected' : '' ?>>Percepción de Luz</option>
                        <option value="Cuenta Dedos" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === 'Cuenta Dedos') ? 'selected' : '' ?>>Cuenta Dedos</option>
                        <option value="0.05" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '0.05') ? 'selected' : '' ?>>0.05</option>
                        <option value="0.1" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '0.1') ? 'selected' : '' ?>>0.1</option>
                        <option value="0.2" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '0.2') ? 'selected' : '' ?>>0.2</option>
                        <option value="0.3" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '0.3') ? 'selected' : '' ?>>0.3</option>
                        <option value="0.4" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '0.4') ? 'selected' : '' ?>>0.4</option>
                        <option value="0.5" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '0.5') ? 'selected' : '' ?>>0.5</option>
                        <option value="0.6" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '0.6') ? 'selected' : '' ?>>0.6</option>
                        <option value="0.7" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '0.7') ? 'selected' : '' ?>>0.7</option>
                        <option value="0.8" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '0.8') ? 'selected' : '' ?>>0.8</option>
                        <option value="0.9" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '0.9') ? 'selected' : '' ?>>0.9</option>
                        <option value="1.0" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '1.0') ? 'selected' : '' ?>>1.0</option>
                        <option value="1.2" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '1.2') ? 'selected' : '' ?>>1.2</option>
                        <option value="1.5" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '1.5') ? 'selected' : '' ?>>1.5</option>
                        <option value="2.0" <?= (($consultation->visual_evaluation->acuity_ocular ?? '') === '2.0') ? 'selected' : '' ?>>2.0</option>
                    </select>
                    <label for="selectpickerBasic">AO</label>
                </div>

            </div>

        </div>

        <div class="row mt-4">
            <div class="col-12 col-lg-3 mt-4">
                <div class="form-floating form-floating-outline mb-6">
                    <select
                            id="chromatic_vision"
                            name="chromatic_vision"
                            class="select2"
                            placeholder="Visión Cromática"
                    >
                        <option value="null" <?= (($consultation->visual_evaluation->chromatic_vision ?? 'null') === 'null') ? 'selected' : '' ?>></option>
                        <option value="normal" <?= (($consultation->visual_evaluation->chromatic_vision ?? '') === 'normal') ? 'selected' : '' ?>>Tricromatopsia(normal)</option>
                        <option value="red" <?= (($consultation->visual_evaluation->chromatic_vision ?? '') === 'red') ? 'selected' : '' ?>>Discromatopsia Protanopia(Rojo)</option>
                        <option value="green" <?= (($consultation->visual_evaluation->chromatic_vision ?? '') === 'green') ? 'selected' : '' ?>>Discromatopsia Deuteranopia(Verde)</option>
                        <option value="blue" <?= (($consultation->visual_evaluation->chromatic_vision ?? '') === 'blue') ? 'selected' : '' ?>>Discromatopsia Tritanopia(Azul)</option>
                    </select>
                    <label for="chromatic_vision">Visión Cromática</label>

                </div>

            </div>
            <div class="col-12 col-lg-3 mt-4">
                <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline mb-6">
                        <input
                                list="stereotest_list"
                                type="text"
                                id="stereotest"
                                name="stereotest"
                                class="form-control form-control-sm"
                                placeholder="Estereotest"
                                value="<?=htmlspecialchars($consultation->visual_evaluation->stereotest ?? '')?>"

                        />
                        <datalist id="stereotest_list">
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="60">60</option>
                            <option value="70">70</option>
                            <option value="80">80</option>
                            <option value="90">90</option>
                            <option value="100">100</option>
                            <option value="110">110</option>
                            <option value="120">120</option>
                            <option value="130">130</option>
                            <option value="140">140</option>
                            <option value="150">150</option>
                            <option value="160">160</option>
                            <option value="170">170</option>
                            <option value="180">180</option>
                            <option value="190">190</option>
                            <option value="200">200</option>
                            <option value="210">210</option>
                            <option value="220">220</option>
                            <option value="230">230</option>
                            <option value="240">240</option>
                            <option value="250">250</option>
                            <option value="260">260</option>
                            <option value="270">270</option>
                            <option value="280">280</option>
                            <option value="290">290</option>
                            <option value="300">300</option>
                            <option value="310">310</option>
                            <option value="320">320</option>
                            <option value="330">330</option>
                            <option value="340">340</option>
                            <option value="350">350</option>
                            <option value="360">360</option>
                            <option value="370">370</option>
                            <option value="380">380</option>
                            <option value="390">390</option>
                            <option value="400">400</option>
                        </datalist>
                        <label for="stereotest">Estereotest</label>
                    </div>
                    <span class="input-group-text">seg. de arco </span>
                </div>

            </div>
            <div class="col-12 col-lg-3 mt-4">
                <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline mb-6">
                        <input
                                type="number"
                                min="3"
                                max="13"
                                id="ease_accommodation"
                                name="ease_accommodation"
                                class="form-control form-control-sm"
                                placeholder="Ciclos"
                                value="<?=htmlspecialchars($consultation->visual_evaluation->ease_accommodation ?? '')?>"

                        />
                        <label for="ease_accommodation">Facilidad de Acomodación</label>
                    </div>
                    <span class="input-group-text">Ciclos</span>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-4">
                <div class="form-floating form-floating-outline mb-6">
                    <select name="brock_string" id="brock_strings" class="select2">
                        <option value="null" <?= (($consultation->visual_evaluation->brock_string ?? 'null') === 'null') ? 'selected' : '' ?>></option>
                        <option value="x" <?= (($consultation->visual_evaluation->brock_string ?? '') === 'x') ? 'selected' : '' ?>>En la bola (X) </option>
                        <option value="exo" <?= (($consultation->visual_evaluation->brock_string ?? '') === 'exo') ? 'selected' : '' ?>>Antes De(Exo)</option>
                        <option value="endo" <?= (($consultation->visual_evaluation->brock_string ?? '') === 'endo') ? 'selected' : '' ?>>Después De(Endo)</option>
                    </select>
                    <label for="brook">Cuerda de Brock</label>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-4">
                <div class="form-floating form-floating-outline mb-6">
                    <select
                            id="worth_bridge"
                            name="worth_bridge"
                            class="select2"
                            placeholder="Puentes de Worth" >
                        <option value="null" <?= (($consultation->visual_evaluation->worth_bridge ?? 'null') === 'null') ? 'selected' : '' ?>></option>
                        <option value="fusion" <?= (($consultation->visual_evaluation->worth_bridge ?? '') === 'fusion') ? 'selected' : '' ?>> 4 Puntos 1 Rojo, 2 Verdes, 1 Blanco (Fusión)</option>
                        <option value="right" <?= (($consultation->visual_evaluation->worth_bridge ?? '') === 'right') ? 'selected' : '' ?>> 3 Puntos Verdes (Supresión OD)</option>
                        <option value="left" <?= (($consultation->visual_evaluation->worth_bridge ?? '') === 'left') ? 'selected' : '' ?>> 2 Puntos Rojos (Supresión Ol)</option>
                    </select>
                    <label for="worth_bride">Puentes de Worth</label>

                </div>
            </div>
            <div class="col-12 col-lg-3 mt-4">
                <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline mb-6">
                        <input
                                list="convergence_list"
                                type="text"
                                id="ppc"
                                name="convergence_break"
                                class=" form-control form-control-sm"
                                placeholder="Ruptura"
                                value="<?=htmlspecialchars($consultation->visual_evaluation->convergence_break ?? '')?>"
                        />

                        <label for="ppc">Punto Próximo de Convergencia </label>
                        <datalist id="convergence_list">
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                        </datalist>
                    </div>
                    <span class="input-group-text">cm</span>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-4">
                <div class="input-group input-group-merge">

                    <div class="form-floating form-floating-outline mb-6">
                        <input
                                list="convergence_list"
                                type="text"
                                id="convergence_recover"
                                name="convergence_recover"
                                class=" form-control form-control-sm"
                                placeholder="Recuperación"
                                value="<?=htmlspecialchars($consultation->visual_evaluation->convergence_recover ?? '')?>"

                        />
                        <label for="convergence_recover">Punto Próximo de Convergencia</label>
                    </div>
                    <span class="input-group-text">cm</span>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-4">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            list="amsler_list"
                            type="text"
                            id="amsler_grid"
                            name="amsler_grid"
                            class="form-control form-control-sm"
                            placeholder="Rejilla de  Amsler"
                            value="<?=htmlspecialchars($consultation->visual_evaluation->amsler_grid ?? '')?>"

                    />
                    <label for="amsler_grid">Rejilla de  Amsler</label>
                    <datalist id="amsler_list">
                        <option>Normal.</option>
                        <option>Metamorfopsia</option>
                        <option>Escotoma</option>
                    </datalist>
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="form-floating form-floating-outline">
                    <textarea name="comments" id="observations" class="form-control" placeholder="Observaciones" ><?=htmlspecialchars($consultation->visual_evaluation->comments ?? '')?></textarea>
                    <label for="observations">Observaciones</label>
                </div>
            </div>
        </div>
    </form>
    <?php if(!$edit):?>
    <button  onclick="saveVisualEvaluation()" class="btn btn-primary mt-4">Guardar</button>
    <?php endif;?>

</div>
