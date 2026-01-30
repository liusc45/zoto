<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<!-- Estilos específicos de la vista (si se requieren) -->
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?= esc($title) ?></h4>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de Promociones</h5>
            <a href="<?= base_url('promociones/nueva') ?>" class="btn btn-primary">
                <i class="mdi mdi-plus me-1"></i> Nueva Promoción
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Canal</th>
                        <th>Vigencia</th>
                        <th>Prioridad</th>
                        <th>Combinable</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($promotions)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">No hay promociones registradas</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($promotions as $promo): ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?= esc($promo['name']) ?></div>
                                    <div class="small text-muted text-truncate" style="max-width: 320px;"><?= esc($promo['description'] ?? '') ?></div>
                                </td>
                                <td>
                                    <?= $promo['code'] ? '<span class="badge bg-secondary">' . esc($promo['code']) . '</span>' : '-' ?>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark"><?= esc($promo['type']) ?></span>
                                </td>
                                <td>
                                    <?php
                                    $channelLabels = [ 'store' => 'Tienda', 'online' => 'Online', 'both' => 'Ambos' ];
                                    $channelClass  = [ 'store' => 'bg-warning text-dark', 'online' => 'bg-primary', 'both' => 'bg-success' ];
                                    $label = $channelLabels[$promo['channel']] ?? $promo['channel'];
                                    $cls   = $channelClass[$promo['channel']] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $cls ?>"><?= esc($label) ?></span>
                                </td>
                                <td>
                                    <div><?= date('d/m/Y', strtotime($promo['starts_at'])) ?></div>
                                    <?php if (!empty($promo['ends_at'])): ?>
                                        <div class="text-muted small">hasta <?= date('d/m/Y', strtotime($promo['ends_at'])) ?></div>
                                    <?php else: ?>
                                        <div class="text-muted small">Sin fecha fin</div>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($promo['priority']) ?></td>
                                <td><?= !empty($promo['combinable']) ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-secondary">No</span>' ?></td>
                                <td>
                                    <button type="button" onclick="toggleActive(<?= (int)$promo['id'] ?>)" data-id="<?= (int)$promo['id'] ?>"
                                            class="btn btn-sm <?= $promo['active'] ? 'btn-success' : 'btn-outline-danger' ?>">
                                        <?= $promo['active'] ? 'Activa' : 'Inactiva' ?>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('promociones/editar/' . $promo['id']) ?>" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="<?= base_url('promociones/eliminar/' . $promo['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta promoción?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script>
    function toggleActive(id) {
        const url = `<?= base_url('promociones/toggle/') ?>${id}`;
        const csrfName = '<?= csrf_token() ?>';
        const csrfHash = '<?= csrf_hash() ?>';
        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfHash
            },
            body: encodeURI(`${csrfName}=${csrfHash}`)
        })
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    const btn = document.querySelector(`button[data-id="${id}"]`);
                    if (!btn) return;
                    if (data.active) {
                        btn.classList.remove('btn-outline-danger');
                        btn.classList.add('btn-success');
                        btn.textContent = 'Activa';
                    } else {
                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-outline-danger');
                        btn.textContent = 'Inactiva';
                    }
                }
            });
    }
</script>
<?= $this->endSection() ?>