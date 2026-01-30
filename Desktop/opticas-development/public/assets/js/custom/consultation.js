const eyeBackground = new Image(),
    generalBackground = $("#form-general"),
    visualBackground = $("#form-visual-background"),
    visualEvaluation = $("#form-visual-evaluation"),
    generalCheckInput = $("#generalCheckInput"),
    contactsPrescription = $("#form-contact-lenses"),
    flatpickrDate = $('#flatpickr-date'),
    flatpickrLastConsultation = $('#flatpickr-last_consultation'),
    flatpickrLastRX = $('#last_prescription_created_at'),
    selectPicker = $('.selectpicker'),
    inputsLastPrescription = $("input[id^=last]"),
    inputsCurrentPrescription =$("input.current"),
    canvas = $("#eyeCanvas")[0],
    diabetic = $('.diabetes'),
    hypertension = $(".hypertensive"),
    lastCheckDate = $("#last-check-date");
let flatpickrOptions = {
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        locale: "es"
    },
    ctx,
    drawing = false;


 $(function(){

     setEyesCanvas();
     $("form").on("submit", event=>{
         event.preventDefault();
     });

     if (flatpickrDate) {
         flatpickrDate.flatpickr({...flatpickrOptions, dateFormat: "Y-m-d H:i:S",enableTime:true
         });
     }
     if (flatpickrLastConsultation){
         flatpickrLastConsultation.flatpickr(flatpickrOptions);
     }
     if (flatpickrLastRX){
         flatpickrLastRX.flatpickr(flatpickrOptions);
     }
     if(lastCheckDate){
         lastCheckDate.flatpickr(flatpickrOptions);
         lastCheckDate.flatpickr().input.disabled = true;
     }
     if (select2.length) {
         select2.each(function () {
             var $this = $(this);
             select2Focus($this);
             $this.wrap('<div class="position-relative"></div>').select2({
                 placeholder: 'Seleccionar opción',
                 dropdownParent: $this.parent()
             });
         });
     }
     if (selectPicker.length) {
        // selectPicker.selectpicker();
         handleBootstrapSelectEvents();
     }

     $("input[name='diabetes']",).on("change",function(){
         let disabled = this.value !== '1';
         diabetic.prop("disabled",disabled)
     });
     $("input[name='hypertensive']",).on("change",function(){
         let disabled = this.value !== '1';
         hypertension.prop("disabled",disabled)
     })

     $("input[name='glasses']").on("change",function(){
         console.log(this)
         let disabled = this.value !== '1';

         lastCheckDate.flatpickr().input.disabled = disabled;

     })




     $('#eyeCanvas').on('mousedown', function () {
         drawing = true;
     });

     $('#eyeCanvas').on('mouseup mouseleave', function () {
         drawing = false;
         ctx.beginPath();
     });

     $('#eyeCanvas').on('mousemove', function (e) {
         if (!drawing) return;

         const rect = canvas.getBoundingClientRect();
         const x = e.originalEvent.clientX - rect.left;
         const y = e.originalEvent.clientY - rect.top;

         ctx.lineWidth = 2;
         ctx.lineCap = "round";
         ctx.strokeStyle = "#ff0000";

         ctx.lineTo(x, y);
         ctx.stroke();
         ctx.beginPath();
         ctx.moveTo(x, y);
     });

     $('#clearCanvas').on('click', function () {
         ctx.clearRect(0, 0, canvas.width, canvas.height);
         eyeBackground.src = "/assets/img/eyes_diagram_labeled.webp"

         drawEyeBackground();
     });

     // $('#visual_evaluation').on('submit', function (e) {
     //     const imageData = canvas.toDataURL("image/png");
     //     $('#eye_canvas_data').val(imageData);
     //     // El formulario continúa su envío normalmente
     // });

     // drawEyeBackground();

});


 function setEyesCanvas() {
     ctx = canvas.getContext("2d");

     eyeBackground.src = imageFromDb ?
         "data:image/webp;base64," + consulting.visual_evaluation.anomalies_image :
         "/assets/img/eyes_diagram_labeled.webp" // Nueva imagen con etiquetas
     eyeBackground.onload =function(event) {
         drawEyeBackground(this);
     }
 }
function drawEyeBackground(event) {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(event??eyeBackground, 0, 0, canvas.width, canvas.height);
}

function displayHealthInfo(display){

    display ?
        generalCheckInput.show()
        :generalCheckInput.hide();

}

