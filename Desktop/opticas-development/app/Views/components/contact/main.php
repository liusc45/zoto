<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"
          xmlns="http://www.w3.org/1999/html"/>
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?=$this->include('partials/breadcrumb');?>


<div class="col-12">
    <div class="card mb-6">
        <div class="card-header p-0">
            <div class="card-header d-flex flex-column">
                <h5 class="mb-0">Nuevo Lente de contacto</h5>
                <small class="text-body float-end">Algunos campos son obligatorios</small>
            </div>
        </div>
        <div class="card-body">
           <form  id="contact-form">
               <div class="row">
                   <!-- Name -->
                   <div class="col-md-4 mt-3 mb-2">
                       <div class="form-floating form-floating-outline">
                           <input
                                   required
                                   type="text"
                                   class="form-control"
                                   id="name"
                                   name="name"
                                   placeholder="Christian Guillermo"
                                   aria-label="Christian Guillermo"
                                   aria-describedby="basic-icon-default-fullname2" />
                           <label for="basic-icon-default-fullname">Nombre(s)</label>
                       </div>
                   </div>
                   <!-- Last Name -->
                   <div class="col-md-4 mt-3 mb-2">
                       <div class="form-floating form-floating-outline">
                           <select name="supplier" id="supplier" class="form-control select2">
                               <option value=""></option>

                               <?php foreach($suppliers as $supplier):?>
                                   <option value="<?= $supplier->id;?>"><?= $supplier->name;?></option>
                               <?php endforeach;?>
                           </select>
                           <label for="supplier">Proveedor</label>
                       </div>
                   </div>
                   <div class="col-md-4 mt-3 mb-2">
                       <div class="form-floating form-floating-outline">
                           <select name="design" id="design" class="form-control select2">
                               <option value=""></option>

                               <?php foreach($designs as $design):?>
                                   <option value="<?= $design->id;?>"><?= $design->name;?></option>
                               <?php endforeach;?>
                           </select>
                           <label for="design">Diseño</label>
                       </div>
                   </div>
                   <div class="col-md-4 mt-3 mb-2">
                       <div class="form-floating form-floating-outline">
                           <select name="brand" id="brand" class="form-control select2">
                               <option value=""></option>

                               <?php foreach($brands as $brand):?>
                                   <option value="<?= $brand->id;?>"><?= $brand->name;?></option>
                               <?php endforeach;?>
                           </select>
                           <label for="brand">Marca</label>
                       </div>
                   </div>
                   <div class="col-md-4 mt-3 mb-2">
                       <div class="form-floating form-floating-outline">
                           <select name="color" id="color" class="form-control select2">
                               <option value=""></option>

                               <?php foreach($colors as $color):?>
                                   <option value="<?= $color->id;?>"><?= $color->name;?></option>
                               <?php endforeach;?>
                           </select>
                           <label for="color">Color</label>
                       </div>
                   </div>
                   <div class="col-md-4 mt-3 mb-2">
                       <div class="form-floating form-floating-outline">
                           <select name="wear" id="wear" class="form-control select2">
                               <option value=""></option>

                               <?php foreach($wears as $wear):?>
                                   <option value="<?= $wear->id;?>"><?= $wear->name;?></option>
                               <?php endforeach;?>
                           </select>
                           <label for="wear">Uso</label>
                       </div>
                   </div>
                   <!--DOB -->

                   <div class="col-md-4 mt-3 mb-2">
                       <div class="form-floating form-floating-outline">
                           <input
                                   required
                                   type="number"
                                   class="form-control"
                                   id="units"
                                   name="units_per_package"
                                   placeholder="2"
                                   aria-label="2"
                           />
                           <label for="units">Unidades por caja</label>
                       </div>
                   </div>

                   <div class="col-md-4 mt-3 mb-2">
                       <div class="input-group input-group-outline">
                           <div class="form-floating form-floating-outline">
                           <input
                                   required
                                   type="number"
                                   class="form-control"
                                   id="replace_unit"
                                   name="replace_unit"
                                   placeholder="2"
                                   aria-label="2"
                           />
                           <label for="replace_unit">Reemplazar en </label>
                       </div>
                           <div class="form-floating form-floating-outline">
                               <select name="replace_time" id="replace_time" class="form-control select2">
                                   <option value="days">Día(s)</option>
                                   <option value="weeks">Semana(s)</option>
                                   <option value="months">Mese(s)</option>
                                   <option value="years">Año(s)</option>
                               </select>
                               <label for="replace_time">Reemplazar en </label>
                           </div>

                       </div>
                   </div>
                   <div class="col-md-4 mt-3 mb-2">
                   </div>

               </div>

           </form>
        </div>
    </div>
</div>

    <div class="card mt-4">
        <div class="card-datatable table-responsive pt-0">
            <table id="lensDatatable" class="datatables-basic table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Unidades/paquete </th>
                        <th>Proveedor</th>
                        <th>Diseño</th>
                        <th>Color</th>
                        <th>Uso</th>
                        <th>Marca</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

