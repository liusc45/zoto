<?= $this->extend('app') ?>

<?= $this->section('content') ?>
<div class="row">
  <div class="col-lg-8">
    <h4 class="py-3">Configuración de Comisiones</h4>
    <?php if (session()->getFlashdata('message')): ?>
      <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>
    <form method="post" action="/commission/settings">
      <div class="card p-3">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Tasa de IVA (%)</label>
            <input type="number" step="0.01" class="form-control" name="tax_rate" value="<?= isset($config['tax_rate']) ? $config['tax_rate']*100 : 16 ?>" oninput="this.nextElementSibling.value=this.value/100">
            <small class="text-muted">Se guardará como tasa (ej. 0.16). Valor actual: <output><?= isset($config['tax_rate'])?$config['tax_rate']:0.16 ?></output></small>
          </div>
          <div class="col-md-6">
            <label class="form-label">Comisión bancaria (%)</label>
            <input type="number" step="0.01" class="form-control" name="bank_commission_rate" value="<?= isset($config['bank_commission_rate']) ? $config['bank_commission_rate']*100 : 3 ?>" oninput="this.nextElementSibling.value=this.value/100">
            <small class="text-muted">Se guardará como tasa (ej. 0.03). Valor actual: <output><?= isset($config['bank_commission_rate'])?$config['bank_commission_rate']:0.03 ?></output></small>
          </div>
          <div class="col-md-3">
            <label class="form-label">% Línea 1</label>
            <input type="number" step="0.01" class="form-control" name="percent_line1" value="<?= isset($config['percent_line1']) ? $config['percent_line1'] : 5 ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label">% Línea 2</label>
            <input type="number" step="0.01" class="form-control" name="percent_line2" value="<?= isset($config['percent_line2']) ? $config['percent_line2'] : 3 ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label">% Línea 13</label>
            <input type="number" step="0.01" class="form-control" name="percent_line13" value="<?= isset($config['percent_line13']) ? $config['percent_line13'] : 5 ?>">
          </div>
          <div class="col-md-3">
            <label class="form-label">% Combo 1+13</label>
            <input type="number" step="0.01" class="form-control" name="percent_bundle_1_13" value="<?= isset($config['percent_bundle_1_13']) ? $config['percent_bundle_1_13'] : 7 ?>">
          </div>
        </div>
        <div class="mt-3">
          <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