function getJsonForm()
{
    let prescription = $("form#prescription").serializeArray()

    prescription.patient = consulting.patient;
    //consulting = $("form.consulting").serializeArray()
    //let postData = new FormData();
    //let json = JSON.stringify(consulting);
    //postData.append("consulting",consulting);
    $.ajax({
    method:"POST",
    url:"/prescription",
    data : prescriptions,
    dataType: "JSON",
    statusCode: {
        201:(xhr)=>{
            toastAlert("success","Graduación Guardada","Graduación Guardada con éxito");
        },
        500:(xhr)=>{}
    }

    }).done(consultation=>{
        console.log(consultation)
    });

}
function saveGeneralBackground()
{
    let gb = generalBackground.serializeArray();

    saveConsultationAjax("consultationgb",gb).done(consultation=>{})

}
function saveVisualBackground()
{
    let vb = visualBackground.serializeArray();
    saveConsultationAjax("consultationvb",vb).done(consultation=>{
    });
}
function saveVisualEvaluation()
{
    savePrescriptions();
    let ve = visualEvaluation.serializeArray();
    ve.push({name:"anomalies_image",value:getCanvasData()})
    saveConsultationAjax("consultationve",ve).done(consultation=>{})
}
function saveContactConsultation()
{
    let cl = contactsPrescription.serializeArray();
    saveConsultationAjax("consultationcl",cl).done(consultation=>{})
}

function savePrescriptions()
{
    let consultation = $("input.consultation-id").val();
    let prescriptions = inputsCurrentPrescription.serializeArray();
    prescriptions.push({name:"consultation",value:consultation});
    prescriptions.push({name:"patient",value:consulting.patient});

    saveConsultationAjax("prescription",prescriptions)

}
function saveConsultationAjax(controller,postData)
{
    postData.push(
        {name:"created_at",value:flatpickrDate.val()},
        {name:"attended_by",value:$("#select-doctor").val()}

    );
debugger
    return $.ajax({

        method:"POST",
        url:`/${controller}`,
        data :postData,
        dataType: "JSON",
        statusCode: getStatusCodeObject()
    }).done(response=>{
        if(controller !== "prescription") {
            let id =  response.consultation;
            $("input.consultation-id").val(id);
            $("#consultation-id-display").text(id);
            if (typeof consulting !== 'undefined') {
                consulting.id = id;
            }
        }
    })
}


function getCanvasData() {
    const canvas = document.getElementById('eyeCanvas');
    const tempCanvas = document.createElement('canvas');
    tempCanvas.width = canvas.width;
    tempCanvas.height = canvas.height;
    const tempCtx = tempCanvas.getContext('2d');

    tempCtx.drawImage(canvas, 0, 0);

    return tempCanvas.toDataURL('image/webp').split(',')[1];
}
function setFinalPrescription()
{
    let inputs = $("input[name^='prescription[total']");

    inputs.each((index,input)=>{
        let finalInputId = input.id.replace("total","final");
        $(`input[id=${finalInputId}]`).val(input.value);
    });

    debugger;
    $("#current-prescription-table").html(`
    <table id="last_rx_table" class=" mb-0 mt-2">
                <caption style="caption-side: top" > RX Final</caption>
                <thead>
                <tr>
                    <th>Esfera</th>
                    <th>Cilindro</th>
                    <th>Eje     </th>
                    <th>Adición</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-3"><input class="form-control form-control-sm" readonly value="${inputs[0].value}"></td>
                    <td class="col-3"><input class="form-control form-control-sm" readonly value="${inputs[1].value}"></td>
                    <td class="col-3"><input class="form-control form-control-sm" readonly value="${inputs[2].value}"></td>
                    <td class="col-3"><input class="form-control form-control-sm" readonly value="${inputs[3].value}"></td>
                </tr>
                <tr>
                    <td class="col-3"><input class="form-control form-control-sm" readonly value="${inputs[4].value}"></td>
                    <td class="col-3"><input class="form-control form-control-sm" readonly value="${inputs[5].value}"></td>
                    <td class="col-3"><input class="form-control form-control-sm" readonly value="${inputs[6].value}"></td>
                    <td class="col-3"><input class="form-control form-control-sm" readonly value="${inputs[7].value}"></td>
                </tr>
                </tbody>
            </table>`)


}
function saveLastPrescription()
{
    inputsLastPrescription.each((index,input)=>{
        if(input.type ==='number')
        {
            input.parentElement.textContent = input.value;
            $(input).hide();
        }
    })
    let postData = inputsLastPrescription.serializeArray()

    postData.push({name:"patient",value:consulting.patient});

    $.ajax({
        method:"POST",
        url:"/prescription",
        data : postData,
        dataType: "JSON",
        statusCode: getStatusCodeObject()
    }).done(consultation=>{
    })

}

function calculateAxis(axisInput)
{
   document.getElementById('calculated_'+axisInput.id).value = axisInput.value;

}

