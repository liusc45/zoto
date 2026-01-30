<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

<div id="card-block" class="card">
    <div class="card-header d-flex flex-column">
        <h5 class="mb-0">Nueva <?=singular(session("meta")["module"])?></h5>
        <small class="text-body float-end">Algunos campos son obligatorios</small>
    </div>
    <div class="card-body">
        <form id="purchaseForm" class="needs-validation">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <select id="selectProvider" class="selectpicker w-100" data-style="btn-default">
                            <option value="00">Seleccionar proveedor</option>
                            <?php foreach($providers as $key => $provider):?>
                                <option value="<?= $provider->id;?>">
                                    <?= $provider->name; ?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-numeric"></i>
                          </span>
                        <div class="form-floating form-floating-outline">
                            <input
                                    type="text"
                                    class="form-control"
                                    id="purchaseBill"
                                    name="bill"
                                    placeholder="ABC123"
                                    aria-label="ABC123"
                                    onchange="setBillNumber(this.value)"
                                    />
                            <label for="purchaseBill">Número de factura</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Date -->
                    <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-calendar"></i>
                          </span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="bs-datepicker-basic"

                                   name="purchased_at"
                                   placeholder="MM/DD/YYYY"
                                   value="<?=date('d/m/Y')?>"
                                   class="form-control" />
                            <label for="bs-datepicker-basic">Fecha de compra</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Date -->
                    <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
<!--                              <i class="mdi mdi-calendar"></i>-->
                          </span>
                        <div class="form-floating form-floating-outline">
                            <input type="number" id="bill-discount"

                                   placeholder="123.00"
                                   class="form-control"
                                   onchange="setBillDiscount(this.value)"

                            />
                            <label for="bill-discount">Descuento Factura </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Date -->
                    <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
