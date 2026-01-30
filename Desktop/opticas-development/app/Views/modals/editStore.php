<div class="modal fade" id="editStore" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">

            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Editar la información de la tienda</h3>
                    <p class="pt-1">La información se actualiza automáticamente al modificar algún valor</p>

                    <?=$this->include('partials/modalAlerts')?>
                </div>
                <form id="editStoreForm" class="row g-4" onsubmit="return false">
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditStoreName"
                                name="name"
                                class="form-control"
                                placeholder="Central" />
                            <label for="modalEditStoreName">Nombre</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditStoreAddress"
                                name="address"
                                class="form-control"
                                placeholder="Av. Central Sur #99" />
                            <label for="modalEditStoreAddress">Dirección</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="tel"
                                id="modalEditStorePhone"
                                name="phone"
                                class="form-control"
                                placeholder="9646427878" />
                            <label for="modalEditStorePhone">Teléfono</label>
                        </div>
                    </div>
                    <input type="hidden" id="modalEditStoreID" name="id"  value="">
                    <input type="hidden" name="_method" value="PUT">
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