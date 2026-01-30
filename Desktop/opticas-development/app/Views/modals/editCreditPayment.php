<div class="modal fade" id="editCreditPayment" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered1 modal-simple modal-add-new-cc">
		<div class="modal-content p-3 p-md-5">
			<div class="modal-body p-md-0">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				<div class="text-center mb-4">
					<h3 class="mb-2 pb-1">Editar un abono de crédito</h3>
					<p>Por favor, introduce la información para actualizar el pago</p>
				</div>
				<div id="creditPaymentSuccess" class="alert d-none alert-solid-primary d-flex align-items-center" role="alert">
					<i class="mdi mdi-alert-circle-check-outline me-2"></i>
					<span id="creditPaymentSuccessText"></span>
				</div>

				<div id="creditPaymentFail" class="alert d-none alert-solid-danger d-flex align-items-center" role="alert">
					<i class="mdi mdi-alert-circle-outline me-2"></i>
					<span id="creditPaymentFailText"></span>
				</div>

                <div class="col-12">
                    <div class="demo-inline-spacing mt-3">
                        <ul class="list-group" id="paymentList"></ul>
                    </div>
                </div>

                <div class="col-12 mt-4 text-center">
                    <button
                        onclick="updatedPaymentCreditData(this)"
                        class="btn btn-primary"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                        Actualizar
                    </button>
                    <button
                        type="reset"
                        class="btn btn-outline-secondary btn-reset"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                        Cerrar
                    </button>
                </div>
			</div>
		</div>
	</div>
</div><?php
