<!DOCTYPE html>

<html
        lang="en"
        class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
        dir="ltr"
        data-theme="theme-default"
        data-assets-path="../public/assets/"
        data-template="vertical-menu-template">
<head>
    <meta charset="utf-8" />
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Custom Options - Forms | Materialize - Material Design HTML Admin Template</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../public/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
            rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../public/assets/vendor/fonts/materialdesignicons.css" />
    <link rel="stylesheet" href="../public/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../public/assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../public/assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../public/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../public/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../public/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../public/assets/vendor/libs/typeahead-js/typeahead.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../public/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../public/assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../public/assets/js/config.js"></script>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <nav
                    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="mdi mdi-menu mdi-24px"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item navbar-search-wrapper mb-0">
                            <a class="nav-item nav-link search-toggler fw-normal px-0" href="javascript:void(0);">
                                <i class="mdi mdi-magnify mdi-24px scaleX-n1-rtl"></i>
                                <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                            </a>
                        </div>
                    </div>
                    <!-- /Search -->

                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <!-- Language -->
                        <li class="nav-item dropdown-language dropdown me-1 me-xl-0">
                            <a
                                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                    href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                <i class="mdi mdi-translate mdi-24px"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-language="en">
                                        <span class="align-middle">English</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-language="fr">
                                        <span class="align-middle">French</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-language="de">
                                        <span class="align-middle">German</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-language="pt">
                                        <span class="align-middle">Portuguese</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ Language -->

                        <!-- Style Switcher -->
                        <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                            <a
                                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                    href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                <i class="mdi mdi-24px"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                        <span class="align-middle"><i class="mdi mdi-weather-sunny me-2"></i>Light</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                        <span class="align-middle"><i class="mdi mdi-weather-night me-2"></i>Dark</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                        <span class="align-middle"><i class="mdi mdi-monitor me-2"></i>System</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- / Style Switcher-->

                            <!-- Quick links  -->
                        </li>

                        <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-1 me-xl-0">
                            <a
                                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                    href="javascript:void(0);"
                                    data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside"
                                    aria-expanded="false">
                                <i class="mdi mdi-view-grid-plus-outline mdi-24px"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end py-0">
                                <div class="dropdown-menu-header border-bottom">
                                    <div class="dropdown-header d-flex align-items-center py-3">
                                        <h5 class="text-body mb-0 me-auto">Shortcuts</h5>
                                        <a
                                                href="javascript:void(0)"
                                                class="dropdown-shortcuts-add text-muted"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="Add shortcuts"
                                        ><i class="mdi mdi-view-grid-plus-outline mdi-24px"></i
                                            ></a>
                                    </div>
                                </div>
                                <div class="dropdown-shortcuts-list scrollable-container">
                                    <div class="row row-bordered overflow-visible g-0">
                                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="mdi mdi-calendar fs-4"></i>
                          </span>
                                            <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                            <small class="text-muted mb-0">Appointments</small>
                                        </div>
                                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="mdi mdi-file-document-outline fs-4"></i>
                          </span>
                                            <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                            <small class="text-muted mb-0">Manage Accounts</small>
                                        </div>
                                    </div>
                                    <div class="row row-bordered overflow-visible g-0">
                                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="mdi mdi-account-outline fs-4"></i>
                          </span>
                                            <a href="app-user-list.html" class="stretched-link">User App</a>
                                            <small class="text-muted mb-0">Manage Users</small>
                                        </div>
                                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="mdi mdi-shield-check-outline fs-4"></i>
                          </span>
                                            <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                                            <small class="text-muted mb-0">Permission</small>
                                        </div>
                                    </div>
                                    <div class="row row-bordered overflow-visible g-0">
                                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="mdi mdi-chart-pie-outline fs-4"></i>
                          </span>
                                            <a href="index.html" class="stretched-link">Dashboard</a>
                                            <small class="text-muted mb-0">Analytics</small>
                                        </div>
                                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="mdi mdi-cog-outline fs-4"></i>
                          </span>
                                            <a href="pages-account-settings-account.html" class="stretched-link">Setting</a>
                                            <small class="text-muted mb-0">Account Settings</small>
                                        </div>
                                    </div>
                                    <div class="row row-bordered overflow-visible g-0">
                                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="mdi mdi-help-circle-outline fs-4"></i>
                          </span>
                                            <a href="pages-faq.html" class="stretched-link">FAQs</a>
                                            <small class="text-muted mb-0">FAQs & Articles</small>
                                        </div>
                                        <div class="dropdown-shortcuts-item col">
                          <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                            <i class="mdi mdi-dock-window fs-4"></i>
                          </span>
                                            <a href="modal-examples.html" class="stretched-link">Modals</a>
                                            <small class="text-muted mb-0">Useful Popups</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- Quick links -->

                        <!-- Notification -->
                        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-2 me-xl-1">
                            <a
                                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                    href="javascript:void(0);"
                                    data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside"
                                    aria-expanded="false">
                                <i class="mdi mdi-bell-outline mdi-24px"></i>
                                <span
                                        class="position-absolute top-0 start-50 translate-middle-y badge badge-dot bg-danger mt-2 border"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end py-0">
                                <li class="dropdown-menu-header border-bottom">
                                    <div class="dropdown-header d-flex align-items-center py-3">
                                        <h6 class="mb-0 me-auto">Notification</h6>
                                        <span class="badge rounded-pill bg-label-primary">8 New</span>
                                    </div>
                                </li>
                                <li class="dropdown-notifications-list scrollable-container">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex gap-2">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar me-1">
                                                        <img src="../public/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                                                    <h6 class="mb-1 text-truncate">Congratulation Lettie 🎉</h6>
                                                    <small class="text-truncate text-body">Won the monthly best seller gold badge</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <small class="text-muted">1h ago</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex gap-2">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar me-1">
                                                        <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                                                    <h6 class="mb-1 text-truncate">Charles Franklin</h6>
                                                    <small class="text-truncate text-body">Accepted your connection</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <small class="text-muted">12hr ago</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                            <div class="d-flex gap-2">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar me-1">
                                                        <img src="../public/assets/img/avatars/2.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                                                    <h6 class="mb-1 text-truncate">New Message ✉️</h6>
                                                    <small class="text-truncate text-body">You have new message from Natalie</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <small class="text-muted">1h ago</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex gap-2">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar me-1">
                                <span class="avatar-initial rounded-circle bg-label-success"
                                ><i class="mdi mdi-cart-outline"></i
                                    ></span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                                                    <h6 class="mb-1 text-truncate">Whoo! You have new order 🛒</h6>
                                                    <small class="text-truncate text-body">ACME Inc. made new order $1,154</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <small class="text-muted">1 day ago</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                            <div class="d-flex gap-2">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar me-1">
                                                        <img src="../public/assets/img/avatars/9.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                                                    <h6 class="mb-1 text-truncate">Application has been approved 🚀</h6>
                                                    <small class="text-truncate text-body"
                                                    >Your ABC project application has been approved.</small
                                                    >
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <small class="text-muted">2 days ago</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                            <div class="d-flex gap-2">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar me-1">
                                <span class="avatar-initial rounded-circle bg-label-success"
                                ><i class="mdi mdi-chart-pie-outline"></i
                                    ></span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                                                    <h6 class="mb-1 text-truncate">Monthly report is generated</h6>
                                                    <small class="text-truncate text-body">July monthly financial report is generated </small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <small class="text-muted">3 days ago</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                            <div class="d-flex gap-2">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar me-1">
                                                        <img src="../public/assets/img/avatars/5.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                                                    <h6 class="mb-1 text-truncate">Send connection request</h6>
                                                    <small class="text-truncate text-body">Peter sent you connection request</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <small class="text-muted">4 days ago</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                            <div class="d-flex gap-2">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar me-1">
                                                        <img src="../public/assets/img/avatars/6.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                                                    <h6 class="mb-1 text-truncate">New message from Jane</h6>
                                                    <small class="text-truncate text-body">Your have new message from Jane</small>
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <small class="text-muted">5 days ago</small>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                            <div class="d-flex gap-2">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar me-1">
                                <span class="avatar-initial rounded-circle bg-label-warning"
                                ><i class="mdi mdi-alert-circle-outline"></i
                                    ></span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 overflow-hidden w-px-200">
                                                    <h6 class="mb-1">CPU is running high</h6>
                                                    <small class="text-truncate text-body"
                                                    >CPU Utilization Percent is currently at 88.63%,</small
                                                    >
                                                </div>
                                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                                    <small class="text-muted">5 days ago</small>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown-menu-footer border-top p-2">
                                    <a href="javascript:void(0);" class="btn btn-primary d-flex justify-content-center">
                                        View all notifications
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ Notification -->

                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="../public/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="pages-account-settings-account.html">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online">
                                                    <img src="../public/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-medium d-block">John Doe</span>
                                                <small class="text-muted">Admin</small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-profile-user.html">
                                        <i class="mdi mdi-account-outline me-2"></i>
                                        <span class="align-middle">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-account-settings-account.html">
                                        <i class="mdi mdi-cog-outline me-2"></i>
                                        <span class="align-middle">Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-account-settings-billing.html">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 mdi mdi-credit-card-outline me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-faq.html">
                                        <i class="mdi mdi-help-circle-outline me-2"></i>
                                        <span class="align-middle">FAQ</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="pages-pricing.html">
                                        <i class="mdi mdi-currency-usd me-2"></i>
                                        <span class="align-middle">Pricing</span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="auth-login-cover.html" target="_blank">
                                        <i class="mdi mdi-logout me-2"></i>
                                        <span class="align-middle">Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>

                <!-- Search Small Screens -->
                <div class="navbar-search-wrapper search-input-wrapper d-none">
                    <input
                            type="text"
                            class="form-control search-input container-xxl border-0"
                            placeholder="Search..."
                            aria-label="Search..." />
                    <i class="mdi mdi-close search-toggler cursor-pointer"></i>
                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Custom Options</h4>

                    <div class="row gy-4">
                        <!-- Basic Custom Radios -->
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Basic Radio</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-basic">
                                                <label class="form-check-label custom-option-content" for="customRadioTemp1">
                                                    <input
                                                            name="customRadioTemp-1"
                                                            class="form-check-input"
                                                            type="radio"
                                                            value=""
                                                            id="customRadioTemp1"
                                                            checked />
                                                    <span class="custom-option-header">
                                <span class="h6 mb-0">Basic</span>
                                <span>Free</span>
                              </span>
                                                    <span class="custom-option-body">
                                <small>Get 1 project with 1 teams members.</small>
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-basic">
                                                <label class="form-check-label custom-option-content" for="customRadioTemp2">
                                                    <input
                                                            name="customRadioTemp-1"
                                                            class="form-check-input"
                                                            type="radio"
                                                            value=""
                                                            id="customRadioTemp2" />
                                                    <span class="custom-option-header">
                                <span class="h6 mb-0">Premium</span>
                                <span>$ 5.00</span>
                              </span>
                                                    <span class="custom-option-body">
                                <small>Get 5 projects with 5 team members.</small>
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Basic Custom Radios -->

                        <!-- Basic Custom Checkboxes -->
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Basic Checkboxes</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-basic">
                                                <label class="form-check-label custom-option-content" for="customCheckTemp3">
                                                    <input class="form-check-input" type="checkbox" value="" id="customCheckTemp3" checked />
                                                    <span class="custom-option-header">
                                <span class="h6 mb-0">Discount</span>
                                <span>20%</span>
                              </span>
                                                    <span class="custom-option-body">
                                <small class="option-text">Get 20% off on your next purchases!</small>
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-basic">
                                                <label class="form-check-label custom-option-content" for="customCheckTemp4">
                                                    <input class="form-check-input" type="checkbox" value="" id="customCheckTemp4" />
                                                    <span class="custom-option-header">
                                <span class="h6 mb-0">Updates</span>
                                <span>Free</span>
                              </span>
                                                    <span class="custom-option-body">
                                <small>Get Updates regarding related products.</small>
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Basic Custom Checkboxes -->

                        <!-- Basic Custom Label Radios -->
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Basic Label Radio</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-label custom-option-basic">
                                                <label class="form-check-label custom-option-content" for="customRadioTemp5">
                                                    <input
                                                            name="customRadioTemp"
                                                            class="form-check-input"
                                                            type="radio"
                                                            value=""
                                                            id="customRadioTemp5"
                                                            checked />
                                                    <span class="custom-option-header">
                                <span class="h6 mb-0">Basic</span>
                                <span>Free</span>
                              </span>
                                                    <span class="custom-option-body">
                                <small>Get 1 project with 1 teams members.</small>
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-label custom-option-basic">
                                                <label class="form-check-label custom-option-content" for="customRadioTemp6">
                                                    <input
                                                            name="customRadioTemp"
                                                            class="form-check-input"
                                                            type="radio"
                                                            value=""
                                                            id="customRadioTemp6" />
                                                    <span class="custom-option-header">
                                <span class="h6 mb-0">Premium</span>
                                <span>$ 5.00</span>
                              </span>
                                                    <span class="custom-option-body">
                                <small>Get 5 projects with 5 team members.</small>
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Basic Custom Label Radios -->

                        <!-- Basic Custom Label Checkboxes -->
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Basic Label Checkboxes</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-label custom-option-basic">
                                                <label class="form-check-label custom-option-content" for="customCheckTemp5">
                                                    <input class="form-check-input" type="checkbox" value="" id="customCheckTemp5" checked />
                                                    <span class="custom-option-header">
                                <span class="h6 mb-0">Discount</span>
                                <span>20%</span>
                              </span>
                                                    <span class="custom-option-body">
                                <small class="option-text">Get 20% off on your next purchases!</small>
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-label custom-option-basic">
                                                <label class="form-check-label custom-option-content" for="customCheckTemp6">
                                                    <input class="form-check-input" type="checkbox" value="" id="customCheckTemp6" />
                                                    <span class="custom-option-header">
                                <span class="h6 mb-0">Updates</span>
                                <span>Free</span>
                              </span>
                                                    <span class="custom-option-body">
                                <small>Get Updates regarding related products.</small>
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Basic Custom Label Checkboxes -->

                        <!-- Custom Icon Radios -->
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Custom Option Radios With Icons</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customRadioIcon1">
                              <span class="custom-option-body">
                                <i class="mdi mdi-rocket-launch-outline"></i>
                                <span class="custom-option-title">Starter</span>
                                <small> Cake sugar plum fruitcake I love sweet roll jelly-o.</small>
                              </span>
                                                    <input
                                                            name="customRadioIcon-01"
                                                            class="form-check-input"
                                                            type="radio"
                                                            value=""
                                                            id="customRadioIcon1"
                                                            checked />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customRadioIcon2">
                              <span class="custom-option-body">
                                <i class="mdi mdi-account-outline"></i>
                                <span class="custom-option-title"> Personal </span>
                                <small> Cake sugar plum fruitcake I love sweet roll jelly-o. </small>
                              </span>
                                                    <input
                                                            name="customRadioIcon-01"
                                                            class="form-check-input"
                                                            type="radio"
                                                            value=""
                                                            id="customRadioIcon2" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customRadioIcon3">
                              <span class="custom-option-body">
                                <i class="mdi mdi-crown-outline"></i>
                                <span class="custom-option-title"> Enterprise </span>
                                <small>Cake sugar plum fruitcake I love sweet roll jelly-o.</small>
                              </span>
                                                    <input
                                                            name="customRadioIcon-01"
                                                            class="form-check-input"
                                                            type="radio"
                                                            value=""
                                                            id="customRadioIcon3" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Custom Icon Radios -->

                        <!-- Custom Icon Checkbox -->
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Custom Option Checkboxes With Icons</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customCheckboxIcon1">
                              <span class="custom-option-body">
                                <i class="mdi mdi-server"></i>
                                <span class="custom-option-title"> Backup </span>
                                <small> Cake sugar plum fruitcake I love sweet roll jelly-o. </small>
                              </span>
                                                    <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            value=""
                                                            id="customCheckboxIcon1"
                                                            checked />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customCheckboxIcon2">
                              <span class="custom-option-body">
                                <i class="mdi mdi-shield-outline"></i>
                                <span class="custom-option-title"> Encrypt </span>
                                <small> Cake sugar plum fruitcake I love sweet roll jelly-o. </small>
                              </span>
                                                    <input class="form-check-input" type="checkbox" value="" id="customCheckboxIcon2" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customCheckboxIcon3">
                              <span class="custom-option-body">
                                <i class="mdi mdi-lock-outline"></i>
                                <span class="custom-option-title"> Site Lock </span>
                                <small> Cake sugar plum fruitcake I love sweet roll jelly-o. </small>
                              </span>
                                                    <input class="form-check-input" type="checkbox" value="" id="customCheckboxIcon3" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Custom Icon Checkbox -->

                        <!-- Custom Svg Icon Radios -->
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Custom Option Radios With SVG Icons</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customRadioSvg1">
                              <span class="custom-option-body">
                                <img
                                        src="../public/assets/img/icons/unicons/paypal.png"
                                        class="w-px-40 mb-2"
                                        alt="paypal" />
                                <span class="custom-option-title"> Design </span>
                                <small>Cake sugar plum fruitcake I love sweet roll jelly-o.</small>
                              </span>
                                                    <input
                                                            name="customRadioSvg"
                                                            class="form-check-input"
                                                            type="radio"
                                                            value=""
                                                            id="customRadioSvg1"
                                                            checked />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customRadioSvg2">
                              <span class="custom-option-body">
                                <img
                                        src="../public/assets/img/icons/unicons/wallet.png"
                                        class="w-px-40 mb-2"
                                        alt="wallet" />
                                <span class="custom-option-title"> Development </span>
                                <small> Cake sugar plum fruitcake I love sweet roll jelly-o. </small>
                              </span>
                                                    <input
                                                            name="customRadioSvg"
                                                            class="form-check-input"
                                                            type="radio"
                                                            value=""
                                                            id="customRadioSvg2" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customRadioSvg3">
                              <span class="custom-option-body">
                                <img
                                        src="../public/assets/img/icons/unicons/cc-success.png"
                                        class="w-px-40 mb-2"
                                        alt="cc-success" />
                                <span class="custom-option-title"> Native App </span>
                                <small>Cake sugar plum fruitcake I love sweet roll jelly-o.</small>
                              </span>
                                                    <input
                                                            name="customRadioSvg"
                                                            class="form-check-input"
                                                            type="radio"
                                                            value=""
                                                            id="customRadioSvg3" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Custom Svg Icon Radios -->

                        <!-- Custom SVG Icon Checkbox -->
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Custom Option Checkboxes With SVG Icons</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customCheckboxSvg1">
                              <span class="custom-option-body">
                                <img src="../public/assets/img/icons/unicons/chart.png" class="w-px-40 mb-2" alt="chart" />
                                <span class="custom-option-title"> Design </span>
                                <small>Cake sugar plum fruitcake I love sweet roll jelly-o.</small>
                              </span>
                                                    <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            value=""
                                                            id="customCheckboxSvg1"
                                                            checked />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customCheckboxSvg2">
                              <span class="custom-option-body">
                                <img
                                        src="../public/assets/img/icons/unicons/cc-warning.png"
                                        class="w-px-40 mb-2"
                                        alt="cc-warning" />
                                <span class="custom-option-title"> Development </span>
                                <small>Cake sugar plum fruitcake I love sweet roll jelly-o.</small>
                              </span>
                                                    <input class="form-check-input" type="checkbox" value="" id="customCheckboxSvg2" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-icon">
                                                <label class="form-check-label custom-option-content" for="customCheckboxSvg3">
                              <span class="custom-option-body">
                                <img
                                        src="../public/assets/img/icons/unicons/paypal.png"
                                        class="w-px-40 mb-2"
                                        alt="paypal" />
                                <span class="custom-option-title"> Native App </span>
                                <small> Cake sugar plum fruitcake I love sweet roll jelly-o. </small>
                              </span>
                                                    <input class="form-check-input" type="checkbox" value="" id="customCheckboxSvg3" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Custom SVG Icon Checkbox -->

                        <!-- Custom Option Radio Image -->
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Custom Options Radio With Images</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-image custom-option-image-radio">
                                                <label class="form-check-label custom-option-content" for="customRadioImg1">
                              <span class="custom-option-body">
                                <img src="../public/assets/img/backgrounds/3.jpg" alt="radioImg" />
                              </span>
                                                </label>
                                                <input
                                                        name="customRadioImage"
                                                        class="form-check-input"
                                                        type="radio"
                                                        value="customRadioImg1"
                                                        id="customRadioImg1"
                                                        checked />
                                            </div>
                                        </div>
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-image custom-option-image-radio">
                                                <label class="form-check-label custom-option-content" for="customRadioImg2">
                              <span class="custom-option-body">
                                <img src="../public/assets/img/backgrounds/8.jpg" alt="radioImg" />
                              </span>
                                                </label>
                                                <input
                                                        name="customRadioImage"
                                                        class="form-check-input"
                                                        type="radio"
                                                        value="customRadioImg2"
                                                        id="customRadioImg2" />
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-image custom-option-image-radio">
                                                <label class="form-check-label custom-option-content" for="customRadioImg3">
                              <span class="custom-option-body">
                                <img src="../public/assets/img/backgrounds/15.jpg" alt="radioImg" />
                              </span>
                                                </label>
                                                <input
                                                        name="customRadioImage"
                                                        class="form-check-input"
                                                        type="radio"
                                                        value="customRadioImg3"
                                                        id="customRadioImg3" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Custom Option Radio Image -->

                        <!-- Custom Option Checkbox Image -->
                        <div class="col-xl-6">
                            <div class="card">
                                <h5 class="card-header">Custom Options Checkbox With Images</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-image custom-option-image-check">
                                                <input class="form-check-input" type="checkbox" value="" id="customCheckboxImg1" checked />
                                                <label class="form-check-label custom-option-content" for="customCheckboxImg1">
                              <span class="custom-option-body">
                                <img src="../public/assets/img/backgrounds/3.jpg" alt="cbImg" />
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md mb-md-0 mb-2">
                                            <div class="form-check custom-option custom-option-image custom-option-image-check">
                                                <input class="form-check-input" type="checkbox" value="" id="customCheckboxImg2" />
                                                <label class="form-check-label custom-option-content" for="customCheckboxImg2">
                              <span class="custom-option-body">
                                <img src="../public/assets/img/backgrounds/8.jpg" alt="cbImg" />
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-check custom-option custom-option-image custom-option-image-check">
                                                <input class="form-check-input" type="checkbox" value="" id="customCheckboxImg3" />
                                                <label class="form-check-label custom-option-content" for="customCheckboxImg3">
                              <span class="custom-option-body">
                                <img src="../public/assets/img/backgrounds/15.jpg" alt="cbImg" />
                              </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Custom Option Checkbox Image -->
                    </div>

                    <script>
                        // Check selected custom option
                        window.Helpers.initCustomOptionCheck();
                    </script>
                </div>
                <!-- / Content -->

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl">
                        <div
                                class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with <span class="text-danger"><i class="tf-icons mdi mdi-heart"></i></span> by
                                <a href="https://pixinvent.com" target="_blank" class="footer-link fw-medium">Pixinvent</a>
                            </div>
                            <div class="d-none d-lg-inline-block">
                                <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank"
                                >License</a
                                >
                                <a href="https://1.envato.market/pixinvent_portfolio" target="_blank" class="footer-link me-4"
                                >More Themes</a
                                >

                                <a
                                        href="https://demos.pixinvent.com/materialize-html-admin-template/documentation/"
                                        target="_blank"
                                        class="footer-link me-4"
                                >Documentation</a
                                >

                                <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link d-none d-sm-inline-block"
                                >Support</a
                                >
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
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
<script src="../public/assets/vendor/libs/jquery/jquery.js"></script>
<script src="../public/assets/vendor/libs/popper/popper.js"></script>
<script src="../public/assets/vendor/js/bootstrap.js"></script>
<script src="../public/assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="../public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../public/assets/vendor/libs/hammer/hammer.js"></script>
<script src="../public/assets/vendor/libs/i18n/i18n.js"></script>
<script src="../public/assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../public/assets/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="../public/assets/js/main.js"></script>

<!-- Page JS -->
</body>
</html>
