<div class="modal fade" id="newPrescriptionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-header">
                <h5 class="modal-title">Nueva receta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <label for="prescription_created_at" class="form-label">Fecha de la receta</label>
                        <input type="text" class="form-control" id="prescription_created_at" placeholder="YYYY-MM-DD" />
                        <input type="hidden" class="form-control" id="prescription_detail_id" placeholder="YYYY-MM-DD" />
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-3" id="prescription-grid">
                        <thead>
                            <tr>
                                <th>Ojo</th>
                                <th>Esfera</th>
                                <th>Cilindro</th>
                                <th>Eje</th>
                                <th>Adición</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-eye="right">
                                <td class="text-nowrap">Derecho</td>
                                <td>
                                    <input type="number"
                                           id="final_right_sphere"
                                           onchange="setFloatingPoint(this)"
                                           step=".25" class="form-control form-control-sm prescription-input"
                                           data-detail name="prescription[final][right][sphere]" >
                                </td>
                                <td>
                                    <input type="number"
                                           id="final_right_cylinder"
                                           onchange="setFloatingPoint(this)"
                                           step=".25" class="form-control form-control-sm prescription-input"
                                           data-detail name="prescription[final][right][cylinder]" >
                                </td>
                                <td>
                                    <input type="number"
                                           id="final_right_axis"
                                           class="form-control form-control-sm prescription-input"
                                           data-detail name="prescription[final][right][axis]" >
                                </td>
                                <td>
                                    <input type="number"
                                           id="final_right_addition"
                                           onchange="setFloatingPoint(this)"
                                           step=".25" class="form-control form-control-sm prescription-input"
                                           data-detail name="prescription[final][right][addition]">
                                </td>
                            </tr>
                            <tr data-eye="left">
                                <td class="text-nowrap">Izquierdo</td>
                                <td>
                                    <input type="number"
                                           id="final_left_sphere"
                                           onchange="setFloatingPoint(this)"
                                           step=".25" class="form-control form-control-sm prescription-input"
                                           data-detail name="prescription[final][left][sphere]">
                                </td>
                                <td>
                                    <input type="number"
                                           id="final_left_cylinder"
                                           onchange="setFloatingPoint(this)"
                                           step=".25" class="form-control form-control-sm prescription-input"
                                           data-detail name="prescription[final][left][cylinder]">
                                </td>
                                <td>
                                    <input type="number"
                                           id="final_left_axis"
                                           onchange="setFloatingPoint(this)"
                                           class="form-control form-control-sm prescription-input"
                                           data-detail name="prescription[final][left][axis]" >
                                </td>
                                <td>
                                    <input type="number"
                                           id="final_left_addition"
                                           onchange="setFloatingPoint(this)"
                                           step=".25" class="form-control form-control-sm prescription-input"
                                           data-detail name="prescription[final][left][addition]">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="savePrescriptionBtn">Guardar</button>
            </div>
        </div>
    </div>
</div>
