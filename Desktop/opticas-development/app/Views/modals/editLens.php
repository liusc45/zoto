<div class="modal fade" id="editLens" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Editar la información de un lente</h3>
                    <p class="pt-1">La información se actualiza automáticamente al modificar algún valor</p>

                </div>
                <form id="editLensForm" class="row g-4" onsubmit="return false">
                    <div class="col-12 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="number"
                                id="modalEditLensCost"
                                name="cost"
                                class="form-control"
                                placeholder="Emilio" />
                            <label for="modalEditSupplierName">Precio de compra</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="number"
                                id="modalEditLensPrice"
                                name="price"
                                class="form-control"
                                placeholder="Ferraez" />
                            <label for="modalEditSupplierAddress">Precio de venta</label>
                        </div>
                    </div>

                    <input id="modalEditLensID" name="id" type="hidden" value="">
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