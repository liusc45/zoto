<!-- Product List Widget -->
<div class="card mb-4">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-3">
                    <div
                        class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                        <div>
                            <p class="mb-2">Ingresos del día</p>
                            <h4 class="mb-2"><?=number_to_currency($reports['sales_today']["totalEarningToday"]->amount, 'MXN','es_MX')?></h4>
                            <p class="mb-0">
                              <span class="me-2"><?=str_replace(" "," de ",$date->toLocalizedString("d MMMM YYYY"))?></span>
<!--                                <span class="badge rounded-pill bg-label-success">+5.7%</span>-->
                            </p>
                        </div>
                        <div class="avatar me-sm-4">
                            <span class="avatar-initial rounded bg-label-secondary">
                              <i class="mdi mdi-calendar-today mdi-24px"></i>
                            </span>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none me-4" />
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div
                        class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                        <div>
                            <p class="mb-2">Ventas de últimos 7 días</p>
                            <h4 class="mb-2"><?=
                               (isset($reports['sales_week']))?
                                   number_to_currency( $reports['sales_week']->amount, 'MXN','es_MX'):0
                                ?></h4>
                            <!--<p class="mb-0">
                              <span class="me-2">21k orders</span>
                            <span class="badge rounded-pill bg-label-success">+12.4%</span>
                            </p>-->
                        </div>
                        <div class="avatar me-lg-4">
                            <span class="avatar-initial rounded bg-label-secondary">
                              <i class="mdi mdi-calendar-range mdi-24px"></i>
                            </span>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none" />
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div
                        class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                        <div>
                            <p class="mb-2">Gastos del día</p>
                            <h4 class="mb-2 text-danger"><?=number_to_currency($reports['expenses_today']->amount, 'MXN','es_MX')?></h4>
<!--                            <p class="mb-0">6k orders</p>-->
                        </div>
                        <div class="avatar me-sm-4">
                            <span class="avatar-initial rounded bg-label-danger">
                              <i class="mdi mdi-cash-minus mdi-24px"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-2">Crédito por cobrar</p>
                            <h4 class="mb-2 text-warning"><?=number_to_currency($reports['debt']->amount, 'MXN', 'es_MX')?></h4>
<!--                            <p class="mb-0">
                              <span class="me-2">150 orders</span
                              ><span class="badge rounded-pill bg-label-danger">-3.5%</span>
                            </p>-->
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                              <i class="mdi mdi-account-credit-card mdi-24px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product List Widget -->
