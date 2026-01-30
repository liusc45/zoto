const flatpickrOptions = {

    altInput: true,
    altFormat: "j F Y",
    dateFormat: "Y-m-d",
    locale: "es",
    onChange: function(selectedDates, dateStr, instance) {
        console.log(instance)
        if(instance.input.id === 'modal-flatpickr-date') {
            let postData = {
                '_method': 'PATCH',
                dob: dateStr
            };
            editCustomer(postData);
        }
    },

}

function setMethodsOnLoad()
{
    $("#editCustomerForm").on("submit", event=>{
        event.preventDefault();
    })
    $("#editCustomerForm input, #editCustomerForm textarea").on("change",event=>{
        if(event.currentTarget.name == 'dob')return false;
        const postData = {};
        postData[event.currentTarget.name]=event.currentTarget.value;
        editCustomer(postData);
    });


    $("#person-dob,#modal-flatpickr-date").flatpickr(flatpickrOptions);

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


    console.log("Events listening");
}

function openEditCustomerModal(patient)
{
    console.log(patient);
    editPerson = patient.person
    document.getElementById("modalEditCustomerID").value = patient.id;
    document.getElementById("modalEditCustomerCard").value = patient.card_id;
    document.getElementById("modalEditCustomerName").value = patient.name;
    document.getElementById("modalEditCustomerLastName").value = patient.last_name;
    document.getElementById("modalEditCustomerPhone").value = patient.main_phone;
    document.getElementById("modalEditCustomerEmail").value = patient.email??'';
    if(patient.dob != null) {
        flatpickr("#modal-flatpickr-date",flatpickrOptions).setDate(patient.dob.date)

    }else {
        // flatpickr("#modal-flatpickr-date",flatpickrOptions).clear();
    }
    $("#modal-street").val(patient.street);
    $("#modal-city").val(patient.city);
    $("#modal-state").val(patient.state);
    $("#modal-postal_code").val(patient.postal_code);

}

function editCustomer(postData)
{
    $.ajax({
        method: 'PATCH',
        url: '/person/'+editPerson,
        data: postData,
        dataType: 'JSON',
        statusCode: {
            400: function(xhr){

                toastAlert('error','Error',"Verifique sus datos y vuelva a intentarlo");
            }
        }
    }).done(function(response){
        if(response){
            toastAlert('success','Cliente actualizado','El cliente se actualizó correctamente');
            dt_basic.ajax.reload();
            location.pathname.split("/")[1]==='paciente'?location.reload():false;

        } else{
            toastAlert('error','Error','Ocurrió un problema, por favor intenta nuevamente');
        }
    });
}

function deleteCustomer(customer)
{
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No serás capaz de recuperar este cliente",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, borrar cliente!',
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
                url: '/customer/'+customer.id,
                data: { '_method': 'DELETE'},
                dataType: 'JSON'
            }).done(function(response){
                Swal.fire({
                    icon: 'success',
                    title: '¡Cliente borrado!',
                    customClass: {
                        confirmButton: 'btn btn-success waves-effect'
                    }
                });
                dt_basic.ajax.reload();
            })
        }
    });
}
function setTaxesCards()
{

    const collapseElementList = [].slice.call(document.querySelectorAll('.card-collapsible'));
    //const expandElementList = [].slice.call(document.querySelectorAll('.card-expand'));
    //const closeElementList = [].slice.call(document.querySelectorAll('.card-close'));

    //  let cardDnD = document.getElementById('sortable-4');

    // Collapsible card
    // --------------------------------------------------------------------
    if (collapseElementList) {
        collapseElementList.map(function (collapseElement) {
            collapseElement.addEventListener('click', event => {
                event.preventDefault();
                // Collapse the element
                new bootstrap.Collapse(collapseElement.closest('.card').querySelector('.collapse'));
                // Toggle collapsed class in `.card-header` element
                collapseElement.closest('.card-header').classList.toggle('collapsed');
                // Toggle class mdi-chevron-down & mdi-chevron-up
                Helpers._toggleClass(collapseElement.firstElementChild, 'mdi-chevron-down', 'mdi-chevron-up');
            });
        });
    }
}
function editTaxInfo(taxInfo) {


    // Llenar el formulario con los datos existentes
    $('#basic-default-nickname').val(taxInfo.nickname);
    $('#basic-default-rfc').val(taxInfo.rfc);
    $('#basic-default-tax_name').val(taxInfo.tax_name);
    $('#basic-default-tax_address').val(taxInfo.tax_address);
    $('#basic-default-postal_code').val(taxInfo.postal_code);
    $('#select2Basic').val(taxInfo.tax_regime);
    $('#tax_id_input').val(taxInfo.id);
}

function deleteTaxInfo(taxId) {
    if (!confirm('¿Estás seguro de eliminar esta información fiscal?')) return;

    $.ajax({
        method: "DELETE",
        url: `/persontax/${taxId}`,
        dataType: "JSON",
        statusCode: {
            200: function() {
                toastAlert('success', 'Eliminado', 'Información fiscal eliminada correctamente');
                location.reload();
            },
            500: function() {
                toastAlert('error', 'Error', 'No se pudo eliminar la información fiscal');
            }
        }
    });
}
function clearForm()
{
    $("#taxIdForm")[0].reset();
    $("#tax_id_input").val(null);
}
