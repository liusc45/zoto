<div class="card-body">

    <form id="personForm" class="needs-validation">

        <!--WorkEmployee Section-->
        <div id="WorkEmployeeSection" class="d-none">

            <h6>Información del empleado</h6>
            <div class="row">
                <div class="col-12">
                    <div class="input-group input-group-merge mb-4">
                        <div class="form-floating form-floating-outline">
                            <select
                                id="contractors"
                                name="company"
                                class="select2 form-select form-select-lg"
                                data-allow-clear="true">
                                <option >Seleccione una empresa</option>
                                <?php

                                if(isset($companies)):
                                    foreach($companies as $company):?>
                                        <option value="<?=$company->id?>"> <?=$company->id. " ". $company->name?> </option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                            <label for="select2Basic">Seleccionar empresa</label>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-6 mx-n4" />
            <h6>Información del paciente</h6>
        </div>
        <!--/WorkEmployee Section-->

        <!--Patient Section-->
        <div class="row">
            <!-- Name -->
            <?php
            if(isset($next_card)):?>
            <div class="col-md-2">
                <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-account-tie"></i>
                          </span>
                    <div class="form-floating form-floating-outline">
                        <input
                            type="text"
                            class="form-control"
                            id="card_id"
                            name="card_id"
                            placeholder="23456"
                            value="<?=$next_card?->card_id?>"
                        />
                        <label for="card_id">Tarjetón*</label>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-md-3">
                <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-account-tie"></i>
                          </span>
                    <div class="form-floating form-floating-outline">
                        <input
                            required
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Christian Guillermo"
                            aria-label="Christian Guillermo"
                            aria-describedby="basic-icon-default-fullname2" />
                        <label for="basic-icon-default-fullname">Nombre(s)</label>
                    </div>
                </div>
            </div>
            <!-- Last Name -->
            <div class="col-md-3">
                <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-account-tie"></i>
                          </span>
                    <div class="form-floating form-floating-outline">
                        <input
                            required
                            type="text"
                            class="form-control searchable"
                            id="last_name"
                            name="last_name"
                            placeholder="Hernández Landa"
                            aria-label="Hernández Landa"
                            aria-describedby="basic-icon-default-fullname2" />
                        <label for="basic-icon-default-fullname">Apellidos</label>
                    </div>
                </div>
            </div>
            <!--DOB -->
            <div class="col-md-4">
                <div class="input-group input-group-merge mb-4 ">
                    <span id="basic-icon-default-calendar" class="input-group-text">
                        <i class="mdi mdi-calendar-account-outline"></i>
                    </span>
                    <div class="form-floating form-floating-outline">
                        <input type="text"
                            class="form-control  flatpickr-input active"
                            name="dob"
                            id="person-dob"
                            placeholder="YYYY-MM-DD"
                        >
                        <label for="person-dob">Fecha de nacimiento</label>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row">
            <!-- Phone -->
            <div class="col-md-3">
                <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-cellphone"></i
                              ></span>
                    <div class="form-floating form-floating-outline">
                        <input
                            type="text"
                            class="form-control searchable"
                            id="phone"
                            name="main_phone"
                            placeholder="5544231212"
                            aria-label="5544231212"
                            minlength="10"
                            aria-describedby="basic-icon-default-fullname2"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        />
                        <label for="basic-icon-default-fullname">Teléfono</label>
                    </div>
                </div>
            </div>
            <!-- Email -->
            <div class="col-md-3">
                <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-email"></i
                              ></span>
                    <div class="form-floating form-floating-outline">
                        <input
                            type="text"
                            class="form-control searchable"
                            id="email"
                            name="email"
                            placeholder="chernandez@outlook.com"
                            aria-label="chernandez@outlook.com"
                            aria-describedby="basic-icon-default-fullname2" />
                        <label for="basic-icon-default-fullname">Email</label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-account-hard-hat"></i>
                          </span>
                    <div class="form-floating form-floating-outline">
                        <input
                                type="text"
                                class="form-control"
                                id="position"
                                name="position"
                                placeholder="Developer"
                                aria-label="Developer"
                                aria-describedby="basic-icon-default-fullname2" />
                        <label for="basic-icon-default-fullname">Puesto</label>
                    </div>
                </div>
            </div>
            <!-- Occupation -->
            <div class="col-md-3">
                <?php

                if(isset($occupations)):?>
                    <div class="input-group input-group-merge mb-4">
                        <div class="form-floating form-floating-outline">
                             <select
                                id="occupation"
                                name="occupation"
                                class="select2 form-select form-select-lg"
                                data-allow-clear="true">
                                <?php

                                    foreach($occupations as $occupation):?>
                                        <option value="<?=$occupation->id?>"> <?=$occupation->title?> </option>
                                    <?php
                                    endforeach;
                               ?>
                            </select>
                            <label for="select2Basic">Ocupación</label>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <!-- Street -->
            <div class="col-md-3">
                <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-home-account"></i>
                          </span>
                    <div class="form-floating form-floating-outline">
                        <input
                            type="text"
                            class="form-control"
                            id="street"
                            name="street"
                            placeholder="Colon 10"
                            aria-label="Colon 10"
                            aria-describedby="basic-icon-default-fullname2" />
                        <label for="basic-icon-default-fullname">Calle</label>
                    </div>
                </div>
            </div>
            <!-- City -->
            <div class="col-md-3">
                <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-city"></i>
                          </span>
                    <div class="form-floating form-floating-outline">
                        <input
                            type="text"
                            class="form-control"
                            id="city"
                            name="city"
                            placeholder="Orizaba"
                            aria-label="Orizaba"
                            aria-describedby="basic-icon-default-fullname2" />
                        <label for="basic-icon-default-fullname">Ciudad</label>
                    </div>
                </div>
            </div>
            <!-- State -->
            <div class="col-md-3">
                <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-city-variant-outline"></i>
                          </span>
                    <div class="form-floating form-floating-outline">
                        <input
                            type="text"
                            class="form-control"
                            id="state"
                            name="state"
                            placeholder="Veracruz"
                            aria-label="Veracruz"
                            aria-describedby="basic-icon-default-fullname2" />
                        <label for="basic-icon-default-fullname">Estado</label>
                    </div>
                </div>
            </div>
            <!-- PostalCode -->
            <div class="col-md-3">
                <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-post"></i>
                          </span>
                    <div class="form-floating form-floating-outline">
                        <input
                            type="number"
                            class="form-control"
                            id="postal_code"
                            name="postal_code"
                            placeholder="93018"
                            aria-label="93018"
                            aria-describedby="basic-icon-default-fullname2" />
                        <label for="basic-icon-default-fullname">C.P.</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- Occupation -->
        <div class="col-md-4">
            <?php

            if(isset($levels)):?>
                <div class="input-group input-group-merge mb-4">
                    <div class="form-floating form-floating-outline">
                        <select
                                id="occupation"
                                name="group_users"
                                class="select2 form-select form-select-lg"
                                data-allow-clear="true">
                            <?php

                            foreach($levels as $levelKey => $levelName):?>
                                <option value="<?=$levelKey?>"> <?=$levelName?> </option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                        <label for="select2Basic">Nivel de usuario </label>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <!--/Patient Section-->

        <input type="hidden" name="created_by" value="<?=auth()->getUser()->id?>">
        <!-- Save button -->
        <button class="btn btn-primary btn-card-block-overlay">Guardar</button>
    </form>
</div>