<?= $this->include('modals/editLens')?>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>
    <script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script>
        console.log('Lens js loaded');
        var dt_basic_table = $('#lensDatatable'), dt_basic;
        $(".select2").select2({tags:true})
        $(function(){

            // Transaction form
            $("form").on("submit",function(e){
                e.preventDefault();
                blocking();
                let lensData = $(this).serializeArray();

                $.ajax({
                    method: "POST",
                    url: "/contact",
                    dataType: "JSON",
                    data: lensData,
                }).done(function(lens){
                    if(lens.id != null){
                        toastAlert('success', 'Lente guardado', 'La configuración del lente se guardo correctamente');
                        $('#lensForm')[0].reset();
                        dt_basic.ajax.reload();
                    }else{
                        toastAlert('error', 'Ocurrió un problema', 'Por favor, intentalo nuevamente');
                    }
                });
            });

            // Lens datatable
            dt_basic = dt_basic_table.DataTable({
                ajax: {
                    url: '/contact',
                    dataSrc: ""
                },
            
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'units_per_package' },
                    { data: 'supplier_name' },
                    { data: 'design_name' },
                    { data: 'color_name' },
                    { data: 'brand_name' },
                    { data: 'wear_name' },
                    { data: '', render: function (data, type, row){
                            let lensJson = JSON.stringify(row);
                            return `
                                    <a href="javascript:void(0);" onclick='openLensModal(${lensJson})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'
                                        data-bs-toggle="modal" data-bs-target="#editLens">
                                        <i class='mdi mdi-pencil-outline'></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick='deleteLens(${lensJson})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'>
                                        <i class='mdi mdi-delete'></i>
                                    </a>
                                `
                        }
                    },
                ],
                columnDefs: [
                    {
                        // For Responsive
                        className: 'control',
                        orderable: false,
                        searchable: false,
                        responsivePriority: 2,
                        targets: 0,
                        render: function (data, type, full, meta) {
                            return '';
                        }
                    },
                    {
                        // Label
                        targets: -1,
                        responsivePriority: 0,
                        title: 'Acciones',
                        render: function (data, type, full, meta) {
                            var $status_number = full['status'];
                            var $status = {
                                1: { title: 'Current', class: 'bg-label-primary' },
                                2: { title: 'Professional', class: ' bg-label-success' },
                                3: { title: 'Rejected', class: ' bg-label-danger' },
                                4: { title: 'Resigned', class: ' bg-label-warning' },
                                5: { title: 'Applied', class: ' bg-label-info' }
                            };
                            if (typeof $status[$status_number] === 'undefined') {
                                return data;
                            }
                            return (
                                `<span class="badge rounded-pill ${$status[$status_number].class}">
                                ${$status[$status_number].title}
                                </span>`
                            );
                        }
                    }
                ],
                dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 10,
                lengthMenu: [10, 25, 50, 75, 100],
                buttons: [],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return 'Detalles de la mica ';
                            }
                        }),
                        type: 'column',
                        renderer: function (api, rowIdx, columns) {
                            var data = $.map(columns, function (col, i) {
                                return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ? `
                                        <tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                                            <td>${col.title} :</td>
                                            <td>${col.data}</td>
                                        </tr>`
                                    : '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(data) : false;
                        }
                    }
                },
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {

                            if(this[0][0] === 0 || this[0][0] === 7 ){
                                return
                            }
                            var column = this;
                            var title = column.footer().textContent;

                            // Create input element and add event listener
                            $('<input type="text" placeholder="Filtrar ' + title + '" />')
                                .appendTo($(column.footer()).empty())
                                .on('keyup change clear', function () {
                                    if (column.search() !== this.value) {
                                        column.search(this.value).draw();
                                    }
                                });
                        });
                },
                layout: {
                    top1: {
                        searchPanes: {
                            viewTotal: true
                        }
                    }
                },
               
            });
            $('div.head-label').html('<h5 class="card-title mb-0">Relación de micas</h5>');

            $("#editLensForm").on("submit", event=>{
                event.preventDefault();
            })

            $("#editLensForm input").on("change",event=>{
                let postData = {
                    '_method': 'PATCH'
                };
                postData[event.currentTarget.name]=event.currentTarget.value;
                let updatedCell = event.currentTarget.name+$('#modalEditLensID').val();
                editLens(postData, updatedCell, event.currentTarget.name);
            });

        });

        function blocking()
        {
            $('#card-block').block({
                message: '<div class="spinner-border text-primary" role="status"></div>',
                timeout: 2000,
                css: {
                    backgroundColor: 'transparent',
                    border: '0'
                },
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8
                }
            });
        }

        function openLensModal(lens)
        {
            document.getElementById("modalEditLensID").value = lens.id;
            document.getElementById("modalEditLensCost").value = lens.cost;
            document.getElementById("modalEditLensPrice").value = lens.price;
        }

        function editLens(postData)
        {
            $.ajax({
                method: 'POST',
                url: '/lens/'+$('#modalEditLensID').val(),
                data: postData,
                dataType: 'JSON',
            }).done(function(response){
                if(response){
                    toastAlert('success', 'Mica actualizada', 'La información se actualizó correctamente');
                    dt_basic.ajax.reload();
                } else{
                    toastAlert('error', 'Algo salió mal', 'Por favor, intentalo nuevamente');
                }
            });
        }

        function deleteLens(lens)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No serás capaz de recuperar este lente",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, borrar lente!',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                    cancelButton: 'btn btn-outline-secondary waves-effect'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'POST',
                        url: '/lens/'+lens.id,
                        data: { '_method': 'DELETE'},
                        dataType: 'JSON'
                    }).done(function(response){
                        toastAlert('info', 'Lente borrado', 'El lente se borró satisfactoriamente');
                        dt_basic.ajax.reload();
                    })
                }
            });
        }
    </script>
<?= $this->endSection() ?>
