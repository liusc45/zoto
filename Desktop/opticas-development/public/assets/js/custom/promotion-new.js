const rules = {
    percent: {
        title: 'Porcentaje de descuento',
        html: `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Porcentaje de descuento *</label>
                            <input type="number" step="0.01" name="rule_percent"
                                   class="form-control" placeholder="10" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Descuento máximo</label>
                            <input type="number" step="0.01" name="rule_max_discount"
                                   class="form-control" placeholder="Opcional">
                        </div>
                    </div>
                `
    },
    fixed: {
        title: 'Monto de descuento',
        html: `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Monto de descuento *</label>
                            <input type="number" step="0.01" name="rule_amount"
                                   class="form-control" placeholder="50.00" required>
                        </div>
                    </div>
                `
    },
    bogo: {
        title: 'Compra y Lleva',
        html:
            `
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Compra *</label>
                            <input type="number" name="rule_buy"
                                   class="form-control" placeholder="2" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Lleva *</label>
                            <input type="number" name="rule_get"
                                   class="form-control" placeholder="1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">% descuento en items gratis</label>
                            <input type="number" name="rule_discount_percent" value="100"
                                   class="form-control">
                        </div>
                    </div>
                `
    },
    tier_amount: {
        title: 'Escalas por Monto (Tiers)',
        html: `
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Configuración de Escalas</label>
                            <div class="alert alert-info p-2 mb-2"><small>Define los descuentos según el monto comprado.</small></div>

                            <!-- Contenedor visual -->
                            <div id="tier-builder-container" class="d-flex flex-column gap-2"></div>
                            <button type="button" class="btn btn-sm btn-label-primary mt-2" onclick="addTierRow('amount')">
                                <i class="mdi mdi-plus"></i> Agregar Escala
                            </button>

                            <!-- Input Oculto que recibe el JSON -->
                            <input type="hidden" name="rule_tiers" id="hidden_rule_tiers">
                        </div>
                    </div>`
    },
    tier_qty: {
        title: 'Escalas por Cantidad (Tiers)',
        html: `
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Configuración de Escalas</label>
                            <div class="alert alert-info p-2 mb-2"><small>Define los descuentos según la cantidad de productos.</small></div>

                            <!-- Contenedor visual -->
                            <div id="tier-builder-container" class="d-flex flex-column gap-2"></div>
                            <button type="button" class="btn btn-sm btn-label-primary mt-2" onclick="addTierRow('qty')">
                                <i class="mdi mdi-plus"></i> Agregar Escala
                            </button>

                            <!-- Input Oculto que recibe el JSON -->
                            <input type="hidden" name="rule_tiers" id="hidden_rule_tiers">
                        </div>
                    </div>`
    },
    bundle: {
        title: 'Bundle (Paquete)',
        html: `
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Contenido del Paquete</label>
                            <div class="alert alert-info p-2 mb-2"><small>Selecciona los productos necesarios para activar este paquete.</small></div>

                            <!-- Contenedor visual -->
                            <div id="bundle-builder-container" class="d-flex flex-column gap-2"></div>
                            <button type="button" class="btn btn-sm btn-label-primary mt-2" onclick="addBundleRow()">
                                <i class="mdi mdi-plus"></i> Agregar Producto al Paquete
                            </button>

                            <!-- Input Oculto -->
                            <input type="hidden" name="rule_bundle_items" id="hidden_rule_bundle">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Descuento total del bundle</label>
                            <input type="number" step="0.01" name="rule_discount_amount" class="form-control" placeholder="100.00">
                        </div>
                    </div>`
    },
    cashback: {
        title: 'Cashback',
        html: `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Porcentaje de cashback *</label>
                            <input type="number" step="0.01" name="rule_cashback_percent" class="form-control" placeholder="5" required>
                        </div>
                    </div>`
    },
    points: {
        title: 'Puntos',
        html: `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Puntos por unidad *</label>
                            <input type="number" step="0.01" name="rule_points_per_unit" class="form-control" placeholder="1" required>
                        </div>
                    </div>`
    },
};


