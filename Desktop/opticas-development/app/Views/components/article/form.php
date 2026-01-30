<form id="articleForm" class="needs-validation">
    <div class="row">
        <!-- NAME -->
        <div class="col-md-6">
            <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-text-box-edit-outline"></i>
                          </span>
                <div class="form-floating form-floating-outline">
                    <input
                        required
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="VOGUE 3548 1565 54 DE PASTA"
                        aria-label="VOGUE 3548 1565 54 DE PASTA"
                        aria-describedby="basic-icon-default-fullname2" />
                    <label for="basic-icon-default-fullname">Nombre</label>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-text-box-edit-outline"></i>
                          </span>
                <div class="form-floating form-floating-outline">
                    <input
                        required
                        type="text"
                        class="form-control"
                        id="key"
                        name="key"
                        placeholder="clave interna "
                        aria-label="VOGUE 3548 1565 54 DE PASTA"
                        aria-describedby="basic-icon-default-fullname2" />
                    <label for="basic-icon-default-fullname">Clave interna </label>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-merge mb-4">
                          <span id="basic-icon-default-fullname2" class="input-group-text">
                              <i class="mdi mdi-text-box-edit-outline"></i>
                          </span>
                <div class="form-floating form-floating-outline">
                    <input
                        required
                        type="text"
                        class="form-control"
                        id="key"
                        name="barcode"
                        placeholder="clave interna "
                        aria-label="VOGUE 3548 1565 54 DE PASTA"
                        aria-describedby="basic-icon-default-fullname2" />
                    <label for="basic-icon-default-fullname">Código de barras </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Lines -->
        <div class="col-md-3">
            <div class="mb-6">
                <div class="form-floating form-floating-outline">
                    <select
                        name="line"
                        id="select2Line"
                        class="select2 form-select form-select-lg"
                        data-allow-clear="true">
                        <?php foreach($lines as $key => $line):?>
                            <option value="<?= $line->id;?>">
                                <?= $line->name; ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                    <label for="select2Basic">Linea</label>
                </div>
            </div>
        </div>
        <!-- Cost -->
        <div class="col-md-3">
            <div class="input-group input-group-merge mb-4">
                              <span id="basic-icon-default-fullname2" class="input-group-text">
                                <i class="mdi mdi-cash-100"></i>
                              </span>
                <div class="form-floating form-floating-outline">
                    <input
                        required
                        type="number"
                        class="form-control"
                        id="cost_price"
                        name="cost"
                        placeholder="1650"
                        aria-label="1650"
                        aria-describedby="basic-icon-default-fullname2" />
                    <label for="basic-icon-default-fullname">Costo</label>
                </div>
            </div>
        </div>
        <!-- minimum price -->
        <div class="col-md-3">
            <div class="input-group input-group-merge mb-4">
                              <span id="basic-icon-default-fullname2" class="input-group-text">
                                <i class="mdi mdi-cash-100"></i>
                              </span>
                <div class="form-floating form-floating-outline">
                    <input
                        required
                        type="number"
                        class="form-control"
                        id="minimum price"
                        name="minimum_price"
                        placeholder="2300"
                        aria-label="2300"
                        aria-describedby="basic-icon-default-fullname2" />
                    <label for="basic-icon-default-fullname">Precio minimo</label>
                </div>
            </div>
        </div>
        <!-- Public Price -->
        <div class="col-md-3">
            <div class="input-group input-group-merge mb-4">
                              <span id="basic-icon-default-fullname2" class="input-group-text">
                                <i class="mdi mdi-cash-100"></i>
                              </span>
                <div class="form-floating form-floating-outline">
                    <input
                        required
                        type="number"
                        class="form-control"
                        id="public_price"
                        name="public_price"
                        placeholder="3000"
                        aria-label="3000"
                        aria-describedby="basic-icon-default-fullname2" />
                    <label for="basic-icon-default-fullname">Precio al público</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Brand -->
        <div class="col-md-4">
            <div class="mb-6">
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
                    <label for="select2Basic">Marca</label>
                </div>
            </div>
        </div>
        <!-- Model -->
        <div class="col-md-4">
            <div class="form-floating form-floating-outline">
                <input
                    type="text"
                    class="form-control"
                    id="model"
                    name="model"
                    placeholder="3545"
                    aria-describedby="floatingInputHelp" />
                <label for="floatingInput">Modelo</label>
            </div>
        </div>
    </div>

    <!-- Save button -->
    <input type="hidden" value="<?=auth()->getUser()->id?>" name="created_by">
    <button class="btn btn-primary btn-card-block-overlay mt-4">Guardar</button>
</form>