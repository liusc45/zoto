<?php
$br = "<br>";
?>
<style>
    #tabla {
        width: 100%;
        margin: 0;
    }

    td, th {
        font-size: 10px;
        padding: 1mm 0;
    }

    .title {
        font-size: 14px;
        font-weight: bold;
    }

    .section {
        font-weight: bold;
        border-top: 1px dashed #000;
        padding-top: 2mm;
    }

    .left { text-align: left; }
    .center { text-align: center; }
    .right { text-align: right; }

    .muted {
        font-size: 9px;
        color: #555;
    }

    .bold { font-weight: bold; }

    img {
        display: block;
        margin: auto;
    }
</style>
<page>
    <table  id="tabla">
    <colgroup>
        <col><col>
    </colgroup>

        <tr>
            <td class="center">
                <img src="assets/img/branding/logo.webp" width="64">
            </td>
        </tr>

        <tr>
            <td class="center title"><?= env("app.title") ?></td>
        </tr>

        <tr>
            <td class="center muted">
                <?= $company->owner ?><br>
                RFC: <?= $company->rfc ?><br>
                Régimen Simplificado de Confianza
            </td>
        </tr>

        <tr>
            <td class="center muted">
                <?= $company->store->name ?><br>
                <?= $company->store->address ?><br>
                Tel: <?= $company->store->phone ?>
            </td>
        </tr>
        <tr><td class="section left">Datos de la venta</td></tr>

        <tr><td class="left">Ticket: <span class="muted"><?= $sales->uuid ?></span></td></tr>
        <tr><td class="left">Tipo de venta: <span class="muted"><?= $type ?></span></td></tr>
        <tr><td class="left">Forma de pago: <span class="muted"><?= $payment_types[$sales->payment_type] ?></span></td></tr>

        <?php if($sales->payment_type === 'cash'): ?>
            <tr><td class="left">Recibido: <?= number_to_currency($sales->payment->cash,"MXN",'es_MX',2) ?></td></tr>
            <tr><td class="left">Cambio: <?= number_to_currency($sales->payment->cashback,"MXN",'es_MX',2) ?></td></tr>
        <?php endif; ?>

        <?php if($sales->payment_type === 'card'): ?>
            <tr><td class="left">Autorización: <span class="muted"><?= $sales->authorization ?></span></td></tr>
        <?php endif; ?>

        <tr>
            <td class="left muted">
                <?= $sales->created_at->toLocalizedString('dd MMMM yyyy') ?>
                <?= $sales->created_at->toTimeString() ?>
            </td>
        </tr>

        <tr><td class="section left">Artículos</td></tr>

        <?php
        $subtotal = 0;
        foreach($items as $item):
            ?>

            <tr>
                <td class="left bold">
                    <?= $item->qty ?> × <?= $item->name ?>
                    <?php if($item->lens_side): ?>
                        <br><span class="muted">
                <?= $item->lens_side === 'right' ? 'Mica derecha' :
                        ($item->lens_side === 'left' ? 'Mica izquierda' : 'Par de micas') ?>
            </span>
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <td class="right">
                    <?= number_to_currency($item->unit_price * $item->qty,"MXN",'es_MX',2) ?>
                </td>
            </tr>

            <?php
            $subtotal += ($item->unit_price * $item->qty);
        endforeach;
        ?>

        <tr><td class="section left">Resumen</td></tr>

        <tr>
            <td class="left">Subtotal</td>
        </tr>
        <tr>
            <td class="right bold"><?= number_to_currency($subtotal,"MXN",'es_MX',2) ?></td>
        </tr>

        <?php if (!empty($sale_promotions)): ?>
            <tr><td class="left">Promociones</td></tr>
            <?php foreach ($sale_promotions as $sp): ?>
                <tr>
                    <td class="right muted">
                        -<?= number_to_currency($sp['discount_amount'],"MXN",'es_MX',2) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>

        <tr>
            <td class="left bold">Total</td>
        </tr>
        <tr>
            <td class="right bold"><?= number_to_currency($sales->amount,"MXN",'es_MX',2) ?></td>
        </tr>

        <tr>
            <td class="left muted"><?= $sales->amount_letter ?></td>
        </tr>

    <?php if($sales->type === 'aside' || $sales->type === 'credit'): ?>
        <?php
        $total_paid = 0;
        if(is_array($payments) && count($payments) > 0):
            foreach($payments as $payment):
                $total_paid += $payment->amount;
            endforeach;
        endif;
        $balance = $sales->amount - $total_paid;
        ?>

        <tr><td class="section left">Historial de pagos</td></tr>

        <?php if(is_array($payments) && count($payments) > 0): ?>
            <?php foreach($payments as $payment): ?>
                <tr>
                    <td class="left muted">
                        <?= $payment->created_at->toLocalizedString('dd MMM yyyy') ?> -
                        <?= $payment_types[$payment->payment_type] ?>
                    </td>
                </tr>
                <tr>
                    <td class="right">
                        <?= number_to_currency($payment->amount,"MXN",'es_MX',2) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td class="left muted center">Sin pagos registrados</td>
            </tr>
        <?php endif; ?>

        <tr><td class="section left"></td></tr>

        <tr>
            <td class="left">Total Pagado</td>
        </tr>
        <tr>
            <td class="right bold"><?= number_to_currency($total_paid,"MXN",'es_MX',2) ?></td>
        </tr>

        <tr>
            <td class="left bold">Saldo Pendiente</td>
        </tr>
        <tr>
            <td class="right bold <?= $balance > 0 ? 'text-danger' : 'text-success' ?>">
                <?= number_to_currency($balance,"MXN",'es_MX',2) ?>
            </td>
        </tr>
    <?php endif;?>

        <tr><td class="section left">Cliente</td></tr>

        <tr>
            <td class="left muted">
                <?= ucwords($sales->person_name ?? "Público en general") ?>
            </td>
        </tr>

        <tr><td class="section left">Atendió</td></tr>

        <tr>
            <td class="left muted">
                <?= $employee->username ?> — <?= $employee->name ?> <?= $employee->last_name ?>
            </td>
        </tr>
    <tr>        <th > </th>      </tr>
    <tr>        <th > </th>      </tr>
        <tr>
            <td class="center section">
                Gracias por su compra
            </td>
        </tr>

        <tr>
            <td class="center muted">
                Si tiene alguna aclaración, escanee el QR
            </td>
        </tr>

</table>
</page>
<qrcode
        value="https://api.whatsapp.com/send?phone=2721766656&text=Hola..."
        ec="H"
        style="width: 45mm;">
</qrcode>
