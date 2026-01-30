<div class="modal fade" id="editSupplier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Editar la información del proveedor</h3>
                    <p class="pt-1">La información se actualiza automáticamente al modificar algún valor</p>

                    <?=$this->include('partials/modalAlerts')?>
                </div>
                <form id="editSupplierForm" class="row g-4" onsubmit="return false">
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditSupplierName"
                                name="name"
                                class="form-control"
                                placeholder="Emilio" />
                            <label for="modalEditSupplierName">Nombre</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditSupplierAddress"
                                name="address"
                                class="form-control"
                                placeholder="Ferraez" />
                            <label for="modalEditSupplierAddress">Dirección</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="tel"
                                id="modalEditSupplierPhone"
                                name="phone"
                                class="form-control"
                                placeholder="228159272" />
                            <label for="modalEditSupplierPhone">Teléfono</label>
                        </div>
                    </div>
                    <input id="modalEditSupplierID" name="id" type="hidden" value="">
                    <input id="modalEditSupplierCompany" name="company" type="hidden" value="">
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