<!-- Checkout Wizard -->
<div id="wizard-checkout" class="bs-stepper wizard-icons wizard-icons-example">
    <form id="sale-form" >
        <input type="hidden" name="store" value="<?= session("store")->id ?>" id="storeId"   >
        <input type="hidden" name="customer" value="1" id="customerId"   >
        <!-- Cart -->
        <div id="checkout-cart" class="content">
            <div class="row">
                <!-- Clients up -->
                <div class=" col-sm-12 col-md-8">
                    <div class="row">
                        <div class=" col-sm-12 col-md-8">
                            <select
                                    id="allCustomers"
                                    class="form-control"
                                    type="text"
                                    autocomplete="off"
                                    placeholder="Buscar clientes..."
                            ><option value="0">Público en general</option>
                            </select>

                        </div>
                        <div class="col-sm-12 col-md-4 mb-2">
                            <div class="d-grid">
                                <button type="button"
                                        class="btn btn-outline-primary waves-effect"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#lastPatients"
                                        onclick="loadLastPatients()"
                                        >
                                    Últimas consultas.
                                </button>
                            </div>
                            <div class="d-grid">
                                <button type="button"
                                        class="btn btn-outline-primary waves-effect"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#addClient"
                                        aria-controls="addClient">
                                    Agregar cliente
                                </button>
                            </div>
                            <div class="d-grid">
                                <button type="button"
                                        class="btn btn-outline-primary waves-effect"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#lensModal"
                                >
                                    Lentes
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="divider">
                                <div class="divider-text">Lineas</div>
                            </div>
                        </div>
                        <ul class="nav nav-pills flex-column flex-md-row mb-3 gap-2 gap-lg-0">
                            <?php
                            foreach( $lines as $line) :?>
                                <li class="nav-item">
                                    <a class="nav-link waves-effect  waves-light line-filter fs-tiny " data-line="<?=$line->id?>" > <?=ucwords(strtolower($line->name))?></a>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                        <div class="form-floating form-floating-outline col-md-3 ">
                            <input class="form-control form-control-sm" placeholder="Código de barras " id="barcode-input">
                            <label for="barcode-input">Código de barras</label>
                        </div>

                        <div class="col-md-9 ">
                            <div class="form-floating form-floating-outline">
                                <select
                                        id="allArticlesList"
                                        class="form-control  article-selector"
                                        type="text"
                                        autocomplete="off"
                                        placeholder="Buscar artículos..." ><option></option>
                                </select>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3 mb-xl-0">
                                <!-- Shopping bag -->
                                <div class="card-datatable table-responsive pb-5 mt-4">
                                    <table class="datatables-order-details w-100">
                                        <thead id="itemsList">
                                        <tr>
                                            <th >Paciente</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="border rounded p-3 mb-3">
                        <hr class="mx-n3" />
                        <!-- Sale type -->
                        <h6>1.Tipo de venta</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <select id="saleType" class="selectpicker w-100" data-style="btn-default">
                                        <option value="cash">Contado</option>
                                        <option value="aside">Apartado</option>
                                        <option value="credit">Crédito</option>
<!--                                        <option value="quote">Cotización</option>-->
                                    </select>
                                </div>
