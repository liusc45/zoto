<div class="modal fade" id="editArticle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Editar la información del artículo</h3>
                    <p class="pt-1">La información se actualiza automáticamente al modificar algún valor</p>

                    <?=$this->include('partials/modalAlerts')?>
                </div>
                <form id="editArticleForm" class="row g-4" onsubmit="return false">

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
                                        id="modalEditArticleName"
                                        name="name"
                                        placeholder="Cama tubular matrimonial"
                                        aria-label="Cama tubular matrimonial"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Descripción</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Cost -->
                        <div class="input-group input-group-merge mb-4">
                      <span id="basic-icon-default-fullname2" class="input-group-text">
                        <i class="mdi mdi-cash-100"></i>
                      </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="number"
                                        class="form-control"
                                        id="modalEditArticleCost"
                                        name="cost"
                                        placeholder="1499"
                                        aria-label="1499"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Precio de compra</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Public Price -->
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="mdi mdi-cash-100"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="number"
                                        class="form-control"
                                        id="modalEditArticlePublicPrice"
                                        name="public_price"
                                        placeholder="1999"
                                        aria-label="1999"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Precio al público</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Special Price -->
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="mdi mdi-cash-100"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="number"
                                        class="form-control"
                                        id="modalEditArticleSpecialPrice"
                                        name="special_price"
                                        placeholder="1899"
                                        aria-label="1899"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Precio con descuento</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Qty Special Price -->
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="mdi mdi-counter"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="number"
                                        class="form-control"
                                        id="modalEditArticleQtySpecialPrice"
                                        name="qty_special_price"
                                        placeholder="1"
                                        aria-label="1"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Mínimo p/descuento</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Wholesale Price -->
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="mdi mdi-cash-100"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="number"
                                        class="form-control"
                                        id="modalEditArticleWholesalePrice"
                                        name="wholesale_price"
                                        placeholder="1849"
                                        aria-label="1849"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Precio especial</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Qty Wholesale Price -->
                        <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="mdi mdi-counter"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="number"
                                        class="form-control"
                                        id="modalEditArticleQtyWholesalePrice"
                                        name="qty_wholesale_price"
                                        placeholder="1"
                                        aria-label="1"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Mínimo p/especial</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- Category Select2 -->
                        <div class="input-group input-group-merge mb-4">
                            <div class="form-floating form-floating-outline">
                                <select
                                        id="categoryEditSelect2"
                                        name="category"
                                        class="select2 form-select form-select"
                                        data-allow-clear="true">
                                </select>
                                <label for="select2Basic">Categoría</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="modalEditArticleID" name="id"  value="">
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