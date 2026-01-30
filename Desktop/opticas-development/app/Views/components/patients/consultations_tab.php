<div class="modal fade" id="modalScrollable" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalScrollableTitle">Comentarios de la consulta</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalComments">
               <textarea class="form-control" id="comments" rows="20"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">
                    Cerrar
                </button>
<!--                <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade show active" id="navs-justified-consultations" role="tabpanel">


    <?php
    if (empty($prescriptions)): ?>
        <p class="mt-4">Sin consultas disponibles</p>
    <?php else:
        foreach ($prescriptions as $key => $prescription): ?>
            <div class="card mt-2 mb-4 h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title">
                        <span class="fw-medium text-heading me-2">Consulta:</span>
                        <a href="#" class="btn btn-sm btn-primary"

                                <?php if(!is_null($prescription->consultation)):?>
                                    data-bs-toggle="modal"
                                    data-bs-target="#full-consultation"
                                    onclick="getConsultation(<?=$prescription->consultation?>)"
                                <?php endif;?>
                        >
                            <span>
                                <?=$prescription->consultation??'propia'?>
                            </span>
                        </a>
                        <?php if(!is_null($prescription->consultation)):?>
                            <a href="/consulta/<?=$prescription->consultation?>" class="btn btn-sm btn-primary">
                                <span><i class="mdi mdi-pencil-box-outline"> </i>Editar</span>
                            </a>
                        <?php endif;?>
                        <?php if(auth()->user()->inGroup('admin')):?>
                        <a onclick="deleteConsultation(<?=$prescription->id?>)" class="btn btn-sm text-white btn-danger">
                            <span><i class="mdi mdi-trash-can"> </i>Borrar</span>
                        </a>
                        <?php endif;?>

                    </h6>
                    <span class="fw-medium text-heading me-2">
                        Fecha:
                        <?php
                        echo str_replace(" ", " de ",$prescription->created_at->toLocalizedString('d MMMM yyyy'))?>
                    </span>
                </div>
                <div class="card-body pb-1 pt-0">
                    <?php if($prescription->doctor): ?>
                    <div class="mb-4 mt-1">
                            <div class="d-flex align-items-center">
                                <span class="fw-medium text-heading me-2">Examinó :DR(A).</span>
                                <small>
                                    <?=$prescription->doctor?->name??'' ?>
                                    <?=$prescription->doctor?->last_name??'' ?>
                                </small>
                            </div>
                        </div>
                    <?php endif;?>
                    <div class="table-responsive text-nowrap border-top mb-4">
                        <table id="last_rx_table" class="table ">
                            <thead>
                                <tr>
                                    <th>
                                        <a
                                         href="javascript:;"
                                         data-prescription='<?=json_encode($prescription->prescription->final)?>'
                                         data-created_at = "<?=$prescription->created_at->toDateString()?>"
                                         data-consultation="<?=$prescription->consultation?>"
                                         class="btn btn-sm btn-primary">
                                        <span><i class="mdi mdi-pencil-box-outline"> </i></span>
                                        </a>
                                    </th>
                                    <th class="col-3">Esfera</th>
                                    <th class="col-3">Cilindro</th>
                                    <th class="col-3">Eje</th>
                                    <th class="col-3">Adición</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>O.D.</td>

                                    <td class="col-3" ><?=$prescription->prescription->final->right->sphere?></td>
                                    <td class="col-3"><?=$prescription->prescription->final->right->cylinder?></td>
                                    <td class="col-3"><?=$prescription->prescription->final->right->axis?></td>
                                    <td class="col-3"><?=$prescription->prescription->final->right->addition?></td>
                                </tr>
                                <tr>
                                    <td>O.I.</td>
                                    <td class="col-3" ><?=$prescription->prescription->final->left->sphere?></td>
                                    <td class="col-3"><?=$prescription->prescription->final->left->cylinder?></td>
                                    <td class="col-3"><?=$prescription->prescription->final->left->axis?></td>
                                    <td class="col-3"><?=$prescription->prescription->final->left->addition?></td>
                                </tr>
                                </tbody>
                            </table>

                    </div>

                    <?php if(empty($prescription->items)):?>
                        <p>
                          Sin Armazón o Micas
                        </p>

                    <?php else:?>
                    <?php foreach ($prescription->items as $key => $item): ?>

                        <p>
                            <span class="fw-medium text-heading me-2"><?=$item->item_obj?->line?>:</span>
                            <span><?=$item->item_obj?->name ?? $item->item_obj?->key?></span>
                        </p>
                    <?php endforeach;?>

                        <a href="/nueva-orden/venta/<?=$prescription->sale?>/paciente/<?=$prescription->patient?> " class=" col-2 btn btn-sm btn-primary">
                            <i class="mdi mdi-cart-outline me-1"></i> Ordenar
                        </a>
                    <?php endif;?>
                    <?php if(!empty($prescription->comments)):?>
                        <p>
                            <a
                                data-bs-toggle="modal"
                                data-bs-target="#modalScrollable"
                                data-bs-comments="<?=$prescription->comments??''?>"
                                data-consultation="<?=$prescription->consultation?>"
                            >
                                Comentarios
                            </a>
                        </p>
                    <?php endif;?>

                    <p>
                        <small class="text-muted">
                            Graduación <?=$prescription?->created_at->humanize()?>
                        </small>
                    </p>

                </div>
            </div>
        <?php
        endforeach;
    endif; ?>

</div>
