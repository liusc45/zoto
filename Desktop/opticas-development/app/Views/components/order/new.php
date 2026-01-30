<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
    <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> Órdenes</h4>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1 mt-3">Ventas a ordenar</h4>
        <p>Verifique la información y guarde las órdenes.</p>
        <div class="row">
            <div class="form-floating form-floating-outline  ">
                <input
                        class="form-control-plaintext"
                        type="number" value="<?=count($patientItems)?>"
                        id="patients_number" readonly
                />
                <label for="patients_number"> Número de pacientes</label>

            </div>
            <span>
            <small >Vendido:</small>

                <?=$sale->created_at->toDateString() . "    (".$sale->created_at->humanize().")"?>
            </span>

        </div>

    </div>
</div>

 <form id="orderForm" class="needs-validation">
     <?php foreach($patientItems as $key => $patient):?>


         <div id="card-block" class="card card-action mb-4">
         <div class="card-header ">
           <div class="card-action-title">
                 <span>
                   <?=
                    $patient["patient"]->id." - ".
                    $patient["patient"]->name." ".
                    $patient["patient"]->last_name
                   ?>
                 </span>
               <small class="text-body ">Venta: <?=$sale->id?></small>
           </div>
             <div class="card-action-element">
                 <ul class="list-inline mb-0">
                     <li class="list-inline-item">
                         <a href="javascript:void(0);" class="card-close"><i class="tf-icons mdi mdi-close"></i></a>
                     </li>
                 </ul>
             </div>

         </div>

         <div class="card-body">
             <div class="list-group">
                 <?php
                     $withFrame = false;
                     $withLens = false;
                     foreach ($patient['items'] as $index=> $item):
                         if(!is_null($item->frame)):
                             $withFrame = true;
                 ?>
                     <div class="list-group-item  d-flex justify-content-between ">
                         <div class="li-wrapper d-flex justify-content-start align-items-center">
                             <div class="avatar avatar-sm me-3">
                                 <span class="avatar-initial rounded-circle bg-label-success"><i class="mdi mdi-glasses"></i> </span>
                             </div>
                             <div class="list-content">
                                 <h6 class="text-primary  "><?=$item->item_obj->key?></h6>
                                 <small class="mb-1"><?=$item->item_obj->name."    ".$item->item_obj->brand?></small>

                             </div>
                         </div>
                         <small>Artículo: <?=$item->item_obj->id?></small>
                     </div>

                     <?php endif;?>

                     <?php if(!is_null($item->lens)):
                        $withLens = true;
                     ?>
                      <div class="list-group-item  d-flex justify-content-between ">
                          <div class="li-wrapper d-flex justify-content-start align-items-center">
                              <div class="avatar avatar-sm me-3">
                                  <span class="avatar-initial rounded-circle bg-label-danger px-3"><i class="mdi mdi-panorama-wide-angle-outline"></i></span>
                              </div>
                              <div class="list-content">
                                  <h6 class="mb-1 text-primary"><?=$item->item_obj->key?></h6>
                                  <br>
                                  <small class="mb-1">Laboratorio:
                                      <select id="select2Lab" class="select2" name="orders[<?=$key?>][lab]">
                                          <?php foreach($labs as $lab):?>
                                          <option value="<?=$lab->id?>" <?=$lab->id == $item->lens->lab ? "selected" : ""?>><?=$lab->company->name?></option>
                                          <?php endforeach;?>
                                      </select>

                                  </small>
                              </div>
                          </div>
                          <div class="row mt-3">
                              <div class="form-floating  col-md-4 mb-2 form-floating-outline">
                                  <select
                                          name="orders[<?=$key?>][status]"
                                          id="select2Status"
                                          class="select2 form-select form-select-lg"
                                          data-allow-clear="true">
                                      <option value="pending">Pendiente</option>
                                      <option value="processing">En proceso</option>
                                      <option value="to_delivery">Para entrega</option>
                                      <option value="delivered">Entregado</option>
                                      <option value="completed">Completado</option>
                                      <option value="warranty">Garantía</option>
                                  </select>
                                  <label for="select2Status">Estado</label>
                              </div>
                              <div class="form-floating  col-md-4 mb-2 form-floating-outline">
                                  <input type="text"
                                         class="form-control"
                                         id="lab_folio"
                                         name="orders[<?=$key?>][lab_folio]"
                                         placeholder="Folio Laboratorio"
                                         aria-label="1"
                                         aria-describedby="basic-icon-default-patients"/>
                                  <label for="select2Status">Folio Laboratorio</label>
                              </div>
                              <div class="form-floating  col-md-4 mb-2 form-floating-outline">
                                  <input
                                          type="date"
                                          class="form-control"
                                          id="lab_sent"
                                          name="orders[<?=$key?>][lab_sent]"
                                          aria-describedby="basic-icon-default-lab-sent" />
                                  <label for="lab_sent"> Envío al laboratorio</label>
                              </div>
                              <div class="form-floating  col-md-4 mb-2 form-floating-outline">
                                  <input
                                          type="date"
                                          class="form-control"
                                          id="lab_received"
                                          name="orders[<?=$key?>][lab_received]"
                                          aria-describedby="basic-icon-default-lab-received" />
                                  <label for="lab_received">Recepción del laboratorio</label>
                              </div>
                              <div class="form-floating  col-md-4 mb-2 form-floating-outline">
                                  <input
                                          type="date"
                                          class="form-control"
                                          id="delivered"
                                          name="orders[<?=$key?>][delivered]"
                                          aria-describedby="basic-icon-default-delivered" />
                                  <label for="delivered">Entrega al cliente</label>
                              </div>

                          </div>
                      </div>
                    <?php endif;?>
                 <?php endforeach;?>
             </div>

             <?php if(!$withFrame):?>
                 <div class="list-group">
                     <div class="list-group-item  d-flex justify-content-between ">
                         <div class="li-wrapper d-flex justify-content-start align-items-center">
                             <div class="avatar avatar-sm me-3">
                                 <span class="avatar-initial rounded-circle bg-label-success"><i class="mdi mdi-glasses"></i> </span>
                             </div>
                             <div class="list-content">
                                 <h6 class="text-primary  ">Sin Armazón </h6>
                                 <div class="form-check">
                                     <input class="form-check-input" type="checkbox"  name="<?="orders[$key]"?>[own_frame]">
                                     <label class="form-check-label" for="defaultCheck3"> ¿Armazón Propio?  </label>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <?php endif;
                 if(!$withLens):?>
                     <div class="list-group">
                        <div class="list-group-item  d-flex justify-content-between ">
                            <div class="li-wrapper d-flex justify-content-start align-items-center">
                                <div class="avatar avatar-sm me-3">
                                    <span class="avatar-initial rounded-circle bg-label-danger px-3"><i class="mdi mdi-panorama-wide-angle-outline"></i></span>
                                </div>
                                <div class="list-content">
                                    <h6 class="mb-1 text-primary">Sin Micas</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                 <?php endif;?>
             <!-- Campos adicionales de montaje y armazón -->
             <div class="row mt-3">
                 <div class="col-12">
                     <h6 class="text-body">Parámetros de montaje (Frame)</h6>
                 </div>
                 <div class="form-floating col-md-4 mb-2 form-floating-outline">
                     <input type="number" step="0.01" class="form-control" id="panoramico_<?=$key?>" name="<?="orders[$key]"?>[panoramic]" placeholder="Panorámico" />
                     <label for="panoramico_<?=$key?>">Panorámico</label>
                 </div>
                 <div class="form-floating col-md-4 mb-2 form-floating-outline">
                     <input type="number" step="0.01" class="form-control" id="pantoscopico_<?=$key?>" name="<?="orders[$key]"?>[pantoscopic]" placeholder="Pantoscópico" />
                     <label for="pantoscopico_<?=$key?>">Pantoscópico</label>
                 </div>
                 <div class="form-floating col-md-4 mb-2 form-floating-outline">
                     <input type="number" step="0.01" class="form-control" id="vertex_od_<?=$key?>" name="<?="orders[$key]"?>[vertex_distance][right]" placeholder="Distancia al vértice OD" />
                     <label for="vertex_od_<?=$key?>">Distancia al Vertex OD</label>
                 </div>

                 <div class="form-floating col-md-4 mb-2 form-floating-outline">
                     <input type="text" class="form-control" id="iniciales_<?=$key?>" name="<?="orders[$key]"?>[initials]" placeholder="Iniciales" />
                     <label for="iniciales_<?=$key?>">Iniciales</label>
                 </div>
                 <div class="form-floating col-md-4 mb-2 form-floating-outline">
                     <input type="text" class="form-control" id="nve_<?=$key?>" name="<?="orders[$key]"?>[nve]" placeholder="NVE" />
                     <label for="nve_<?=$key?>">NVE</label>
                 </div>
                 <div class="form-floating col-md-4 mb-2 form-floating-outline">
                     <input type="number" step="0.01" class="form-control" id="vertex_oi_<?=$key?>" name="<?="orders[$key]"?>[vertex_distance][left]" placeholder="Distancia al vértice OI" />
                     <label for="vertex_oi_<?=$key?>">Distancia al Vertex OI</label>
                 </div>
             </div>

             <div class="row mt-2">
                 <div class="col-12">
                     <h6 class="text-body">Medidas del armazón</h6>
                 </div>
                 <div class="form-floating col-md-3 mb-2 form-floating-outline">
                     <input type="number" step="0.01" class="form-control" id="horizontal_diameter<?=$key?>" name="<?="orders[$key]"?>[frame_measures][horizontal]" placeholder="Diámetro Horizontal" />
                     <label for="horizontal_diameter<?=$key?>">Diámetro Horizontal</label>
                 </div>
                 <div class="form-floating col-md-3 mb-2 form-floating-outline">
                     <input type="number" step="0.01" class="form-control" id="vertical_diameter<?=$key?>" name="<?="orders[$key]"?>[frame_measures][vertical]" placeholder="Diámetro Vertical" />
                     <label for="vertical_diameter<?=$key?>">Diámetro Vertical</label>
                 </div>
                 <div class="form-floating col-md-3 mb-2 form-floating-outline">
                     <input type="number" step="0.01" class="form-control" id="effective_<?=$key?>" name="<?="orders[$key]"?>[frame_measures][effective]" placeholder="Efectivo" />
                     <label for="effective_<?=$key?>">Efectivo</label>
                 </div>
                 <div class="form-floating col-md-3 mb-2 form-floating-outline">
                     <input type="number" step="0.01" class="form-control" id="bridge_<?=$key?>" name="<?="orders[$key]"?>[frame_measures][bridge]" placeholder="Puente" />
                     <label for="bridge_<?=$key?>">Puente</label>
                 </div>
             </div>

             <p>
             <div class="form-floating form-floating-outline mb-4">
                 <textarea name="<?="orders[$key]"?>[comments]" class="form-control h-px-100" id="exampleFormControlTextarea1" placeholder="Comments here..."></textarea>
                 <label for="exampleFormControlTextarea1">Observaciones</label>
             </div>
             </p>
         </div>
     </div>

     <?php endforeach;?>
         <input type="hidden" value="<?=auth()->getUser()->id?>" name="created_by">

        <input type="hidden" value="<?=$sale->id?>" name="sale">

         <button class="btn btn-primary btn-card-block-overlay mt-4">Guardar</button>
 </form>