<!--                              <i class="mdi mdi-calendar"></i>-->
                          </span>
                        <div class="form-floating form-floating-outline">
                            <input type="text"
                                   id="bill-discount"
                                   placeholder="123.45"
                                   class="form-control"
                                   onchange="setBillAmount(this.value)"
                            />
                            <label for="bill-discount">Total factura. </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input
                                type="text"
                                readonly
                                class="form-control-plaintext px-0"
                                id="exampleFormControlReadOnlyInputPlain1"
                                value="email@example.com" />
                        <label for="exampleFormControlReadOnlyInputPlain1" class="px-0">RFC</label>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-floating form-floating-outline">
                        <input
                                type="text"
                                readonly
                                class="form-control-plaintext px-0"
                                id="nameProvider"
                                value="Proveedor Mayorista SA" />
                        <label for="exampleFormControlReadOnlyInputPlain1" class="px-0">Nombre del proveedor</label>
                    </div>
                </div>
            </div>


            <div class="col-md-12 mt-3">
                <div class="col-md-12 mt-3">
                    <div class="form-floating form-floating-outline">
                        <select id="select2Article"
                                class="select2 form-select form-select-lg"
                                data-allow-clear="true">
                                <option value="00">Seleccionar artículo</option>
                            <?php foreach($articles as $key => $article):?>
                                <option value="<?= $article->id;?>">
                                    <?= $article->name; ?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>

            <div id="articleList" class="mt-3"></div>
            <!-- Save button -->
            <button class="btn btn-primary btn-card-block-overlay mt-3">Guardar</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script>
    console.log('Purchases js loaded');
    const providersData = <?= json_encode($providers); ?>;
    const articles  = <?= json_encode($articles); ?>;
    const indexedArticles = articles.reduce((acc,article)=>{
         acc[article.id] = article;
         return acc;
    },[]);
    const purchaseForm = $("#purchaseForm");

    let purchasedArticles = [];
    let purchase  = {};
    const bsDatepickerBasic = $('#bs-datepicker-basic');
    const select2Article = $('#select2Article');



    $(function () {
        purchaseForm.on("submit",e=> {
           e.preventDefault();
           purchase.articles = purchasedArticles;
           
           $.ajax({
               method : "POST",
               url  : "/purchase",
               data : purchase,
               dataType: "JSON",
               statusCode:{
                   201: xhr=> {
                       console.log(xhr)
                   },
                   400:xhr=>
                   {
                       toastAlert("error","Faltan datos","");
                       console.log(xhr);
                   }
               },

           }).done(response=>{
               console.log(response);
           })
        });


        if (bsDatepickerBasic.length) {
            bsDatepickerBasic.datepicker({
                format: 'dd-mm-yyyy',
                autoclose:true,
                todayHighlight: true,
              //  orientation: isRtl ? 'auto right' : 'auto left'
            }).on("changeDate",function(event){

                purchase.date = this.value.split("/").reverse().join("-");
            }).trigger("changeDate")
        }

        $('#selectProvider').on('change', function(e) {
            console.log(e)
            let selectedValue = e.currentTarget.value
            const selectedProvider = providersData.find(provider => provider.id === selectedValue);

            purchase.supplier = selectedValue;

            if (selectedProvider) {
                console.log(selectedProvider);
                $('#nameProvider').val(selectedProvider.name);
                $('#addressProvider').val(selectedProvider.address);
            } else {
                console.log('Proveedor no encontrado');
            }
        });

        select2Article.select2({
            placeholder: "Seleccionar artículo",
            allowClear: true
        }).on('select2:select', function (e) {
            var data = e.params.data;
            //console.log(e);
            select2Article.val(null).trigger('change');
            drawNewArticle(indexedArticles[data.id]);
           // toastAlert('info', 'Articulo agregado','Recuerda agregar la información adicional');
        });
    });

    function drawNewArticle(article)
    {
       // article = article || {};
        purchasedArticles[article.id.toString()] = article;
        console.log('Nuevo item');
        itemForm = `
            <div class="row mt-2" id="article-${article.id}">
                <div class="col-md-2">
                    <div class=" mb-6">
                      <a href="#" onclick="removeArticle('${article.id}',this)" class="btn btn-danger btn-sm"><i class="mdi mdi-trash-can-outline"></i>  </a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating form-floating-outline mb-6">
                      <input type="number" onchange=setQty(this.value,${article.id})  class="form-control" id="articleUnits-${article.id}" placeholder="99" />
                      <label for="basic-default-fullname">Unidades</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating form-floating-outline mb-6">
                      <input type="text" class="form-control" id="articleName-${article.id}" value="${article.name.trim()}" placeholder="Lentes de lujo polarizados" />
                      <label for="basic-default-company">Artículo</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating form-floating-outline mb-6">
                      <input type="number" onchange="setDiscount(this.value,${article.id})" class="form-control" id="articleDiscount-${article.id}" placeholder="99" />
                      <label for="basic-default-fullname">Descuento</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating form-floating-outline mb-6">
                      <input type="number" onchange="setCost(this.value,${article.id})" class="form-control" id="unitPrice-${article.id}" placeholder="99" />
                      <label for="basic-default-fullname">Costo por unidad</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating form-floating-outline mb-6">
                      <input type="number" onfocus="setTotalCost(this,${article.id})" class="form-control" id="articleTotal-${article.id}" placeholder="99" />
                      <label for="basic-default-fullname">Total partida</label>
                    </div>
                </div>

            </div>`
        $('#articleList').append(itemForm);
    }

    function removeArticle(id,elem)
    {
        delete purchasedArticles[id];
        elem.closest('#article-'+id).remove();
    }
    function setBillNumber(value) {

        purchase.bill = value
        console.log(purchase);
    }
    function setQty(qty,itemId)
    {
        purchasedArticles[itemId].qty = qty
    }
    function setDiscount(amount,itemId)
    {

        purchasedArticles[itemId].discount = parseFloat(amount)
    }

    function setCost(amount,itemId)
    {

        purchasedArticles[itemId].cost = parseFloat(amount)
    }

    function setTotalCost(input,itemId)
    {
        let item = purchasedArticles[itemId];
        purchasedArticles[itemId].totalCost = item.qty*item.cost
        input.value =  item.qty*item.cost

    }
    function setBillDiscount(value)
    {
        purchase.discount = value
    }
    function setBillAmount(value)
    {
        purchase.amount = value
    }



</script>
<?= $this->endSection() ?>
