<form id="articleForm" class="needs-validation">
    <div class="row">
        <!-- internalKey-->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <input
                    required
                    type="text"
                    class="form-control"
                    id="key"
                    name="key"
                    placeholder="clave interna "
                    aria-label="VOGUE 3548 1565 54 DE PASTA"
                />
                <label for="key">Clave interna </label>
            </div>
        </div>
        <!-- /internalKey -->
        <!-- NAME -->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <input
                        required
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="VOGUE 3548 1565 54 DE PASTA"
                        aria-label="VOGUE 3548 1565 54 DE PASTA"
                    />
                <label for="name">Nombre</label>
            </div>
        </div>
        <!-- /NAME -->
        <!--Barcode-->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <input
                        required
                        type="text"
                        class="form-control"
                        id="barcode"
                        name="barcode"
                        placeholder="Código de barras"
                        aria-label="VOGUE 3548 1565 54 DE PASTA"
                        aria-describedby="barcode" />
                <label for="barcode">Código de barras </label>
            </div>
        </div>
        <!--/Barcode-->
        <!-- Lines -->
        <div class="col-md-3 mb-3">
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
                <label for="select2Line">Linea</label>
            </div>
        </div>
    </div>

    <div class="row">

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
        <!-- Brand -->
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
                <input
                        type="text"
                        class="form-control"
                        id="model"
                        name="model"
                        placeholder="3545"
                />
                <label for="model">Modelo</label>
            </div>
        </div>
        <!--Model-->

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
                <input
                        type="number"
                        class="form-control"
                        min="35"
                        max="66"
                        step="1"
                        placeholder="54"
                        id="sizeCode"
                        name="size_code"
                />
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

        <!-- Cost -->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <input required
                       type="number"
                       class="form-control"
                       id="cost"
                       name="cost"
                       placeholder="1650"
                       aria-label="1650"
                />
                <label for="cost">Costo</label>
            </div>
        </div>
        <!-- /Cost -->

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
    <hr>
    <div class="row mt-4">
        <!-- FrameStyle -->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <select
                        id="select2Style"
                        name="style"
                        class="select2 form-select"
                        data-allow-clear="true">
                    <?php foreach($styles as $key => $style):?>
                        <option value="<?= $key?>"> <?= $style ?> </option>
                    <?php endforeach;?>
                </select>
                <label for="select2Style">Estilo Armazón</label>
            </div>
        </div>
        <!--/FrameStyle -->

        <!--Shape-->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <select
                        id="select2Shape"
                        name="shape"
                        class="select2 form-select"
                        data-allow-clear="true">
                    <option >N/A</option>
                    <option value="square"  >Cuadrada</option>
                    <option value="rectangle" >Rectangular </option>
                    <option value="geometric" >Geométrico </option>
                    <option value="rounded" >Redondo </option>
                </select>
                <label for="select2Shape">Forma Armazón </label>
            </div>

        </div>
        <!--/Shape -->
        <!--Gender -->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <select
                        id="select2Gender"
                        name="gender"
                        class="select2 form-select"
                        data-allow-clear="true"
                >
                    <option value="m" > Masculino </option>
                    <option value="f"  >Femenino</option>
                </select>
                <label for="select2Gender">Genero </label>
            </div>
        </div>
        <!--/Gender -->

        <!-- Color -->
        <div class="col-md-3 mb-3 ">
            <div class="form-floating form-floating-outline">
                <select
                        id="select2Color"
                        name="color"
                        class="select2 form-select"
                        data-allow-clear="true">
                    <?php foreach($colors as $key => $color):?>
                        <option value="<?= $color->id;?>">
                            <?= $color->name; ?>
                        </option>
                    <?php endforeach;?>
                </select>
                <label for="select2Color">Color General</label>
            </div>
        </div>
        <!--Color-->

        <!-- Front Material-->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <select
                    id="select2FrameMaterial"
                    name="frame_material"
                    class="select2 form-select"
                    data-allow-clear="true">
                    <?php foreach($materials as $key => $material):?>
                        <option value="<?= $material->id;?>"><?= $material->name; ?></option>
                    <?php endforeach;?>
                </select>
                <label for="select2FrameMaterial">Material (Frontal)</label>
            </div>
        </div>
        <!-- Front Color-->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <select
                        id="select2FrameColor"
                        name="frame_color"
                        class="select2 form-select"
                        data-allow-clear="true">
                        <?php foreach($colors as $key => $color):?>
                            <option value="<?= $color->id;?>" ><?= $color->name; ?> </option>
                        <?php endforeach;?>
                </select>
                <label for="select2FrameColor">Color (Frontal)</label>
            </div>
        </div>

        <!-- Rod Material-->
        <div class="col-md-3 mb-3">
            <div >
                <div class="form-floating form-floating-outline">
                    <select
                            id="select2RodMaterial"
                            name="rod_material"
                            class="select2 form-select"
                            data-allow-clear="true">
                        <?php foreach($materials as $key => $material):?>
                            <option value="<?= $material->id;?>">
                                <?= $material->name; ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                    <label for="select2RodMaterial">Material (Varilla)</label>
                </div>
            </div>
        </div>
        <!-- Rod Color-->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <select
                        id="select2RodColor"
                        name="rod_color"
                        class="select2 form-select"
                        data-allow-clear="true">
                    <?php foreach($colors as $key => $color):?>
                        <option value="<?= $color->id;?>"><?= $color->name; ?></option>
                    <?php endforeach;?>
                </select>
                <label for="select2RodColor">Color (Varilla)</label>
                </div>
        </div>
    </div>
    <div class=" row mt-4">
        <!--Solares -->
        <!-- convertir en catálogo los que pertenecen a solares ...-->
        <div class="divider">
            <span class="divider-text">Solares</span>
        </div>
        <div class="col-md-2 mb-3">
            <div class="form-floating form-floating-outline">
                <select
                            id="select2Supplier"
                            name="solar[material]"
                            class="select2 form-select"
                            data-allow-clear="true">
                        <option>N/A</option>
                        <option value="1">mica</option>
                        <option value="2">cristal</option>
                        <option value="3">policarbonato</option>
                        <option value="4">presentación</option>

                    </select>
                <label for="select2Basic">material mica</label>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="form-floating form-floating-outline">
                <select
                        id="solarProperty"
                        name="solar[property]"
                        class="select2 form-select"
                        data-allow-clear="true">
                    <option value="1">Normal</option>
                    <option value="2">Polarizado</option>
                    <option value="3">Fotocromatico</option>
                    <option value="4">Espejeado</option>
                </select>
                <label for="solarProperty">Propiedad Lente</label>
            </div>
        </div>

        <div class="col-md-2 mb-3">
            <div class="form-floating form-floating-outline">
                    <select
                            id="solarTreatment"
                            name="solar[treatment]"
                            class="select2 form-select"
                            data-allow-clear="true">
                        <option >N/A</option>
                        <option value="1"  >Espejeado</option>
                        <option value="2" >Antireflejanto </option>
                        <option value="3" >Antireflejante con espejeado</option>
                    </select>
                    <label for="solarTreatment">Tratamiento Lente</label>
                </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="form-floating form-floating-outline">
                    <select
                            id="solarColorTreatment"
                            name="solar[treatment_color]"
                            class="select2 form-select"
                            data-allow-clear="true">
                        <option >N/A</option>
                        <option value="1" >Plateado</option>
                        <option value="2" >Dorado </option>
                        <option value="3" >Rojo </option>
                        <option value="4" >Rosa </option>
                        <option value="5" >Azul </option>

                    </select>
                    <label for="solarColorTreatment">Color Tratamiento </label>
                </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="form-floating form-floating-outline">
                <select
                        id="solarFade"
                            name="solar[lens_fade]"
                            class="select2 form-select"
                            data-allow-clear="true">
                        <option>N/A</option>
                        <option value="1"  >Sólido</option>
                        <option value="2" >Degradado </option>
                    </select>
                    <label for="solarFade">Efecto </label>
                </div>
        </div>
        <!-- Color -->
        <div class="col-md-2 mb-3">
            <div class="form-floating form-floating-outline">
                <select
                        id="solarColor"
                        name="solar[lens_colors]"
                        class="select2 form-select"
                        data-allow-clear="true">
                    <?php foreach($colors as $key => $color):?>
                        <option value="<?= $color->id;?>"><?= $color->name; ?></option>
                    <?php endforeach;?>
                </select>
                <label for="solarColor">Color de lente </label>
            </div>
        </div>
        <!--solares-->
    </div>

    <div class="row mt-4">
        <!-- Size -->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <input
                    type="number"
                    class="form-control"
                    id="size_h"
                    name="size[horizontal]"
                    min="35"
                    max="66"
                    step="1"
                    placeholder="54"
                />
                <label for="floatingInput">Horizontal</label>
            </div>
        </div>
        <!-- Size -->
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <input
                    type="number"
                    class="form-control"
                    id="size_v"
                    name="size[vertical]"
                    min="12"
                    max="66"
                    step="1"
                    placeholder="54"
                />
                    <label for="size_v">Vertical</label>
                </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <input type="number"
                       class="form-control"
                       id="size_b"
                       name="size[bridge]"
                       min="12"
                       max="25"
                       step="1"
                       placeholder="54"
                />
                <label for="floatingInput">Puente</label>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="form-floating form-floating-outline">
                <input
                    type="number"
                    class="form-control"
                    id="size_r"
                    name="size[rod]"
                    min="140"
                    max="145"
                    step="1"
                    placeholder="54"
                />
                <label for="floatingInput">Varilla</label>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3 mt-4 dropzone needsclick dz-clickable" id="dropzone">
        <div class="dz-message ">
            Arrastra el archivo o da click para buscar
            <span class="note needsclick">
                        (La imagen <span class="fw-medium">no</span> se guarda automáticamente.)
                    </span>
        </div>
        <div class="fallback">
            <input name="file" type="file" />
        </div>
    </div>
    <!-- Save button -->
    <input type="hidden" value="<?=auth()->getUser()->id?>" name="created_by">
    <button class="btn btn-primary btn-card-block-overlay mt-4">Guardar</button>
</form>
