<div class="modal fade" id="editBrandModal"  tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Editar Marca</h3>
                    <p class="pt-1">La información se actualiza automáticamente al modificar algún valor</p>

                </div>
                <form id="editBrandForm" class="row g-4" onsubmit="return false">

                    <div class="col-md-12">
                        <!-- NAME -->
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-text-box-edit-outline"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="text"
                                        class="form-control"
                                        id="modalEditBrandName"
                                        name="name"
                                        placeholder="Cama tubular matrimonial"
                                        aria-label="Cama tubular matrimonial"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Descripción</label>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" id="modalEditBrandID" name="id"  value="">
                    <input type="hidden" name="_method" value="PATCH">
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