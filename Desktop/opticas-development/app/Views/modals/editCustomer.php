<div class="modal fade" id="editCustomer" data-bs-focus="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Editar la información del cliente</h3>
                    <p class="pt-1">La información se actualiza automáticamente al modificar algún valor</p>
                </div>
                <?=$this->include('partials/modalAlerts')?>
                <form id="editCustomerForm" class="row g-4" onsubmit="return false">
                    <div class="col-12 col-md-2">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditCustomerCard"
                                name="card_id"
                                class="form-control"
                                placeholder="21324" />
                            <label for="modalEditCustomerCard">Tarjet&oacute;n</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditCustomerName"
                                name="name"
                                class="form-control"
                                placeholder="Emilio" />
                            <label for="modalEditCustomerName">Nombre(s)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditCustomerLastName"
                                name="last_name"
                                class="form-control"
                                placeholder="Ferraez" />
                            <label for="modalEditCustomerLastName">Apellidos</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input
                                    type="tel"
                                    id="modalEditCustomerPhone"
                                    name="main_phone"
                                    class="form-control"
                                    placeholder="228159272"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            />
                            <label for="modalEditCustomerPhone">Celular</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="email"
                                id="modalEditCustomerEmail"
                                name="email"
                                class="form-control"
                                placeholder="eferraez@hotmail.com" />
                            <label for="modalEditCustomerEmail">Correo</label>
                        </div>
                    </div>
                    <!--DOB -->
                    <div class="col-md-4">
                        <div class="input-group input-group-merge">
                          <span id="basic-icon-default-calendar" class="input-group-text">
                              <i class="mdi mdi-calendar-account-outline"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input type="text"
                                       class="form-control flatpickr-date"
                                       placeholder="23-08-1993"
                                       aria-label="23-08-1993"
                                       id="modal-flatpickr-date"
                                       name="dob"
                                />
                                <label for="modal-flatpickr-date">Fecha de nacimiento</label>
                            </div>
                        </div>
                    </div>
                    <!-- Street -->
                    <div class="col-md-8">
                        <div class="input-group input-group-merge">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-home-account"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="text"
                                        class="form-control"
                                        id="modal-street"
                                        name="street"
                                        placeholder="Colon 10"
                                        aria-label="Colon 10"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Calle</label>
                            </div>
                        </div>
                    </div>
                    <!-- City -->
                    <div class="col-md-4">
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-city"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        type="text"
                                        class="form-control"
                                        id="modal-city"
                                        name="city"
                                        placeholder="Orizaba"
                                        aria-label="Orizaba"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Ciudad</label>
                            </div>
                        </div>
                    </div>
                    <!-- State -->
                    <div class="col-md-4">
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-city-variant-outline"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="text"
                                        class="form-control"
                                        id="modal-state"
                                        name="state"
                                        placeholder="Veracruz"
                                        aria-label="Veracruz"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Estado</label>
                            </div>
                        </div>
                    </div>
                    <!-- PostalCode -->
                    <div class="col-md-4">
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-post"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        type="number"
                                        class="form-control"
                                        id="modal-postal_code"
                                        name="postal_code"
                                        placeholder="93018"
                                        aria-label="93018"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">C.P.</label>
                            </div>
                        </div>
                    </div>
                </form>

                    <?php if(!empty($patient->phones)) : ?>
                        <div class="text-center border-bottom">
                            <p class="">Otros teléfonos</p>
                        </div>
                        <div class="card-body ">
                            <?php foreach($patient->phones as $key => $phone):?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-merge mb-4">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text"
                                                       class="form-control person-phone"
                                                       id="modal-name-other-phone"
                                                       name="type"
                                                       value="<?=$phone->type?>"
                                                       placeholder="Oficina"
                                                       aria-label="Oficina"
                                                       data-phone-id="<?=$phone->id?>"
                                                       aria-describedby="basic-icon-default-fullname2" />
                                                <label for="basic-icon-default-fullname">Nombre</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-merge mb-4">
                                            <div class="form-floating form-floating-outline">
                                                <input type="number"
                                                       class="form-control person-phone"
                                                       id="modal-value-other-phone"
                                                       name="numbre"
                                                       value="<?=$phone->number?>"
                                                       placeholder="2218548754"
                                                       data-phone-id="<?=$phone->id?>"
                                                />
                                                <label for="basic-icon-default-fullname">Teléfono</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    <?php endif; ?>
                    <input id="modalEditCustomerID" name="id" type="hidden" value="">
                    <div class="col-12 text-center">
                        <button
                            type="reset"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                            Cerrar
                        </button>
                    </div>
            </div>
        </div>
    </div>
</div>
