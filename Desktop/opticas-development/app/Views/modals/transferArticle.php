<div class="modal fade" id="transferArticle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Transferir artículos</h3>
                    <p class="pt-1">Se necesita confirmar el traspaso. La actualización automática se encuentra desactivada.</p>
                </div>
                <?=$this->include('partials/modalAlerts')?>
                <form id="transferArticleForm" class="row g-4" onsubmit="return false">
                    <div class="col-8">
                        <div class="form-floating form-floating-outline">
                            <input
                                    type="text"
                                    id="articlesName"
                                    name="article_name"
                                    class="form-control"
                                    placeholder="Alacena"
                                    readonly
                            />
                            <label for="modalEditCustomerName">Artículo a transferir (Solo lectura)</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-floating form-floating-outline">
                            <input
                                    type="text"
                                    id="uptotransfer"
                                    name="article"
                                    class="form-control"
                                    placeholder="Alacena"
                                    readonly
                            />
                            <label for="modalEditCustomerName">Máximo transferible.</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input
                                type="number"
                                id="articlesTransfer"
                                name="qty"
                                class="form-control"
                                placeholder="3"
                                min="1"
                                value="1"
                                />
                            <label for="modalEditCustomerName">Pieza(s) a enviar</label>
                        </div>
                    </div>
                    <!-- STORE -->
                    <div class="col-12  col-md-6">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                                <select
                                        id="storeStockSelect2"
                                        name="receive"
                                        class="select2 form-select form-select"
                                        data-allow-clear="true">
                                </select>
                                <label for="select2Basic">Tienda receptora</label>
                            </div>
                        </div>
                    </div>
                    <input id="transferArticleID" name="item" type="hidden" value="">
<!--                    <input id="inventoryID" name="inventory" type="hidden" value="">-->
                    <input id="originStoreID" name="dispatch" type="hidden" value="">
                    <div class="col-12 text-center">
                        <button
                            type="submit"
                            id="confirmBtn"
                            class="btn btn-primary"
                            aria-label="Close">
                            Confirmar
                        </button>
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
