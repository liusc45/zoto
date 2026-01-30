<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> Rangos</h4>

<div id="card-block" class="card">
    <div class="card-header d-flex flex-column">
        <h5 class="mb-0">Nuevo rango</h5>
    </div>
    <div class="card-body">
        <form id="RangeForm" class="needs-validation" >
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="input-group input-group-merge mb-4 col-6">
                      <span class="input-group-text">
                          <i class="mdi mdi-text-box-edit-outline"></i>
                      </span>
                        <div class="form-floating form-floating-outline">
                            <input
                                    required
                                    type="text"
                                    class="form-control"
                                    id="description"
                                    name="description"
                                    placeholder="Esfera"
                                    aria-label="Descripción"
                            />
                            <label for="description">Descripción</label>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-card-block-overlay">Guardar</button>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-datatable table-responsive pt-0">
        <table id="rangeDatatable" class="datatables-basic table table-bordered">
            <thead>
            <tr>
                <th>id</th>
                <th>Descripción</th>
                <th>Intervalos</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal for intervals -->
<div class="modal fade" id="intervalModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Intervalos del rango</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="intervalList"></div>
        <form id="IntervalForm">
          <div class="row g-2">
            <div class="col-6">
              <div class="form-floating form-floating-outline">
                <input type="number" step="0.01" class="form-control" name="min_value" placeholder="-10.00" required>
                <label>Mínimo</label>
              </div>
            </div>
            <div class="col-6">
              <div class="form-floating form-floating-outline">
                <input type="number" step="0.01" class="form-control" name="max_value" placeholder="10.00" required>
                <label>Máximo</label>
              </div>
            </div>
          </div>
          <button class="btn btn-primary mt-3" type="submit">Agregar intervalo</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script>
let dt;
let selectedRangeId = null;

function blocking() { $("#card-block").block({ message: '<div class="spinner-border text-primary" role="status"></div>' }); }
function unblock() { $("#card-block").unblock(); }

function loadIntervals(rangeId){
  $('#intervalList').html('<div class="text-muted">Cargando...</div>');
  $.get(`/range/${rangeId}/intervals`, function(data){
    const html = (data||[]).map(it => `
      <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
        <span>${it.min_value} a ${it.max_value}</span>
        <button data-id="${it.id}" class="btn btn-sm btn-danger btn-del-interval">Eliminar</button>
      </div>`).join('');
    $('#intervalList').html(html || '<div class="text-muted">Sin intervalos</div>');
    // bind delete
    $('.btn-del-interval').off('click').on('click', function(){
      const iid = $(this).data('id');
      $.ajax({ url: `/range/interval/${iid}`, method: 'DELETE'}).done(()=> loadIntervals(rangeId));
    });
  });
}

$(function(){
  // Create range
  $('#RangeForm').on('submit', function(e){
    e.preventDefault();
    blocking();
    $.post('/range', $(this).serialize()).done(function(r){
      dt.ajax.reload();
      $('#RangeForm')[0].reset();
    }).fail(function(xhr){
      Swal.fire('Error', xhr.responseJSON?.messages ?? 'Error al guardar', 'error');
    }).always(unblock);
  });

  // datatable
  const dt_basic_table = $('#rangeDatatable');
  if (dt_basic_table.length) {
    dt = dt_basic_table.DataTable({
      ajax: { url: '/range', dataSrc: '' },
      columns: [
        { data: 'id' },
        { data: 'description' },
        { data: null },
        { data: null }
      ],
      columnDefs: [
        { targets: 2, render: function(data, type, row){
            return `<button class="btn btn-sm btn-secondary btn-intervals" data-id="${row.id}">Gestionar</button>`;
          }
        },
        { targets: 3, render: function(data, type, row){
            return `<button class=\"btn btn-sm btn-danger btn-delete\" data-id=\"${row.id}\">Eliminar</button>`;
          }
        }
      ]
    });
  }

  // open intervals modal
  $(document).on('click', '.btn-intervals', function(){
    selectedRangeId = $(this).data('id');
    loadIntervals(selectedRangeId);
    const modal = new bootstrap.Modal(document.getElementById('intervalModal'));
    modal.show();
  });

  // delete range
  $(document).on('click', '.btn-delete', function(){
    const id = $(this).data('id');
    Swal.fire({ title:'¿Eliminar?', icon:'warning', showCancelButton:true }).then(res=>{
      if(res.isConfirmed){
        $.ajax({ url: '/range/'+id, method: 'DELETE' }).done(()=> dt.ajax.reload());
      }
    });
  });

  // Add interval
  $('#IntervalForm').on('submit', function(e){
    e.preventDefault();
    if(!selectedRangeId) return;
    $.post(`/range/${selectedRangeId}/interval`, $(this).serialize()).done(function(){
      $('#IntervalForm')[0].reset();
      loadIntervals(selectedRangeId);
    }).fail(function(xhr){
      const msg = xhr.responseJSON?.messages ?? xhr.responseText ?? 'Error al guardar intervalo';
      Swal.fire('Error', msg, 'error');
    });
  });
});
</script>
<?= $this->endSection() ?>
