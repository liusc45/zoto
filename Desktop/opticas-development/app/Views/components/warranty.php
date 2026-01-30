<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>


<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script>
    console.log('Warranty JS loaded');
</script>

<?= $this->endSection() ?>
