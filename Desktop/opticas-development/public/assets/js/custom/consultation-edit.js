const forms ={
    "form-general" :"consultationgb" ,
    "form-visual-background" : "consultationvb",
    "form-visual-evaluation" : "consultationve",
    "prescription" : "prescription",
    "form-contact-lenses":"consultationcl"
};


$(function(){
    $("form.consulting input, textarea").on("change",setUpdateData);

    $(".select2").on("select2:select",setUpdateData);
    selectPicker.on("change",setUpdateData);

    $("input[name='healthy']").trigger("input");

    $("#updateImage").on("click",function(event){

        let controller = forms[event.currentTarget.form.id]
        let postData = [{name:"anomalies_image",value:getCanvasData()}];
        updateConsultation(consulting.id,controller,postData);

    })
})

function setUpdateData(event)
{
        let element = event.currentTarget;
    let prescriptionDetail = element.dataset.prescriptionDetail;

    if (prescriptionDetail) {
        let fieldName = getPrescriptionField(element.name);
        if (!fieldName) {
            return;
        }
        let value = element.type === 'checkbox' ? (element.checked ? 1 : 0) : element.value;
        updatePrescriptionDetail(prescriptionDetail, fieldName, value);
        return;
    }

    let controller = forms[element.form.id];
    let value = element.type ==='checkbox'?(element.value === 'on'?1:0):element.value;
    let postdata = [{name :element.name,value:value}];

    if(event.currentTarget.classList.contains("interpupilar_distance"))
    {
        postdata = [];
        $(".interpupilar_distance").each(function(index,element){
            console.log(element)
            postdata.push({name :element.name,value:element.value})
        });

    }

    updateConsultation(consulting.id,controller,postdata);
}

function getPrescriptionField(fieldName)
{
    let match = fieldName.match(/\[([a-z_]+)]$/);
    return match ? match[1] : null;
}

function updatePrescriptionDetail(detailId, fieldName, value)
{
    $.ajax({
        method: 'PATCH',
        url: `/prescription/${detailId}`,
        data: [{name: fieldName, value: value}],
        dataType: 'JSON',
        statusCode: {
            400: function(xhr){
            },
            500: function(xhr){
                toastAlert('error','Error',"Ocurrió un error, Comunicar a soporte");
            },
            200:xhr=>toastAlert("success","","Campo actualizado")
        }
    })
}

function updateConsultation(consultation,controller,postdata)
{
    $.ajax({
        method: 'PATCH',
        url: `/${controller}/${consultation}`,
        data: postdata,
        dataType: 'JSON',
        statusCode: {
             400: function(xhr){
             },
            500: function(xhr){
                 toastAlert('error','Error',"Ocurrió un error, Comunicar a soporte");
            },
            200:xhr=>toastAlert("success","","Campo actualizado")
        }
    })

}
