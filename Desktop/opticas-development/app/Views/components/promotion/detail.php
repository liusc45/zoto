<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-6">
                        <div class="form-floating form-floating-outline">
                            <select id="select2Brand"
                                    class="select2Brand form-select form-select-lg"
                                    data-allow-clear="true">
                                    <?php foreach($brands as $key => $brand):?>
                                        <option value="<?= $brand->id;?>">
                                            <?= $brand->name; ?>
                                        </option>
                                    <?php endforeach;?>
                            </select>
                            <label for="select2Basic">Marca</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-6">
                        <div class="form-floating form-floating-outline">
                            <select id="select2Color"
                                    class="select2Color form-select form-select-lg"
                                    data-allow-clear="true">
                                    <?php foreach($colors as $key => $color):?>
                                        <option value="<?= $color->id;?>">
                                            <?= $color->name; ?>
                                        </option>
                                    <?php endforeach;?>
                            </select>
                            <label for="select2Basic">Color</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-6">
                        <div class="form-floating form-floating-outline">
                            <select id="select2Line"
                                    class="select2Line form-select form-select-lg"
                                    data-allow-clear="true">
                                    <?php foreach($lines as $key => $line):?>
                                        <option value="<?= $line->id;?>">
                                            <?= $line->name; ?>
                                        </option>
                                    <?php endforeach;?>
                            </select>
                            <label for="select2Basic">Linea</label>
                        </div>
                    </div>
                </div>

                <hr class="my-12" />

                <div class="row">
                    <div class="col-md-3 mb-6">
                        <div class="form-floating form-floating-outline">
                            <select id="select2LensDesigns"
                                    class="select2Brand form-select form-select-lg"
                                    data-allow-clear="true">
                                <?php foreach($lens_designs as $key => $lens_design):?>
                                    <option value="<?= $lens_design->id;?>">
                                        <?= $lens_design->name; ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <label for="select2Basic">Diseño de lente</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-6">
                        <div class="form-floating form-floating-outline">
                            <select id="select2Color"
                                    class="select2Color form-select form-select-lg"
                                    data-allow-clear="true">
                                <?php foreach($lens_materials as $key => $lens_material):?>
                                    <option value="<?= $lens_material->id;?>">
                                        <?= $lens_material->name; ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <label for="select2Basic">Material de lente</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-6">
                        <div class="form-floating form-floating-outline">
                            <select id="select2Line"
                                    class="select2Line form-select form-select-lg"
                                    data-allow-clear="true">
                                <?php foreach($lens_treatments as $key => $lens_treatment):?>
                                    <option value="<?= $lens_treatment->id;?>">
                                        <?= $lens_treatment->name; ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <label for="select2Basic">Tratamiento de lente</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-6">
                        <div class="form-floating form-floating-outline">
                            <select id="select2Line"
                                    class="select2Line form-select form-select-lg"
                                    data-allow-clear="true">
                                <?php foreach($lens_types as $key => $lens_type):?>
                                    <option value="<?= $lens_type->id;?>">
                                        <?= $lens_type->name; ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <label for="select2Basic">Tipo de lente</label>
                        </div>
                    </div>
                </div>

                <hr class="my-12" />

                <div class="row">
                    <div class="col-md-4 mb-6">
                        <div class="form-floating form-floating-outline">
                            <select id="select2Brand"
                                    class="select2Brand form-select form-select-lg"
                                    data-allow-clear="true">
                                <?php foreach($contact_brands as $key => $contact_brand):?>
                                    <option value="<?= $contact_brand->id;?>">
                                        <?= $contact_brand->name; ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <label for="select2Basic">Marca de lente</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-6">
                        <div class="form-floating form-floating-outline">
                            <select id="select2Color"
                                    class="select2Color form-select form-select-lg"
                                    data-allow-clear="true">
                                <?php foreach($contact_designs as $key => $contact_design):?>
                                    <option value="<?= $contact_design->id;?>">
                                        <?= $contact_design->name; ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <label for="select2Basic">Diseño de lente</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-6">
                        <div class="form-floating form-floating-outline">
                            <select id="select2Line"
                                    class="select2Line form-select form-select-lg"
                                    data-allow-clear="true">
                                <?php foreach($contact_wears as $key => $contact_wear):?>
                                    <option value="<?= $contact_wear->id;?>">
                                        <?= $contact_wear->name; ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <label for="select2Basic">Usos de lente</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-12 mt-4">
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Linea</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php foreach($items as $key => $item):?>
                            <tr>
                                <td><?=$item->name?></td>
                                <td><?=$item->line?></td>
                                <td><?=$item->brand?></td>
                                <td><?=$item->color?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="ri-more-2-line"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);">
                                                <i class="ri-pencil-line me-1"></i> Editar</a>
                                            <a class="dropdown-item" href="javascript:void(0);">
                                                <i class="ri-delete-bin-7-line me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
    <script src="/assets/vendor/libs/select2/select2.js"></script>

    <script>
        let selectedItems = new Map();
        let promotionsTable;
        let categories = [];
        const select2Brand = $('.select2Brand');
        const select2Color = $('.select2Color');
        const select2Line = $('.select2Line');

        $(function() {
            select2Brand.each(function () {
                var $this = $(this);
                select2Focus($this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Seleccionar opción',
                    dropdownParent: $this.parent()
                });
            });

            select2Color.each(function () {
                var $this = $(this);
                select2Focus($this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Seleccionar opción',
                    dropdownParent: $this.parent()
                });
            });

            select2Line.each(function () {
                var $this = $(this);
                select2Focus($this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Seleccionar opción',
                    dropdownParent: $this.parent()
                });
            });


            // Inicializar Flatpickr para fechas
            $('.flatpickr-date-time').flatpickr({
                enableTime: true,
                dateFormat: 'Y-m-d H:i',
                time_24hr: true
            });

            // Inicializar DataTable de promociones
            promotionsTable = $('#promotionsTable').DataTable({
                ajax: {
                    url: '/promotion',
                    dataSrc: ''
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { 
                        data: 'description',
                        render: function(data) {
                            return data ? data.substring(0, 50) + (data.length > 50 ? '...' : '') : '';
                        }
                    },
                    { 
                        data: 'starts_at',
                        render: function(data) {
                            return data.date.split(' ')[0];
                        }
                    },
                    { 
                        data: 'ends_at',
                        render: function(data) {
                            return data.date.split(' ')[0];
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-primary edit-promotion" data-id="${data.id}">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-promotion" data-id="${data.id}">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                order: [[0, 'desc']],
                pageLength: 10,
                responsive: true
            });

            // Evento para agregar nueva promoción
            $('#addPromotion').on('click', function() {
                resetPromotionForm();
                $('#modalTitle').text('Nueva Promoción');
                $('#promotionModal').modal('show');
            });

            // Evento para editar promoción
            $('#promotionsTable').on('click', '.edit-promotion', function() {
                const promotionId = $(this).data('id');
                loadPromotion(promotionId);
            });

            // Evento para eliminar promoción
            $('#promotionsTable').on('click', '.delete-promotion', function() {
                const promotionId = $(this).data('id');
                deletePromotion(promotionId);
            });

            // Evento para ver artículos de una promoción
            $('#promotionsTable').on('click', '.view-items', function() {
                const promotionId = $(this).data('id');
                viewPromotionItems(promotionId);
            });

            // Evento para buscar artículos
            $('#searchItems').on('click', function() {
                searchItems();
            });

            $('#itemSearch').on('keypress', function(e) {
                if (e.which === 13) {
                    searchItems();
                    e.preventDefault();
                }
            });

            // Evento para filtrar por categoría
            $('#categoryFilter').on('change', function() {
                searchItems();
            });

            // Evento para guardar promoción
            $('#savePromotion').on('click', function() {
                savePromotion();
            });
        });

        // Buscar artículos
        function searchItems() {
            const category = $('#categoryFilter').val();
            const search = $('#itemSearch').val();

            $.ajax({
                url: '/promotion/getFilteredItems',
                method: 'GET',
                data: {
                    category: category,
                    search: search
                },
                success: function(data) {
                    renderItemsTable(data);
                }
            });
        }


        // Cargar promoción para editar
        function loadPromotion(id) {
            $.ajax({
                url: `/promotion/${id}`,
                method: 'GET',
                success: function(data) {
                    resetPromotionForm();
                    console.log(data);
                    $('#promotionId').val(data.id);
                    $('#promotionName').val(data.name);
                    $('#promotionDescription').val(data.description);
                    $('#promotionStartsAt').val(formatDateForFlatpickr(data.starts_at.date.split(' ')[0]));
                    $('#promotionEndsAt').val(formatDateForFlatpickr(data.ends_at.date.split(' ')[0]));
                    
                    // Cargar artículos seleccionados
                    selectedItems.clear();
                    if (data.items && data.items.length > 0) {
                        data.items.forEach(item => {
                            selectedItems.set(item.item_id, {
                                item_id: item.item_id,
                                name: item.item_name,
                                key: item.item_key,
                                price: item.price
                            });
                        });
                    }
                    
                    // Buscar artículos para mostrar los seleccionados
                    searchItems();
                    
                    $('#modalTitle').text('Editar Promoción');
                    $('#promotionModal').modal('show');
                }
            });
        }

        // Guardar promoción
        function savePromotion() {
            const id = $('#promotionId').val();
            let promoName = $('#promotionName').val();
            let promoDescription = $('#promotionDescription').val();
            let promoStarts = $('#promotionStartsAt').val();
            let promoEnds = $('#promotionEndsAt').val();
            const isNew = !id;
            
            // Validar formulario
            if (!promoName || !promoStarts || !promoEnds) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor complete todos los campos requeridos'
                });
                return;
            }
            
            const data = {
                name: promoName,
                description: promoDescription,
                starts_at: promoStarts,
                ends_at: promoEnds,
            };
            
            // Enviar solicitud
            $.ajax({
                url: isNew ? '/promotion' : `/promotion/${id}`,
                method: isNew ? 'POST' : 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(promotion) {
                    console.log(promotion);
                    $('#promotionModal').modal('hide');
                    promotionsTable.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: isNew ? 'Promoción creada exitosamente' : 'Promoción actualizada exitosamente'
                    }).then(() => {
                        isNew ? window.location.href = '/promocion/'+promotion.id : '';
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Error al guardar la promoción';
                    if (xhr.responseJSON && xhr.responseJSON.messages) {
                        errorMessage = Object.values(xhr.responseJSON.messages).join('\n');
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        }

        // Eliminar promoción
        function deletePromotion(id) {
            Swal.fire({
                title: '¿Está seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/promotion/${id}`,
                        method: 'DELETE',
                        success: function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: 'Promoción eliminada exitosamente'
                            });
                            
                            promotionsTable.ajax.reload();
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al eliminar la promoción'
                            });
                        }
                    });
                }
            });
        }

        // Resetear formulario
        function resetPromotionForm() {
            $('#promotionId').val('');
            $('#promotionName').val('');
            $('#promotionDescription').val('');
            $('#promotionStatus').val('active');
            
            // Establecer fechas predeterminadas (hoy y un mes después)
            const today = new Date();
            const nextMonth = new Date();
            nextMonth.setMonth(nextMonth.getMonth() + 1);
            
            $('#promotionStartsAt').val(formatDateForFlatpickr(today));
            $('#promotionEndsAt').val(formatDateForFlatpickr(nextMonth));
            
            // Limpiar artículos seleccionados
            selectedItems.clear();
            $('#itemsTable tbody').empty();
        }

        // Formatear fecha para Flatpickr
        function formatDateForFlatpickr(date) {
            if (!date) return '';
            
            const d = new Date(date);
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            const hours = String(d.getHours()).padStart(2, '0');
            const minutes = String(d.getMinutes()).padStart(2, '0');
            
            return `${year}-${month}-${day} ${hours}:${minutes}`;
        }

        // Formatear moneda
        function formatCurrency(value) {
            return new Intl.NumberFormat('es-MX', {
                style: 'currency',
                currency: 'MXN'
            }).format(value);
        }
    </script>
<?= $this->endSection() ?>