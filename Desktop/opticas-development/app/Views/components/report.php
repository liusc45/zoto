<?= $this->extend('app') ?>
<?php
helper('number');
?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
    <h4 class="py-3 col-lg-9">
        <span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?>
    </h4>
    <div class="form-floating col-lg-3 form-floating-outline">
        <input type="text" id="bs-rangepicker-range" class="form-control" />
        <label for="bs-rangepicker-range">Fechas</label>
    </div>
</div>


<div class="container-xxl  container-p-y">

    <div class="row gy-4 mb-4">
        <!-- Sales Overview-->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="mb-2">General de ventas</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php if(is_array($date)) : ?>
                            <small class="me-2 text-body">Presentando del <?=$date['start']?> al <?=$date['end']?></small>
                        <?php else: ?>
                            <small class="me-2 text-body">Hoy es <?=str_replace(" "," de ",$date->toLocalizedString("d MMMM YYYY"))?></small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-between flex-wrap gap-3">
                    <div class="d-flex gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="mdi mdi-point-of-sale mdi-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <h4 class="mb-0"><?=number_to_currency($reports['sales_today']["totalEarningToday"]->amount, 'MXN','es_MX')?></h4>
                            <?php if(is_array($date)) : ?>
                                <small class="me-2 text-body">Ingresos del periodo</small>
                            <?php else: ?>
                                <small>Ingresos del día</small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="mdi mdi-calendar-range mdi-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <h4 class="mb-0">
                                <?= (isset($reports['sales_week']))?
                                    number_to_currency( $reports['sales_week']->amount, 'MXN','es_MX'):0
                                ?>
                            </h4>
                            <?php if(is_array($date)) : ?>
                                <small class="me-2 text-body">Ventas del periodo</small>
                            <?php else: ?>
                                <small>Ventas de últimos 7 días</small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-danger rounded">
                                <i class="mdi mdi-cash-minus mdi-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <h4 class="mb-0"><?=number_to_currency($reports['expenses_today']->amount, 'MXN','es_MX')?></h4>
                            <?php if(is_array($date)) : ?>
                                <small class="me-2 text-body">Gastos del periodo</small>
                            <?php else: ?>
                                <small>Gastos de últimos 7 días</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Sales Overview-->

        <!-- Ventas por categorias -->
        <div class="col-lg-6">
            <div class="swiper-container swiper-container-horizontal text-bg-primary">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-white mb-2">Ventas por categoría</h5>
                                <div class="d-flex align-items-center gap-2">
                                    <small>Ventas globales, se incluye todo el histórico de ventas</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 order-2 order-md-1">
                                    <div class="row mt-0 mt-md-3">
                                        <div class="col-4">
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-flex mb-3 align-items-center">
                                                    <p class="mb-0 me-2 weekly-sales-text-bg-primary"><?=@$reports["TopCategories"][0]->sales?></p>
                                                    <p class="mb-0"><?=@$reports["TopCategories"][0]->category?></p>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <p class="mb-0 me-2 weekly-sales-text-bg-primary"><?=@$reports["TopCategories"][1]->sales?></p>
                                                    <p class="mb-0"><?=@$reports["TopCategories"][1]->category?></p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-4">
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-flex mb-3 align-items-center">
                                                    <p class="mb-0 me-2 weekly-sales-text-bg-primary"><?=@$reports["TopCategories"][2]->sales?></p>
                                                    <p class="mb-0"><?=@$reports["TopCategories"][2]->category?></p>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <p class="mb-0 me-2 weekly-sales-text-bg-primary"><?=@$reports["TopCategories"][3]->sales?></p>
                                                    <p class="mb-0"><?=@$reports["TopCategories"][3]->category?></p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-4">
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-flex mb-3 align-items-center">
                                                    <p class="mb-0 me-2 weekly-sales-text-bg-primary"><?=@$reports["TopCategories"][4]->sales?></p>
                                                    <p class="mb-0"><?=@$reports["TopCategories"][4]->category?></p>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <p class="mb-0 me-2 weekly-sales-text-bg-primary"><?=@$reports["TopCategories"][5]->sales?></p>
                                                    <p class="mb-0"><?=@$reports["TopCategories"][5]->category?></p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <!-- /ventas por categorias-->
    </div>

    <div class="row gy-4 mb-4">
        <div class="col col-12">
            <div class="col-12">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Top de vendedores</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless border-top">
                            <thead class="border-bottom">
                            <tr>
                                <th>Vendedor</th>
                                <th>Artículos</th>
                                <th>Ventas</th>
                                <th>Compra</th>
                                <th>Utilidad</th>
                            </tr>
                            </thead>
                            <tbody id="topSeller">
                            <?php foreach(@$reports['utility'] as $key => $seller):?>
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-truncate"><?=$seller->user_name?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0"><?=$seller->sold_items?></h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">$<?=$seller->sold?></h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">$<?=$seller->final_cost?></h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">$<?=$seller->difference?></h6>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row gy-4 mb-4">
        <div class="col col-12">
            <div class="col-12">
                <div class="card overflow-hidden" style="height: 400px">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Relación de abonos</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless border-top">
                            <thead class="border-bottom">
                            <tr>
                                <th>Fecha</th>
                                <th>Venta</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Pago</th>
                            </tr>
                            </thead>
                            <tbody id="topSeller">
                            <?php foreach($reports['deposits'] as $key => $deposit):?>
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1 text-truncate"><?= explode(" ", $deposit->created_at)[0];?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0"><?=$deposit->venta?></h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0"><?=$deposit->name?></h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">$<?=$deposit->amount?></h6>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0"><?=$deposit->tipo_pago?></h6>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4 mb-4">
        <!-- Monthly sales-->
        <div class="card mb-4">
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table table-bordered">
                    <thead>
                    <tr>
                        <th>Artículo</th>
                        <th>Descripción</th>
                        <th>Vendidos</th>
                        <th>Costo unitario</th>
                        <th>Total de compra</th>
                        <th>Total de ventas</th>
                        <th>Descuentos</th>
                        <th>Total de ganancia</th>
                        <th>Tipo de pago</th>
                        <th>Vendedor</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($reports['monthly'] as $key => $sale):?>
                        <tr>
                            <td><?=$sale->item?></td>
                            <td><?=$sale->item_name?></td>
                            <td><?=$sale->quantity?></td>
                            <td><?=$sale->unit_cost?></td>
                            <td><?=$sale->sales_cost?></td>
                            <td><?=$sale->sales?></td>
                            <td><?=floatval($sale->discount)?></td>
                            <td><?=$sale->ganancia?></td>
                            <td><?=ucfirst($sale->tipo_pago)?></td>
                            <td><?=$sale->user_name?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Totales</th>
                        <th></th>
                        <th></th>
                        <th id="cost"></th>
                        <th id="purchases"></th>
                        <th id="sales"></th>
                        <th id="discount"></th>
                        <th id="profit"></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /Monthly sales-->
    </div>

    <div class="row gy-4 mb-4">
        <div class="col col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
                    <h5 class="card-title mb-0">Ventas por sucursales</h5>
                </div>
                <div class="card-body">
                    <div id="barChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/moment/moment.js"></script>
