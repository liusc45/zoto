<div class="tab-pane fade" id="navs-justified-messages" role="tabpanel" xmlns="http://www.w3.org/1999/html">
    <form class="consulting" id="form-contact-lenses">
        <input type="hidden" name="patient" value="<?=$patient->id?>">
        <input type="hidden" name="consultation" class="consultation-id"  value="<?=@$consultation->id?>">

        
        <div class="divider">
            <div class="divider-text">Keratometría</div>
        </div>
        
        <div class="col-12">
            <div class="row mb-5">
                <div class="col-2">
                    <input id="right_a"  class=" form-control form-control-sm keratometry" type="number" min="20" max="68" step=".01" placeholder="O.D.">
                </div>
                <div class="col-2">
                    <input id="right_b" class="form-control form-control-sm keratometry" type="number" min="20"  max="68" step=".01" placeholder="O.D.">
                </div>
                <div class="col-2">
                    <input id="right_axis" oninput="calculateAxis(this)" class="form-control form-control-sm" type="number" min="0" max="180" step="1" placeholder="O.D.">
                </div>

            </div>
            <div class="row">
                <div class="col-2">
                    <input id="calculated_right_a"  name="right_keratometry_a"  class=" form-control form-control-lg"  placeholder="O.D." value="<?=htmlspecialchars($consultation->contact_lenses->right_keratometry_a ?? '')?>" >
                </div>
                <div class="col-2">
                    <input id="calculated_right_b" name="right_keratometry_b" class="form-control form-control-lg"  placeholder="O.D." value="<?=htmlspecialchars($consultation->contact_lenses->right_keratometry_b ?? '')?>" >
                </div>
                <div class="col-2">
                    <input id="calculated_right_axis" name="right_keratometry_axis" class="form-control form-control-lg"  placeholder="O.D." value="<?=htmlspecialchars($consultation->contact_lenses->right_keratometry_axis ?? '')?>" >
                </div>

            </div>
            <div class="row">
                <div class="col-2">
                    <input id="calculated_left_a" name="left_keratometry_a" class="form-control form-control-lg"  placeholder="O.I." value="<?=htmlspecialchars($consultation->contact_lenses->left_keratometry_a ?? '')?>" >
                </div>
                <div class="col-2">
                    <input id="calculated_left_b" name="left_keratometry_b" class="form-control form-control-lg"  placeholder="O.I." value="<?=htmlspecialchars($consultation->contact_lenses->left_keratometry_b ?? '')?>" >
                </div>
                <div class="col-2">
                    <input id="calculated_left_axis" name="left_keratometry_axis" class="form-control form-control-lg"  placeholder="O.I." value="<?=htmlspecialchars($consultation->contact_lenses->left_keratometry_axis ?? '')?>" >
                </div>

            </div>
            <div class="row mt-5">
                <div class="col-2">
                    <input id="left_a"  class="form-control form-control-sm keratometry" type="number" min="20" max="68" step=".01" placeholder="O.I.">
                </div>
                <div class="col-2">
                    <input id="left_b"  class="form-control form-control-sm keratometry" type="number" min="20" max="68" step=".01" placeholder="O.I.">
                </div>
                <div class="col-2">
                    <input id="left_axis" oninput="calculateAxis(this)" class="form-control form-control-sm" type="number" min="0" max="180" step="1" placeholder="O.I.">
                </div>

            </div>
        </div>

        <div class="row mt-2">

            <div class="col-12 col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                        type="number"
                        min="8"
                        max="15"
                        id="eyelid_opening"
                        name="eyelid_opening"
                        class="form-control form-control-sm"
                        placeholder="Apertura Palpebral"
                        value="<?=htmlspecialchars($consultation->contact_lenses->eyelid_opening ?? '')?>"
                    />
                    <label for="eyelid_opening">Apertura Palpebral</label>
                </div>
            </div>
            <div class="col-12 col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                        type="number"
                        min="10"
                        max="14"
                        step=".1"
                        onchange="setFloatingPoint(this)"
                        id="cornea_diameter"
                        name="cornea_diameter"
                        class="form-control form-control-sm"
                        placeholder="Diámetro Corneal" value="<?=htmlspecialchars($consultation->contact_lenses->cornea_diameter ?? '')?>" />
                    <label for="cornea_diameter">Diámetro Corneal</label>
                </div>
            </div>
            <div class="col-12 col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                        type="number"
                        min="2.5"
                        max="5.5"
                        step=".1"
                        id="pupil_diameter"
                        name="pupil_diameter"
                        class="form-control form-control-sm"
                        placeholder="Diámetro Pupilar" value="<?=htmlspecialchars($consultation->contact_lenses->pupil_diameter ?? '')?>" />
                    <label for="pupil_diameter">Diámetro Pupilar</label>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class=" input-group input-group-merge">

                    <div class="form-floating form-floating-outline mb-6">
                        <input
                                type="number"
                                min="1"
                                max="35"
                                id="tear_breakup_time"
                                name="tear_breakup_time"
                                class="form-control form-control-sm"
                                placeholder="Tiempo de Ruptura Lagrimal" value="<?=htmlspecialchars($consultation->contact_lenses->tear_breakup_time ?? '')?>" />
                        <label for="tear_breakup_time">Tiempo de Ruptura Lagrimal</label>
                    </div>
                    <span class="input-group-text">sec.</span>
                </div>
            </div>

        </div>
        <div class="row mt-2">
            <div class="divider">
                <div class="divider-text">
                    Rx Evaluación visual.
                </div>
            </div>
            <div class="col-12 col-lg-6" >
                <div class="table-responsive" id="current-prescription-table">
                    <table id="last_rx_table" class=" mb-0 mt-2">
                        <caption style="caption-side: top"> RX Final</caption>
                        <thead>
                        <tr>
                            <th>Esfera</th>
                            <th>Cilindro</th>
                            <th>Eje     </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="col-3"><input class="form-control form-control-sm" readonly="" value=""></td>
                            <td class="col-3"><input class="form-control form-control-sm" readonly="" value=""></td>
                            <td class="col-3"><input class="form-control form-control-sm" readonly="" value=""></td>
                            <td class="col-3"><input class="form-control form-control-sm" readonly="" value=""></td>
                        </tr>
                        <tr>
                            <td class="col-3"><input class="form-control form-control-sm" readonly="" value=""></td>
                            <td class="col-3"><input class="form-control form-control-sm" readonly="" value=""></td>
                            <td class="col-3"><input class="form-control form-control-sm" readonly="" value=""></td>
                            <td class="col-3"><input class="form-control form-control-sm" readonly="" value=""></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="row mt-2">
            <div class="divider col-12">
                <div class="divider-text">Lentes de contacto a ordenar</div>
            </div>
        </div>
        <div class="d-flex flex-row mt-2">
            <div class="col-1 mt-3 ">
                <span>O.D.</span>
            </div>
            <div class="me-auto">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                        type="number"
                        min="7"
                        max="9"
                        step=".01"
                        id="right_base"
                        name="right_base"
                        class="form-control"
                        placeholder="Curva Base"
                        onChange="setFloatingPoint(this)"
                        value="<?=htmlspecialchars($consultation->contact_lenses->right_base ?? '')?>"
                    />
                    <label for="right_base">Curva Base</label>
                </div>
            </div>
            <div class="me-auto">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                    type="number"
                    min="9"
                    max="15"
                    step=".1"
                    id="right_diameter"
                    name="right_diameter"
                    class="form-control"
                    placeholder="Diámetro"
                    value="<?=htmlspecialchars($consultation->contact_lenses->right_diameter ?? '')?>" />
                    <label for="right_diameter">Diámetro</label>
                </div>
            </div>
            <div class="me-auto col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                    type="text"
                    id="right_thickness"
                    name="right_thickness"
                    class="form-control"
                    placeholder="Espesor"
                    value="<?=htmlspecialchars($consultation->contact_lenses->right_thickness ?? '')?>" />
                    <label for="right_thickness">Espesor</label>
                </div>
            </div>
            <div class="me-auto col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                    type="text"
                    id="right_cpp"
                    name="right_cpp"
                    class="form-control"
                    placeholder="CPP"
                    value="<?=htmlspecialchars($consultation->contact_lenses->right_cpp ?? '')?>" />
                    <label for="right_cpp">CPP</label>
                </div>
            </div>
            <!--Esfera-->
            <div class="me-auto">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                    type="number"
                    min="-30"
                    max="25"
                    step=".25"
                    id="final_right_sphere"
                    name="final_right_sphere"
                    class="form-control form-control-sm"
                    placeholder="Esfera"
                    onChange="setFloatingPoint(this)"
                    value="<?=htmlspecialchars($consultation->contact_lenses->final_right_sphere ?? '')?>"
                    />
                    <label for="right_sphere">Esfera</label>
                </div>
            </div>
            <!--Cilindro-->
            <div class="me-auto">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                    type="number"
                    min="-30"
                    max="25"
                    step=".25"
                    id="final_right_cylinder"
                    name="final_right_cylinder"
                    class=" form-control form-control-sm"
                    placeholder="Cilindro"
                    onChange="setFloatingPoint(this)"
                    value="<?=htmlspecialchars($consultation->contact_lenses->final_right_cylinder ?? '')?>"
                    />
                    <label for="right_cylinder">Cilindro</label>
                </div>
            </div>
            <!--Eje-->
            <div class="me-auto" >
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            id="final_right_axis"
                            name="final_right_axis"
                            class="form-control form-control-sm"
                            type="number"
                            min="0"
                            max="180"
                            step="1"
                            placeholder="Eje"
                            value="<?=htmlspecialchars($consultation->contact_lenses->final_right_axis ?? '')?>" >

                    <label for="right_cylinder">Eje</label>
                </div>
            </div>

        </div>
        <div class="d-flex flex-row mt-2">
            <div class="col-1 mt-3">
                <span>O.I.</span>
            </div>
            <div class="me-auto">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="number"
                            min="7"
                            max="9"
                            step=".01"
                            id="left_base"
                            name="left_base"
                            class="form-control"
                            placeholder="Curva Base"
                            onChange="setFloatingPoint(this)"
                            value="<?=htmlspecialchars($consultation->contact_lenses->left_base ?? '')?>"
                    />
                    <label for="basic-default-phone">Curva Base</label>
                </div>
            </div>
            <div class="me-auto">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="number"
                            min="9"
                            max="15"
                            step=".1"
                            id="left_diameter"
                            name="left_diameter"
                            class="form-control"
                            placeholder="Diámetro"
                            value="<?=htmlspecialchars($consultation->contact_lenses->left_diameter ?? '')?>" />
                    <label for="left_diameter">Diámetro</label>
                </div>
            </div>
            <div class="me-auto col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="text"
                            id="left_thickness"
                            name="left_thickness"
                            class="form-control"
                            placeholder="Espesor"
                            value="<?=htmlspecialchars($consultation->contact_lenses->left_thickness ?? '')?>" />
                    <label for="left_thickness">Espesor</label>
                </div>
            </div>
            <div class="me-auto col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="text"
                            id="left_cpp"
                            name="left_cpp"
                            class="form-control"
                            placeholder="CPP"
                            value="<?=htmlspecialchars($consultation->contact_lenses->left_cpp ?? '')?>" />
                    <label for="left_cpp">CPP</label>
                </div>
            </div>
            <div class="me-auto">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="number"
                            step =".25"
                            min="-30"
                            max="25"
                            id="final_left_sphere"
                            name="final_left_sphere"
                            class="form-control form-control-sm"
                            placeholder="Esfera"
                            onChange="setFloatingPoint(this)"
                            value="<?=htmlspecialchars($consultation->contact_lenses->final_left_sphere ?? '')?>"
                    />
                    <label for="left_sphere">Esfera</label>
                </div>
            </div>
            <div class="me-auto">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="number"
                            step =".25"
                            min="-30"
                            max="25"
                            id="final_left_cylinder"
                            name="final_left_cylinder"
                            class=" form-control form-control-sm"
                            placeholder="Cilindro"
                            onChange="setFloatingPoint(this)"
                            value="<?=htmlspecialchars($consultation->contact_lenses->final_left_cylinder ?? '')?>"
                    />
                    <label for="left_cylinder">Cilindro</label>
                </div>
            </div>
            <!--Eje-->
            <div class="me-auto">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            id="final_left_axis"
                            name="final_left_axis"
                            class="form-control form-control-sm"
                            type="number"
                            min="0"
                            max="180"
                            step="1"
                            placeholder="Eje"
                            value="<?=htmlspecialchars($consultation->contact_lenses->final_left_axis ?? '')?>" >

                    <label for="right_cylinder">Eje</label>
                </div>
            </div>

        </div>
        <div class="row mt-2">

            <div class="divider">
                <div class="divider-text">Graduación Sobrerrefracción</div>
            </div>
            <div class="col-1 mt-3 ">
                <span>O.D.</span>
            </div>
            <!-- agudeza visual antes-->
            <div class="col-12 col-lg-2 ">
                <div class="form-floating form-floating-outline">
                    <select name="contact_right_acuity_before" id="contact_right_acuity_before" class="select2 w-100 " data-style="btn">
                        <option value="null">O.D. </option>
                        <option value="light_perception">Percepción de Luz</option>
                        <option value="fingers">Cuenta Dedos</option>
                        <option value="0.05">0.05</option>
                        <option value="0.1">0.1</option>
                        <option value="0.2">0.2</option>
                        <option value="0.3">0.3</option>
                        <option value="0.4">0.4</option>
                        <option value="0.5">0.5</option>
                        <option value="0.6">0.6</option>
                        <option value="0.7">0.7</option>
                        <option value="0.8">0.8</option>
                        <option value="0.9">0.9</option>
                        <option value="1.0">1.0</option>
                        <option value="1.2">1.2</option>
                        <option value="1.5">1.5</option>
                        <option value="2.0">2.0</option>
                        <option value="20/400">20/400</option>
                        <option value="20/300">20/300</option>
                        <option value="20/200">20/200</option>
                        <option value="20/100">20/100</option>
                        <option value="20/80">20/80</option>
                        <option value="20/70">20/70</option>
                        <option value="20/60">20/60</option>
                        <option value="20/50">20/50</option>
                        <option value="20/40">20/40</option>
                        <option value="20/30">20/30</option>
                        <option value="20/25">20/25</option>
                        <option value="20/20">20/20</option>
                        <option value="20/15">20/15</option>
                        <option value="20/10">20/10</option>
                    </select>
                    <label for="avsa-rigth">Agudeza visual antes</label>
                </div>


            </div>

            <!--Sobrerrefracción-->

            <!--Esfera sobrerrefracción-->
            <div class="col-12 col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="number"
                            min="-30"
                            max="25"
                            step=".25"
                            id="right_sphere"
                            name="over_right_sphere"
                            class="form-control form-control-sm"
                            placeholder="Esfera"
                            value="<?=htmlspecialchars($consultation->contact_lenses->over_right_sphere ?? '')?>" />
                    <label for="right_sphere">Esfera</label>
                </div>
            </div>
            <!--Cilindro-->
            <div class="col-12 col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="number"
                            min="-30"
                            max="25"
                            step=".25"
                            id="over_right_cylinder"
                            name="over_right_cylinder"
                            class=" form-control form-control-sm"
                            placeholder="Cilindro"
                            value="<?=htmlspecialchars($consultation->contact_lenses->over_right_cylinder ?? '')?>" />
                    <label for="right_cylinder">Cilindro</label>
                </div>
            </div>
            <!-- agudeza visual antes-->
            <div class="col-12 col-lg-2 ">
                <div class="form-floating form-floating-outline">
                    <select name="contact_right_acuity_after" id="contact_right_acuity_after" class="select2 w-100 " data-style="btn">
                        <option value="null">O.D. </option>
                        <option value="light_perception">Percepción de Luz</option>
                        <option value="fingers">Cuenta Dedos</option>
                        <option value="0.05">0.05</option>
                        <option value="0.1">0.1</option>
                        <option value="0.2">0.2</option>
                        <option value="0.3">0.3</option>
                        <option value="0.4">0.4</option>
                        <option value="0.5">0.5</option>
                        <option value="0.6">0.6</option>
                        <option value="0.7">0.7</option>
                        <option value="0.8">0.8</option>
                        <option value="0.9">0.9</option>
                        <option value="1.0">1.0</option>
                        <option value="1.2">1.2</option>
                        <option value="1.5">1.5</option>
                        <option value="2.0">2.0</option>
                        <option value="20/400">20/400</option>
                        <option value="20/300">20/300</option>
                        <option value="20/200">20/200</option>
                        <option value="20/100">20/100</option>
                        <option value="20/80">20/80</option>
                        <option value="20/70">20/70</option>
                        <option value="20/60">20/60</option>
                        <option value="20/50">20/50</option>
                        <option value="20/40">20/40</option>
                        <option value="20/30">20/30</option>
                        <option value="20/25">20/25</option>
                        <option value="20/20">20/20</option>
                        <option value="20/15">20/15</option>
                        <option value="20/10">20/10</option>
                    </select>
                    <label for="avsa-rigth">Agudeza visual Posterior</label>
                </div>


            </div>

            <!--/Sobrerrefracción.-->

        </div>
        <div class="row mt-2">
            <div class="col-1 mt-3">
                <span>O.I.</span>
            </div>

            <!--Sobrerrefracción-->
            <div class="col-12 col-lg-2">
                <div class="form-floating form-floating-outline mt-2">
                    <select name="contact_left_acuity_before" id="contact_left_acuity_before" class="select2 w-100 "  data-style="btn">
                        <option value="null">O.I. </option>
                        <option value="light_perception">Percepción de Luz</option>
                        <option value="fingers">Cuenta Dedos</option>
                        <option value="0.05">0.05</option>
                        <option value="0.1">0.1</option>
                        <option value="0.2">0.2</option>
                        <option value="0.3">0.3</option>
                        <option value="0.4">0.4</option>
                        <option value="0.5">0.5</option>
                        <option value="0.6">0.6</option>
                        <option value="0.7">0.7</option>
                        <option value="0.8">0.8</option>
                        <option value="0.9">0.9</option>
                        <option value="1.0">1.0</option>
                        <option value="1.2">1.2</option>
                        <option value="1.5">1.5</option>
                        <option value="2.0">2.0</option>
                        <option value="20/400">20/400</option>
                        <option value="20/300">20/300</option>
                        <option value="20/200">20/200</option>
                        <option value="20/100">20/100</option>
                        <option value="20/80">20/80</option>
                        <option value="20/70">20/70</option>
                        <option value="20/60">20/60</option>
                        <option value="20/50">20/50</option>
                        <option value="20/40">20/40</option>
                        <option value="20/30">20/30</option>
                        <option value="20/25">20/25</option>
                        <option value="20/20">20/20</option>
                        <option value="20/15">20/15</option>
                        <option value="20/10">20/10</option>
                    </select>
                    <label for="selectpickerBasic">Ojo izquierdo</label>
                </div>
            </div>
            <!--Esfera sobrerrefracción-->
            <div class="col-12 col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="number"
                            min="-30"
                            max="25"
                            step=".25"
                            id="over_left_sphere"
                            name="over_left_sphere"
                            class="form-control form-control-sm"
                            placeholder="Esfera"
                            value="<?=htmlspecialchars($consultation->contact_lenses->over_left_sphere ?? '')?>" />
                    <label for="over_left_sphere">Esfera</label>
                </div>
            </div>
            <!--Cilindro-->
            <div class="col-12 col-lg-2">
                <div class="form-floating form-floating-outline mb-6">
                    <input
                            type="number"
                            min="-30"
                            max="25"
                            step=".25"
                            id="over_left_cylinder"
                            name="over_left_cylinder"
                            class=" form-control form-control-sm"
                            placeholder="Cilindro"
                            value="<?=htmlspecialchars($consultation->contact_lenses->over_left_cylinder ?? '')?>" />
                    <label for="over_left_cylinder">Cilindro</label>
                </div>
            </div>
            <!-- agudeza visual antes-->
            <div class="col-12 col-lg-2 ">
                <div class="form-floating form-floating-outline">
                    <select name="contact_left_acuity_after" id="contact_left_acuity_after" class="select2 w-100 " data-style="btn">
                        <option value="null">O.I. </option>
                        <option value="light_perception">Percepción de Luz</option>
                        <option value="fingers">Cuenta Dedos</option>
                        <option value="0.05">0.05</option>
                        <option value="0.1">0.1</option>
                        <option value="0.2">0.2</option>
                        <option value="0.3">0.3</option>
                        <option value="0.4">0.4</option>
                        <option value="0.5">0.5</option>
                        <option value="0.6">0.6</option>
                        <option value="0.7">0.7</option>
                        <option value="0.8">0.8</option>
                        <option value="0.9">0.9</option>
                        <option value="1.0">1.0</option>
                        <option value="1.2">1.2</option>
                        <option value="1.5">1.5</option>
                        <option value="2.0">2.0</option>
                        <option value="20/400">20/400</option>
                        <option value="20/300">20/300</option>
                        <option value="20/200">20/200</option>
                        <option value="20/100">20/100</option>
                        <option value="20/80">20/80</option>
                        <option value="20/70">20/70</option>
                        <option value="20/60">20/60</option>
                        <option value="20/50">20/50</option>
                        <option value="20/40">20/40</option>
                        <option value="20/30">20/30</option>
                        <option value="20/25">20/25</option>
                        <option value="20/20">20/20</option>
                        <option value="20/15">20/15</option>
                        <option value="20/10">20/10</option>
                    </select>
                    <label for="avsa-rigth">Agudeza visual antes</label>
                </div>


            </div>

            <!--/Sobrerrefracción-->
            <div class="col-12 col-lg-6 mt-3">
                <div class="form-floating form-floating-outline mb-6">
                    <select
                            id="select-contacts"
                            name="suggested"
                            class="form-control select2"
                            placeholder="Lentes de contacto a ordenar">
                        <?php
                        if(is_array($contacts)):
                        foreach ($contacts as $contact) :
                        ?>
                        <option value="<?= $contact->id ?>" <?= (($consultation->contact_lenses->suggested ?? null) == $contact->id) ? 'selected' : '' ?>><?= $contact->name ?></option>
                        <?php
                        endforeach;
                        endif;
                        ?>
                    </select>
                    <label for="over_comment">Lente de contacto</label>
                </div>
            </div>

        </div>
    </form>
    <button  onclick="saveContactConsultation()" class="btn btn-primary mt-4">Guardar</button>

    <script>
        // Prefill contact lenses form fields from backend-provided $consultation (exposed as `consulting`)
        // $(function () {
        //     try {
        //         if (typeof consulting !== 'undefined' && consulting) {
        //             // Fill hidden consultation id
        //             if (consulting.id) {
        //                 $("#form-contact-lenses .consultation-id").val(consulting.id);
        //             }
        //             // Map contact lenses data to form inputs by name
        //             const data = consulting.contact_lenses || {};
        //             const $form = $("#form-contact-lenses");
        //             Object.keys(data).forEach(function (key) {
        //                 const $field = $form.find("[name='" + key + "']");
        //                 if ($field.length === 0) return;
        //                 const value = data[key];
        //                 if ($field.is('select')) {
        //                     $field.val(String(value)).trigger('change'); // works with select2 too
        //                 } else if ($field.attr('type') === 'checkbox') {
        //                     const checked = value === 1 || value === '1' || value === true || value === 'true';
        //                     $field.prop('checked', checked).trigger('change');
        //                 } else if ($field.attr('type') === 'number') {
        //                     if (value !== null && value !== undefined && value !== '') {
        //                         $field.val(value);
        //                     }
        //                 } else {
        //                     if (value !== null && value !== undefined) {
        //                         $field.val(value);
        //                     }
        //                 }
        //             });
        //         }
        //     } catch (e) {
        //         console.error('Error prefilling contact lenses data', e);
        //     }
        // });
    </script>
</div>

