<div class="modal fade" id="editExpense" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">

            <div class="modal-body py-3 py-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Editar la información de un gasto</h3>
                    <p class="pt-1">La información se actualiza automáticamente al modificar algún valor</p>

                    <?=$this->include('partials/modalAlerts')?>
                </div>
                <form id="editExpenseForm" class="row g-4" onsubmit="return false">
                    <div class="col-md-4">
                        <!-- Amount -->
                        <div class="input-group input-group-merge">
                  <span id="basic-icon-default-fullname2" class="input-group-text">
                    <i class="mdi mdi-cash-multiple"></i>
                  </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="number"
                                        class="form-control"
                                        id="amountExpenseUpdate"
                                        name="amount"
                                        placeholder="99.99 MXN"
                                        aria-label="99.99 MXN"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Monto</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <!-- Concept -->
                        <div class="input-group input-group-merge">
                  <span id="basic-icon-default-fullname2" class="input-group-text"
                  ><i class="mdi mdi-text-box-edit-outline"></i
                      ></span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        required
                                        type="text"
                                        class="form-control"
                                        id="conceptExpenseUpdate"
                                        name="concept"
                                        placeholder="Pago de servicio"
                                        aria-label="Pago de servicio"
                                        aria-describedby="basic-icon-default-fullname2" />
                                <label for="basic-icon-default-fullname">Concepto</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Category Select2 -->
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                                <select
                                        id="select2ExpensesUpdate"
                                        name="category"
                                        class="select2 form-select"
                                >
                                    <option value="">Seleccionar opción</option>
                                    <?php foreach($categories as $key => $category):?>
                                        <option value="<?= $category->id;?>">
                                            <?=$category->name; ?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Date -->
                        <div class="input-group input-group-merge">
              <span id="basic-icon-default-fullname2" class="input-group-text">
                <i class="mdi mdi-calendar-month-outline"></i>
              </span>
                            <div class="form-floating form-floating-outline">
                                <input
                                        type="text"
                                        class="form-control flatpickr-input"
                                        placeholder="YYYY-MM-DD"
                                        id="flatpickr-date"
                                        name="applied"
                                        readonly="readonly"
                                        value="<?=$today?>">
                                <label for="flatpickr-date">Fecha</label>
                            </div>
                        </div>
                    </div>

                    <!-- Responsible -->
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <select
                                    id="responsibleSelectUpdate"
                                    name="responsible"
                                    class="expenseResponsibleUpdateSelect select2 form-select "
                                    data-allow-clear="true">

								<?php foreach($users as $key => $user):?>
                                    <option value="<?= $user->id;?>" <?= $user->id === session()->get('id_user') ? 'selected' : ''?>>
										<?= $user->name . " " . $user->last_name ?>
                                    </option>
								<?php endforeach;?>
                            </select>
                           
                        </div>
                    </div>

                    <!-- Comment -->
                    <div class="input-group input-group-merge">
                  <span id="basic-icon-default-message2" class="input-group-text"
                  ><i class="mdi mdi-message-outline"></i
                      ></span>
                        <div class="form-floating form-floating-outline">
                    <textarea
                            id="commentsExpenseUpdate"
                            name="comments"
                            class="form-control"
                            placeholder="Información relevante para la transacción"
                            aria-label="Información relevante para la transacción"
                            aria-describedby="basic-icon-default-message2"
                            style="height: 60px"></textarea>
                            <label for="basic-icon-default-message">Comentario</label>
                        </div>
                    </div>
                    <input type="hidden" id="modalExpenseUpdateID" name="id"  value="">
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
