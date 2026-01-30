<?= $this->extend('app') ?>

<?= $this->section('componentStyles') ?>
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/dropzone/dropzone.css" />

<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= env('app.title')?> /</span> <?=$title?></h4>

    <?=$this->include('partials/alerts');?>

    <div id="card-block" class="card">
        <div class="card-header d-flex flex-column">
            <h5 class="mb-0">Nuevo artículo</h5>
            <small class="text-body float-end">Algunos campos son obligatorios</small>
        </div>
        <div class="card-body">

            <?=$this->include('components/article/form')?>
        </div>
    </div>

    <?=$this->include('partials/deleteAlerts');?>
    <div class="card mt-4">
        <div class="card-datatable table-responsive pt-0">
            <table id="articlesDatatable" class="datatables-basic table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Publicado</th>
                    <th>ID</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Linea</th>
                    <th>Marca</th>
                    <th>Color</th>
                    <th>P. Mínimo</th>
                    <th>P. Público</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <?= $this->include('modals/addStock')?>
    <?= $this->include('modals/editArticle')?>

<?= $this->endSection() ?>

<?= $this->section('componentScripts') ?>

    <script src="/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="/assets/vendor/libs/block-ui/block-ui.js"></script>
    <script src="/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="/assets/vendor/libs/dropzone/dropzone.js"></script>



    <script>
        console.log('Articles JS loaded')
        var dt_basic_table = $('.datatables-basic'), dt_basic;
        let dropzoneBasic = $('#dropzone');


        const previewTemplate = `<div class="dz-preview dz-file-preview">
                                    <div class="dz-details">
                                      <div class="dz-thumbnail">
                                        <img data-dz-thumbnail>
                                        <span class="dz-nopreview">Sin imagen previa</span>
                                        <div class="dz-success-mark"></div>
                                        <div class="dz-error-mark"></div>
                                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                      </div>
                                      <div class="dz-filename" data-dz-name></div>
                                      <div class="dz-size" data-dz-size></div>
                                    </div>
                                    </div>`;
        dropzoneBasic.dropzone( {

            url:'/article',
            autoProcessQueue : true,
            previewTemplate: previewTemplate,
            //    parallelUploads: 1,
            //   maxFilesize: 5,
              addRemoveLinks: true,
            //    maxFiles: 1,
                acceptedFiles: 'image/*',
            //    resizeQuality: 0.8,
            //    resizeMethod: 'contain'
        });

        $(function(){
            let categories

            // Article form
            $("form#articleForm").on("submit",function(e){
                e.preventDefault();
                blocking();
                let articleData = $(this).serializeArray();

                    $.ajax({
                        method: "POST",
                        url: "/article",
                        dataType: "JSON",
                        data: articleData,
                        statusCode: {
                            201:(xhr)=>{
                                debugger;
                                toastAlert('success','Artículo guardado','El artículo se guardo exitosamente');
                                $('#articleForm')[0].reset();
                                uploadPhotos(xhr);
                                unBlock();

                                $('.select2 ').val(null).trigger('change');
                            },
                            500:()=>{
                                toastAlert('error','Error','Ocurrió un problema al guardar');

                            }
                        }
                    }).done(function(article){

                        if(article.id != null){

                         //   dt_basic.ajax.reload();

                        }else{

                        }
                    });
                });

            // Articles datatable
            dt_basic = dt_basic_table.DataTable({
                ajax: {
                    url: '/item',
                    dataSrc: ""
                },
                columns: [
                    { data: '' },

                    { data: 'id' },
                    { data: 'id' },
                    { data: 'name'},
                    { data: 'line' },
                    { data: 'brand'},
                    { data: 'color'},
                    { data: 'minimum_price'},
                    { data: 'public_price'},
                    { data: '', render: function (data, type, row){
                            let articleJson = JSON.stringify(row);
                            return `
                                    <a href="javascript:void(0);" onclick='openAddStockModal(${articleJson})'
                                        class='btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit'
                                        data-bs-toggle="modal" data-bs-target="#addStockArticleModal">
                                        <i class='mdi mdi-package-variant-closed-plus'></i>
                                    </a>
                                  <div class="d-inline-block">
                                    <a href="#" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                                      <ul class="dropdown-menu dropdown-menu-end m-0">
                                        <li><a href="#" onclick='openArticleModal(${articleJson})' class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editArticle">Editar</a></li>
                                      <div class="dropdown-divider"></div>
                                        <li><a href="#" onclick='deleteArticle(${articleJson})' class="dropdown-item text-danger">Eliminar</a></li>
                                      </ul>
                                  </div>
                            `
                        }
                    }
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
                        // For Checkboxes
                        targets: 1,
                        orderable: false,
                        searchable: false,
                       // responsivePriority: 3,



                    },

                    {
                        responsivePriority: 1,
                        targets: 4
                    },
                    {
                        // Actions
                        targets: -1,
                        title: 'Acciones',
                        orderable: false,
                        searchable: false,

                    }
                ],
                order: [[3, 'desc']],
                dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 10,
                lengthMenu: [10, 25, 50, 75, 100],
                buttons: [
                    {
                        extend: 'collection',
                        className: 'btn btn-label-primary dropdown-toggle me-2',
                        text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span class="d-none d-sm-inline-block">Exportar</span>',
                        buttons: [
                            {
                                extend: 'csv',
                                text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 6, 7, 8],
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 6, 7, 8],
                                }
                            }
                        ]
                    }
                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return 'Detalles del artículo ';
                            }
                        }),
                        type: 'column',
                        renderer: function (api, rowIdx, columns) {
                            var data = $.map(columns, function (col, i) {
                                return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ? `
                                    <tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                                        <td>${col.title}:</td>
                                        <td>${col.data}</td>
                                    </tr>`
                                    : '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(data) : false;
                        }
                    }
                }
            });
            $('div.head-label').html('<h5 class="card-title mb-0">Relación de artículos</h5>');

            $("#editArticleForm").on("submit", event=>{
                event.preventDefault();
            });

            $("#editArticleForm input").on("change",event=>{
                let postData = {
                    '_method':'PATCH'
                };
                postData[event.currentTarget.name]=event.currentTarget.value;
                editArticle(postData, '/article');
            });

            $("#addStockArticle").on("submit",function(e){
                e.preventDefault();
                let articleStockData = $(this).serializeArray();
                articleStockData['store_name']=  $('#storeStockSelect2 option:selected').text();
                $.ajax({
                    method: "POST",
                    url: "/inventory",
                    dataType: "JSON",
                    data: articleStockData,
                }).done(function(inventory){
                    if(inventory.id != null){
                        toastAlert('success','Artículo inventariado','El artículo se agregó al inventario correctamente');
                        $('#stockAddNumber, #stockAddBill').val('');
                    }else{
                        toastAlert('error','Error','Ocurrió un problema al guardar');
                    }
                });
            });


            dropzoneBasic.on("addedFile",file=>{
                console.log(file);
            })

            $('#categoryEditSelect2, #supplierEditSelect2').on('select2:select', function (e) {
                let selected = e.currentTarget.id;
                let endpoint = selected === 'categoryEditSelect2' ? '/article' : '/inventory';
                let postData = {
                    //e.params.data.id, e.params.data.text
                    'category':e.params.data.id,
                    '_method':'PATCH'
                }
                editArticle(postData, endpoint);
            });


        });


        function openAddStockModal(article)
        {
            document.getElementById("modalAddStockArticleName").value = article.name;
            document.getElementById("modalAddStockArticleID").value = article.id;
        }

        var currentArticle;
        function openArticleModal(article)
        {
            currentArticle = article;
            $('#categoryEditSelect2').val(article.category).trigger('change');
            document.getElementById("modalEditArticleID").value = article.id;
            document.getElementById("modalEditArticleName").value = article.name;
            document.getElementById("modalEditArticleCost").value = article.cost;
            document.getElementById("modalEditArticlePublicPrice").value = article.public_price;
            document.getElementById("modalEditArticleSpecialPrice").value = article.special_price;
            document.getElementById("modalEditArticleQtySpecialPrice").value = article.qty_special_price;
            document.getElementById("modalEditArticleWholesalePrice").value = article.wholesale_price;
            document.getElementById("modalEditArticleQtyWholesalePrice").value = article.qty_wholesale_price;
        }

        function blocking()
        {
            $('#card-block').block({
                message: '<div class="spinner-border text-primary" role="status"></div>',

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

        function unBlock()
        {
            $("#card-block").unblock()
        }

        function editArticle(postData, endpoint)
        {
            $.ajax({
                method: 'POST',
                url: endpoint+'/'+currentArticle.id,
                data: postData,
                dataType: 'JSON',
            }).done(function(response){
                if(response){
                    toastAlert('success','Artículo actualizado','El artículo se actualizo correctamente');
                    dt_basic.ajax.reload();
                } else{
                    toastAlert('error','Error','Ocurrió un problema al actualizar');
                }
            });
        }

        function deleteArticle(article)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No serás capaz de recuperar este artículo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, borrar artículo!',
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
                        url: '/article/'+article.id,
                        data: { '_method': 'DELETE'},
                        dataType: 'JSON',
                        statusCode:{
                            400: function (response){
                                toastAlert('error','Artículo bloqueado','No se puede borrar el artículo ya que tiene inventario en bodega');
                            }
                        }
                    }).done(function(response){
                        toastAlert('success','Artículo borrado','El artículo se borró exitosamente');
                        dt_basic.ajax.reload();
                    })
                }
            });
        }

        function uploadPhotos(article)
        {
            let postData = new FormData();

            postData.append("article",article.id);
            let files = Dropzone.instances[0].files;
            if(files.length ===0) {

                return false;
            }
            files.forEach((k, v) => postData.append(v, k));

            $.ajax({
                method:"POST",
                url: "/upload",
                data:postData,
                dataType:"JSON",
                contentType: false,
                processData: false,

            }).done(response=>console.log(response))

        }

    </script>

<?= $this->endSection() ?>
