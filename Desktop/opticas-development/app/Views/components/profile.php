<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/css/pages/page-profile.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Perfil del usuario:</span><span id="user-name"></span></h4>

<!-- Header -->
<div class="row">
    <div class="col-12">
        <div class="card mb-4 mt-4">
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    <img
                            src="/assets/img/avatars/1.png"
                            alt="user image"
                            class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
                </div>
                <div class="flex-grow-1 mt-3 mt-sm-5">
                    <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                        <div class="user-profile-info">
                            <h4 id="user-name2"></h4>
                            <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                <li class="list-inline-item">
                                    <i class="mdi mdi-account-outline me-1 mdi-20px"></i
                                    ><span class="fw-medium" id="user"></span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="mdi mdi-map-marker-outline me-1 mdi-20px"></i
                                    ><span class="fw-medium" id="store"></span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="mdi mdi-calendar-blank-outline me-1 mdi-20px"></i
                                    ><span class="fw-medium"> Alta April 2021</span>
                                </li>
                            </ul>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-primary">
                            <i class="mdi mdi-account-check-outline me-1"></i>Conectado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Header -->

<!-- Navbar pills -->
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-sm-row mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="/perfil"
                ><i class="mdi mdi-account-outline me-1 mdi-20px"></i>Perfil</a
                >
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="pages-profile-teams.html"
                ><i class="mdi mdi-finance me-1 mdi-20px"></i>Estadisticas</a
                >
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/mis-ventas"
                ><i class="mdi mdi-archive me-1 mdi-20px"></i>Historial</a
                >
            </li>
        </ul>
    </div>
</div>
<!--/ Navbar pills -->

<!-- User Profile Content -->
<div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5">
        <!-- About User -->
        <div class="card mb-4">
            <div class="card-body">
                <small class="card-text text-uppercase">Información</small>
                <ul class="list-unstyled my-3 py-1">
                    <li class="d-flex align-items-center mb-3">
                        <i class="mdi mdi-account-outline mdi-24px"></i
                        ><span class="fw-medium mx-2">Nombre:</span> <span id="user-name3"></span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="mdi mdi-check mdi-24px"></i><span class="fw-medium mx-2">Estatus:</span>
                        <span id="status"></span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="mdi mdi-star-outline mdi-24px"></i><span class="fw-medium mx-2">Tipo:</span>
                        <span></span>
                    </li>
                </ul>
                <small class="card-text text-uppercase">Contacto</small>
                <ul class="list-unstyled my-3 py-1">
                    <li class="d-flex align-items-center mb-3">
                        <i class="mdi mdi-phone-outline mdi-24px"></i><span class="fw-medium mx-2">Celular:</span>
                        <span id="phone"></span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="mdi mdi-whatsapp mdi-24px"></i><span class="fw-medium mx-2">Whatsapp:</span>
                        <span id="whatsapp"></span>
                    </li>
                    <li class="d-flex align-items-center mb-3">
                        <i class="mdi mdi-email-outline mdi-24px"></i><span class="fw-medium mx-2">Correo:</span>
                        <span id="email"></span>
                    </li>
                </ul>
            </div>
        </div>
        <!--/ About User -->
    </div>
    <div class="col-xl-8 col-lg-7 col-md-7">
        <!-- Activity Timeline -->
        <div class="card card-action mb-4">
            <div class="card-header align-items-center">
                <h5 class="card-action-title mb-0">
                    <i class="mdi mdi-format-list-bulleted mdi-24px me-2"></i>Ultimas ventas
                </h5>
                <div id="loadingSales" class="spinner-border align-items-center justify-content-center text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="card-body pt-3 pb-0">
                <ul class="timeline mb-0" id="last-sales">

                </ul>
            </div>
        </div>
        <!--/ Activity Timeline -->
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>

<script>
    console.log('Profile JS loaded');
/*    let user = <?= json_encode(auth()->user())?>;*/

    $(function () {
        $.ajax({
            method: 'GET',
            url: '/user/'+<?=session()->user['id']?>,
            dataType: 'JSON'
        }).done(function(user){
            $('#user-name, #user-name2, #user-name3').text(user.name + ' ' + user.last_name);
            $('#phone, #whatsapp').text(user.phone);
            $('#email').text(user.secret);
            $('#user').text(user.username);
            $('#store').text(user.store);
            if (user.active === true){
                $('#active').text('Activo');
            }else {
                $('#active').text('Desactivado');
            }
        })

        $.ajax({
            method: 'GET',
            url: '/sale/user/'+<?=session()->user['id']?>,
            dataType: 'JSON'
        }).done(function(sales){
            let lastSales = sales.slice(-5);
            lastSales.reverse();
            lastSales.forEach(function (sale){
                let date = sale.created_at.date.split(' ');
                $('#last-sales').append(`
                <li class="timeline-item timeline-item-transparent border-transparent">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                        <div class="timeline-header mb-1">
                            <h6 class="mb-0">Monto: $${formatMoney(sale.amount)}</h6>
                            <small class="text-muted">${date[0]}</small>
                        </div>
                        <div class="badge bg-label-secondary rounded-pill lh-xs">Articulos: ${sale.items}</div>
                        <div class="badge bg-label-secondary rounded-pill lh-xs">Tipo de pago: ${sale.payment_type}</div>
                        <div class="badge bg-label-secondary rounded-pill lh-xs">Entrega: ${sale.delivery}</div>
                        <div class="badge bg-label-secondary rounded-pill lh-xs"><a href="/ticket/${sale.uuid}" target="_blank">Ver ticket</a></div>
                    </div>
                </li>
                `);
            })
            $('#loadingSales').addClass('d-none');
        })
    });


</script>
<?= $this->endSection() ?>
