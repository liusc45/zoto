<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/css/pages/page-user-view.css" />
<link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

<div class="row gy-6 gy-md-0">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
      <?=$this->include('components/patients/patient')?>
        <!-- /User Card -->
    </div>
    <!--/ User Sidebar -->
    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        <div class="col-12">
            <div class="card mb-6">
                <div class="card-header p-0">
                    <div class="nav-align-top">
                        <ul class="nav nav-tabs nav-fill" role="tablist">
                            <li class="nav-item  ">
                                <button
                                        type="button"
                                        class="nav-link active "
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-consultations"
                                        aria-controls="navs-justified-consultations"
                                        aria-selected="false">
                              <span class="d-none d-sm-block">
                                  <i class="tf-icons ri-user-3-line me-2"></i> Consultas</span>
                                    <i class="ri-user-3-line ri-20px d-sm-none"></i>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                        type="button"
                                        class="nav-link"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-purchases"
                                        aria-controls="navs-justified-purchases"
                                        aria-selected="false">
                              <span class="d-none d-sm-block">
                                  <i class="tf-icons ri-user-3-line me-2"></i> Compras</span>
                                    <i class="ri-user-3-line ri-20px d-sm-none"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="tab-content p-0">
                        <?=$this->include('components/patients/consultations_tab')?>
                        <?=$this->include('components/patients/purchases_tab')?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ User Content -->
</div>

    <?= $this->include('modals/editCustomer')?>
    <?= $this->include('modals/consultation')?>
    <?= $this->include('modals/newPhoneModal')?>
    <?= $this->include('modals/prescription')?>
    <?= $this->include('components/patients/taxID')?>

<?= $this->endSection() ?>


<?= $this->section('componentScripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="/assets/js/custom/patient-edit.js"></script>
<script src="/assets/js/custom/patient-detail.js"></script>

<script>
    let prescriptions = <?=json_encode($prescriptions)?>


</script>
<?= $this->endSection() ?>

