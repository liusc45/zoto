<?php
$user = auth()->getUser();

?>
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
                    <span class="d-none d-md-inline-block text-muted">Buscar... Ctrl + K </span>
                </a>
            </div>
        </div>
        <!-- /Search -->
            <!-- Store selector -->
        <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item mb-0">
                <div class="dropdown bootstrap-select w-100">
                    <select class="selectpicker"
                            id="storeSelector"
                            onchange="setUserStore()"
                            data-style="btn-default"
                            data-live-search="false">
                        <?php
                        if(!empty(session("stores"))):
                            $stores = session("stores");
                            foreach($stores as $store) : ?>
                                <option <?=@session("store")->id===$store->id?"selected": ''?>  value="<?=$store->id?>"><?=$store->name?></option>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
        </div>

            <!-- / Store selector -->
        <ul class="navbar-nav flex-row align-items-center">
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="pages-account-settings-account.html">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-medium d-block"><?=$user->name . " " . $user->last_name ?></span>
                                    <small class="text-muted"><?=$user->username?></small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/perfil">
                            <i class="mdi mdi-account-outline me-2"></i>
                            <span class="align-middle">Mi perfil</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/mi-corte" target="_blank">
                            <i class="mdi mdi-cash-register me-2"></i>
                            <span class="align-middle">Mi corte</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="pages-account-settings-account.html">
                            <i class="mdi mdi-cog-outline me-2"></i>
                            <span class="align-middle">Ajustes</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/logout">
                            <i class="mdi mdi-logout me-2"></i>
                            <span class="align-middle">Cerrar sesión</span>
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
            placeholder="Buscar...Ctrl + K "
            aria-label="Buscar...Ctrl + K " />
        <i class="mdi mdi-close search-toggler cursor-pointer"></i>
    </div>
</nav>
