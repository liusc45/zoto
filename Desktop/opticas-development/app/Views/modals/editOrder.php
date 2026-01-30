<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-order">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Editar Orden</h1>
                    <p>Actualizar detalles de la orden</p>
                </div>
                <form id="editOrderForm" class="row gy-1 pt-75">
                    <input type="hidden" id="id" name="id" />

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="sale">Venta</label>
                        <select
                            id="sale"
                            name="sale"
                            class="select2 form-select"
                            aria-label="Venta">
                            <option value="">Seleccione una venta</option>
                            <?php if(isset($sales)): ?>
                                <?php foreach($sales as $sale):?>
                                    <option value="<?= $sale->id;?>">
                                        <?= $sale->id; ?> - <?= date('d/m/Y', strtotime($sale->created_at)); ?>
                                    </option>
                                <?php endforeach;?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="lab">Laboratorio</label>
                        <select
                            id="lab"
                            name="lab"
                            class="select2 form-select"
                            aria-label="Laboratorio">
                            <option value="">Seleccione un laboratorio</option>
                            <?php if(isset($labs)): ?>
                                <?php foreach($labs as $lab):?>
                                    <option value="<?= $lab->id;?>">
                                        <?= $lab->name; ?>
                                    </option>
                                <?php endforeach;?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="patients_number">Número de pacientes</label>
                        <input
                            type="number"
                            id="patients_number"
                            name="patients_number"
                            class="form-control"
                            placeholder="1"
                            value=""
                        />
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="status">Estado</label>
                        <select
                            id="status"
                            name="status"
                            class="select2 form-select"
                            aria-label="Estado">
                            <option value="pending">Pendiente</option>
                            <option value="processing">En proceso</option>
                            <option value="to_delivery">Para entrega</option>
                            <option value="delivered">Entregado</option>
                            <option value="completed">Completado</option>
                            <option value="warranty">Garantía</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="lab_sent">Fecha de envío al laboratorio</label>
                        <input
                            type="date"
                            id="lab_sent"
                            name="lab_sent"
                            class="form-control"
                            value=""
                        />
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="lab_received">Fecha de recepción del laboratorio</label>
                        <input
                            type="date"
                            id="lab_received"
                            name="lab_received"
                            class="form-control"
                            value=""
                        />
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="delivered">Fecha de entrega al cliente</label>
                        <input
                            type="date"
                            id="delivered"
                            name="delivered"
                            class="form-control"
                            value=""
                        />
                    </div>

                    <div class="col-12 text-center mt-2 pt-50">
                        <button type="submit" class="btn btn-primary me-1">Guardar cambios</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
