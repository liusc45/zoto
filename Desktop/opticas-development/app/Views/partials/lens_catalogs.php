 <div class="row">

    <?php
    foreach($catalogs as $key => $catalog):
    ?>
    <div class="col-12 col-lg-3  ">
        <div class="input-group  mb-4">
            <div class="form-floating form-floating-outline">
                <select
                    id="lens-<?=$key?>"
                    name="<?=$key?>"
                    class="form-select select2 filter-lens"
                    data-allow-clear="true">
                    <option></option>

                    <?php foreach($$key as $list):?>
                        <option value="<?=$list->id?>"> <?=$list->name?> </option>
                        <?php endforeach; ?>
                </select>
                <label for="select2Basic">Seleccionar <?=$catalog?></label>
            </div>
        </div>
    </div>
    <?php
    endforeach;
    if(@$title !=="Mostrador"): ?>
        <div class="col-12 col-lg-3">
        <div class="input-group input-group-merge mb-4">
              <span id="basic-icon-default-cost" class="input-group-text"
              ><i class="mdi mdi-cash"></i
                  ></span>
            <div class="form-floating form-floating-outline">
                <input
                        required
                        type="text"
                        class="form-control"
                        id="cost"
                        name="cost"
                        placeholder="500.00"
                        aria-label="500.00"
                        aria-describedby="basic-icon-default-cost2" />
                <label for="basic-icon-default-cost">Costo</label>
            </div>
        </div>
    </div>
        <div class="col-12 col-lg-3">
        <div class="input-group input-group-merge mb-4">
              <span id="basic-icon-default-cost" class="input-group-text"
              ><i class="mdi mdi-cash"></i
                  ></span>
            <div class="form-floating form-floating-outline">
                <input
                        required
                        type="text"
                        class="form-control"
                        id="price"
                        name="price"
                        placeholder="500.00"
                        aria-label="500.00"
                        aria-describedby="basic-icon-default-cost2" />
                <label for="basic-icon-default-cost">Precio Público</label>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
