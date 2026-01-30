
<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

<div class="card">
    <h5 class="card-header">Inventarios <?=$history[0]->code ?>, <?=$history[0]->item_name ?>  </h5>
    <div class="table-responsive text-nowrap hoverable">
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Id</th>
                <th>stock</th>
                <th>Factura</th>
                <th>Entrada</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            <?php
            foreach($history as $key => $inventory):?>
            <tr>
                <td>
                    <?=$inventory->id?>
<!--                    <i class="mdi mdi-wallet-travel mdi-20px text-danger me-3"></i><span class="fw-medium">Tours Project</span>-->
                </td>
                <td><?=$inventory->stock?></td>
                <td>
                    <?=$inventory->bill?>
                </td>
                <td>
                    <?=$inventory->enter_at->toLocalizedString('MMMM d, yyyy');?>
                </td>
               
            </tr>
           <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>


