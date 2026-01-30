<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="/assets/"
    data-template="vertical-menu-template-no-customizer">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />


    <title><?=session()->meta["path"]?> | <?=env('app.title')?></title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="MyWebSite" />
    <link rel="manifest" href="/site.webmanifest" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="/assets/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/remixicon/remixicon.css" />
    <link rel="stylesheet" href="/assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/swiper/swiper.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/toastr/toastr.css" />
    <!-- Page CSS -->
    <link rel="stylesheet" href="/assets/vendor/css/pages/cards-statistics.css" />
    <link rel="stylesheet" href="/assets/vendor/css/pages/cards-analytics.css" />

    <!-- Helpers -->
    <script src="/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/assets/js/config.js"></script>

    <?= $this->renderSection('componentStyles')?>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <!-- Sidebar -->
        <?= $this->include('partials/sidebar',["path"=>session("meta")["path"]]) ?>
        <!-- / Sidebar -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <?= $this->include('partials/navbar',["tiendas"=>["tienda1"]]) ?>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y">
					<?php if(env('app.baseURL')==='https://dev-labendicion.sistematlan.com') : ?>
                        <div class="alert alert-solid-warning" role="alert">
                            <span class="text-black">
                                ¡ATENCIÓN! Estás en la versión de pruebas del sistema. Si eres un vendedor o administrador visita
                                el siguiente <a href="https://labendicion.sistematlan.com">link.</a>
                            </span>
                        </div>
					<?php endif; ?>
                    <!-- Content -->
                    <?= $this->renderSection('content')?>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?= $this->include('partials/footer') ?>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="/assets/vendor/libs/jquery/jquery.js"></script>
<script src="/assets/vendor/libs/moment/moment.js"></script>
<script src="/assets/vendor/libs/select2/select2.js"></script>
<script src="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="/assets/vendor/js/bootstrap.js"></script>
<script src="/assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="/assets/vendor/libs/popper/popper.js"></script>
<script src="/assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="/assets/vendor/libs/hammer/hammer.js"></script>
<script src="/assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="/assets/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="/assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="/assets/vendor/libs/swiper/swiper.js"></script>

<!-- Main JS -->
<script src="/assets/js/main.js"></script>
<script src="/assets/js/utils.js"></script>
<script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/toastr/toastr.js"></script>

<!-- Page JS -->
<script src="/assets/js/dashboards-analytics.js"></script>


<script>
    console.log('Global JS loaded');
    let bsRangePickerRange;
    const select2 = $('.select2');
    $(function (){
        if (select2.length) {
            select2.each(function () {
                var $this = $(this);
                select2Focus($this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Seleccionar opción',
                    dropdownParent: $this.parent()
                });
            });
        }

        $('#storeSelector').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            setUserStore(e.target[clickedIndex].value)
        });

        bsRangePickerRange = $('#bs-rangepicker-range');
        if (bsRangePickerRange) {
            bsRangePickerRange.daterangepicker({
                ranges: {
                    Hoy: [moment(), moment()],
                    Ayer: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                    'Mes actual': [moment().startOf('month'), moment().endOf('month')],
                    'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "customRangeLabel": "Personalizado",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                }
            });
        }

        $('#bs-rangepicker-range').on('apply.daterangepicker', function(ev, picker) {
            let startDate = picker.startDate.format('YYYY-MM-DD')
            let endDate = picker.endDate.format('YYYY-MM-DD')
            getDateRangeData(startDate, endDate);
        });
    });

    function setUserStore(storeId)
    {
        saleBlock();
        let inSale = location.pathname=== "/inicio";
        
        if(undefined===storeId)
        {
            $.unblockUI();
            return;

        }
        $.ajax({
            method:"POST",
            url:"/user/store",
            data:{id:storeId},
            dataType :"JSON",

        }).done(function(){
             location.href = "/"+location.pathname.split("/")[1];
        });
    }

    function formatMoney(price)
    {
        return new Intl.NumberFormat('es-MX', {style: "currency", currency: 'MXN'}).format(price);
    }

    function saleBlock()
    {
        $.blockUI({
            message: '<div class="spinner-border text-primary" role="status"></div>',

            css: {
                backgroundColor: 'transparent',
                border: '0'
            },
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8
            }
        });
    }

    function stripslashes(str) {
        str = str.replace(/\\'/g, '\'');
        str = str.replace(/\\"/g, '"');
        str = str.replace(/\\0/g, '\0');
        str = str.replace(/\\\\/g, '\\');
        return str;
    }

    /**
     * Muestra una alerta de notificación tipo "toast" en la interfaz de usuario.
     *
     * @function toastAlert
     * @param {string} type - El tipo de notificación que se desea mostrar. Puede ser uno de los siguientes valores: 'success', 'info', 'warning', 'error'.
     * @param {string} title - El título de la notificación.
     * @param {string} message - El mensaje de la notificación.
     *
     * @example
     * toastAlert('success', 'Operación exitosa', 'Los datos se guardaron correctamente');
     * toastAlert('error', 'Error', 'No se pudo conectar al servidor');
     */
    function toastAlert(type, title, message)
    {
        Command: toastr[type](message, title);

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }

    function blocking()
    {
        $('#card-block').block({
            message: '<div class="spinner-border text-primary" role="status"></div>',
            timeout: 2000,
            css: {
                backgroundColor: 'transparent',
                border: '0'
            },
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8
            }
        });
    }

    /**
     * Redirects to a URL with date range parameters (`start` and `end`).
     *
     * This function takes two dates, converts them into URL parameters (`start` and `end`),
     * and redirects the user to the same page with these parameters added. It’s useful
     * for loading data filtered by a specific time range.
     *
     * @function getDateRangeData
     * @param {string} startDate - Start date of the range in `YYYY-MM-DD` format.
     * @param {string} endDate - End date of the range in `YYYY-MM-DD` format.
     *
     * @example
     * // Redirects to the current page with a date range from January 1 to January 31, 2023
     * getDateRangeData("2023-01-01", "2023-01-31");
     * // Result: /current_path?start=2023-01-01&end=2023-01-31
     */
    function getDateRangeData(startDate, endDate) {
        let params = new URLSearchParams();
        params.set("start", startDate);
        params.set("end", endDate);
        location.href = location.pathname+"?"+params.toString();
    }
</script>
<?= $this->renderSection('componentScripts')?>

</body>
</html>
