<?php
$path = session("meta")["path"];
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/mostrador" class="app-brand-link">
              <span class="app-brand-logo demo">
                <img width="35" height="35" src="/assets/img/branding/logo.webp" alt="logo de <?=env('app.title')?>">
              </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2"><?=env('app.title')?></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z"
                    fill="currentColor"
                    fill-opacity="0.6" />
                <path
                    d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z"
                    fill="currentColor"
                    fill-opacity="0.38" />
            </svg>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Main -->
        <li class="menu-item">
            <a href="/mostrador" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                <div data-i18n="Inicio">Inicio</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/cumpleanos" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-whatsapp"></i>
                <div >Notificar</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="/inventario" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-store"></i>
                <div data-i18n="Inventario">Inventario</div>
            </a>
        </li>

        <?php if (auth()->user()->inGroup("admin")) :?>
            <li class="menu-item">
                <a href="/ingresos" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-cash-plus"></i>
                    <div data-i18n="Ingresos">Ingresos</div>
                </a>
            </li>
        <?php endif; ?>

            <li class="menu-item">
            <a href="/gastos" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-cash-minus"></i>
                <div data-i18n="Gastos">Gastos</div>
            </a>
        </li>

        <?php if (auth()->user()->inGroup("admin")) :?>
            <li class="menu-item">
                <a href="/reportes" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-chart-arc"></i>
                    <div data-i18n="Reportes">Reportes</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/ventas" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-cash-register"></i>
                    <div data-i18n="Ventas">Ventas</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/entregas" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-truck-outline"></i>
                    <div data-i18n="Entregas">Entregas</div>
                    <?php if (session("toDeliver") !== null ) :?>
                        <div class="badge bg-danger rounded-pill ms-auto"><?=session("toDeliver")?></div>
                    <?php endif; ?>
                </a>
            </li>
            <li class="menu-item">
                <a href="/ordenes" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-clipboard-list-outline"></i>
                    <div data-i18n="Órdenes">Órdenes</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/apartados" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-receipt-text-clock"></i>
                    <div data-i18n="Apartados">Apartados</div>
                </a>
            </li>
            <!-- Apps & Pages -->
            <li class="menu-header fw-medium mt-4">
                <span class="menu-header-text" data-i18n="Administración">Administración</span>
            </li>
            <li class="menu-item">
                <a  class="menu-link menu-toggle waves-effect">
                    <i class="menu-icon tf-icons mdi mdi-tag-plus"></i>
                    <div data-i18n="Artículos">Artículos</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/articulos" class="menu-link">
                            <div >Artículos</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/articulos/armazones" class="menu-link">
                            <div >Armazones</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/micas" class="menu-link">
                            <div >Micas</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/pupilentes" class="menu-link">
                            <div >Pupilentes</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="/precios" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-currency-usd"></i>
                    <div>Precios</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/promociones" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-sale"></i>
                    <div >Promociones</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/facturas" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-receipt-text"></i>
                    <div data-i18n="Facturas">Facturas</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/compras" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-receipt-text"></i>
                    <div data-i18n="Compras">Compras</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/garantias" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-autorenew"></i>
                    <div data-i18n="Garantías">Garantías</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/pacientes" class="menu-link">
                    <i class="menu-icon tf-icons mdi  mdi-card-account-details"></i>
                    <div data-i18n="Clientes">Pacientes</div>
                </a>
            </li>
            <li class="menu-item" >
                <a href="/empleados" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-account-group"></i>
                    <div >Empleados</div>
                </a>
            </li>
            <li class="menu-item" >
            <a href="/creditos" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-account-credit-card"></i>
                <div ">Créditos</div>
            </a>

            </li>
            <?php
            $activeOpen = '';
            ?>
            <li class="menu-item <?=$activeOpen?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
                    <i class="menu-icon tf-icons mdi mdi-account-tie"></i>
                    <div >Empresas</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/proveedores" class="menu-link">
                            <div >Proveedores</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/laboratorios" class="menu-link">
                            <div >Laboratorios</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/convenios" class="menu-link">
                            <div >Convenios</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="/tiendas" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-store"></i>
                    <div data-i18n="Tiendas">Tiendas</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="/traspasos" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-transfer"></i>
                    <div data-i18n="Traspasos">Traspasos</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
                    <i class="menu-icon tf-icons mdi mdi-shape-plus"></i>
                    <div>Catálogos</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="/lineas" class="menu-link">
                            <div>Lineas</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/marcas" class="menu-link">
                            <div>Marcas</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/colores" class="menu-link">
                            <div>Colores</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/materiales" class="menu-link">
                            <div>Materiales</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/rangos" class="menu-link">
                            <div data-i18n="Rangos">Rangos</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/categorias" class="menu-link">
                            <div data-i18n="Categorías">Categorías</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/tarjetas-pago" class="menu-link">
                            <div data-i18n="Categorías">Tarjetas pago</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="/ocupaciones" class="menu-link">
                            <div data-i18n="Ocupaciones">Ocupaciones</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <!-- Misc -->
        <li class="menu-header fw-medium mt-4">
            <span class="menu-header-text" data-i18n="Ayuda">Ayuda</span>
        </li>
        <li class="menu-item">
            <a href="https://api.whatsapp.com/send?phone=5212281159021&text=%F0%9F%94%A5%20Hola%2C%20necesito%20ayuda%20con%20el%20sistema%20de%20La%20Bendici%C3%B3n" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-lifebuoy"></i>
                <div data-i18n="Soporte">Soporte</div>
            </a>
        </li>
        <li class="menu-item">
            <a
                href="https://sonat.com/@oswaldo-sanchez/muebleria-la-bendicion/new-topic?lang=en"
                target="_blank"
                class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-file-document-multiple-outline"></i>
                <div data-i18n="Documentación">Documentación</div>
            </a>
        </li>
    </ul>
</aside>
