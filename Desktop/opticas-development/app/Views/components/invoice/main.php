<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
<link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
<link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> Facturas</h4>
<?=$this->include('partials/alerts');?>


<div class="card">
    <div class="card-body">
        <form id="invoiceForm">
        <input type="hidden" name="sale" id="invoice_sale" />

        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <div id="invoice_customer" class="fw-medium"></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <label class="form-label">Datos fiscales</label>
                <select class="form-select" name="person_tax" id="invoice_person_tax"></select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Serie</label>
                <input class="form-control" name="series" value="A" />
            </div>
            <div class="col-md-2">
                <label class="form-label">IVA (%)</label>
                <input class="form-control" name="tax_rate" value="16.00" />
            </div>
        </div>


        <div class="mb-3">
            <label class="form-label">Pagos de la venta</label>
            <div id="invoice_payments" class="border rounded p-2 small" style="max-height:180px;overflow:auto"></div>
        </div>

        <div class="d-flex justify-content-between border-top pt-2 mb-3">
            <div>Pagado: <span id="invoice_paid" class="fw-bold text-success"></span></div>
            <div>Pendiente: <span id="invoice_pending" class="fw-bold text-danger"></span></div>
            <div>Total venta: <span id="invoice_total" class="fw-bold"></span></div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Crear factura</button>
    </form>
    </div>
</div>


<div class="card mt-4">
  <div class="card-datatable table-responsive">
    <table id="invoiceDatatable" class="datatables-basic table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Serie</th>
          <th>Folio</th>
          <th>Venta</th>
          <th>Total</th>
          <th>Estatus</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
<script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script>
  let invoiceTable;
  function currency(n){
    const num = parseFloat(n||0);
    return num.toLocaleString('es-MX',{style:'currency',currency:'MXN'});
  }

  document.addEventListener('DOMContentLoaded', function() {
    invoiceTable = $('#invoiceDatatable').DataTable({
      ajax: { url: '/invoice', dataSrc: '' },
      columns: [
        { data: 'id' },
        { data: 'series' },
        { data: 'folio' },
        { data: 'sale' },
        { data: 'total', render: d => currency(d) },
        { data: 'status' },
        { data: 'created_at' },
        { data: null, orderable: false, render: row => `
          <a href="#" class="btn btn-sm btn-outline-primary" data-action="print" data-id="${row.id}">
            <i class="mdi mdi-printer"></i>
          </a>
        `}
      ]
    });

    // Submit crear factura
    $('#invoiceForm').on('submit', function(e) {
      e.preventDefault();
      const data = $(this).serialize();
      $.post('/invoice/from-sale', data)
        .done(resp => {
          if (typeof toastAlert === 'function') {
            toastAlert('success','Factura creada','Se ha creado la factura correctamente');
          }
          invoiceTable.ajax.reload(null,false);
        })
        .fail(xhr => {
          if (typeof toastAlert === 'function') {
            toastAlert('error','No se pudo crear','Revise la información');
          }
        });
    });

    // Autoabrir con parámetros ?sale=&customer=
    const params = new URLSearchParams(location.search);
    const saleId = params.get('sale');
    const customer = params.get('customer');
    if (saleId) {
      openInvoiceFromSale(parseInt(saleId), customer || '');
    }
  });

  // Expuesta para usarse desde /ventas y aquí mismo
  function openInvoiceFromSale(saleId, customerName) {
    $('#saleIdLabel').text(`#${saleId}`);
    $('#invoice_sale').val(saleId);
    $('#invoice_customer').text(customerName || '');
    $('#invoice_person_tax').empty();
    $('#invoice_payments').html('Cargando...');
    $('#invoice_paid').text('');
    $('#invoice_pending').text('');
    $('#invoice_total').text('');

    $.getJSON(`/invoice/sale/${saleId}`, function(data) {
      // Datos fiscales
      if (data.personTaxes && data.personTaxes.length) {
        data.personTaxes.forEach(pt => {
          $('#invoice_person_tax').append(`<option value="${pt.id}">${pt.nickname || pt.tax_name || pt.rfc}</option>`);
        });
      } else {
        $('#invoice_person_tax').append('<option value="">Sin datos fiscales</option>');
      }

      // Pagos
      const lines = (data.payments || []).map(p => {
        const type = (p.payment_type||'').toString().toUpperCase();
        const terminal = p.terminal ? ` (${p.terminal})` : '';
        return `<div class="d-flex justify-content-between border-bottom py-1">
                  <span>${type}${terminal}</span>
                  <span>${currency(p.amount)}</span>
                </div>`;
      });
      $('#invoice_payments').html(lines.join(''));

      $('#invoice_paid').text(currency(data.paid));
      $('#invoice_pending').text(currency(data.pending));
      $('#invoice_total').text(currency((data.sale||{}).amount));
    });
  }
</script>
<?= $this->endSection() ?>
