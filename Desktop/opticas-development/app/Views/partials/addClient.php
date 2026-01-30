<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="addClient"
    aria-labelledby="offcanvasEndLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasEndLabel" class="offcanvas-title">Agregar cliente</h5>
        <button
            type="button"
            id="closeSidebar"
            class="btn-close text-reset"
            data-bs-dismiss="offcanvas"
            aria-label="Close"></button>

    </div>

    <div class="offcanvas-body my-auto mx-0 flex-grow-0">
        <?= $this->include('partials/addClientAlerts')?>
        <form id="customerFormSidebar" class="needs-validation" onSubmit="return false">
            <div class="row">
                <!-- Name -->
                <div class="col-md-12">
                    <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-account-tie"></i
                              ></span>
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
                <div class="col-md-12">
                    <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-account-tie"></i>
                          </span>
                        <div class="form-floating form-floating-outline">
                            <input
                                    required
                                    type="text"
                                    class="form-control"
                                    id="last_name"
                                    name="last_name"
                                    placeholder="Hernández Landa"
                                    aria-label="Hernández Landa"
                                    aria-describedby="basic-icon-default-fullname2" />
                            <label for="basic-icon-default-fullname">Apellidos</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Phone -->
                <div class="col-md-12">
                    <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-cellphone"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                    required
                                    type="text"
                                    class="form-control"
                                    id="phone"
                                    name="phone"
                                    placeholder="5544231212"
                                    aria-label="5544231212"
                                    minlength="10"
                                    maxlength="10"
                                    aria-describedby="basic-icon-default-fullname2" />
                            <label for="basic-icon-default-fullname">Teléfono</label>
                        </div>
                    </div>
                </div>
                <!-- Email -->
                <div class="col-md-12">
                    <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                          ><i class="mdi mdi-email"></i
                              ></span>
                        <div class="form-floating form-floating-outline">
                            <input
                                    type="text"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="chernandez@outlook.com"
                                    aria-label="chernandez@outlook.com"
                                    aria-describedby="basic-icon-default-fullname2" />
                            <label for="basic-icon-default-fullname">Email</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Address -->
                <div class="col-md-12">
                    <div class="input-group input-group-merge mb-4">
                        <span id="basic-icon-default-message2" class="input-group-text"><i class="mdi mdi-map-marker-path"></i></span>
                        <div class="form-floating form-floating-outline">
                            <textarea id="basic-icon-default-message" class="form-control" name="address" placeholder="Av. Lazaro Cardenas #1274. Xalapa, Veracruz. Entrando por Agua Santa 2" aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2" style="height: 60px"></textarea>
                            <label for="basic-icon-default-message">Dirección</label>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="created_by" value="<?=auth()->getUser()->id?>">
            <!-- Save button -->
            <button class="btn btn-primary btn-card-block-overlay">Guardar</button>
        </form>
    </div>
</div>
