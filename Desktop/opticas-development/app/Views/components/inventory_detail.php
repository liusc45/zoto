<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

<div class="card" id="detail-card">
    <h5 class="card-header">Inventarios <?=$history[0]->code ?>, <?=$history[0]->item_name ?><br>
        <a href="<?='' ?>?export=xls" target="_blank">
            Descargar
            <span class=" menu-icon tf-icons mdi mdi-microsoft-excel mdi-36px"></span>
        </a>
    </h5>
    <div id="inventorySuccessAlert" class="alert d-none alert-solid-primary d-flex align-items-center" role="alert">
        <i class="mdi mdi-alert-circle-check-outline me-2"></i>
        <span id="inventorySuccessAlertText"></span>
    </div>

    <div id="inventoryFailAlert" class="alert d-none alert-solid-danger d-flex align-items-center" role="alert">
        <i class="mdi mdi-alert-circle-outline me-2"></i>
        <span id="inventoryFailAlertText"></span>
    </div>
    <div class="table-responsive text-nowrap hoverable">
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Id</th>
                <th>stock</th>
                <th>Factura</th>
                <th>Entrada</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            <?php
            foreach($history as $key => $inventory):
                $invJson =  json_encode($inventory->toRawArray());
                ?>
            <tr id="<?=$inventory->id?>">
                <td>
                    <?=$inventory->id?>
<!--                    <i class="mdi mdi-wallet-travel mdi-20px text-danger me-3"></i><span class="fw-medium">Tours Project</span>-->
                </td>
                <td>
                    <input
                            class="form-control"
                            placeholder="18"
                            type="number"
                            value="<?=$inventory->stock?>"
                            min="0"
                            onchange='updateInventory(<?=$invJson?>,this.value)'
                    />
                </td>
                <td>
                    <?=$inventory->bill?>
                </td>
                <td>
                    <?=$inventory->enter_at->toLocalizedString('MMMM d, yyyy');?>
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="mdi mdi-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item waves-effect" href="javascript:void(0);"><i class="mdi mdi-pencil-outline me-1"></i> Modificar</a>
                            <a class="dropdown-item waves-effect" href="javascript:void(0);" onclick='transferArticle(<?=$invJson?>)'
                               data-bs-toggle="modal" data-bs-target="#transferArticle">
                                <i class='mdi mdi-transfer'></i>
                                Transferir
                            </a>
                            <a class="dropdown-item waves-effect" href='javascript:deleteInventory(<?=$invJson?>);'><i class="mdi mdi-trash-can-outline me-1"></i> Borrar</a>
                        </div>
                    </div>
                </td>
            </tr>
           <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->include('modals/transferArticle')?>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>



<script>
    console.log('Deliver JS loaded')
    
    
    
    $(function(){
        select2Catalogs('tiendas');
        $("#transferArticleForm").on("submit",function(e){
            $('#confirmBtn').prop('disabled', true);
            e.preventDefault();
            let postData = $(this).serializeArray();
            postData.receive = $("#storeStockSelect2").val();
            
            if(postData.receive === null)
            {
                $("#editFailAlertText").text("Se requiere una tienda destino.")
                $("#editFailAlert")
                    .removeClass("d-none")
                    .delay(5000)
                    .hide("fast",function(){
                        $(this).addClass("d-none")
                    });
                return false;
            }
            console.log(postData);
            $.ajax({
                method: "POST",
                url: "/transfer",
                data: postData,
                dataType :"JSON",
                statusCode:{
                    400:function(xhr)
                    {
                        toastAlert('warning','Información incorrecta', xhr.responseJSON.messages.error);
                    },
                    500:function(xhr)
                    {
                        toastAlert('error','Ocurrió un problema', xhr.responseJSON.messages.error);
                    },
                    201:function(xhr)
                    {
                        toastAlert('success','Transferencia exitosa','En breve se actualizará la información');
                        $('#confirmBtn').prop('disabled', false);
                    }
                }
            }).done(function(response){
               // dt_basic.ajax.reload();
            })

        })

    });
    function deleteInventory(item)
    {
        saleBlock()
        debugger;
        let postData = {
            _method : "DELETE",
        }
        $.ajax({
            method:"POST",
            url : "/inventory/"+item.id,
            dataType :"JSON",
            data : postData
        }).done(function(response){
            $.unblockUI()
            $("tr#"+item.id).fadeOut();

        });
        
    }
    function updateInventory(item,value)
    {
        saleBlock();
        item.stock = value;
        let postData = {
            inventory : item,
            _method : "PATCH",
        }
        $.ajax({
            method:"POST",
            url : "/inventory/"+item.id,
            dataType :"JSON",
            data : postData
        }).done(function(response){
            console.log(response)
            $("#editSuccessAlertText").text("Inventario actualizado ")
            $("#editSuccessAlert")
                .removeClass("d-none")
                .delay(7000)
                .hide("fast",function(){
                    $(this).addClass("d-none")
                });
            $.unblockUI();
            if(value === "0")
            {
                $("tr#"+item.id).fadeOut();
            }
        });

    }
    function transferArticle(article)
    {
        console.log(article);
        $('#articlesTransfer').attr({
            "max": article.stock,
        });
        $("#storeStockSelect2").val(null).trigger("change")
        $("#uptotransfer").val(article.stock);
        $("#inventoryID").val(article.id);
        $("#transferArticleID").val( article.item);
        $("#originStoreID").val( article.store);
        $("#articlesName").val( article.item_name);
    }

    function blockCard()
    {
        $('#detail-card').block({
            message: '<div class="spinner-border text-white" role="status"></div>',
            css: {
                backgroundColor: 'transparent',
                border: '0'
            },
            overlayCSS: {
                opacity: 0.5
            }
        });
    }

</script>

<?= $this->endSection() ?>
