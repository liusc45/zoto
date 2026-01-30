<div class="modal fade" id="addStockArticleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Agregar inventario del artículo</h3>
                    <p class="pt-1">Llenar todos los datos en la medida de lo posible.</p>

                    <div id="addStockSuccessAlert" class="alert d-none alert-solid-primary d-flex align-items-center" role="alert">
                        <i class="mdi mdi-alert-circle-check-outline me-2"></i>
                        <span id="addStockSuccessAlertText"></span>
                    </div>

                    <div id="addStockFailAlert" class="alert d-none alert-solid-danger d-flex align-items-center" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-2"></i>
                        <span id="editFailAlertText"></span>
                    </div>
                </div>
                <form id="addStockArticle" class="row g-4">
                    <!-- NAME -->
                    <div class="col-md-12">
                        <div class="input-group input-group-merge">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-text-box-edit-outline"></i>
                          </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="text"
                                        class="form-control"
                                        id="modalAddStockArticleName"
                                        name="name"
                                        placeholder="Cama tubular matrimonial"
                                        aria-label="Cama tubular matrimonial"
                                        aria-describedby="basic-icon-default-fullname2"
                                        readonly/>
                                <label for="basic-icon-default-fullname">Descripción</label>
                            </div>
                        </div>
                    </div>
                    <!-- SUPPLIER -->
                    <div class="col-md-12">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                                <select
                                        id="supplierStockSelect2"
                                        name="supplier"
                                        class="select2 form-select form-select"
                                        data-allow-clear="true"> <?php
                                    foreach ($suppliers as $supplier) : ?>
                                        <option value="<?=$supplier->id?>">
                                            <?= $supplier->name ?>
                                        </option>
                                    <?php endforeach;?>
                                </select>

                                <label for="select2Basic">Proveedor</label>
                            </div>
                        </div>
                    </div>
                    <!-- STORE -->
                    <div class="col-md-12">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                                <select
                                        id="storeStockSelect2"
                                        name="store"
                                        class="select2 form-select form-select"
                                        data-allow-clear="true">
                                <?php
                                foreach (session("stores") as $store) : ?>
                                <option value="<?=$store->id?>">
                                    <?= $store->name ?>
                                </option>
                                <?php endforeach;?>
                                </select>

                                <label for="select2Basic">Tienda</label>
                            </div>
                        </div>
                    </div>

                    <!-- STOCK -->
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input
                                    type="number"
                                    step=".01"
                                    class="form-control"
                                    id="articlecost"
                                    name="cost"
                                    min="1"
                                    placeholder="600">
                            <label for="exampleFormControlInput1">Precio factura</label>
                        </div>
                    </div>
                    <!-- STOCK -->
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input
                                    type="number"
                                    class="form-control"
                                    id="stockAddNumber"
                                    name="stock"
                                    min="1"
                                    placeholder="3">
                            <label for="exampleFormControlInput1">Piezas</label>
                        </div>
                    </div>

                    <!-- BILL -->
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input
                                    type="text"
                                    class="form-control"
                                    id="stockAddBill"
                                    name="bill"
                                    placeholder="F4891-A">
                            <label for="exampleFormControlInput1">Factura</label>
                        </div>
                    </div>

                    <input type="hidden" id="modalAddStockArticleID" name="item"  value="">
                    <div class="col-12 text-center">
                        <button
                            type="submit"
                            class="btn btn-primary waves-effect waves-light">
                            Guardar
                        </button>
                        <button
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