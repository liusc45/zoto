function setSelects(selectId,dataset)
{
    var $this = $("#"+selectId);
    select2Focus($this);
    $this.wrap('<div class="position-relative"></div>').select2({
        data : dataset,
        tags:true,
        placeholder: 'Seleccionar opción',
        dropdownParent: $this.parent()
    });
}
function select2Catalogs(module)
{
    let endpoint;
    let selectorID;
    let additionalSelect= '';
    switch (module) {
        case 'categorias':
            endpoint= '/itemCategory';
            selectorID='categorySelect2';
            additionalSelect='categoryEditSelect2';
            break;
        case 'tiendas':
            endpoint= '/store';
            selectorID='storeStockSelect2'
            additionalSelect='';
            break;
        case 'proveedores':
            endpoint= '/supplier';
            selectorID='supplierSelect2';
            additionalSelect='supplierStockSelect2';
            break;
        case 'articulos':
            endpoint= '/article';
            selectorID='';
            additionalSelect='';
            break;
        default:
            return false;
    }

    $.ajax({
        method: "GET",
        "url": endpoint,
        "dataType":"JSON"
    }).done(function (responseData){
        let dataset =  $.map(responseData,function(obj){
            obj.id = obj.id,
            obj.text = obj.name;
            return obj;
        });
        setSelects(selectorID,dataset);
        if(additionalSelect !== ''){
            setSelects(additionalSelect,dataset);
        }
    })
}