function updateRuleFields() {
    const type = document.getElementById('promoType').value;
    const container = document.getElementById('ruleFields');

    // container.innerHTML =  rules[type]?.html??'<p class="text-muted">Seleccione un tipo de promoción para configurar las reglas</p>';
    if (rules[type]) {
        container.innerHTML = rules[type].html;
    } else {
        container.innerHTML = '<p class="text-muted">Seleccione un tipo de promoción para configurar las reglas</p>';
        return;
    }

    // Prefill if editing
    const rulesData = container.dataset.rules ? JSON.parse(container.dataset.rules) : {};

    // Lógica especial para constructores visuales
    if (type === 'tier_amount' || type === 'tier_qty') {
        initTierBuilder(rulesData.tiers || [], type === 'tier_amount' ? 'amount' : 'qty');
    } else if (type === 'bundle') {
        initBundleBuilder(rulesData.bundle_items || []);
    } else {
        // Lógica estándar para inputs simples
        if (Object.keys(rulesData).length) {
            for (const [key, val] of Object.entries(rulesData)) {
                const input = container.querySelector(`[name="rule_${key}"]`);
                if (input) {
                    if (input.tagName.toLowerCase() === 'textarea') {
                        // Fallback por si acaso queda algún textarea
                        input.value = typeof val === 'string' ? val : JSON.stringify(val);
                    } else {
                        input.value = val;
                    }
                }
            }
        }
    }
}

// --- Lógica de Constructores Visuales (Builders) ---

// 1. TIERS BUILDER
function initTierBuilder(data, type) {
    const container = document.getElementById('tier-builder-container');
    container.innerHTML = '';

    if (!data || data.length === 0) {
        addTierRow(type);
    } else {
        data.forEach(row => addTierRow(type, row));
    }
    updateTierJson(type);
}

function addTierRow(type, values = {}) {
    const container = document.getElementById('tier-builder-container');
    const labelKey = type === 'amount' ? 'Monto Min ($)' : 'Cant. Min (Unid)';
    const keyProp = type === 'amount' ? 'min_amount' : 'min_qty';

    const valKey = values[keyProp] || '';
    const valPercent = values.percent || '';

    const row = document.createElement('div');
    row.className = 'input-group tier-row';
    row.innerHTML = `
                    <span class="input-group-text bg-light">${labelKey}</span>
                    <input type="number" class="form-control tier-key" placeholder="Ej: 100" value="${valKey}" oninput="updateTierJson('${type}')">
                    <span class="input-group-text bg-light">% Descuento</span>
                    <input type="number" class="form-control tier-val" placeholder="Ej: 10" value="${valPercent}" oninput="updateTierJson('${type}')">
                    <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove(); updateTierJson('${type}')"><i class="mdi mdi-delete"></i></button>
                `;
    container.appendChild(row);
}

function updateTierJson(type) {
    const rows = document.querySelectorAll('.tier-row');
    const data = [];
    const keyProp = type === 'amount' ? 'min_amount' : 'min_qty';

    rows.forEach(row => {
        const keyVal = row.querySelector('.tier-key').value;
        const percentVal = row.querySelector('.tier-val').value;

        if (keyVal && percentVal) {
            let obj = {percent: parseFloat(percentVal)};
            obj[keyProp] = parseFloat(keyVal);
            data.push(obj);
        }
    });

    document.getElementById('hidden_rule_tiers').value = JSON.stringify(data);
}

// 2. BUNDLE BUILDER
function initBundleBuilder(data) {
    const container = document.getElementById('bundle-builder-container');
    container.innerHTML = '';

    if (!data || data.length === 0) {
        addBundleRow();
    } else {
        data.forEach(row => addBundleRow(row));
    }
    updateBundleJson();
}

