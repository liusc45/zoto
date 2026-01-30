<div class="offcanvas offcanvas-bottom h-50 overflow-scroll" data-bs-scroll="true" data-bs-backdrop="false" id="lensModal" tabindex="-1" aria-hidden="true">
    <div class="offcanvas-content">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="exampleModalLabel1">Modal para lentes</h4>
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close">
                
            </button>
        </div>
        <div class="modal-body">
            <?=$this->include('partials/lens_catalogs')?>
        </div>
        <div class="card-datatable table-responsive">
            <table id="lensDatatable" class="datatables-basic table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Corrección Óptica</th>
                    <th>Material</th>
                    <th>Tipo</th>
                    <th>Color</th>
                    <th>Tipo Corrección</th>
                    <th>Tratamiento</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th></th>
                    <th>Corrección Óptica</th>
                    <th>Material</th>
                    <th>Tipo</th>
                    <th>Color</th>
                    <th>Tipo Corrección</th>
                    <th>Tratamiento</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas" aria-label="Close">
                Cerrar
            </button>
        </div>
    </div>
</div>
