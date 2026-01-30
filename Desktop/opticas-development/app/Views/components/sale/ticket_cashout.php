<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"/>

    <style>
        #invoice-POS{
            padding:1mm;
            margin: 0 auto;
            background: #FFF;
            ::selection {background: #f31544; color: #FFF;}
            ::moz-selection {background: #f31544; color: #FFF;}
            h1{
                font-size: 1.5em;
                color: #222;
            }
            h2{font-size: .9em;}
            h3{
                font-size: 1.2em;
                font-weight: 300;
                line-height: 2em;
            }
            p{
                font-size: .7em;
                color: #666;
                line-height: 1.2em;
            }

            #top, #mid,#bot{ /* Targets all id with 'col-' */
                border-bottom: 1px solid #EEE;
            }

            #top{min-height: 100px;}
            #mid{min-height: 80px;}
            #bot{ min-height: 50px;}

            #top .logo{
            //float: left;
                height: 60px;
                width: 60px;
                background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
                background-size: 60px 60px;
            }
            .clientlogo{
                float: left;
                height: 60px;
                width: 60px;
                background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
                background-size: 60px 60px;
                border-radius: 50px;
            }
            .info{
                display: block;
            //float:left;
                margin-left: 0;
            }
            .title{
                float: right;
            }
            .title p{text-align: right;}
            table{
                width: 100%;
                border-collapse: collapse;
            }
            td{
            //padding: 5px 0 5px 15px;
            //border: 1px solid #EEE
            }
            .tabletitle{
            //padding: 5px;
                font-size: .5em;
                background: #EEE;
            }
            .service{border-bottom: 1px solid #EEE;}
            .item{width: 24mm;}
            .itemtext{font-size: .5em;}

            #legalcopy{
                margin-top: 5mm;
            }
        }
    </style>
</head>
<body>

<div id="invoice-POS">

    <div>
        <div class="center mb-4"><img src="assets/img/branding/bnw.png"  width='64'></div>
    </div>
    <div id="top">
        <div class="logo"></div>
        <div class="info">
            <h4>Corte del día:  <?=date("m-d-Y");?></h4>
        </div>
    </div>

    <div id="mid">
        <div class="info">
            <h5>Información de la sucursal:</h5>
            <p>
                Sucursal: <?=session()->store->name?></br>
                Dirección: <?=session()->store->address?></br>
                Teléfono: <?=session()->store->phone?></br>
                Generado por: <?=$user->name . " " . $user->last_name ?></br>
            </p>
        </div>
    </div><!--End Invoice Mid-->

    <div id="bot">
        <h5>Relación de ventas:</h5>
        <div id="table">
            <table>
                <tr class="tabletitle">
                    <td class="item"><h6>Cant</h6></td>
                    <td class="item"><h6>Item</h6></td>
                    <td class="Rate"><h6 class="text-end">Monto</h6></td>
                </tr>
                <?php
                    $totalSales = 0;
                ?>
				<?php foreach($sales as $key => $sale):?>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext"><?=$sale->qty?></p></td>
                        <td class="tableitem"><p class="itemtext"><?=substr($sale->item, 0, 25);?></p></td>
                        <td class="tableitem"><p class="itemtext text-end">$<?=$sale->amount?></p></td>
                    </tr>
                    <?php
                        $totalSales += $sale->amount
                    ?>
				<?php endforeach;?>

                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate text-end"><h4>Total </h4></td>
                    <td class="payment"><h4>$<?=$totalSales?></h4></td>
                </tr>

            </table>
        </div><!--End Table-->
    </div><!--End InvoiceBot-->


    <div id="bot">
        <h5>Relación de abonos:</h5>
        <div id="table">
            <table>
                <tr class="tabletitle">
                    <td class="item"><h6>Crédito</h6></td>
                    <td></td>
                    <td class="Rate"><h6 class="text-end">Monto</h6></td>
                </tr>
				<?php
				$totalPartials = 0;
				?>
				<?php foreach($partials as $key => $partial):?>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext"><?=$partial->id?></p></td>
                        <td></td>
                        <td class="tableitem"><p class="itemtext text-end">$<?=$partial->abono?></p></td>
                    </tr>
					<?php
					$totalPartials += $partial->abono
					?>
				<?php endforeach;?>

                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate text-end"><h4>Total </h4></td>
                    <td class="payment"><h4>$<?=$totalPartials?></h4></td>
                </tr>

            </table>
        </div><!--End Table-->
    </div><!--End InvoiceBot-->



    <div id="bot">
        <h5>Formas de pago:</h5>
        <div id="table">
            <table>
                <tr class="tabletitle">
                    <td class="item"><h6>Método</h6></td>
                    <td></td>
                    <td class="item text-end"><h6>Monto</h6></td>
                </tr>
				<?php
				$totalPayments = 0;
				?>
				<?php foreach($payments as $key => $payment):?>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext"><?=$payment->payment_type?></p></td>
                        <td></td>
                        <td class="tableitem"><p class="itemtext text-end">$<?=$payment->amount?></p></td>
                    </tr>
					<?php
					$totalPayments += $payment->amount
					?>
				<?php endforeach;?>
                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate text-end"><h4>Total </h4></td>
                    <td class="payment"><h4>$<?=$totalPayments?></h4></td>
                </tr>

            </table>
        </div><!--End Table-->
    </div><!--End InvoiceBot-->


</div><!--End Invoice-->

</body>
</html>