<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="/assets/js/cards-actions.js"></script>

    <script>
        console.log('Orders JS loaded')
        // Check if consultation_id is provided
        const consultationId = <?= isset($consultation_id) ? "'".$consultation_id."'" : 'null' ?>;

        $(function(){
            // Pre-fill form if consultation_id is provided



            // Orders form
            $("form#orderForm").on("submit", function(e){
                e.preventDefault();
                blocking();
                let orderData = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url: "/order",
                    data: orderData,

                    statusCode: {
                        201:function(response){
                            console.log(response);

                            $("form#orderForm").trigger("reset");
                            unblocking();
                            toastAlert("success","Nueva Orden","Guardada con éxito")


                        },
                    },
                    error: function(error){
                        console.error(error);
                        unblocking();
                        toastAlert('error','Error', 'Ha ocurrido un error al crear la orden')

                    }
                });
            });


        });

        function blocking() {
            $('#card-block').block({
                message: '<div class="spinner-border text-white" role="status"></div>',
                timeout: 1000,
                css: {
                    backgroundColor: 'transparent',
                    border: '0'
                },
                overlayCSS: {
                    backgroundColor: '#000',
                    opacity: 0.1
                }
            });
        }

        function unblocking() {
            $('#card-block').unblock();
        }
    </script>
<?= $this->endSection() ?>