<script src="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="https://cdn.datatables.net/plug-ins/2.0.8/api/sum().js"></script>
<script>
    console.log('Reports js loaded');
    let sales = <?=json_encode($reports['byStoreWeek'])?>;
    let dates = sales.dates;
    let salesData = sales.series;
    var dt_basic_table = $('.datatables-basic');

    $(function(){
        let labelColor, borderColor, legendColor;

        if (isDarkStyle) {
            labelColor = config.colors_dark.textMuted;
            legendColor = config.colors_dark.bodyColor;
            borderColor = config.colors_dark.borderColor;
        } else {
            labelColor = config.colors.textMuted;
            legendColor = config.colors.bodyColor;
            borderColor = config.colors.borderColor;
        }

        // Color constant
        const chartColors = {
            column: {
                series1: '#255C99',
                series2: '#EF476F',
                series3: '#FFD166',
                series4: '#06D6A0',
                series5: '#420039',
                bg: '#EBEDEF'
            }
        };

        // Bar Chart
        // --------------------------------------------------------------------
        const barChartEl = document.querySelector('#barChart'),
            barChartConfig = {
                chart: {
                    height: 400,
                    fontFamily: 'Inter',
                    type: 'bar',
                    stacked: true,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '15%',
                        colors: {
                            backgroundBarColors: [
                                chartColors.column.bg,
                                chartColors.column.bg,
                                chartColors.column.bg,
                                chartColors.column.bg,
                                chartColors.column.bg
                            ],
                            backgroundBarRadius: 10
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'start',
                    labels: {
                        colors: legendColor,
                        useSeriesColors: false
                    }
                },
                colors: [chartColors.column.series1, chartColors.column.series2, chartColors.column.series3],
                stroke: {
                    show: true,
                    colors: ['transparent']
                },
                grid: {
                    borderColor: borderColor,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                series: salesData,
                xaxis: {
                    categories: dates,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '11px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '11px'
                        }
                    }
                },
                fill: {
                    opacity: 1
                }
            };
        if (typeof barChartEl !== undefined && barChartEl !== null) {
            const barChart = new ApexCharts(barChartEl, barChartConfig);
            barChart.render();
        }

        dt_basic = dt_basic_table.DataTable({
            order: [[1, 'asc']],
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 10,
            lengthMenu: [10, 25, 50, 75, 100],
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-label-primary dropdown-toggle me-2',
                    text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">Exportar</span>',
                    buttons: [
                        {
                            extend: 'csv',
                            text: '<i class="mdi mdi-file-document-outline me-1" ></i>CSV',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6,7,8]
                            },
                            footer: true
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [0,1,2,3,4,5,6,7,8]
                            },
                            footer: true
                        }
                    ]
                }
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['full_name'];
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            },
            language: {
                url: '//cdn.datatables.net/plug-ins/2.0.8/i18n/es-MX.json',
            },
            drawCallback: function () {
                var api = this.api();
                $( api.table().footer()).html();
                let cost = api.column(3).data().sum().toLocaleString("es-MX")
                let purchases = api.column(4).data().sum().toLocaleString("es-MX")
                let sales = api.column(5).data().sum().toLocaleString("es-MX")
                let discount = api.column(6).data().sum().toLocaleString("es-MX")
                let profit = api.column(7).data().sum().toLocaleString("es-MX")
                $('#cost').html(`$${cost} M.N.`);
                $('#purchases').html(`$${purchases} M.N.`);
                $('#sales').html(`$${sales} M.N.`);
                $('#discount').html(`$${discount} M.N.`);
                $('#profit').html(`$${profit} M.N.`);
            }
        });
        $('div.head-label').html('<h5 class="card-title mb-0">Relación de ventas por artículo</h5>');

    });

    let stores = <?=json_encode($reports["byStoreWeek"])?>

</script>

<?= $this->endSection() ?>
