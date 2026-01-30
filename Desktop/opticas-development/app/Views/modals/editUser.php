<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Editar la información del usuario</h3>
                    <p class="pt-1">La información se actualiza automáticamente al modificar algún valor</p>

                    <?=$this->include('partials/modalAlerts')?>
                </div>
                <form id="editUserForm" class="row g-4" onsubmit="return false">
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditUserName"
                                name="name"
                                class="form-control"
                                placeholder="Emilio" />
                            <label for="modalEditUserName">Nombre(s)</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditUserLastName"
                                name="last_name"
                                class="form-control"
                                placeholder="Ferraez" />
                            <label for="modalEditUserLastName">Apellidos</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditUserUsername"
                                name="username"
                                class="form-control"
                                placeholder="eferraez" />
                            <label for="modalEditUsername">Usuario</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="email"
                                id="modalEditUserEmail"
                                name="email"
                                class="form-control"
                                placeholder="eferraez@hotmail.com" />
                            <label for="modalEditUserEmail">Correo</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input
                                    type="tel"
                                    id="modalEditUserPhone"
                                    name="phone"
                                    class="form-control"
                                    placeholder="228159272" />
                            <label for="modalEditUserPhone">Celular</label>
                        </div>
                    </div>
                    <input id="modalEditUserID" name="id" type="hidden" value="">
                    <div class="col-12 text-center">
                        <button
                            type="reset"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                            Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>