<!DOCTYPE html>
<?php
$br = "<br>";
?>
<html lang="es" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <title></title>
    <style>
        #tabla{
            margin-right: 1mm;
            margin-left: -1mm;
        }
        td{
            font-size: 10px;
            /*border: .5px blue;*/
        }
        th{
            width: 50mm;
    
            font-size: 10px;
            /*border: 1px black;*/
        }
     
        img{
            margin: auto;
            display: block;
            background: rgb(5, 5, 5);
        }
        .title{
            font-size: 15px;
        }
        .left{
            text-align: left;
        }
        .center{
            text-align: center;
        }
        .right{
            text-align: right;
        }
        
        .font-100{
            font-weight: 100;
        }
        span{
            font-size: 10px;
        }
    </style>
</head>
<body >

<table  id="tabla">
    <colgroup>
        <col><col>
    </colgroup>
    
    <tr>
        <td  class="center"><img src="assets/img/branding/bnw.png"  width='64'></td>
    </tr>
    <tr>        <th > </th>      </tr>
    <tr >
        <th  class="title center " ><?=env("app.title")?></th>
    </tr>
    <tr>        <th > </th>      </tr>
    <tr >
        <th class=" left mt-4" ><?= $company->owner?></th>
    </tr>
    <tr>        <th > </th>      </tr>
    <tr>
        <th class="left">
            RFC:<?=$company->rfc?>
        </th>
    </tr><tr>
        <th class="left">
            Tienda:<?=$company->store->name?>
        </th>
    </tr>
    <tr>        <th > </th>      </tr>
    <tr>
        <th class="left">Dirección: <?=$company->store->address.$br." Teléfono: ".$company->store->phone?></th>
    </tr>
    <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr>
    <tr>
        <th class="left"  >Ticket:
            <span class="left font-100" style="font-size: 10px;"><?=$br.@$sales->uuid ?> </span>
        </th>

    </tr>
    <tr>
        <th class="left">Compra a crédito <span class="right font-100"> </span></th>
    </tr>
    
    <?php if($sales->payment_type === 'cash'):?>
        <tr><th>Recibido: <?=@$sales->payment->cash?></th></tr>
        <tr><th>Cambio: <?=@$sales->payment->cashback?></th></tr>
    <?php endif;?>
    <?php if($sales->payment_type === 'card'):?>
        <tr>
            <th class="left">No. de autorización: <span class="right font-100"><?=$sales->authorization ?> </span></th>
        </tr>
    <?php endif;?>
    <tr>
        <th class="left">Fecha y hora de compra:</th>
    </tr>
    <tr>
        <td class="left font-100">
            <?= str_replace(" ", " de ",$sales->created_at->toLocalizedString('dd MMMM yyyy')) ?>
            <?=$sales->created_at->toTimeString()  ?>
        </td>
    </tr>
    <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr>
    <tr>
        <th class="left text-courses" >Artículos.</th>
    </tr>

    <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr>
    
    <?php
    $subtotal = 0;
    foreach($items as $index => $item):?>
        <tr>
            <th   class="left text-courses font-100"  >
                <?=$item->qty .$br.$item->name  ?>
            </th>
        </tr>
        <tr>
            <th  class="right">
                <?= number_to_currency($item->final_price,"MXN",'es_MX',2) ?>
            </th>
        </tr>
        <tr> <th ></th></tr>

    <?php
    $subtotal+=$item->final_price;
    endforeach;?>
    <tr>
        <th class="left text-courses" >Pagos.</th>
    </tr>
    <?php
    $fee = 0;
    foreach($payments as $index => $payment):?>
    <tr>
        <td   >
            <?=$index .".". $payment->created_at  ?>
        </td>
    </tr>
    <tr>
        <td class="right"  >
            <?= number_to_currency($payment->amount,"MXN",'es_MX',2) ?>
        </td>
    </tr>

    <?php
    $fee+=$payment->amount;
    endforeach;  ?>
    <tr>        <th > </th>      </tr>
    <tr>
        <th class="left">Total abonado: </th>
    </tr>
    <tr>
        <th class="right">
            <span >
                <?= number_to_currency($fee,"MXN",'es_MX',2) ?>
            </span>
        </th>
    </tr>

    <tr>
        <th class="left">Resta : </th>
    </tr>
    <tr>
        <th class="right"><span > <?= number_to_currency($sales->amount-$fee,"MXN",'es_MX',2) ?></span></th>
        
    </tr>
  
    <tr>
        <th class="left">Lo atendió:</th>
    </tr>
    <tr>
        <td><?= $user->name. " ". $user->last_name?></td>
    </tr>
    <tr> <th > </th> </tr>

    <tr>        <th > </th>      </tr> <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr> <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr> <tr>        <th > </th>      </tr>
    <tr>
        <th class="left">Cliente:</th>
    </tr>

    <tr>
        <td class="left font-100"><?=ucwords($sales->customer_name) ?></td>
    </tr>
   <?php if($sales->customer!== 1):?>
       <tr>
        <td class="left font-100"><?=ucwords($sales->customer_address) ?></td>
    </tr>
    <?php endif;?>
   
    <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr>
    <tr>
        <th class="center">Muchas gracias por su compra.<br>Disfrute su compra.</th>
    </tr>
    <tr>
        <th class="center">Si tiene alguna queja, favor de escanear el QR </th>
    </tr>
    <tr>
    
    </tr>
</table>
<qrcode value="Value to Coder" ec="H" style="width: 50mm; background-color: white; color: black;"></qrcode>
<link>
</body>
</html>
