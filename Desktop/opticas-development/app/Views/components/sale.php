<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<link rel="stylesheet" href="/assets/vendor/css/pages/wizard-ex-checkout.css" />
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
helper('number');
?>

    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Venta en sucursal:</span> <?=session("store")->name?></h4>


    <?php if (in_array("superadmin",auth()->user()->getGroups())) :?>
        <?= $this->include('partials/stats')?>
	<?php endif; ?>

    <?= $this->include('partials/sale')?>

<?= $this->include('partials/addClient')?>
<?= $this->include('partials/lastPatients')?>
<?= $this->include('modals/lensModal')?>

<?= $this->endSection() ?>


<?= $this->section('componentScripts') ?>
<script>
    const lineFilters = $("a.line-filter");
    let store = <?= json_encode(session("store"))?>;
    let user = <?= json_encode(auth()->user())?>;
    const dt_basic_table = $('#lensDatatable');
    const accounts = <?= json_encode($cards)?>;
    let dt_basic;
    $(function(){
        lineFilters.on("click",function(e){
            console.log(this,e)
            let same = $(this).hasClass("active");
            lineFilters.removeClass("active");
            if(same)
            {
                setItemSelector(itemsFromApi);

            }else{
                showItemByLine(e);
                $(this).addClass("active").addClass("nav-link");
            }
        });
    });
</script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="/assets/vendor/libs/select2/select2.js"></script>
<script src="/assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

<script src="/assets/js/custom/sale.js?version=<?= time()?>"></script>
<script src="/assets/js/custom/lens-datatable.js?version=<?= time()?>"></script>

<?= $this->endSection() ?>
