
console.log('Patient detail JS');
let prescription = {};
const symptoms = {
    'fatigue':"fatiga",
    'burning':"ardor",
    'itching':"comezón",
    'photophobia':'fotofobia',
    'redness':'enrojecimiento',
    'blurry':"visión borrosa",
    'headache':'cefalea',
    'secretion':'secreción'
};

const blurry={
    "far":"Lejos",
    "close":"Cerca",
    "double":"Visión Doble"
};
const headache={
    "frontal":"Frontal",
    "occipital" : "Occipital",
    "parietal":"Parietal",
    "temporal":"Temporal"
}
const secretions ={
    'white' : "Blanco",
    'transparent': "Transparente",
    'yellow' : "Amarillo",
    'green' : 'Verde'

};
const chroma = {
    'normal': 'Normal',
    'red': 'Roja',
    'green': 'Verde',
    'blue': 'Azul'
}
const brock = {
    "x" : 'En la bola',
    'exo' : 'Antes de (exo)',
    'endo' : 'Despues de (endo)'
}
const bridge = {
    "fusion": "Fusion",
    "right" : "Derecha",
    "left" : "Izquierda",
};
const comments = $("#comments");
let selectedPrescriptionID;
let consultationComments = '';
let currentConsultation ;

$(function() {


    $("a[href='#']").on("click",function(e){
        e.preventDefault()
    })

    setTaxesCards();
    setMethodsOnLoad()
    $("input.person-phone").on("change",event=>{
        let phoneId = event.currentTarget.dataset.phoneId;
        let postData =[ {
            name : event.currentTarget.name,
            value : event.currentTarget.value

        }]
        $.ajax({
            method: "PATCH",
            url: `/phone/${phoneId}`,
            data: postData,
            dataType: "JSON",
        }).done(response=>{
            console.log(response)
        })

        console.log(event)
    })

    $("form#taxIdForm").off('submit').on("submit",function(e){
        e.preventDefault();
        let taxData = $(this).serializeArray();
        const taxId = $('#tax_id_input').val();
        console.log(taxData);
        $.ajax({
            method: taxId ? "PUT" : "POST",
            url: taxId ? `/persontax/${taxId}` : "/persontax",
            dataType: "JSON",
            data: taxData,
            statusCode: {
                200: function(response){
                    toastAlert('success','Información fiscal registrada','La información se registró correctamente');
                },
                500: function(response){
                    toastAlert('error','Error','Ocurrió un problema, por favor intenta nuevamente');
                }
            }
        }).done(function(taxInfo){
            console.log(taxInfo);
        }).then(()=>{location.reload()})
    });

    // updatePrescriptionInputs();

    $('input[type="radio"][name^="customRadioTemp-"]').on('change', function () {
        updatePrescriptionInputs();
        updateCurrentPrescription(this);
    });

    // Open modal to add a new standalone prescription
    $('#newPrescription').on('click', function (e) {
        const patientId = $(this).data('patient-id');
        const $modal = $('#newPrescriptionModal');
        $modal.data('patient-id', patientId);

        // Initialize flatpickr on the date field (only once)
        const $date = $('#prescription_created_at');
        if (!$date.hasClass('fp-attached')) {
            $date.flatpickr({
                dateFormat: 'Y-m-d',
                defaultDate: new Date(),
                locale: 'es'
            });
            $date.addClass('fp-attached');
        } else if (!$date.val()) {
            $date.val(flatpickr.formatDate(new Date(), 'Y-m-d'));
        }

        // Clear inputs
        $('#prescription-grid input').val('');

        const modalEl = document.getElementById('newPrescriptionModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        $("#savePrescriptionBtn").prop("disabled", false);

        modal.show();
    });

    // Open modal pre-filled from an existing prescription button in the consultations tab
    $(document).on('click', 'a[data-prescription]', function () {
        const $btn = $(this);
        const raw = $btn.attr('data-prescription');
        const existingDate = $btn.attr('data-created_at'); // Obtener la fecha existente
        let data;
        try {
            data = typeof raw === 'string' ? JSON.parse(raw) : raw;
        } catch (e) {
            console.error('Invalid prescription JSON on button:', e, raw);
            toastAlert && toastAlert('error', 'Error', 'No se pudo leer la receta para editar.');
            return;
        }

        const $modal = $('#newPrescriptionModal');
        // Ensure the patient id is set on modal using the page's newPrescription button
        const patientId = $('#newPrescription').data('patient-id');
        if (patientId) {
            $modal.data('patient-id', patientId);
        }

        // Initialize or set date
        const $date = $('#prescription_created_at');
        if (!$date.hasClass('fp-attached')) {
            $date.flatpickr({
                dateFormat: 'Y-m-d',
                defaultDate: existingDate ? new Date(existingDate) : new Date(), // Usar fecha existente si está disponible
                locale: 'es'
            });
            $date.addClass('fp-attached');
        }
        // Establecer la fecha existente de la prescripción en lugar de una nueva
        if (existingDate) {
            $date.val(existingDate);
        } else if (!$date.val()) {
            $date.val(flatpickr.formatDate(new Date(), 'Y-m-d'));
        }

        // Prefill inputs if data is present
        const r = (data && data.right) ? data.right : {};
        const l = (data && data.left) ? data.left : {};
        $('input[name="prescription[final][right][sphere]"]').val(r.sphere ?? '').attr('data-detail',data.right.id);
        $('input[name="prescription[final][right][cylinder]"]').val(r.cylinder ?? '').attr('data-detail',data.right.id);
        $('input[name="prescription[final][right][axis]"]').val(r.axis ?? '').attr('data-detail',data.right.id);
        $('input[name="prescription[final][right][addition]"]').val(r.addition ?? '').attr('data-detail',data.right.id);

        $('input[name="prescription[final][left][sphere]"]').val(l.sphere ?? '').attr('data-detail',data.left.id);
        $('input[name="prescription[final][left][cylinder]"]').val(l.cylinder ?? '').attr('data-detail',data.left.id);
        $('input[name="prescription[final][left][axis]"]').val(l.axis ?? '').attr('data-detail',data.left.id);
        $('input[name="prescription[final][left][addition]"]').val(l.addition ?? '').attr('data-detail',data.left.id);

        const modalEl = document.getElementById('newPrescriptionModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        $("#savePrescriptionBtn").prop("disabled", true);
        modal.show();
    });

    // Save standalone prescription or edited-from-list prescription (creates a new record)
    $(document).on('click', '#savePrescriptionBtn', function () {
        const $modal = $('#newPrescriptionModal');
        // Prefer patient id stored on modal; if missing, try to get it from the main New Prescription button
        let patientId = $modal.data('patient-id') || $('#newPrescription').data('patient-id');
        const createdAt = $('#prescription_created_at').val();

        // Build payload
        const payload = {
            patient: patientId,
            created_at: createdAt,

            prescription: {
                final: {
                    right: {
                        sphere: $('input[name="prescription[final][right][sphere]"]').val() || '',
                        cylinder: $('input[name="prescription[final][right][cylinder]"]').val() || '',
                        axis: $('input[name="prescription[final][right][axis]"]').val() || '',
                        addition: $('input[name="prescription[final][right][addition]"]').val() || ''
                    },
                    left: {
                        sphere: $('input[name="prescription[final][left][sphere]"]').val() || '',
                        cylinder: $('input[name="prescription[final][left][cylinder]"]').val() || '',
                        axis: $('input[name="prescription[final][left][axis]"]').val() || '',
                        addition: $('input[name="prescription[final][left][addition]"]').val() || ''
                    }
                }
            }
        };

        if (!payload.patient) {
            toastAlert('error', 'Falta paciente', 'No se encontró el paciente.');
            return;
        }
        if (!payload.created_at) {
            toastAlert('error', 'Falta fecha', 'Selecciona la fecha de la receta.');
            return;
        }

        $.ajax({
            method: 'POST',
            url: '/prescription',
            data: payload,
            dataType: 'json',
            statusCode: {
                201: function () {
                    toastAlert('success', 'Receta guardada', 'La receta se guardó correctamente.');
                },
                500: function (response) {
                    console.error(response);
                    toastAlert('error', 'Error', 'Ocurrió un problema al guardar.');
                }
            }
        }).done(function(){
            // Close modal and refresh to reflect new prescription
            const modalEl = document.getElementById('newPrescriptionModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();
        }).then(function(){
            // Simple approach: refresh the page to reload prescriptions list
            location.reload();
        });
    });

    $('input.prescription-input').on('change', function (e) {
        console.log(e);
        debugger;
        let name = e.currentTarget.id.split('_')[2];
        let value = e.currentTarget.value;
        let detail = e.currentTarget.dataset.detail;
        let postData = [{name: name, value: value}];
        // let consultation = e.currentTarget.dataset.consultation;
        toastAlert('info', 'Actualizando información', 'Por favor, espera unos momentos');
        updateDetails(postData, detail);
    });

    $("form#newPhoneForm").on("submit",function(e){
        e.preventDefault();
        let phoneData = $(this).serializeArray();
        saveNewPhone(phoneData);
    });
    
    $(window).on("unload",function() {
        URL.revokeObjectURL(imageUrl)
    });



    var modalScrollable = document.getElementById('modalScrollable')
    modalScrollable.addEventListener('show.bs.modal', function (event) {
        var modalBodyInput = modalScrollable.querySelector('.modal-body textarea')
        modalBodyInput.textContent = event.relatedTarget.dataset.bsComments
        consultationComments = event.relatedTarget.dataset.bsComments
        currentConsultation = event.relatedTarget.dataset.consultation


    })

    modalScrollable.addEventListener('hidden.bs.modal', function (event) {

        if( comments.val()!==consultationComments) {
           toastAlert('info', 'Actualizando comentarios', 'Por favor, espera unos momentos');
           updateComments(comments.val())
       }
    })


})
function updateComments(comments) {
    console.log("updating coments "+ currentConsultation );
    $.ajax({
        method: "PUT",
        url: `/consultation/${currentConsultation}`,
        data: {comments:comments},
        dataType: "JSON",
    }).done(function(response){
        location.reload()
    })


}
function updatePrescriptionInputs() {
    $('.prescription-input').prop('readonly', true);

    const $checkedRadio = $('input[type="radio"][name^="customRadioTemp-"]:checked');
    console.log($checkedRadio);

    if ($checkedRadio.length) {
        const prescriptionId = $checkedRadio.attr('id').replace('prescription-', 'prescriptionCard-');
        $('#' + prescriptionId).find('.prescription-input').prop('readonly', false);
        selectedPrescriptionID = $checkedRadio.attr('id').split('-')[1];
        prescription = prescriptions.find(obj => obj.id == selectedPrescriptionID);
    }
}
// function updateCurrentPrescription(radio) {
//     console.log(radio)
//     $.ajax({
//         method: 'PUT',
//         url: `/prescription/${consultation}/${detail}`,
//         data: {current:1 },
//         dataType: 'JSON'
//     }).done(function(response){
//         toastAlert('success', 'Información actualizada', 'La información se actualizó correctamente');
//     })
// }

function updateDetails(postData,detail) {
    $.ajax({
        method: 'PUT',
        url: `/prescription/${detail}`,
        data: postData,
        dataType: 'JSON'
    }).done(function(response){
        toastAlert('success', 'Información actualizada', 'La información se actualizó correctamente');
    })
}

function saveNewPhone(phoneData) {
    $.ajax({
        method: "POST",
        url: "/phone",
        dataType: "JSON",
        data: phoneData,
    }).done(function(phone){
        if (phone.id){
            toastAlert('success','Teléfono registrado','La información se registró correctamente');
        }else {
            toastAlert('error','Error','Ocurrió un problema, por favor intenta nuevamente');
        }
    }).then(()=>{location.reload()})
}

function deletePhone(phoneId,element) {
    element.parentElement.remove()
    $.ajax({
        method: "DELETE",
        url: `/phone/${phoneId}`,
        dataType: "JSON",
        statusCode:{
            200:xhr=> {
                toastAlert("success", "Telefono eliminado", "con éxito")

            },
            500:()=>toastAlert("error","Error","Contacte a soporte")
        }
    })
}

function getConsultation(idConsultation) {
    if(!idConsultation) return;
    $.get(`/consultation/${idConsultation}`).done(getConsultationTemplate)
}


function getConsultationTemplate(consultation){
    let gb = consultation.general_background;
    let vb = consultation.visual_background;
    let ve = consultation.visual_evaluation;
    console.log(gb,vb,ve)
    let img = ve.anomalies_image !== null   && ve.anomalies_image.length>0?
        URL.createObjectURL(base64ToBlob(ve.anomalies_image)) :
        "/assets/img/eyes_diagram_labeled.webp"
    const consultationTemplate = `
<div class="consultation-details card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Consulta #${consultation.id}</h5>
        <div class="consultation-meta">
            <small>Atendido por: ${consultation.attended_by}</small>
            <small class="ms-2">Fecha: ${new Date(consultation.created_at.date).toLocaleDateString()}</small>
        </div>
    </div>
    <div class="card-body">
        <!-- Antecedentes Generales -->
        <div class="section mb-4">
            <h5 class="section-title">Antecedentes Generales</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="health-status">
                        <p>
                            <strong>Estado de Salud:</strong> ${(gb?.healthy??false) ? 'Saludable' : 'Con padecimientos'}
                        </p>
                        <!-- Diabetes -->
                        ${gb.diabetes ? `
                        <div class="condition-details">
                            <p><strong>Diabetes:</strong> Sí</p>
                            <p><strong>Último nivel de glucosa:</strong> ${gb?.glucose_level}</p>
                            <p><strong>Fecha última medición:</strong> ${new Date(gb?.last_glucose_date.date).toLocaleDateString()}</p>
                        </div>
                        ` : ''}

                        <!-- Hipertensión -->
                        ${gb.hypertension ? `
                        <div class="condition-details">
                            <p><strong>Hipertensión:</strong> Sí</p>
                            <p><strong>Nivel de presión:</strong> ${gb?.pressure_level}</p>
                            <p><strong>Fecha última medición:</strong> ${new Date(gb?.last_blood_pressure_date.date).toLocaleDateString()}</p>
                        </div>
                        ` : ''}
                    </div>
                </div>

                <div class="col-md-6">
                    <p><strong>Historia Patológica Ocular:</strong> ${gb.ocular_pathological_history || 'No reportada'}</p>
                    <p><strong>Observaciones:</strong> ${gb.observations || 'Sin observaciones'}</p>
                </div>
            </div>
        </div>

        <!-- Antecedentes Visuales -->
        <div class="section mb-4">
            <h5 class="section-title">Antecedentes Visuales</h5>
            <div class="row g-3">
                <div class="col-3">
                    <p><strong>Uso de lentes:</strong> ${vb?.glasses ? 'Sí' : 'No'}</p>
                    ${vb?.last_check_date ? `<p><strong>Última revisión:</strong> ${new Date(vb.last_check_date).toLocaleDateString()}</p>` : ''}
                    <p><strong>Comentarios:</strong> ${vb?.vb_comments || 'Sin comentarios'}</p>
                </div>
                <div class="col-3">
                    <p>
                    <img src="${img}" alt="Anomalías" width="600" height="300">
                    </p>
                </div>

                <!-- Evaluación Visual -->

            </div>
        </div>

        <div class="section mb-4">
            <div class="row g-3">
                <div class="col-12">
                    <h5 class="section-title">Evaluación Visual</h5>
                    <h6 class="mt-3">Síntomas Reportados:</h6>
                    <div class="symptoms-grid row">
                        ${['fatigue', 'burning', 'itching', 'photophobia', 'redness']
                            .map(symptom => `
                            <div class="symptom-item col-lg-2 col-12">
                                <i class=" ${ve[symptom]??false ? 'mdi mdi-check-circle text-danger' : 'mdi mdi-code-brackets text-success'}"></i>
                                <span>${symptoms[symptom].charAt(0).toUpperCase() + symptoms[symptom].slice(1)} </span>
                            </div>
                        `).join('')}
                    </div>
                </div>
                <div class="col-12">
                    <h6 class="mt-3">Visión Borrosa:</h6>

                    <div class="symptoms-grid row">
                        ${Object.entries(blurry).map((item,value) => 
                            ` <div class="symptom-item col-lg-2 col-12">
                                <i class="${ve?.blurry?.includes(item[0]) ?
                                'mdi mdi-check-circle text-danger' :
                                'mdi mdi-code-brackets text-success'}  "></i>
                                <span>${item[1]}  </span>
                            </div>`).join('')}
                    </div>
                </div>
                <div class="col-12">
                    <h6 class="mt-3">Cefalea:</h6>

                    <div class="symptoms-grid row">
                        ${Object.entries(headache).map((item,value) => `

                            <div class="symptom-item col-lg-2 col-12">
                                <i class="${ve?.headache?.includes(item[0])  ?
                                    'mdi mdi-check-circle text-danger' :
                                        'mdi mdi-code-brackets text-success'}  "></i>
                                <span>${item[1]}  </span>
                            </div>`).join('')}
                    </div>
                </div>
                <div class="col-12">
                    <h6 class="mt-3">Secreción:</h6>
                     <div class="symptoms-grid row">
                     ${['white','transparent','yellow','green'].map((item,value) =>
                        `<div class="symptom-item col-lg-2 col-12">
                            <i class="${ ve?.secretion===item ?
                            'mdi mdi-check-circle text-danger' :
                            'mdi mdi-code-brackets text-success'} "></i>
                            <span>${secretions[item]}</span>
                        </div>`).join('')}   
                        
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-4">
                    <p><strong>Segmento Anterior:</strong> ${ve?.anterior_segment}</p>
                </div>
                <div class="col-4">
                    <p><strong>Cover Test:</strong> ${ve?.cover_test}</p>
                </div>
                <div class="col-4">
                    <p><strong>Segmento Anterior:</strong> ${ve?.posterior_segment}</p>
                </div>
            </div>
            <div class="row g-3">
                <!-- Pruebas Visuales -->
                <div class="col-lg-6">
                    <h6>Pruebas Realizadas</h6>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Visión Cromática</span>
                            <span>${chroma[ve?.chromatic_vision] || 'No realizado'}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Facilidad de Acomodación</span>
                            <span>${ve?.ease_accommodation } ciclos</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Cuerda de Brock</span>
                            <span>${brock[ve?.brock_string] }</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Estereotest</span>
                            <span>${ve?.stereotest || 'No realizado'}</span>
                        </li>
                    </ul>
                </div> <div class="col-lg-6">
                    <h6>Pruebas Realizadas</h6>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Puente de worth</span>
                            <span>${bridge[ve?.worth_bridge] || 'No realizado'}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Punto de convergencia rompimiento</span>
                            <span>${ve?.convergence_break } cm</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Punto de convergencia recuperación</span>
                            <span>${ve?.convergence_recover||'No realizado' } cm </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Rejilla de Amsler</span>
                            <span>${ve?.amsler_grid || 'No realizado'}</span>
                        </li>
                    </ul>
                </div>

                <!-- Agudeza Visual -->
                <div class="col-md-6">
                    <h6>Agudeza Visual</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Antes</th>
                                <th>Después</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Ojo Izquierdo</td>
                                <td>${ve.left_acuity_before || '-'}</td>
                                <td>${ve.left_acuity_after || '-'}</td>
                            </tr>
                            <tr>
                                <td>Ojo Derecho</td>
                                <td>${ve.right_acuity_before || '-'}</td>
                                <td>${ve.right_acuity_after || '-'}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



                <!-- Mediciones -->
                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <p><strong>Distancia Interpupilar:</strong> ${ve?.interpupilar_distance?.join('/') || 'No registrada'}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Capacidad Izquierda:</strong> ${ve?.left_capacity || 'No registrada'}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Capacidad Derecha:</strong> ${ve?.right_capacity || 'No registrada'}</p>
                        </div>
                    </div>
                </div>

                <!-- Comentarios -->
                <div class="col-12">
                    <p><strong>Comentarios de Evaluación:</strong> ${ve?.ve_comments || 'Sin comentarios'}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-footer text-end">
        <button type="button" class="btn btn-primary" onclick="exportToPDF(${consultation.id})">
            <i class="mdi mdi-file-pdf-outline me-1"></i>
            Exportar a PDF
        </button>
    </div>
</div>
`;

    $("#consultation-content").html(consultationTemplate);
}

    // Agregar esta función en tu archivo JavaScript
