<?=$this->extend('app');?>
<?=$this->section('componentStyles');?>
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css">
<?=$this->endSection();?>
<?=$this->section('content');?>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="form-floating form-floating-outline">
            <select
            name="brand"
            id="select2Brand"
            class="select2 form-select form-select-lg"
            data-allow-clear="true">
            <?php foreach($brands as $key => $brand):?>
                <option value="<?= $brand->id;?>">
                    <?= $brand->name; ?>
                </option>
            <?php endforeach;?>
        </select>
            <label for="select2Brand">Marca</label>
        </div>
    </div>
    <!--/Brand -->
    <!-- Model -->
    <div class="col-md-3 mb-3">
        <div class="form-floating form-floating-outline">
           <select
               id="select2Model"
               name="model"
               class="select2 form-select form-select-lg"
               data-allow-clear="true">
               <?php foreach($models as $key => $model):?>
                   <option value="<?= $model->id;?>">
                       <?= $model->name; ?>
                   </option>
               <?php endforeach;?>
           </select>
            <label for="select2Model">Modelo</label>
        </div>
    </div>
    <!--Model-->

    <div class="col-md-3 mb-3">
        <div class="form-floating form-floating-outline">
            <select
                    name="line"
                    id="select2Line"
                    class="select2 form-select form-select-lg"
                    data-allow-clear="true">
            <?php foreach($lines as $key => $line):?>
                <option value="<?= $line->id?>" >
                    <?= $line->name; ?>
                </option>
            <?php endforeach;?>
        </select>
            <label for="select2Line">Linea</label>
        </div>
    </div>
    <!-- supplier -->
    <div class="col-md-3 mb-3">
        <div class="form-floating form-floating-outline">
            <select
                    id="select2Supplier"
                    name="supplier"
                    class="select2 form-select form-select-lg"
                    data-allow-clear="true">
                <?php foreach($suppliers as $key => $supplier):?>
                    <option value="<?= $supplier->id;?>">
                        <?= $supplier->company->name; ?>
                    </option>
                <?php endforeach;?>
            </select>
            <label for="select2Supplier">Proveedor</label>
        </div>
    </div>
    <!-- /supplier -->

    <!-- ColorCode -->
    <div class="col-md-3 mb-3">
        <div class="form-floating form-floating-outline">
            <input
                type="text"
                class="form-control"
                id="keyColor"
                name="key_color"
                placeholder="1254"
            />
            <label for="keyColor">Color (clave)</label>
        </div>
    </div>
    <!-- /ColorCode -->
    <!-- SizeCode -->
    <div class="col-md-3 mb-3 ">
        <div class="form-floating form-floating-outline">
            <select
                class=" select2 form-select form-select-lg"
                id="sizeCode"
                name="size_code"
            >
                <option value="">Seleccione</option>
                <?php foreach($sizes as $key => $size):?>
                    <option value="<?= $size->id;?>">
                        <?= $size->name; ?>
                    </option>
                <?php endforeach;?>
            </select>
            <label for="sizeCode">Tamaño (clave)</label>
        </div>
    </div>
    <!-- /SizeCode -->
    <!-- Public Price -->
    <div class="col-md-3 mb-3 ">
        <div class="form-floating form-floating-outline">
            <input
                required
                type="number"
                class="form-control"
                id="public_price"
                name="public_price"
                placeholder="3000"
                aria-label="3000"
            />
            <label for="public_price">Precio al público</label>
        </div>
    </div>
    <!-- /Public Price -->
    <!-- Range -->
    <div class="col-md-6 col-12 mb-4">
        <div class="form-floating form-floating-outline">
            <input type="text" id="bs-rangepicker-range" class="form-control">
            <label for="bs-rangepicker-range">Ranges</label>
        </div>
    </div>
    <!-- /Range -->

    <!-- minimum price -->
    <div class="col-md-3 mb-3">
        <div class="form-floating form-floating-outline">
            <input
                required
                type="number"
                class="form-control"
                id="item_size"
                name="size"
                placeholder="2300"
                aria-label="2300"
            />
            <label for="minimum_price">Tamaño</label>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/select2/select2.js"></script>
<script src="/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js"></script>
<?= $this->endSection() ?>