function addBundleRow(values = {}) {
    const container = document.getElementById('bundle-builder-container');
    const valId = values.product_id || '';
    const valQty = values.quantity || 1;

    let options = '<option value="">Seleccione producto...</option>';
    items.forEach(item => {
        const selected = String(item.id) === String(valId) ? 'selected' : '';
        options += `<option value="${item.id}" ${selected}>${item.code} - ${item.name}</option>`;
    });

    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 bundle-row align-items-center';
    row.innerHTML = `
                    <div class="col-8">
                        <select class="form-select bundle-product" onchange="updateBundleJson()">
                            ${options}
                        </select>
                    </div>
                    <div class="col-3">
                        <div class="input-group">
                            <span class="input-group-text">Cant.</span>
                            <input type="number" class="form-control bundle-qty" value="${valQty}" min="1" onchange="updateBundleJson()">
                        </div>
                    </div>
                    <div class="col-1 text-end">
                        <button class="btn btn-icon btn-outline-danger btn-sm" type="button" onclick="this.closest('.bundle-row').remove(); updateBundleJson()">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                `;
    container.appendChild(row);

    // Inicializar Select2
    $(row.querySelector('.bundle-product')).select2({
        width: '100%',
        dropdownParent: row
    });
    // Hook de Select2
    $(row.querySelector('.bundle-product')).on('change', function () {
        updateBundleJson();
    });
}

function updateBundleJson() {
    const rows = document.querySelectorAll('.bundle-row');
    const data = [];

    rows.forEach(row => {
        const prodId = $(row.querySelector('.bundle-product')).val();
        const qty = row.querySelector('.bundle-qty').value;

        if (prodId && qty) {
            data.push({
                product_id: parseInt(prodId),
                quantity: parseInt(qty)
            });
        }
    });

    document.getElementById('hidden_rule_bundle').value = JSON.stringify(data);
}


// --- Lógica de Navegación del Wizard ---
let currentStep = 1;

function selectPromoType(type) {
    document.getElementById('promoType').value = type;
    
    // UI Feedback
    document.querySelectorAll('.type-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Usar el evento para encontrar la card si es posible, o buscarla por tipo
    const target = event ? event.currentTarget : document.querySelector(`.type-card[onclick*="'${type}'"]`);
    if (target) target.classList.add('selected');
    
    updateRuleFields();
    
    // Auto avanzar al siguiente paso tras seleccionar el tipo (si es creación)
    setTimeout(() => changeStep(1), 300);
}

function changeStep(n) {
    const steps = document.getElementsByClassName("step-container");
    
    // Validar antes de avanzar
    if (n > 0 && !validateStep(currentStep)) return;

    // Ocultar paso actual
    steps[currentStep - 1].classList.remove("active");
    
    // Actualizar paso actual
    currentStep += n;
    
    if (currentStep > steps.length) {
        // En teoría no debería pasar por los botones, pero por si acaso
        document.getElementById("promotionForm").submit();
        return;
    }

    // Mostrar nuevo paso
    steps[currentStep - 1].classList.add("active");
    
    // Actualizar UI del Wizard Header
    updateWizardUI();
    
    // Si llegamos al último paso, generar resumen
    if (currentStep === 4) {
        generateSummary();
    }
}

function updateWizardUI() {
    const dots = document.querySelectorAll('.wizard-step');
    dots.forEach((dot, idx) => {
        const stepNum = idx + 1;
        dot.classList.remove('active', 'completed');
        
        if (stepNum === currentStep) {
            dot.classList.add('active');
        } else if (stepNum < currentStep) {
            dot.classList.add('completed');
        }
    });

    // Controlar botones
    document.getElementById("prevBtn").style.display = currentStep === 1 ? "none" : "inline-block";
    
    if (currentStep === dots.length) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("submitBtn").style.display = "inline-block";
    } else {
        document.getElementById("nextBtn").style.display = "inline-block";
        document.getElementById("submitBtn").style.display = "none";
    }
}

