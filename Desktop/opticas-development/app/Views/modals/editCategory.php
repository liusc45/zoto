<div class="modal fade" id="editCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Editar la información de la categoría</h3>
                    <p class="pt-1">La información se actualiza automáticamente al modificar algún valor</p>

                    <?=$this->include('partials/modalAlerts')?>
                </div>
                <form id="editItemCategoryForm" class="row g-4" onsubmit="return false">
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditCategoryName"
                                name="name"
                                class="form-control"
                                placeholder="Linea blanca" />
                            <label for="modalEditCategoryName">Nombre</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="text"
                                id="modalEditCategoryDescription"
                                name="description"
                                class="form-control"
                                placeholder="Electrodomesticos para el hogar" />
                            <label for="modalEditCategoryDescription">Descripción</label>
                        </div>
                    </div>
                    <input type="hidden" id="modalEditCategoryID" name="id"  value="">
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