<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
    <style>
        .step-container { display: none; }
        .step-container.active { display: block; }
        .type-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e1e4e8;
            height: 100%;
        }
        .type-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: var(--bs-primary);
        }
        .type-card.selected {
            border-color: var(--bs-primary);
            background-color: rgba(var(--bs-primary-rgb), 0.05);
            box-shadow: 0 0 0 1px var(--bs-primary);
        }
        .type-card .icon-circle {
            width: 50px;
            height: 50px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
            color: #566a7f;
        }
        .type-card.selected .icon-circle {
            background: var(--bs-primary);
            color: #fff;
        }
        .wizard-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }
        .wizard-steps::before {
            content: "";
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e1e4e8;
            z-index: 1;
        }
        .wizard-step {
            position: relative;
            z-index: 2;
            background: #fff;
            padding: 0 10px;
            text-align: center;
            flex: 1;
        }
        .step-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e1e4e8;
            margin: 0 auto 5px;
            line-height: 32px;
            font-weight: bold;
            color: #566a7f;
        }
        .wizard-step.active .step-dot {
            background: var(--bs-primary);
            color: #fff;
        }
        .wizard-step.completed .step-dot {
            background: #28a745;
            color: #fff;
        }
        .step-label {
            font-size: 12px;
            font-weight: 500;
            color: #a1acb8;
        }
        .wizard-step.active .step-label {
            color: var(--bs-primary);
        }
        .summary-box {
            background: #f0f7ff;
            border-left: 4px solid var(--bs-primary);
            padding: 15px;
            border-radius: 4px;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?= esc($title) ?></h4>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><?= esc($title) ?></h5>
        </div>
        <div class="card-body">

        <?php $errors = session('errors'); ?>
        <?php if ($errors && is_array($errors) && count($errors)): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <div class="d-flex align-items-start">
                    <i class="mdi mdi-alert-circle-outline me-2 fs-4"></i>
                    <div>
                        <strong>Revisa los siguientes errores:</strong>
                        <ul class="mb-0 mt-1">
                            <?php foreach ($errors as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= $promotion ? base_url('promociones/update/' . $promotion['id']) : base_url('promociones/store') ?>"
              method="post"
              id="promotionForm">
            <?= csrf_field() ?>

            <!-- Wizard Header -->
            <div class="wizard-steps">
                <div class="wizard-step active" data-step="1">
                    <div class="step-dot">1</div>
                    <div class="step-label">Tipo</div>
                </div>
                <div class="wizard-step" data-step="2">
                    <div class="step-dot">2</div>
                    <div class="step-label">Detalles</div>
                </div>
                <div class="wizard-step" data-step="3">
                    <div class="step-dot">3</div>
                    <div class="step-label">Condiciones</div>
                </div>
                <div class="wizard-step" data-step="4">
                    <div class="step-dot">4</div>
                    <div class="step-label">Vigencia</div>
                </div>
            </div>

            <!-- Paso 1: Tipo de Promoción -->
            <div class="step-container active" id="step-1">
                <div class="mb-4 text-center">
                    <h5 class="mb-1">¿Qué tipo de promoción deseas crear?</h5>
                    <p class="text-muted">Selecciona la opción que mejor se adapte a tu objetivo</p>
                </div>
                
                <div class="row g-4 mb-4">
                    <?php foreach ($types as $key => $typeInfo): ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="card type-card p-3 text-center <?= old('type', $promotion['type'] ?? '') == $key ? 'selected' : '' ?>" 
                                 onclick="selectPromoType('<?= $key ?>')">
                                <div class="icon-circle">
                                    <i class="mdi <?= $typeInfo['icon'] ?>"></i>
                                </div>
                                <h6 class="mb-2"><?= esc($typeInfo['label']) ?></h6>
                                <p class="small text-muted mb-0"><?= esc($typeInfo['description']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="type" id="promoType" value="<?= old('type', $promotion['type'] ?? '') ?>" required>
            </div>

            <!-- Paso 2: Detalles y Reglas -->
            <div class="step-container" id="step-2">
                <div class="mb-4">
                    <h6 class="mb-3 text-body border-bottom pb-2">Información de la Promoción</h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="promotion-name" name="name"
                                       value="<?= old('name', $promotion['name'] ?? '') ?>"
                                       class="form-control" placeholder="Nombre de la promoción" required>
                                <label for="promotion-name">Nombre de la promoción *</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="code" id="promotion-code"
                                       value="<?= old('code', $promotion['code'] ?? '') ?>"
                                       class="form-control" placeholder="CÓDIGO (opcional)">
                                <label for="promotion-code">Código promocional</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <textarea name="description" rows="2" id="promotion-description" class="form-control" style="height: 80px;"><?= old('description', $promotion['description'] ?? '') ?></textarea>
                                <label for="promotion-description">Descripción interna / Notas</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="mb-3 text-body border-bottom pb-2">Configuración del Descuento</h6>
                    <div id="ruleFields" class="p-2" 
                         data-rules='<?= isset($promotion["rule_json"]) ? json_encode($promotion["rule_json"]) : json_encode([]) ?>' 
                         data-type='<?= old('type', $promotion['type'] ?? '') ?>'>
                        <p class="text-muted italic">Selecciona primero un tipo de promoción.</p>
                    </div>
                </div>
            </div>

            <!-- Paso 3: Condiciones (Restricciones) -->
            <div class="step-container" id="step-3">
                <div class="mb-4">
                    <h6 class="mb-3 text-body border-bottom pb-2">¿Cuándo aplica este beneficio?</h6>
                    <div class="row g-3">
                        <div class="col-md-6 form-floating form-floating-outline">
                            <input type="number" step="0.01" name="constraint_min_amount" id="min-amount"
                                   value="<?= old('constraint_min_amount', $promotion['constraints_json']['min_amount'] ?? '') ?>"
                                   class="form-control" placeholder="0.00">
                            <label for="min-amount">Compra mínima ($)</label>
                        </div>
                        <div class="col-md-6 form-floating form-floating-outline">
                            <input type="number" name="constraint_min_qty" id="min-qty"
                                   value="<?= old('constraint_min_qty', $promotion['constraints_json']['min_qty'] ?? '') ?>"
                                   class="form-control" placeholder="0">
                            <label for="min-qty">Cantidad mínima de productos</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="mb-3 text-body border-bottom pb-2">¿A qué productos aplica?</h6>
                    <div class="alert alert-outline-secondary p-2 mb-3">
                        <small><i class="mdi mdi-information-outline me-1"></i> Si no seleccionas productos ni categorías, la promoción aplicará a <strong>todo el catálogo</strong>.</small>
                    </div>

                    <!-- Buscador de productos -->
                    <div class="col-12">
                        <input type="hidden" name="constraint_product_ids" id="product-ids"
                               value="<?= old('constraint_product_ids', isset($promotion['constraints_json']['product_ids']) ? implode(',', $promotion['constraints_json']['product_ids']) : '') ?>">
                        
                        <div class="form-floating form-floating-outline mb-2">
                            <input type="text" id="catalog-search" class="form-control" placeholder="Buscar por nombre o código...">
                            <label for="catalog-search">Buscar y agregar productos específicos</label>
                            
                            <button type="button" id="btn-add-all-results" class="btn btn-sm btn-primary mt-2 w-100 shadow-sm" style="display: none;">
                                <i class="mdi mdi-playlist-plus me-1"></i> Agregar los <span id="count-results">0</span> encontrados
                            </button>

                            <ul id="catalog-results" class="list-group position-absolute w-100 shadow-lg" style="z-index: 1050; max-height: 300px; overflow-y: auto; display: none;"></ul>
                        </div>

                        <div id="selected-products-container" class="d-flex flex-wrap gap-2 mt-2 p-2 border rounded bg-lighter min-h-50px">
                             <small class="text-muted w-100 text-center py-2 empty-msg">Todos los productos (sin restricción)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paso 4: Vigencia y Finalización -->
            <div class="step-container" id="step-4">
                <div class="mb-4">
                    <h6 class="mb-3 text-body border-bottom pb-2">Vigencia de la Promoción</h6>
                    <div class="row g-3">
                        <div class="col-md-6 form-floating form-floating-outline">
                            <input type="datetime-local" name="starts_at" id="validity"
                                   value="<?= old('starts_at', isset($promotion['starts_at']) ? date('Y-m-d\TH:i', strtotime($promotion['starts_at'])) : date('Y-m-d\TH:i')) ?>"
                                   class="form-control" required>
                            <label for="validity">Inicia el *</label>
                        </div>
                        <div class="col-md-6 form-floating form-floating-outline">
                            <input type="datetime-local" name="ends_at" id="ends-at"
                                   value="<?= old('ends_at', isset($promotion['ends_at']) && $promotion['ends_at'] ? date('Y-m-d\TH:i', strtotime($promotion['ends_at'])) : '') ?>"
                                   class="form-control">
                            <label for="ends-at">Termina el (opcional)</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="mb-3 text-body border-bottom pb-2">Opciones adicionales</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="promoActive" name="active" value="1" <?= old('active', $promotion['active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="promoActive">¿La promoción está activa ahora mismo?</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="promoCombinable" name="combinable" value="1" <?= old('combinable', $promotion['combinable'] ?? 0) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="promoCombinable">¿Se puede usar con otras promociones?</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="summary-box mb-4">
                    <h6 class="mb-2"><i class="mdi mdi-eye-outline me-1"></i> Resumen de lo configurado:</h6>
                    <p id="promotion-summary-text" class="mb-0 text-dark fw-medium">Configura los pasos anteriores para ver el resumen.</p>
                </div>
            </div>

            <!-- Botones de Navegación -->
            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                <button type="button" class="btn btn-outline-secondary" id="prevBtn" onclick="changeStep(-1)" style="display: none;">
                    <i class="mdi mdi-chevron-left me-1"></i> Anterior
                </button>
                <div class="ms-auto">
                    <a href="<?= base_url('promociones') ?>" class="btn btn-link text-muted me-2">Cancelar</a>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">
                        Siguiente <i class="mdi mdi-chevron-right ms-1"></i>
                    </button>
                    <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                        <i class="mdi mdi-check-all me-1"></i> <?= $promotion ? 'Actualizar' : 'Crear' ?> Promoción
                    </button>
                </div>
            </div>
        </form>
    </div>
<?= $this->endSection() ?>
<?= $this->section('componentScripts') ?>
    <script src="/assets/vendor/libs/select2/select2.js"></script>
    <script src="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>

    <script>
        const items = <?= json_encode($items)?>;
        const catalogItems = items.reduce((acc, item) => {
            acc[item.id] = item;
            return acc;

        });
    </script>
    <script src="/assets/js/custom/promotion-new.js"></script>
<?= $this->endSection() ?>