function validateStep(step) {
    if (step === 1) {
        const type = document.getElementById('promoType').value;
        if (!type) {
            alert('Por favor, selecciona un tipo de promoción.');
            return false;
        }
    }
    if (step === 2) {
        const name = document.getElementById('promotion-name').value;
        if (!name) {
            alert('El nombre de la promoción es obligatorio.');
            return false;
        }
        // Validar campos de reglas dinámicas
        const requiredFields = document.getElementById('ruleFields').querySelectorAll('[required]');
        for (let field of requiredFields) {
            if (!field.value) {
                alert('Por favor completa todos los campos obligatorios del descuento.');
                return false;
            }
        }
    }
    return true;
}

function generateSummary() {
    const type = document.getElementById('promoType').value;
    const name = document.getElementById('promotion-name').value;
    const amount = document.getElementById('min-amount').value;
    const qty = document.getElementById('min-qty').value;
    const productIds = document.getElementById('product-ids').value;
    
    let summary = `La promoción <strong>"${name}"</strong> `;
    
    // Describir el beneficio según el tipo
    switch(type) {
        case 'percent':
            const pct = document.querySelector('[name="rule_percent"]')?.value || 'X';
            summary += `ofrece un <strong>${pct}% de descuento</strong>`;
            break;
        case 'fixed':
            const fxd = document.querySelector('[name="rule_amount"]')?.value || 'X';
            summary += `ofrece un descuento directo de <strong>$${fxd}</strong>`;
            break;
        case 'bogo':
            const buy = document.querySelector('[name="rule_buy"]')?.value || 'X';
            const get = document.querySelector('[name="rule_get"]')?.value || 'X';
            summary += `es un <strong>${buy}x${parseInt(buy)+parseInt(get)}</strong> (compra ${buy} y lleva ${get} gratis)`;
            break;
        default:
            summary += `está configurada`;
    }

    // Describir condiciones
    if (amount > 0 || qty > 0) {
        summary += ` al cumplirse `;
        if (amount > 0) summary += `un monto mínimo de <strong>$${amount}</strong>`;
        if (amount > 0 && qty > 0) summary += ` y `;
        if (qty > 0) summary += `la compra de al menos <strong>${qty} pieza(s)</strong>`;
    }

    // Describir productos
    if (productIds) {
        const count = productIds.split(',').length;
        summary += ` en una selección de <strong>${count} productos</strong>.`;
    } else {
        summary += ` en <strong>todos los productos</strong> del catálogo.`;
    }

    document.getElementById('promotion-summary-text').innerHTML = summary;
}

// Inicializar campos al cargar
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('ruleFields');
    const presetType = container.dataset.type;
    if (presetType) {
        document.getElementById('promoType').value = presetType;
        // Si hay un tipo pre-seleccionado (edición), marcar la card
        const card = document.querySelector(`.type-card[onclick*="'${presetType}'"]`);
        if (card) card.classList.add('selected');
    }
    updateRuleFields();

    initProductCatalog(); // Inicializar el buscador de productos
    
    // Si estamos editando, mostrar botones adecuados
    if (presetType) {
        // Podríamos decidir si saltar al paso 2 o dejarlo en el 1
    }
});

