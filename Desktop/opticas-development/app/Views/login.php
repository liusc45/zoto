<!DOCTYPE html>

<html
        lang="es"
        class="light-style layout-wide customizer-hide"
        dir="ltr"
        data-theme="theme-default"
        data-assets-path="/assets/"
        data-template="horizontal-menu-template">
<head>
    <meta charset="utf-8" />
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Entrar | <?=env('app.title')?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
            rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="/assets/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="/assets/vendor/css/pages/page-auth.css" />

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>
</head>

<body>
<!-- Content -->

<div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Login -->
            <div class="card p-2">
                <!-- Logo -->
                <div class="app-brand justify-content-center mt-5">
                    <a href="index.html" class="app-brand-link gap-2">
                        <span class="app-brand-logo demo">
                            <img width="130" height="130" src="assets/img/branding/logo.webp" alt="logo de <?=env('app.title')?>">
                        </span>
                    </a>
                </div>
                <!-- /Logo -->

                <div class="card-body mt-2">
                    <?php
                    if (!is_null(session("error"))):?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <?= @session("error")?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                   <?php endif; ?>
                    <h4 class="mb-2"><span class="app-brand-text demo text-heading fw-bold"><?=env('app.title')?></span></h4>
                    <p class="mb-4">Por favor, introduce tus datos de acceso.</p>

                    <form id="formAuthentication" class="mb-3" action="<?= url_to('login') ?>" method="post">
                        <div class="form-floating form-floating-outline mb-3">
                            <input
                                    type="text"
                                    class="form-control"
                                    id="username"
                                    name="username"
                                    placeholder="vendedor"
                                    autofocus />
                            <label for="email">Usuario</label>
                        </div>
                        <div class="mb-3">
                            <div class="form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                                type="password"
                                                id="password"
                                                class="form-control"
                                                name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" />
                                        <label for="password">Contraseña</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                                <?php if(env('app.baseURL')==='https://dev-labendicion.sistematlan.com') : ?>
                                    <div class="alert alert-solid-warning" role="alert">
                                        <span class="text-black">
                                        ¡ATENCIÓN! <br> Estás en la versión de pruebas del sistema. <br> Si eres un vendedor o administrador visita
                                            el siguiente <a href="https://labendicion.sistematlan.com">link.</a>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            <button class="btn btn-primary d-grid w-100" type="submit">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
</div>

<!-- / Content -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="/assets/vendor/libs/jquery/jquery.js"></script>
<script src="/assets/vendor/js/bootstrap.js"></script>
<script src="/assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="/assets/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
<script src="/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js"></script>
<script src="/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js"></script>


<!-- Page JS -->
<script>
    'use strict';
    const formAuthentication = document.querySelector('#formAuthentication');

    document.addEventListener('DOMContentLoaded', function (e) {
        (function () {
            // Form validation for Add new record
            if (formAuthentication) {
                const fv = FormValidation.formValidation(formAuthentication, {
                    fields: {
                        username: {
                            validators: {
                                notEmpty: {
                                    message: 'Por favor, introduce tu usuario'
                                },
                                stringLength: {
                                    min: 5,
                                    message: 'El usuario debe ser mayor a 5 caracteres'
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'Por favor, introduce tu contraseña'
                                },
                                stringLength: {
                                    min: 8,
                                    message: 'La contraseña debe ser mayor a 8 caracteres'
                                }
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap5: new FormValidation.plugins.Bootstrap5({
                            eleValidClass: '',
                            rowSelector: '.mb-3'
                        }),
                        submitButton: new FormValidation.plugins.SubmitButton(),

                        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                        autoFocus: new FormValidation.plugins.AutoFocus()
                    },
                    init: instance => {
                        instance.on('plugins.message.placed', function (e) {
                            if (e.element.parentElement.classList.contains('input-group')) {
                                e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                            }
                        });
                    }
                });
            }
        })();
    });

</script>
</body>
</html>
