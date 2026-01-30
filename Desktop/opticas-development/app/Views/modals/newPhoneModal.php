<div class="modal fade" id="newPhoneModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Agregar un teléfono</h4>
                <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <form id="newPhoneForm" >
                <div class="modal-body">
                        <div class="row">
                        <div class="col mb-6 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="phoneName" name="type" class="form-control" placeholder="Oficina" />
                                <label for="nameBasic">Nombre</label>
                            </div>
                        </div>
                        <div class="col mb-6 mt-2">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="phoneNumber" name="number" maxlength="13" minlength="10" class="form-control" placeholder="+525544661123" />
                                <label for="nameBasic">Teléfono</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-primary">Guardar</button>
                </div>
                <input type="hidden" id="person" name="person" value="<?=$patient->person?>" />
            </form>
        </div>
    </div>
</div>