// Lógica para el Buscador de Productos en Memoria
function initProductCatalog() {
    const searchInput = document.getElementById('catalog-search');
    const resultsList = document.getElementById('catalog-results');
    const hiddenInput = document.getElementById('product-ids');
    const selectedContainer = document.getElementById('selected-products-container');
    const btnClearSelected = document.getElementById('btn-clear-selected');
    const selectedCount = document.getElementById('selected-count');
    // Asegurar que el contenedor sea relativo para posicionar bien el dropdown
    if (resultsList && resultsList.parentElement) {
        resultsList.parentElement.classList.add('position-relative');
        resultsList.classList.add('bg-white', 'border');
        resultsList.style.background = resultsList.style.background || '#fff';
        // Elevar z-index para sobreponer Select2/otros overlays
        if (!resultsList.style.zIndex) resultsList.style.zIndex = '2000';
    }

    // Referencias a filtros
    const filterInputs = {
        brand: $('#filterBrand'),
        model: $('#filterModel'),
        line: $('#filterLine'),
        supplier: $('#filterSupplier'),
        keyColor: document.getElementById('filterKeyColor'),
        sizeCode: $('#filterSizeCode'),
        priceMax: document.getElementById('filterPriceMax')
    };

    // Inicializar Select2
    $('.select2').select2();

    // Variables de estado
    let currentFilteredItems = [];
    let activeIndex = -1; // Para navegación con teclado

    // Render inicial de productos seleccionados (usando items global)
    renderSelectedProducts();

    // Función centralizada de búsqueda
    function performSearch() {
        const query = searchInput.value.toLowerCase().trim();

        // Obtener valores de filtros
        const filters = {
            brand: filterInputs.brand.val(),
            model: filterInputs.model.val(),
            line: filterInputs.line.val(),
            supplier: filterInputs.supplier.val(),
            keyColor: filterInputs.keyColor.value.toLowerCase(),
            sizeCode: filterInputs.sizeCode.val(),
            priceMax: filterInputs.priceMax.value
        };

        // Detectar si hay filtros activos
        const hasActiveFilters = Object.values(filters).some(val => val !== "" && val !== null);

        // Si no hay texto y no hay filtros activos, ocultar
        if (query.length < 2 && !hasActiveFilters) {
            resultsList.style.display = 'none';
            document.getElementById('btn-add-all-results').style.display = 'none';
            return;
        }

        resultsList.innerHTML = '';
        resultsList.setAttribute('role', 'listbox');

        // Filtrar el array en memoria (variable global 'items')
        const results = items.filter(product => {
            // 1. Filtro por texto (nombre o código)
            const matchText = !query || product.name.toLowerCase().includes(query) || (product.code && product.code.toLowerCase().includes(query));

            if (!matchText) return false;

            // 2. Filtros avanzados
            if (filters.brand && String(product.brand) !== String(filters.brand)) return false;
            if (filters.model && String(product.model) !== String(filters.model)) return false;
            if (filters.line && String(product.line) !== String(filters.line)) return false;
            if (filters.supplier && String(product.supplier) !== String(filters.supplier)) return false;
            if (filters.keyColor && (!product.color_key || !product.color_key.toLowerCase().includes(filters.keyColor))) return false;
            if (filters.sizeCode && String(product.size) !== String(filters.sizeCode)) return false;
            if (filters.priceMax && parseFloat(product.price) > parseFloat(filters.priceMax)) return false;

            return true;
        });
        
        currentFilteredItems = results;
        activeIndex = results.length > 0 ? 0 : -1;

        const btnAddAll = document.getElementById('btn-add-all-results');
        const countSpan = document.getElementById('count-results');

        if (results.length > 0) {
            btnAddAll.style.display = 'block';
            countSpan.textContent = results.length;

            const displayLimit = 20;
            results.slice(0, displayLimit).forEach(product => {
                const li = document.createElement('li');
                // Estilizado mejorado para el dropdown
                li.className = 'list-group-item list-group-item-action cursor-pointer d-flex justify-content-between align-items-center border-start-0 border-end-0';
                li.setAttribute('role', 'option');

                const isSelected = getCurrentIds().includes(String(product.id));
                // Icono y estilo visual si ya está seleccionado
                const icon = isSelected
                    ? '<i class="mdi mdi-check-circle text-success me-2"></i>'
                    : '<i class="mdi mdi-plus-circle-outline text-primary me-2"></i>';

                li.innerHTML = `
                            <div class="d-flex align-items-center flex-grow-1">
                                ${icon}
                                <div class="ms-1">
                                    <div class="fw-semibold">${product.code || ''} ${product.name || ''}</div>
                                    <small class="text-muted">$${Number(product.price || 0).toFixed(2)}</small>
                                </div>
                            </div>
                            <span class="badge ${isSelected ? 'bg-success' : 'bg-label-primary'}">${isSelected ? 'Seleccionado' : 'Agregar'}</span>
                        `;

                // Evitar que el click cierre el dropdown por el manejador global
                li.addEventListener('mousedown', (ev) => {
                    ev.preventDefault();
                    ev.stopPropagation();
                });
                li.addEventListener('click', (ev) => {
                    ev.preventDefault();
                    ev.stopPropagation();
                    if (isSelected) {
                        removeProduct(product.id);
                    } else {
                        addProduct(product.id);
                    }
                    // Mantener el foco y el dropdown abierto mientras se seleccionan múltiples ítems
                    searchInput.focus();
                    performSearch();
                });

                resultsList.appendChild(li);
            });

            // Resaltar el primero
            updateActiveDescendant();
            resultsList.style.display = 'block';
        } else {
            btnAddAll.style.display = 'none';
            // Mostrar estado vacío
            const emptyLi = document.createElement('li');
            emptyLi.className = 'list-group-item text-muted';
            emptyLi.textContent = 'Sin resultados';
            emptyLi.setAttribute('role', 'option');
            resultsList.appendChild(emptyLi);
            resultsList.style.display = 'block';
        }
    }

    // Actualiza resaltado y atributos ARIA del elemento activo
    function updateActiveDescendant() {
        const options = Array.from(resultsList.querySelectorAll('[role="option"]'));
        options.forEach((el, idx) => {
            if (idx === activeIndex) {
                el.classList.add('active');
                el.setAttribute('aria-selected', 'true');
            } else {
                el.classList.remove('active');
                el.removeAttribute('aria-selected');
            }
        });
        if (activeIndex >= 0 && options[activeIndex]) {
            options[activeIndex].scrollIntoView({ block: 'nearest' });
        }
    }

    // Helpers de selección
    function getCurrentIds() {
        const raw = (hiddenInput.value || '').trim();
        if (!raw) return [];
        return raw.split(',').map(s => s.trim()).filter(Boolean);
    }

    function setCurrentIds(ids) {
        // Unicos y como string
        const unique = Array.from(new Set(ids.map(id => String(id))));
        hiddenInput.value = unique.join(',');
        renderSelectedProducts();
    }

    function addProduct(id) {
        const ids = getCurrentIds();
        if (!ids.includes(String(id))) {
            ids.push(String(id));
            setCurrentIds(ids);
        }
    }

    function removeProduct(id) {
        const ids = getCurrentIds().filter(x => String(x) !== String(id));
        setCurrentIds(ids);
    }

    function renderSelectedProducts() {
        const ids = getCurrentIds();
        selectedContainer.innerHTML = '';

        if (ids.length === 0) {
            const empty = document.createElement('small');
            empty.className = 'text-muted w-100 text-center py-2 empty-msg';
            empty.textContent = 'Sin productos seleccionados';
            selectedContainer.appendChild(empty);
            if (btnClearSelected) btnClearSelected.style.display = 'none';
            if (selectedCount) selectedCount.textContent = '';
            return;
        }

        if (btnClearSelected) btnClearSelected.style.display = 'inline-block';
        if (selectedCount) selectedCount.textContent = `${ids.length} producto${ids.length !== 1 ? 's' : ''} seleccionados`;

        ids.forEach(id => {
            const p = catalogItems[id];
            if (!p) return;
            const chip = document.createElement('div');
            chip.className = 'badge bg-label-secondary text-body d-flex align-items-center gap-2 px-3 py-2';
            chip.innerHTML = `
                        <span class="fw-medium">${p.code || ''}</span>
                        <span class="text-muted">${p.name || ''}</span>
                        <button type="button" class="btn btn-sm btn-icon btn-text-danger ms-2" aria-label="Quitar">
                            <i class="mdi mdi-close"></i>
                        </button>
                    `;
            chip.querySelector('button').addEventListener('click', () => removeProduct(id));
            selectedContainer.appendChild(chip);
        });
    }

    // Eventos
    // Debounce para búsqueda
    function debounce(fn, wait) {
        let t;
        return function (...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }
    const debouncedSearch = debounce(performSearch, 250);
    searchInput.addEventListener('input', debouncedSearch);

    // Navegación con teclado
    searchInput.addEventListener('keydown', (e) => {
        const options = Array.from(resultsList.querySelectorAll('[role="option"]'));
        if (e.key === 'ArrowDown') {
            if (options.length > 0) {
                activeIndex = Math.min((activeIndex < 0 ? 0 : activeIndex + 1), options.length - 1);
                updateActiveDescendant();
                resultsList.style.display = 'block';
                e.preventDefault();
            }
        } else if (e.key === 'ArrowUp') {
            if (options.length > 0) {
                activeIndex = Math.max(0, activeIndex - 1);
                updateActiveDescendant();
                e.preventDefault();
            }
        } else if (e.key === 'Enter') {
            if (activeIndex >= 0 && options[activeIndex]) {
                const idx = activeIndex;
                // Determinar producto según el índice visible
                const current = currentFilteredItems.slice(0, 20)[idx];
                if (current) {
                    const isSelected = getCurrentIds().includes(String(current.id));
                    if (isSelected) {
                        removeProduct(current.id);
                    } else {
                        addProduct(current.id);
                    }
                    performSearch();
                }
                e.preventDefault();
            }
        } else if (e.key === 'Escape') {
            resultsList.style.display = 'none';
            const addAllBtn = document.getElementById('btn-add-all-results');
            if (addAllBtn) addAllBtn.style.display = 'none';
        }
    });

    // Filtros avanzados triggers
    filterInputs.brand.on('change', debouncedSearch);
    filterInputs.model.on('change', debouncedSearch);
    filterInputs.line.on('change', debouncedSearch);
    filterInputs.supplier.on('change', debouncedSearch);
    filterInputs.sizeCode.on('change', debouncedSearch);
    filterInputs.keyColor.addEventListener('input', debouncedSearch);
    filterInputs.priceMax.addEventListener('input', debouncedSearch);

    // Agregar todos los resultados visibles
    document.getElementById('btn-add-all-results').addEventListener('click', () => {
        const current = getCurrentIds();
        const merged = current.concat(currentFilteredItems.map(p => String(p.id)));
        setCurrentIds(merged);
        resultsList.style.display = 'none';
        document.getElementById('btn-add-all-results').style.display = 'none';
    });

    // Limpiar todos los productos seleccionados
    if (btnClearSelected) {
        btnClearSelected.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            setCurrentIds([]);
            // También ocultar dropdown y botón masivo, y mantener el foco en el buscador
            if (resultsList) resultsList.style.display = 'none';
            const addAllBtn = document.getElementById('btn-add-all-results');
            if (addAllBtn) addAllBtn.style.display = 'none';
            if (searchInput) searchInput.focus();
        });
    }

    // Ocultar resultados al hacer click fuera del área de búsqueda/resultado
    const searchArea = searchInput ? searchInput.closest('.form-floating') : null;
    document.addEventListener('click', (e) => {
        // Si el click ocurrió dentro del área (input, botón agregar todos o lista), no cerrar
        const clickedInside = (searchArea && searchArea.contains(e.target));
        if (!clickedInside) {
            resultsList.style.display = 'none';
            document.getElementById('btn-add-all-results').style.display = 'none';
        }
    });
}

