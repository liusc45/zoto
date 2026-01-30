<!-- Product List Widget -->
<div class="card mb-4">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-3">
                    <div
                        class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                        <div>
                            <p class="mb-2">Inversión del inventario</p>
                            <h4 class="mb-2"><?=@number_to_currency($inventoryStats->cost??0,'MXN','es_MX',2)?></h4>
                        </div>
                        <div class="avatar me-sm-4">
                            <span class="avatar-initial rounded bg-label-secondary">
                              <i class="mdi mdi-cash mdi-24px"></i>
                            </span>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none me-4" />
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div
                        class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                        <div>
                            <p class="mb-2">Estimado de venta</p>
                            <h4 class="mb-2"><?= number_to_currency($inventoryStats->public_price??0,'MXN','es_MX',2)?></h4>
                        </div>
                        <div class="avatar me-lg-4">
                            <span class="avatar-initial rounded bg-label-secondary">
                              <i class="mdi mdi-cash mdi-24px"></i>
                            </span>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none" />
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div
                        class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                        <div>
                            <p class="mb-2">Estimado con descuentos</p>
                            <h4 class="mb-2"><?=number_to_currency($inventoryStats->discount_price??0,'MXN','es_MX',2)?></h4>
                        </div>
                        <div class="avatar me-sm-4">
                            <span class="avatar-initial rounded bg-label-secondary">
                              <i class="mdi mdi-sale-outline mdi-24px"></i>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Product List Widget -->
