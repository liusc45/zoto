<div class="tab-pane fade" id="navs-justified-purchases" role="tabpanel">

    <?php
    if (empty($sales)): ?>
        <p class="mt-4">Sin compras </p>
    <?php else:
        foreach ($sales as $key => $sale): ?>
            <div class="card h-100 mt-2 mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2"> <span class="fw-medium text-heading me-2">Venta : <?=$sale->id?></span></h5>
                    <div>
                        <span class="fw-medium text-heading me-2">Fecha:</span>
                        <span><?=$sale?->created_at?->humanize()?></span>
                    </div>
                    <div>
                        <span class="fw-medium text-heading me-2">Atendido:</span>
                        <span><?=$sale->user?? ''?></span>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                      <?php  foreach($sale->sale_items as $key => $sale_item):?>
                        <tr >
                            <td class="flex-shrink-0">
                                <span class="mb-0"><?=$sale_item->item_obj->key?> </span>
                            </td>
                            <td >
                                <div class="d-flex justify-content-left align-items-center">
                                    <div class="d-flex flex-column">
                                        <span class=" fw-medium text-heading"><?=$sale_item->item_obj->name?></span>
                                        <small class="text-truncate"><?=$sale_item->item_obj->line?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-heading">
                                    <span><?=$sale_item->unit_price?></span>
                                </div>
                            </td>
                        </tr>

                        <?php endforeach;?>
                    </table>
                    <div class="row">
                        <div class="info-container col-lg-4 mt-4">
                            <ul class="list-unstyled mb-6">
                                <li class="mb-2">
                                    <a href="/ordenes?consultation=<?=@$sale->id?>" class="btn btn-sm btn-primary">
                                        <i class="mdi mdi-cart-outline me-1"></i> Ordenar
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                </div>
            </div>
        <?php
        endforeach;
    endif; ?>


</div>