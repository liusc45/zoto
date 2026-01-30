<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Gestión de Precios</h5>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary" id="saveAllChanges" style="display: none;">
                    <i class="mdi mdi-content-save me-1"></i>Guardar Cambios
                </button>
                <button type="button" class="btn btn-secondary" id="discardChanges" style="display: none;">
                    <i class="mdi mdi-cancel me-1"></i>Descartar Cambios
                </button>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table id="priceManagerTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Precio Regular</th>
                    <th>Precio Promoción</th>
                    <th>Precio Descuento</th>
                    <th>Precio Outlet</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal para editar precios -->
    <div class="modal fade" id="editPricesModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Precios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="priceEditForm">
                        <input type="hidden" id="editItemId">
                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <input type="text" class="form-control" id="editItemName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de Precio</label>
                            <select class="form-select" id="editPriceType">
                                <option value="regular">Regular</option>
                                <option value="promotion">Promoción</option>
                                <option value="discount">Descuento</option>
                                <option value="outlet">Outlet</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Monto</label>
                            <input type="number" class="form-control" id="editAmount" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="datetime-local" class="form-control" id="editStartsAt">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha Fin</label>
                            <input type="datetime-local" class="form-control" id="editEndsAt">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="savePriceChanges">Guardar</button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <script>
        let priceTable;
        let modifiedRows = new Set();

        $(function() {
            priceTable = $('#priceManagerTable').DataTable({
                ajax: {
                    url: '/price',
                    dataSrc: ''
                },
                columns: [
                    { data: 'item' },
                    { data: null, render: function(data, type, row) {
                        return `${row.item_key} ${row.item_name} `
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return createPriceCell(row, 'regular');
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return createPriceCell(row, 'promotion');
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return createPriceCell(row, 'discount');
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return createPriceCell(row, 'outlet');
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-primary edit-prices" data-item-id="${row.item}">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                            `;
                        }
                    }
                ],
                order: [[1, 'asc']],
                pageLength: 25,
                responsive: true
            });

            // Evento para edición rápida de precios
            $('#priceManagerTable').on('change', '.price-input', function() {
                const $input = $(this);
                const itemId = $input.data('item-id');
                const priceType = $input.data('price-type');
                const newValue = $input.val();

                modifiedRows.add(itemId);
                toggleSaveButtons(true);
            });

            // Guardar todos los cambios
            $('#saveAllChanges').on('click', function() {
                const updates = [];
                modifiedRows.forEach(itemId => {
                    const row = priceTable.row(`[data-item-id="${itemId}"]`);
                    const rowData = row.data();
                    ['regular', 'promotion', 'discount', 'outlet'].forEach(type => {
                        const value = $(`#price-${itemId}-${type}`).val();
                        if (value) {
                            updates.push({
                                item: itemId,
                                type: type,
                                amount: value
                            });
                        }
                    });
                });

                // Llamada API para guardar cambios
                $.ajax({
                    url: '/api/item-prices/batch',
                    method: 'POST',
                    data: JSON.stringify({ prices: updates }),
                    contentType: 'application/json',
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cambios guardados',
                            text: 'Los precios se han actualizado correctamente'
                        });
                        modifiedRows.clear();
                        toggleSaveButtons(false);
                        priceTable.ajax.reload();
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudieron guardar los cambios'
                        });
                    }
                });
            });
        });

        function createPriceCell(row, type) {
            const price = row.prices?.find(p => p.type === type);
            return `
                <input type="number"
                       class="form-control form-control-sm price-input"
                       id="price-${row.item}-${type}"
                       data-item-id="${row.item}"
                       data-price-type="${type}"
                       value="${price ? price.amount : ''}"
                       step="0.01">
            `;
        }

        function toggleSaveButtons(show) {
            $('#saveAllChanges, #discardChanges').toggle(show);
        }
    </script>
<?= $this->endSection() ?>