function exportToPDF(consultationId) {
    // Mostrar indicador de carga
    toastAlert('info', 'Generando PDF', 'Por favor espera...');

    // Configurar opciones de PDF
    const element = document.querySelector('.consultation-details');
    const opt = {
        margin: 1,
        filename: `consulta-${consultationId}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };

    // Generar PDF
    html2pdf().set(opt).from(element).save().then(() => {
        toastAlert('success', 'PDF generado', 'El documento se ha generado correctamente');
    }).catch(error => {
        toastAlert('error', 'Error', 'No se pudo generar el PDF');
        console.error('Error al generar PDF:', error);
    });
}


function base64ToBlob(base64Image) {
    if (!base64Image) return null;
    // Remover el prefijo de data URL si existe
    const base64WithoutPrefix = base64Image.replace(/^data:image\/(png|jpg|jpeg);base64,/, '');

    // Convertir base64 a array de bytes
    const byteCharacters = atob(base64WithoutPrefix);
    const byteArrays = [];

    for (let i = 0; i < byteCharacters.length; i++) {
    byteArrays.push(byteCharacters.charCodeAt(i));
    }

    // Crear Blob
    const byteArray = new Uint8Array(byteArrays);
    return new Blob([byteArray], { type: 'image/webp' });
}
// Limpiar URLs cuando se cierre/destruya el componente


function deleteConsultation(idConsultation) {
    $.ajax({
        method:"DELETE",
        url:`/prescription/${idConsultation}`,
        dataType:"JSON",
    }).done(function(response){
        console.log(response)
        location.reload();
    })
}

