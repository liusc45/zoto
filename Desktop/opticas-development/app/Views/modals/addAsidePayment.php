<div class="modal fade" id="addNewAsidePayment" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
		<div class="modal-content p-3 p-md-5">
			<div class="modal-body p-md-0">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				<div class="text-center mb-4">
					<h3 class="mb-2 pb-1">Registrar abono de apartado</h3>
					<p>Por favor, introduce la información para registrar el pago</p>
				</div>

				<form id="newAsidePaymentForm" class="row g-4" onsubmit="return false">
					<div class="col-12">
						<div class="input-group input-group-merge">
							<div class="form-floating form-floating-outline">
								<input
									id="client"
									class="form-control"
									type="text"
									placeholder="Rodulfo Rincón"
									readonly
									aria-describedby="modalAddCard2" />
								<label for="modalAddCard">Nombre del cliente (solo lectura)</label>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="input-group input-group-merge">
							<div class="form-floating form-floating-outline">
								<input
									id="name"
									class="form-control"
									type="text"
									placeholder="Bañera de Disney "
									readonly
									aria-describedby="modalAddCard2" />
								<label for="modalAddCard">Descripción del apartado (solo lectura)</label>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="form-floating form-floating-outline">
							<select id="paymentMethod" name="payment_type" class="selectpicker w-100" data-style="btn-default">
								<option value="cash">Efectivo</option>
								<option value="card">Tarjeta Crédito/Debito</option>
								<option value="transfer">Transferencia</option>
							</select>
						</div>
					</div>
					<div id="ticketNumberInput" class="col-12 d-none">
						<div class="form-floating form-floating-outline">
							<input
								type="number"
								id="ticketNumber"
								name="aut"
								class="form-control"
								placeholder="17290750" />
							<label for="modalAddCardName">Numero de aprobación</label>
						</div>
					</div>
					<div class="col-12 col-md-4" id="cashInput">
						<div class="form-floating form-floating-outline">
							<input
								type="number"
								id="amount"
								name="amount"
								onchange="calculate()"
								class="form-control"
								placeholder="750" />
							<label for="modalAddCardName">Abono</label>
						</div>
					</div>
					<div class="col-12 col-md-4" id="receivedInput">
						<div class="form-floating form-floating-outline">
							<input
								type="number"
								id="cash"
								name="cash"
								onchange="calculate()"
								class="form-control"
								placeholder="1000" />
							<label for="modalAddCardExpiryDate">Recibí</label>
						</div>
					</div>
					<div class="col-12 col-md-4" id="cashbackInput">
						<div class="input-group input-group-merge">
							<div class="form-floating form-floating-outline">
								<input
									type="number"
									id="cashback"
									name="cashback"
									class="form-control"
									readonly
									placeholder="250" />
								<label for="modalAddCardCvv">Cambio</label>
							</div>
							<span class="input-group-text cursor-pointer" id="modalAddCardCvv2"
							><i
									class="mdi mdi-help-circle-outline text-muted"
									data-bs-toggle="tooltip"
									data-bs-placement="top"
									title="Se calcula automaticamente"></i
								></span>
						</div>
					</div>
					<input type="hidden" id="aside" name="credit" value="">
					<input type="hidden" name="aside" value="1">
					<input type="hidden" id="sale" name="sale" value="">
					<input type="hidden" id="created_by" name="created_by" value="<?=auth()->getUser()->id?>">
					<div class="col-12 text-center">
						<button type="submit" class="btn btn-primary me-sm-3 me-1">Guardar abono</button>
						<button
							type="reset"
							class="btn btn-outline-secondary btn-reset"
							data-bs-dismiss="modal"
							aria-label="Close">
							Cancelar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>