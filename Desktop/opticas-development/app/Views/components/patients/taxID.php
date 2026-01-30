<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="offcanvasTaxID"
    aria-labelledby="offcanvasEndLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasEndLabel" class="offcanvas-title">Información Fiscal</h5>
        <button
            type="button"
            class="btn-close text-reset"
            data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0">

        <form id="taxIdForm" >
            <div class="form-floating form-floating-outline mt-2 mb-6">
                <input type="text"
                       class="form-control"
                       id="basic-default-nickname"
                       name="nickname"
                       placeholder="Esposo"
                       oninput="this.value = this.value.toUpperCase()"/>
                <label for="basic-default-fullname">Identificador</label>
            </div>
            <div class="form-floating form-floating-outline mt-2 mb-6">
                <input type="text"
                       class="form-control"
                       id="basic-default-rfc"
                       name="rfc"
                       maxlength="13"
                       minlength="13"
                       placeholder="SOPE840927R7Q"
                       oninput="this.value = this.value.toUpperCase()"/>
                <label for="basic-default-fullname">RFC</label>
            </div>
            <div class="form-floating form-floating-outline mt-2 mb-6">
                <input type="text"
                       class="form-control"
                       id="basic-default-tax_name"
                       name="tax_name"
                       placeholder="ACME Inc."
                       oninput="this.value = this.value.toUpperCase()"/>
                <label for="basic-default-company">Razón Social</label>
            </div>
            <div class="form-floating form-floating-outline mt-2 mb-6">
                <input
                        type="text"
                        id="basic-default-tax_address"
                        name="tax_address"
                        class="form-control"
                        placeholder="Domicilio Fiscal 99"
                        aria-label="Domicilio Fiscal 99"
                        aria-describedby="basic-default-email2"
                        oninput="this.value = this.value.toUpperCase()"/>
                <label for="basic-default-email">Domicilio</label>
            </div>
            <div class="form-floating form-floating-outline mt-2 mb-6">
                <input
                        type="number"
                        id="basic-default-postal_code"
                        name="postal_code"
                        maxlength="5"
                        minlength="5"
                        class="form-control phone-mask"
                        placeholder="91000" />
                <label for="basic-default-phone">Código Postal</label>
            </div>

            <div class="col-12 mt-2 mb-6">
                <div class="form-floating form-floating-outline">
                    <select
                            id="select2Basic"
                            class="select2 form-select form-select-lg"
                            data-allow-clear="true">
                        <option value="1">Régimen Simplificado de Confianza</option>
                        <option value="2">Sueldos y Salarios</option>
                        <option value="3">Actividades Empresariales</option>
                        <option value="4">Arrendamiento</option>
                        <option value="5">Incorporación Fisca</option>
                    </select>
                    <label for="select2Basic">Regimen Fiscal</label>
                </div>
            </div>

            <input type="hidden" name="person" value="<?=$patient->person?>">
            <input type="hidden" name="id" id="tax_id_input" >
            <button type="submit"
                    class="btn btn-primary mb-2 mt-2 d-grid w-100">
                Guardar
            </button>
            <button
                    type="button"
                    class="btn btn-outline-secondary d-grid w-100"
                    data-bs-dismiss="offcanvas">
                Cerrar
            </button>
        </form>
    </div>
</div>