<!--                                <div class="form-floating form-floating-outline d-none">-->
<!--                                    <input type="text"-->
<!--                                           name="cash"-->
<!--                                           class="form-control mt-1"-->
<!--                                           id="deposit"-->
<!--                                           placeholder="1.1 Abono"-->
<!--                                    />-->
<!--                                    <label for="deposit" >1.1 Abono</label>-->
<!--                                </div>-->
                            </div>
                        </div>
                        <!-- Price Details -->
                        <h6 class="mb-4">Detalle de la venta</h6>
                        <dl class="row mb-0" id="totals">
                            <dt class="col-6 fw-normal text-heading">Artículos</dt>
                            <dd class="col-6 text-end" id="items-qty">0</dd>

                            <dt class="col-6 fw-normal text-heading">Subtotal</dt>
                            <dd class="col-6 text-end">
                                <span id="subtotal">$0.00</span> M.N.
                            </dd>
                        </dl>
                        <div class="row mb-0" id="discounts">
                            <span class="col-6 fw-normal text-heading">Descuentos</span>
                            <div id="YBTXdiscount"></div>
                            <div id="otherDiscount"></div>
                        </div>
                        <hr class="mx-n3 my-3" />

                        <dl class="row mb-0 h6 mt-2">
                            <dt class="col-6 mb-0">Total</dt>
                            <dd class="col-6 text-end mb-0">
                                <span id="total">$0.00</span> M.N.
                            </dd>
                        </dl>
                        <dl class="row mb-0 h6 " id="remain-payment">
                            <dt class="col-6 mb-0">Restan</dt>
                            <dd class="col-6 text-end mb-0">
                                <span id="topay">$0.00</span> M.N.
                            </dd>
                        </dl>
                        <hr class="mx-n3" />

                        <!-- Offer -->
                        <?php if(auth()->user()->inGroup("admin")) :?>
                            <h6>Descuento <small>(En porcentaje)</small></h6>
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-xl-12">
                                    <input
                                            type="number"
                                            step="1"
                                            value="0"
                                            class="form-control"
                                            id="discountValue"
                                            placeholder="Descuento"
                                            aria-label="Descuento" />
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-grid">
                                        <button id="applyDiscountBtn"
                                                type="button"

                                                class="btn btn-outline-primary btn-sm">
                                            Aplicar descuento
                                        </button>
                                        <button id="removeDiscountBtn"
                                                type="button"
                                                onclick="removeDiscount()"
                                                class="btn btn-outline-primary btn-sm d-none">
                                            Remover descuento
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>



                        <!-- Payment method -->
                        <h6>2.Método de pago</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-2">
                                    <select id="paymentMethod" class="selectpicker w-100" data-style="btn-default">
                                        <option value="cash">Efectivo</option>
                                        <option value="cc">Tarjeta Crédito/Debito</option>
                                        <option value="transfer">Transferencia</option>
                                    </select>
                                </div>

                                <div class="form-floating form-floating-outline  payment cash">
                                    <input
                                            type="text"
                                            name="cashToPay"
                                            class="form-control mt-1 "
                                            id="cashToPay"
                                            placeholder="Paga"
                                            aria-label="Paga"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    >
                                    <label for="cashToPay" >Paga</label>
                                </div>

                                <div class="form-floating form-floating-outline   payment cash cc transfer ">
                                    <input
                                        type="text"
                                        name="cash"
                                        class="form-control mt-1 "
                                        id="cashreceived"
                                        placeholder="Recibí. Doble click para borrar"
                                        aria-label="Recibí"

                                    />
                                    <label for="cashreceived">Recibí.</label>
                                </div>
                                <div class="cc transfer payment d-none">
                                    <select id="accountSelect" class="selectpicker w-100 " data-style="btn-default">
                                        <?php foreach ($accounts as $account) :?>
                                            <option value="<?= $account->id ?>"><?= $account->alias ?></option>
                                        <?php    endforeach; ?>
                                    </select>
                                </div>
                                <div class="cc voucher payment d-none">
                                    <select id="modalities" class="selectpicker w-100 " data-style="btn-default">
                                        <?php foreach ($cards[1] as $card) :
                                            if($card->active==1):?>
                                                <option value="<?= $card->id ?>"><?= $card->alias ?></option>
                                            <?php endif; endforeach; ?>
                                    </select>
                                </div>


                                <input
                                        type="text"
                                        name="aut"
                                        class="form-control mt-1 d-none payment  cc voucher transfer "
                                        id="ticketNumber"
                                        placeholder="Numero de ticket o transferencia"
                                        aria-label="Numero de ticket" />
                                <input
                                        type="text"
                                        name="cashback"
                                        class="form-control mt-1 payment cash  "
                                        id="cashback"
                                        placeholder="Cambio"
                                        aria-label="Cambio"
                                        readonly />
                            </div>

                            <div class="col-12">
                                <div class="d-grid">
                                    <button type="button"
                                            onclick="splitPayment()"
                                            class="btn btn-sm btn-outline-primary">
                                        3. Aplicar pago
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr class="mx-n3" />

                        <div class="card-body d-none" id="shipmentSection">
                            <hr class="mx-n3" />
                            <div class="card-title header-elements">
                                <h5 class="m-0 me-2">Envío a domicilio</h5>
                                <div class="card-title-elements ms-auto">
                                    <label class="switch switch-primary switch-sm me-0">
                                        <input type="checkbox" id="shipment" name="shipment" class="switch-input" />
                                        <span class="switch-toggle-slider">
                                          <span class="switch-on"></span>
                                          <span class="switch-off"></span>
                                        </span>
                                        <span class="switch-label"></span>
                                    </label>
                                </div>
                            </div>
                            <p class="card-text" id="userAddress"></p>
                        </div>
                        <dl class="row mb-0" id="payments"></dl>


                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-next "  disabled  id="saleBtn">Realizar venta</button>
                        <button class="btn btn-primary btn-next d-none mt-2" id="quoteBtn" onclick="quoteCart()">Realizar cotización</button>
                    </div>
                </div>
            </div>

                <!-- Cart right -->
        </div>

    </form>
</div>
<!--/ Checkout Wizard -->
