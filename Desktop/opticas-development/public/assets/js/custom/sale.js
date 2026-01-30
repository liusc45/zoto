saleBlock();
console.log('Sales JS loaded');
const saleForm = $("#sale-form"),
    saleBtn =  $("#saleBtn"),
    itemSelector = $('.article-selector'),
    lenses = $('#allLenses'),
    cashback = $("#cashback"),
    moneyReceived = $("#cashreceived"),
    cashToPay = $("#cashToPay"),
    ticketNumber = $("#ticketNumber"),
    customerSelector = $("#allCustomers"),
    paymentsList = $("#payments"),
    discountValue = $('#discountValue'),
    totalToSale =  $('#total'),
    itemsList = $("#itemsList"),
    saleType = $("#saleType"),
    deposit = $('#deposit'),
    toPay = $("#topay"),
    inputPayment = $(".payment"),
    params = new URLSearchParams(window.location.search),
    barcodeInput = $("#barcode-input"),
    filterLens = $('.filter-lens'),
    quoteBtn = $('#quoteBtn'),
    applyDiscountBtn = $('#applyDiscountBtn'),
    removeDiscountBtn = $('#removeDiscountBtn'),
    accountSelect = $("#accountSelect"),
    modalitiesPicker = $("#modalities")
//    payRemain = $("#remain-payment");


let itemsFromApi,
    indexedPatients,
    indexedArticles,
    indexedLenses,
    customers,
    customersLoaded  = false,
    itemsOrder = 1 ,
    inventoryLoaded = false,
    discounts = {},
    paymentType = $("#paymentMethod"),
    paymentComplete = false,
    payments = [],
    subtotal = 0,
    sale = {
        store:store.id ,
        customer :null,
        customers :[],
        payment_type :paymentType.val(),
        type: 'cash',
        amount:0.0,
        payment : [],
        consultations : []
    },
    patients_number = 0,
    cart = {},
    storeStock,
    itemPrices,
    cartDiscount ={
        concept: "mostrador",
        percentage: 0,
        amount: 0.0
    },
    amountYbtx = 0,
    currentCustomer = 0,
    // Promociones
    activePromotions = [],
    appliedPromotions = { totalDiscount: 0, applied: [] };

var articlesLoaded, lensesLoaded  = false;



$(function () {

    // Cargar promociones activas para POS
    loadActivePromotions().then(() => recalcPromotions());

    $(document).on("keyup", function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    })

    discounts.general = {
        concept: "general",
        percentage: 0,
        amount: 0.0
    };

    saleForm.on("submit", function (e) {
        return false;
    });

    fillArticles();
    fillCustomers();
    lensDatatable(dt_basic_table);
    //fillGlasses();
    getGeneralInventory()
    itemSelector.on('select2:select',addToCart);
    barcodeInput.on("keypress",addToCart);

   //customerSelector.on('select2:select',  customerDetail);
    saleType.on('change', function (e) {
        sale.type=this.value;
        resetPayments();
        saleBtn.prop('disabled', true);

        switch (this.value) {
            case 'cash':
                saleBtn.show()
                //calculatePayment();
                toggleSaleBtn();
                quoteBtn.addClass('d-none');
                deposit.val(null).parent().addClass('d-none');

                break;
            case 'aside':
                deposit.parent().removeClass('d-none');
                saleBtn.show()
                quoteBtn.addClass('d-none');
                break;
            case 'credit':
                deposit.parent().removeClass('d-none');
               toggleSaleBtn(true);
                quoteBtn.addClass('d-none');
                break;
            case 'quote':
                saleBtn.hide()
                deposit.val(null).parent().addClass('d-none');
                quoteBtn.removeClass('d-none');
                break;

        }
    });


    moneyReceived
        .on("keyup",calculateCashback)
        .on("dblclick",clearPayment);

    saleBtn.on("click",checkoutCart);

    //Ticker number for card method payment
    paymentType.on("change",function(e) {
        // hide todos
        // show por clase.
        clearPayment();
        inputPayment.addClass("d-none");
        $("."+this.value).removeClass("d-none");
        // sale.setPaymentType(this.value);
        toggleSaleBtn();
    });

    accountSelect.on("change",function(e){
        account = this.value;
        setCardModalities(account)
    });

    ticketNumber.on("keyup",function(){
        this.value.length >3 ?toggleSaleBtn():''
    })
    deposit.on("change", function(){
        sale.payment.partial = this.value;
       // updateToPay()
    })

    //Quick Save client
    $(" #customerFormSidebar" ).on("submit",function(e){
        e.preventDefault();
        customersLoaded = false;
        let customerData = $(this).serializeArray();

        $.ajax({
            method: "POST",
            url: "/patient",
            dataType: "JSON",
            data: customerData,
        }).done(function(client){
            if(client.id != null){
                toastAlert('success','Cliente registrado','El cliente se guardo exitosamente');
                $('#customerFormSidebar')[0].reset();
                $('#userAddress').text(`${client.address}`);
                $('#shipmentSection').removeClass('d-none');
                $('#closeSidebar').trigger('click')
                fillCustomers()
            }else{
                toastAlert('error','Error','Ocurrió un problema al guardar');
            }
        });
    });


    $('#frameModal').on('shown.bs.modal', function (event) {
       let patient = event.relatedTarget.dataset.patient;
        $("#allArticlesModal").data("patient",JSON.parse(patient));
    })


    filterLens
        .each(function () {
        var $this = $(this);
        // select2Focus($this);
        let options = {
            placeholder: 'Seleccione un artículo',
            allowClear:false,
        };
        $this.wrap('<div class="position-relative"></div>');
        options= {...options, dropdownParent : $this.parent()}

        $this.select2(options);
    })
        .on('select2:select', function (e) {
        filterColumn(e.params.data.text);
    });

    // --- Admin PIN to authorize discount ---
    applyDiscountBtn.off('click._admin_pin').on('click._admin_pin', async function (e) {
        e.preventDefault();
        // Require a discount value before asking for PIN
        const discountPercent = parseFloat(discountValue.val() || '0');
        if (isNaN(discountPercent) || discountPercent <= 0) {
            toastAlert('warning', 'Sin descuento', 'Ingresa un porcentaje de descuento antes de solicitar autorización.');
            return;
        }

        try {
            const pin = await requestAdminPin();
            if (!pin) return; // canceled

            validateAdminPin(pin)
                .done(function (resp) {
                    if (resp && resp.valid) {
                        // Autorizado: aplicar el descuento normalmente
                        getDiscounts(true);
                        toastAlert('success', 'PIN correcto', 'Aplicando descuento.');

                    } else {
                        toastAlert('error', 'PIN incorrecto', 'No estás autorizado para aplicar descuentos.');
                    }
                })
                .fail(function () {
                    toastAlert('error', 'Validación fallida', 'No se pudo validar el PIN de administrador.');
                    toastAlert('error', 'PIN incorrecto', 'No estás autorizado para aplicar descuentos.');

                });
        } catch (err) {
            console.error('Error solicitando PIN:', err);
        }
    });

});


function setCardModalities(account)
{
    $cards = accounts[account];

    html = '';
    modalitiesPicker.empty();
    modalitiesPicker.selectpicker('destroy');
    for(let account of $cards)
    {
        html +=`<option value="${account.id}">${account.alias}</option> `

    }
    modalitiesPicker.html('');
    modalitiesPicker.html(html)
    modalitiesPicker.selectpicker();


    //modalitiesPicker.
}

/**
 * Muestra un modal para capturar el PIN de administrador y devuelve una Promise
 * que resuelve con el PIN (string) o null si el usuario cancela.
 */
function requestAdminPin() {
    return new Promise(function (resolve) {
        if ($('#adminPinModal').length === 0) {
            $('body').append(`
<div class="modal fade" id="adminPinModal" tabindex="-1" aria-labelledby="adminPinLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adminPinLabel">Autorización de descuento</h5>
        <button type="button" class="btn-close" id="adminPinClose" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="adminPinInput" class="form-label">Ingresa el PIN de administrador</label>
          <input type="password" class="form-control" id="adminPinInput" autocomplete="off" />
          <div class="form-text">Este paso es necesario para aplicar descuentos.</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" id="adminPinCancel" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="adminPinConfirm">Autorizar</button>
      </div>
    </div>
  </div>
</div>`);
        }

        var $modal = $('#adminPinModal');
        var $input = $('#adminPinInput');

        function done(value) {
            $modal.modal('hide');
            resolve(value);
            setTimeout(function(){ $input.val(''); }, 150);
        }

        $modal.off('shown.bs.modal._pin').on('shown.bs.modal._pin', function () {
            $input.trigger('focus');
        });

        $('#adminPinConfirm').off('click._pin').on('click._pin', function () {
            var val = ($input.val() || '').trim();
            if (!val) {
                toastAlert('warning', 'PIN vacío', 'Ingresa el PIN para continuar.');
                return;
            }
            done(val);
        });

        $('#adminPinCancel, #adminPinClose').off('click._pin').on('click._pin', function () {
            done(null);
        });

        $input.off('keypress._pin').on('keypress._pin', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                $('#adminPinConfirm').trigger('click');
            }
        });

        $modal.modal('show');
    });
}

/**
 * Envía el PIN al servidor para validar permisos de descuento.
 * Debe responder { valid: true|false }.
 */
function validateAdminPin(pin) {
    return $.ajax({
        method: 'POST',
        url: '/pin/auth',
        dataType: 'json',
        data: { pin: pin }
    });
}
function addToCart(event)
{
    debugger

    if(currentCustomer===0)
    {
        addCartCustomer(null)
        sale.customer = null;
    }
    if(event && event.key ==="Enter")
    {
        event.preventDefault();
    }

    let itemID =getItemId(event);

    clearInput();

    let inventory = getStock(itemID);

    if (undefined === itemID || inventory.stock === 0) {
        toastAlert('error', 'Artículo sin inventario', 'No es posible agregar más artículos.');
        return false
    }
    if(existsInCart(itemID))  {
        cart[currentCustomer].items[itemID].qty++;
        $(`input[id^='input-${itemID}']`).val(cart[currentCustomer].items[itemID].qty)
        updateSubtotal(cart);
        updateItemsQty();
        calculateTotal();
        clearInput(this)
        return false;
    }

    let currentItem = indexedArticles[itemID];
    let currentPrice = getPriceByItem(itemID)??currentItem.price;

    clearInput(this)


    if (cart[currentCustomer].items === undefined) {
        cart[currentCustomer].items = {};
    }
    cart[currentCustomer].items[itemID] = currentItem;
    cart[currentCustomer].items[itemID].qty = 1;
    cart[currentCustomer].items[itemID].unit_price = currentPrice;
    cart[currentCustomer].items[itemID].final_price = currentPrice;
    cart[currentCustomer].items[itemID].lens_side = isLensMaterial(currentItem) ? 'pair' : null;
    cart[currentCustomer].items[itemID].is_half = false;

    $(`#item-patient-${cart[currentCustomer].identifier}`).append(getArticleCard(cart[currentCustomer].items[itemID],inventory,itemID));


    if(isQuote()){

        if( typeof inQuote(currentItem) ==='object'){
            cart[itemBatch].qty  = current.qty;
        }
    }

    updateSubtotal(cart);
    itemsOrder++;
    updateItemsQty();
    moneyReceived.trigger("keyup");
    calculateTotal();
    // Recalcular promociones al agregar
    recalcPromotions();
}


function addCartCustomer(patient = null,consultation = null)
{
    if(customerInCart(patient))
    {
        toastAlert('error','Cliente ya agregado','El cliente ya se encuentra agregado.');
        return false;
    }


    sale.consultations.push(consultation);
    currentCustomer = currentCustomer===null ? 0:++currentCustomer;
    cart[currentCustomer] = patient?? {id:null, name:"Público en General" ,last_name:''};

    patients_number++

    let identifier =   patient !==null ? [patient.id,patient.person,patient.original_id].join("-") :   "0-0-0";
    cart[currentCustomer].identifier = identifier;

    itemsList.append(getPatientRow(patient??cart[currentCustomer],identifier));

}
function customerInCart(patient)
{

    return undefined !==Object.values(cart).find(item => {
        return item.id === patient.id;
    })
}

function existsInCart(itemID)
{
  return   cart[currentCustomer]?.items!== undefined? cart[currentCustomer]?.items[itemID] !== undefined : false;
}
function getPriceByItem(itemID)
{
    let today = dayjs();
    let found;
    let prices = itemPrices[itemID]?.prices ?? [];

    if(prices.length>1)
    {
        found = prices.find(price => {
            let inDate =  today.isAfter(dayjs(price.starts_at))

            return price.type ==='promotion' && inDate
        });
    }
    return (typeof found) === 'object' ? found.amount : null;
}

function getItemId(event)
{
    let lens = event.type==="click"?JSON.parse(event.currentTarget.dataset?.lens): {id:null};
    let item = {
        "click" :lens.item,
        "keypress": getItemByBarcode(event.currentTarget.value),
        "select2:select":event.params?.data.id,
     }
     return item[event.type]

}

function getItemByBarcode(barcode){

    let found =  indexedArticles.find(article => {
        if (typeof article === 'object') {
            if (article.barcode === barcode) {
                return article.barcode
            }
        }
    });
    return found?.id;

}
// on document loaded.

function clearInput(ele)
{
    $(ele).val(null).trigger("change");
}



function getPatientRow(patient,identifier)
{
   // let identifier = [patient.id,patient.person,patient.original_id].join("-");

    let prescriptionHtml = '';

    if(patient.id !=null && patient.id !== 0) {

        getPrescription(patient.id).done(prescription => {
            cart[currentCustomer].prescription = prescription.id;
            cart[currentCustomer].consultation = prescription.consultation;
            prescriptionHtml = `
                <div class="col-md-6">
                  <div class="card card-action mb-4">
                    <div class="card-header">
                      <div class="card-action-title">
                      Graduación
                        <a href="javascript:void(0);"
                           onclick="selectPrescription(${patient.id},false)"
                           data-bs-toggle="offcanvas"
                           data-bs-target="#lastPatients">
                        <i class="tf-icons mdi mdi-rotate-left"></i>
                        </a>
                      </div>
                      <div class="card-action-element">
                        <ul class="list-inline mb-0">
                          <li class="list-inline-item">
                            <a href="javascript:void(0);" id="prescription-${patient.id}" class="card-collapsible">
                                <i class="tf-icons mdi mdi-chevron-up"></i>
                            </a>
                            
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="collapse show" style="">
                      <div class="card-body" id="body-prescription-${patient.id}">
                      ${getPrescriptionHtml(prescription)}
                      </div>
                    </div>
                  </div>
                </div>
       `
        });
    }

    return `<tr id="row-${identifier}">
                <td>
                    <div class="col-md mb-md-0 mb-2">
                          <div class="form-check custom-option custom-option-basic checked">
                            <label class="form-check-label custom-option-content" for="${identifier}">
                              <input name="customRadioTemp-1" class="form-check-input" type="radio" value="${currentCustomer}" id="${identifier}" onchange="currentCustomer=this.value" checked="">
                              <span class="custom-option-header">
                                <span class="h6 mb-0">${patient.name}&nbsp;${patient.last_name}</span>
                                <span>${patient.id}</span>
                                <span><a onclick="unCartCustomer(${currentCustomer},'${identifier}')"><i class="mdi mdi-trash-can-outline mdi-24px"></i> </a></span>
                              </span>
                              <span class="custom-option-body">
                                <table id="item-patient-${identifier}"></table>
                              </span>
                            </label>
                            ${prescriptionHtml}
                          </div>
                    </div>
                </td>
            </tr>`


}
function getArticleCard(item,stock)
{


    //let stock = getStock(item.id);
    let identifier = item.id+"-"+itemsOrder;

   // const image = item.pictures?.length > 0 ? item.pictures[0] : 'not-found.jpg';
    let itemQty = 1;

    if(isQuote()){
        let current = inQuote(item)
        if( typeof current ==='object'){
             itemQty = current.qty;
        }
    }

    return `
<tr id="${item.id}" class="align-middle">

    <!-- Cantidad -->
    <td class="text-center" style="width:60px;">
        <input
            id="input-${item.id}-${itemsOrder}"
            type="number"
            class="form-control form-control-sm text-center"
            value="1"
            readonly />
    </td>

    <!-- Producto -->
    <td>
        <div class="d-flex flex-column">

            <!-- Nombre -->
            <span class="fw-semibold">
                ${item.key ?? item.name}
            </span>

            <!-- Fecha de caducidad -->
            ${stock.expiration_date ? `
                <small class="text-muted">
                    Caducidad: ${stock.expiration_date}
                </small>
            ` : ''}

            <!-- Selector solo si aplica -->
            ${isLensMaterial(item) ? `
                <div class="mt-1" style="max-width:160px;">
                    <select
                        class="form-select form-select-sm"
                        onchange="setLensSide(${item.id}, this.value, ${currentCustomer})">
                        <option value="pair">Par</option>
                        <option value="right">Derecha</option>
                        <option value="left">Izquierda</option>
                    </select>
                </div>
            ` : `
                <small class="fst-italic text-muted mt-1">
                    Pieza completa
                </small>
            `}
        </div>
    </td>

    <!-- Precio -->
    <td class="text-end fw-semibold" style="width:120px;"
        id="subtotalArticle-${item.id}-${itemsOrder}">
        ${new Intl.NumberFormat('es-MX', {
        style: "currency",
        currency: 'MXN'
    }).format(item.unit_price)}
    </td>

    <!-- Acción -->
    <td class="text-center" style="width:40px;">
        <a class="text-danger" style="cursor:pointer"
           onclick='removeItemFromCart(${JSON.stringify(item)})'>
            <i class="mdi mdi-delete-outline mdi-18px"></i>
        </a>
    </td>

</tr>
`;
}

function getStock(item)
{
    return undefined === storeStock[item] ? false:storeStock[item];
}
// function imageModalData(image)
// {
//     const imageElement = document.getElementById('imageModal');
//     imageElement.src = '/photo/'+image;
// }


function updateQty(item,input,stock,selectorId,indexCart)
{
    if (cart[indexCart]?.items[item.id]?.is_half) {
        input.value = 1;
        return;
    }

    let qtyInt = parseInt(input.value);
    if(stock<qtyInt){
        toastAlert("error","Fuera de stock", `Cantidad máxima  ${stock}.`);
        input.value= stock
        qtyInt = stock;

        $("#"+selectorId).text(0);
        cart[indexCart].items[item.id].qty = stock;

    }
    let currentPrice = getPriceByItem(item.id)??item.price;
    let articleTotal =  currentPrice * qtyInt;
    let articleTotalFormated = new Intl.NumberFormat('es-MX', {style:"currency", currency:'MXN'}).format(articleTotal);
    $('#'+selectorId).text(articleTotalFormated);
    cart[indexCart].items[item.id].qty = qtyInt;
    updateItemsQty();
    updateFinalPrice(item,indexCart);
}

function updateItemsQty()
{


    let itemsQty =0;

    Object.values(cart).forEach(patient => {
        if(typeof patient.items === 'object')
        {
            itemsQty= Object.values(patient.items)
                .reduce(
                    (accumulator, item) => (accumulator + item.qty)
                    , itemsQty
                );
        }
    })
    $("#items-qty").text(itemsQty);
    sale.items= itemsQty;
}
function removeItemFromCart(item)
{
    delete cart[currentCustomer].items[item.id];
    $( "#"+item.id)
        .fadeOut( "slow")
        .remove()
   // Reflect.deleteProperty(cart,item.batch);

    if(paymentType.val()==="cash")
    {
        clearPayment();
    }


    updateItemsQty();
    updateSubtotal(cart)
    calculateTotal()
    // Recalcular promociones al remover
    recalcPromotions();
}

function unCartCustomer(index,identifier)
{
   delete cart[index];
   $("#row-"+identifier).remove();
   updateSubtotal(cart);
   calculateTotal();
}


function updateFinalPrice(item,indexCart)
{
    let unitPrice = getPriceByItem(item.id)??item.price;
    cart[indexCart].items[item.id].final_price =unitPrice * cart[indexCart].items[item.id].qty;
    cart[indexCart].items[item.id].unit_price = unitPrice

    updateSubtotal(cart);
    calculateTotal();
    // Recalcular promociones al eliminar
    recalcPromotions();
}

function updateSubtotal(cart)
{
    let initialValue = 0;
    let arrayCart = Object.values(cart);

    if(arrayCart.length === 0)
    {
        subtotal = 0;
        currentCustomer = 0;
    }
    //let subtotal = 0;
    arrayCart.forEach(patient => {
        if(typeof patient.items === 'object')
        {
            subtotal = Object.values(patient.items)
                .reduce(
                    (accumulator, item) => (accumulator + item.final_price)
                , initialValue
            );
            initialValue= subtotal;
        }else{
            subtotal = 0;
        }

    })

    sale.amount = Number(subtotal.toFixed(2));
    //calcularDescuentos()
    $('#subtotal').text(formatMoney(subtotal));
}
function getDiscounts(displayAlert)
{
    //let ybtx = getybtxDiscount();
    let generalAmount = subtotal ;
    let finalPrice;
    applyDiscountBtn.addClass('d-none');
    $('#removeDiscountBtn').removeClass('d-none');
    if (undefined === discountValue.val()) {
        finalPrice = parseFloat(subtotal).toFixed(2);
    } else {
        let discountPercent = parseFloat(discountValue.val());
        discountValue.val('0').prop('disabled', true);
        let currentDiscount = {
            concept: "mostrador",
            percentage: discountPercent,
            amount: parseFloat(((discountPercent / 100) * generalAmount).toFixed(2))
        };
        discounts['general'] =(currentDiscount);
        cartDiscount = {...currentDiscount};
        if (displayAlert) {
            toastAlert('info', 'Descuento aplicado', 'El descuento se aplicó correctamente');
            let discountAmount = parseFloat(((discountPercent / 100) * generalAmount).toFixed(2));
            $('#discount').text(formatMoney(discountAmount));
            $('#otherDiscount').html(`
                <div class="d-flex justify-content-between align-items-center my-2">
                    <div>
                        <span class="fw-bolder text-heading">
                            Descuento Adicional <br>
                        </span>
                    </div>
                    <span class="text-end fw-bolder text-heading">
                        <span>${formatMoney(discountAmount)}</span> M.N.
                    </span>
                </div>
            `);
        }

    }
    calculateTotal();
}

function removeDiscount()
{
    getDiscounts();
    applyDiscountBtn.removeClass('d-none');
    $('#removeDiscountBtn').addClass('d-none');
    discountValue.prop('disabled', false);
    $('#otherDiscount').html('');
    //delete discounts['general'];
    setYbtxDiscount();
    calculateTotal();
}

function setYbtxDiscount()
{
    let html = '';
    let percentage = 0;
    //descuento Ybtx
    let countAmount = Object.values(cart).reduce((acc,item)=>{
        if(item.categoryName === "Yerbatex"){
            return acc+(item.unit_price*item.qty)
        }
        else{
            return acc;
        }
    },0);

    amountYbtx = countAmount;
    switch(true) {
        case (countAmount >= 5000):
            percentage = .35;
            break;
        case(countAmount >= 3000 && countAmount <= 4999):
            percentage = .30;
            break;

        case (countAmount > 1200 && countAmount < 3000):
            percentage = .20;
            break;

    }
    if(percentage > 0){
        let discountAmount = countAmount*percentage;
        discounts['yerbatex']= {
            concept : "yerbatex",
            percentage : percentage*100,
            amount : discountAmount ,
        };


//        subtotal = (subtotal- countAmount) + finalAmount;
       html =`
            <div id="discount-yerbatex" class="d-flex justify-content-between align-items-center my-2">
                <div>
                    <span class="fw-bolder text-heading">
                        Descuento Yerbatex <br> <small>(${percentage*100}% aplicado)</small>
                    </span>
                </div>
                <span class="text-end fw-bolder text-heading">
                    <span id="">${formatMoney(discountAmount)}</span> M.N.
                </span>
            </div>
        `;

    }else{
        discounts['yerbatex']= {
            concept : "yerbatex",
            percentage : 0,
            amount : 0 ,
        };
    }

    $("#YBTXdiscount").html( html);

}

function checkDiscounts()
{
    let finalAmount;

    finalAmount =parseFloat(( subtotal- discounts.general.amount).toFixed(2));

    return finalAmount

}
function calculateTotal(displayAlert = false)
{
    // Base: aplica descuentos manuales existentes
    let base = checkDiscounts();
    // Resta descuentos por promociones consolidadas
    const promoDiscount = Number((appliedPromotions?.totalDiscount || 0));
    let finalPrice = Math.max(0, Number((base - promoDiscount).toFixed(2)));

    sale.amount = finalPrice;
    moneyReceived.trigger("keyup");
    updateToPay();
    updateTotal(parseFloat(finalPrice).toFixed(2));
    toggleSaleBtn()
}
function updateTotal(total)
{
    totalToSale.text(formatMoney(total));
    cashToPay.val(total.replace(",",""));

    if(total ==="0")

    {
        moneyReceived.val(null);
        cashback.val(null);
    }
}

function setLensSide(itemId, side, indexCart)
{
    const item = cart[indexCart]?.items[itemId];
    if (!item) return;

    // 🔒 Validación dura
    if (!isLensMaterial(item)) {
        item.lens_side = 'pair';
        item.is_half = false;
        return;
    }

    item.lens_side = side;
    item.is_half = side !== 'pair';

    const basePrice = getPriceByItem(itemId) ?? item.price;

    if (item.is_half) {
        item.unit_price = Number((basePrice / 2).toFixed(2));
        item.qty = 1;
    } else {
        item.unit_price = basePrice;
        item.qty = 1;
    }

    item.final_price = item.unit_price;

    updateSubtotal(cart);
    recalcPromotions();
    calculateTotal();
}
// ===================== PROMOCIONES (POS) =====================
async function loadActivePromotions() {
    try {
        const res = await fetch('/promotion/active?channel=store', { headers: { 'Accept': 'application/json' } });
        const json = await res.json();
        activePromotions = Array.isArray(json.data) ? json.data : [];
    } catch (e) {
        console.warn('Promociones activas no disponibles', e);
        activePromotions = [];
    }
}

function buildContextFromCart() {
    const patients = Object.values(cart || {});
    // Colapsar todos los items de todos los pacientes del carrito
    const items = patients.flatMap(p => Object.values(p.items || {}));
    const subtotalLocal = items.reduce((acc, it) => acc + (Number(it.unit_price || it.price || 0) * Number(it.qty || it.quantity || 1)), 0);
    const quantity = items.reduce((acc, it) => acc + Number(it.qty || it.quantity || 1), 0);

    return {
        amount: Number(subtotalLocal.toFixed(2)),
        quantity,
        unit_price: quantity > 0 ? Number((subtotalLocal / quantity).toFixed(2)) : 0,
        channel: 'store',
        customer_id: sale.customer || null,
        customer_group: sale.customer_group || null,
        items: items.map(it => ({
            item_id: it.id,
            product_id: it.product_id || it.id,
            category_id: it.category_id || null,
            quantity: Number(it.qty || it.quantity || 1),
            unit_price: Number(it.unit_price || it.price || 0)
        })),
        shipping_cost: 0
    };
}

async function previewPromotion(promoId, context) {
    const form = new URLSearchParams();
    form.set('promotion_id', String(promoId));
    form.set('amount', String(context.amount || 0));
    form.set('quantity', String(context.quantity || 0));
    form.set('unit_price', String(context.unit_price || 0));
    form.set('channel', context.channel || 'store');
    if (context.customer_id) form.set('customer_id', context.customer_id);
    if (context.customer_group) form.set('customer_group', context.customer_group);
    if (Array.isArray(context.items)) form.set('items', JSON.stringify(context.items));
    if (context.shipping_cost != null) form.set('shipping_cost', String(context.shipping_cost));

    const res = await fetch('/promotion/preview', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
        body: form.toString()
    });
    if (!res.ok) throw new Error('preview failed');
    return res.json(); // { discount, meta }
}

function consolidatePromotions(previews) {
    const combinables = [];
    const nonCombinables = [];

    for (const { promo, result } of previews) {
        const discount = Number(result?.discount || 0);
        if (discount <= 0) continue;
        const entry = {
            id: promo.id,
            name: promo.name,
            code: promo.code || null,
            type: promo.type,
            priority: Number(promo.priority || 100),
            combinable: Number(promo.combinable || 0) === 1,
            discount,
            meta: result?.meta || {}
        };
        (entry.combinable ? combinables : nonCombinables).push(entry);
    }

    nonCombinables.sort((a, b) => a.priority - b.priority || b.discount - a.discount);
    const bestNonComb = nonCombinables[0];
    const sumComb = combinables.reduce((acc, x) => acc + x.discount, 0);

    let applied = [];
    if (bestNonComb && bestNonComb.discount >= sumComb) {
        applied = [bestNonComb];
    } else {
        applied = combinables;
    }

    const totalDiscount = Number(applied.reduce((acc, x) => acc + x.discount, 0).toFixed(2));
    return { totalDiscount, applied };
}

function setAppliedPromotions(data) {
    appliedPromotions = data || { totalDiscount: 0, applied: [] };
    // Guardar para backend
    sale.applied_promotions = appliedPromotions.applied.map(p => ({
        promotion: p.id,
        promo_code: p.code || null,
        discount_amount: Number(p.discount.toFixed(2)),
        meta: p.meta || {}
    }));
}

function renderPromotionUI() {
    // Usa el contenedor existente de otros descuentos si existe
    const container = document.getElementById('otherDiscount');
    const target = container || document.getElementById('applied-promotions');
    if (!target) return;

    const wrapperId = 'applied-promotions-wrapper';
    let wrapper = document.getElementById(wrapperId);
    if (!wrapper) {
        wrapper = document.createElement('div');
        wrapper.id = wrapperId;
        wrapper.className = 'my-2';
        target.appendChild(wrapper);
    }
    wrapper.innerHTML = '';

    if (!appliedPromotions.applied.length) {
        return; // nada que mostrar
    }
    // Título
    const h = document.createElement('div');
    h.className = 'd-flex justify-content-between align-items-center';
    h.innerHTML = `<div><span class="fw-bolder text-heading">Promociones</span></div>
                   <span class="text-end fw-bolder text-heading">-${formatMoney(appliedPromotions.totalDiscount || 0)} M.N.</span>`;
    wrapper.appendChild(h);

    for (const p of appliedPromotions.applied) {
        const el = document.createElement('div');
        el.className = 'd-flex justify-content-between align-items-center small text-muted';
        el.innerHTML = `<div><span class="badge bg-success me-1">${p.name}</span></div>
                        <span>-${formatMoney(p.discount)}</span>`;
        wrapper.appendChild(el);
    }
}

let _promoTimer;
async function recalcPromotions() {
    clearTimeout(_promoTimer);
    _promoTimer = setTimeout(async () => {
        const context = buildContextFromCart();
        if (!activePromotions.length || !context.amount) {
            setAppliedPromotions({ totalDiscount: 0, applied: [] });
            renderPromotionUI();
            calculateTotal();
            return;
        }
        const previews = await Promise.all(activePromotions.map(async p => {
            try { return { promo: p, result: await previewPromotion(p.id, context) }; }
            catch(e){ return { promo: p, result: { discount: 0, meta: { reason: 'error' } } }; }
        }));
        const consolidated = consolidatePromotions(previews);
        setAppliedPromotions(consolidated);
        renderPromotionUI();
        calculateTotal();
    }, 200);
}
// ===================== FIN PROMOCIONES (POS) =====================

function splitPayment()
{
    let type = paymentType.val();
    let change = parseFloat(cashback.val());
    let received = parseFloat( moneyReceived.val());
    let amount =type==="cash"? received -change:received;
    let select = paymentType[0].options;

    if(amount === '' || isNaN(amount))
    {
        return ;
    }
    //if(paid() + amount > sale.amount)
    if((paid() + amount  ) > sale.amount)
    {
        toastAlert("error","Monto excedido", "No puedes recibir un monto mayor al costo");
        clearPayment();
        return ;
    }


    if(type === "cash"){

        if(change< 0 ){
            toastAlert("error","Monto erróneo", "Verifique su pago");
            return ;

        }
        let payment = {
            type : type,
            received : parseFloat(amount),
            amount: parseFloat(cashToPay.val()),
            cashback:change
        };
        payments.push(payment);

        paymentsList.append(`
            <div id="paymentType-${payments.length}" class="d-flex flex-column">
                <div class="d-flex mb-2">
                    <span onclick="deletePayment(${payments.length})" class="mdi mdi-close-circle-outline me-2" style="cursor: pointer;"></span>
                    <span class="fw-normal text-heading">${select[select.selectedIndex].text}</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-normal text-heading">Paga</span>
                    <span class="text-end">$<span>${payment.amount}</span> M.N.</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-normal text-heading">Recibido</span>
                    <span class="text-end">$<span id="subtotal">${payment.received}</span> M.N.</span>
                </div>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="fw-normal text-heading">Cambio</span>
                    <span class="text-end">$<span id="subtotal">${payment.cashback}</span> M.N.</span>
                </div>
            </div>
        `);
    }else{
        payments.push({
            type : type,
            amount: parseFloat(amount),
            aut: ticketNumber.val(),
            account:accountSelect.val(),
            modality: type ==='cc'?modalitiesPicker.val():null,
        });

        paymentsList.append(`
            <div id="paymentType-${payments.length}" class="d-flex justify-content-between align-items-center my-2">
                <div>
                    <span onclick="deletePayment(${payments.length})" class="mdi mdi-close-circle-outline" style="cursor: pointer;"></span> 
                    <span class="fw-normal text-heading">
                        ${select[select.selectedIndex].text}
                    </span>
                </div>
                <span class="text-end">
                    $<span id="subtotal">${amount}</span> M.N.
                </span>
            </div>
        `);
    }

    $("#cashreceived,#cashback,#cashToPay").val(null);
    ticketNumber.val(null)

    updateToPay();
    toggleSaleBtn();
}
function resetPayments()
{
    payments = [];
    paymentsList.html(null);
    updateToPay();
}
function deletePayment(paymentIndex)
{
    $('#paymentType-'+paymentIndex).remove();
    delete payments[paymentIndex-1];
    paymentComplete = false;
    //payments = payments.filter(payment => payment.type !== paymentType);
    updateToPay();
    toggleSaleBtn();
}
function calculatePayment()
{

    let total = paid();

    paymentComplete = total== sale.amount;
//    paymentComplete =isCash()?:(saleType.val()==='aside'?total>=1:true )

    //(isCash() && total>deposit.val())
    if( total>sale.amount){
        toastAlert("warning","Monto excedido", "No puedes recibir un monto mayor al costo")
    }
    sale.payment_type = payments.length>1?'multi':paymentType.val();

}

function paid()
{
    let paid = Number( payments.reduce((acc,payment)=>acc+payment.amount,0).toFixed(2));

    return payments.length>0? paid:0

}


function fillArticles()
{
    $.ajax({
        method: 'GET',
        url: '/item',
        dataType: 'JSON'
    }).done(function(articles){
        itemsFromApi =articles;
        itemSelector.each(function (k) {
            var $this = $(this);
            // select2Focus($this);
            let options = {
                placeholder: 'Seleccione un artículo',
                data: articles.map(mapItems),
                templateResult: formatItem,
                templateSelection: formatItem,
                allowClear: false
            };
            if(k === 1)
            {
                $this.wrap('<div class="position-relative"></div>');
                options= {...options, dropdownParent : $this.parent()}
            }
            $this.select2(options);
        });
        indexedArticles  = articles.reduce((acc,article ) => {
            acc[article.id]  = article
            return acc
        },[]);
        articlesLoaded =true;
        finishLoading();
    });

    $.get('/price').done(function(prices){
        itemPrices = prices.reduce((acc,price ) => {
            acc[price.item]=price
            return acc;
        },[]);
    })
}

function fillGlasses()
{
    $.ajax({
        method: 'GET',
        url: '/lens',
        dataType: 'JSON'
    }).done(function(lenses){
        lensesName = lenses.map(lens => {
            return {
                "id":lens.id,
                "text": `${lens.id} ${lens.design} ${lens.color} ${lens.material} ${lens.optical_correction} ${lens.price} ${lens.treatment} ${lens.type} `
            }
        });
        indexedLenses  = lenses.reduce((acc,lense ) => {
            acc[lense.item]  = lense
            return acc
        },[]);
    }).then(function () {
        //LIVESEARCH
        lenses.select2({
            placeholder: 'Seleccione un artículo',
            data: lensesName,
            allowClear:false,
        });
        lensesLoaded =true;
        finishLoading();
    });

}

function fillCustomers()
{
    let flatCustomers;
    $.get('/patient').done(function(customers){
        indexedPatients = customers.reduce((acc,patient)=>{
            acc[patient.id] = patient;
            return acc;
        },[]);
        flatCustomers = customers.map(customer => {
            return {
                id: customer.id,
                text: customer.name + " " + customer.last_name,
                selected : customer.id==="1"
            }
        });
        setCustomerSelector(flatCustomers);

        customersLoaded =true;

    }).done(finishLoading);
}

function setCustomerSelector(customers)
{
    customerSelector.select2({
            placeholder: 'Cliente',
            data: customers,
            allowClear:false,
            minimumInputLength: 3
        }).on('select2:select',  (e) =>{

            let data = e.params.data;
            let patient = indexedPatients[data.id];
            addCartCustomer(patient);

            sale.customer = e.params.data.id

            setCollapsible($("#prescription-"+patient.id)[0]);

            customerSelector.val(null).trigger('change');
             //todo terminar de implementar el customer detail.
           // customerDetail(e);
        });
}
function getGeneralInventory()
{
    $.ajax({
        method:"GET",
        url :"/stock/store/"+store.id,
        dataType : "JSON"
    }).done(function(response){
        storeStock = response.reduce((acumulated,inventory ) => {
            acumulated[inventory.item]  = inventory
            return acumulated
        },[])
        inventoryLoaded = true;
        finishLoading();
    })


}


function calculateCashback(e=null)
{
    if(paymentType.val() != "cash")
    {
        return ;
    }
    if(null === e || isNaN(e.currentTarget.value) )
    {
        e.currentTarget.value = '';
        return false
    }
    let received = parseFloat(e.currentTarget.value);
    if(isNaN(received)){
        return false;
    }

    let priceToPay = parseFloat(cashToPay.val())
    let cashBack = received - priceToPay;

    $("#cashback").val(cashBack.toFixed(2));

    toggleSaleBtn();
}

function isCash() {
    return saleType.val() === 'cash';
}


function clearPayment(){
    ticketNumber.val(null);
    moneyReceived.val(null);
    cashback.val(null);
    ticketNumber.val(null)

}

function finishLoading()
{
    let loaded = articlesLoaded && customersLoaded && inventoryLoaded;
    loaded ? $.unblockUI():false;
    loaded ? quoteProcess():false;
}

function updateToPay()
{
    let saleType = sale.type;
    let money  = paymentComplete?0:sale.amount-paid();

    toPay.text(formatMoney(Number(money.toFixed(2))));

}

function toggleSaleBtn(bypass=false)
{
    let enable = Object.keys(cart).length >0;
    calculatePayment();
    enable = enable &&( paymentComplete || bypass || !isCash());


    if(enable) {
        saleBtn.prop('disabled', false);
    }else {
        saleBtn.prop('disabled', true);
    }
}
function checkoutCart()
{
    if (payments.length ===0  && isCash() ){
        toastAlert("error","No hay pagos", "Aplica un pago para continuar");
        return false;
    }
    saleBlock();
    sale.delivery = $("#shipment").prop("checked")?'pending':'store';

    if(saleType.val()!=="cash" && sale.customer == null )
    {
        $.unblockUI();
        toastAlert('warning', 'Venta sin cliente', 'Registre o seleccione un cliente para venta a crédito');
        return false;
    }
    debugger;

    let withCard =  payments.find(({type})=> type ==='card');


    let voucher = (withCard!== undefined && withCard.type ==='card')? withCard.aut :null;


    if(null !== voucher && voucher === "")
    {
        toggleSaleBtn();
        $.unblockUI();
        return false
    }

    sale.comments= '';
    sale.patients_number = patients_number;
    sale.cart = cart;
    sale.discounts = discounts;
    sale.payments = payments;

    $.ajax({
        "method" : "POST",
        "url":"/sale",
        "data":sale,
        dataType:"JSON",
        statusCode : {
            500 : serverError,
            400 :saleBadRequest,
            403 :forbiddenSale,
        }
    }).done(function(sale){
        if (sale.sale.id){
            $.unblockUI();
            if (params.has('quote')) {
                let quoteId = params.get('quote');
                closeQuote(quoteId, sale.sale.id);
            }
            toastAlert('success','Venta registrada','En breve se recargará la página');
            window.open("/ticket/"+sale.sale.uuid,"_blank").print();
            location.reload();
        }else {
            $.unblockUI();
            toastAlert('error','Error','Ocurrió un problema, por favor, intenta nuevamente');
        }
    })
}

function closeQuote(quote, sale)
{
    $.ajax({
        method: 'PATCH',
        url: '/quote/'+quote,
        data: {
            'sale': sale,
        },
        dataType: 'JSON'
    }).done(function(response){
        $.ajax({
            method: 'DELETE',
            url: '/quote/'+quote,
            dataType: 'JSON'
        }).done(function(){
           
        })
    })
}

function quoteCart()
{
    saleBlock();

    if(sale.customer == null )
    {
        $.unblockUI();
        toastAlert('warning', 'Venta sin cliente', 'Registre o seleccione un cliente para realizar cotización');
        return false;
    }

    if(isQuote())
    {
        deleteQuote(new URLSearchParams(window.location.search).get('quote'));
    }

    sale.comments= '';

    sale.cart = cart;

    $.ajax({
        "method" : "POST",
        "url":"/quote",
        "data":sale,
        dataType:"JSON",
        statusCode : {
            201:()=>{
                $.unblockUI();
                toastAlert('success','Cotización registrada','En breve se recargará la página');
                location.reload();
            },
            500 : serverError,
            400 :saleBadRequest,
            403 :forbiddenSale,
        }
    }).done(function(quote){
        if (quote.id){
            $.unblockUI();
            toastAlert('success','Cotización registrada','La cotización se registró correctamente');
        }else {
            $.unblockUI();
            toastAlert('error','Error','Ocurrió un problema, por favor, intenta nuevamente');
        }

    })

}

function serverError()
{
    $.unblockUI();
    toastAlert('error','Error','Ocurrió un problema, por favor intenta nuevamente');
}
function saleBadRequest()
{
    $.unblockUI();
    toastAlert('error','Error','Ocurrió un problema, por favor intenta nuevamente');
}

function forbiddenSale()
{
    location.href = '/login'
}

function isQuote()
{
    return  new URLSearchParams(location.search).get('quote')!==null;
}
function inQuote(item)
{
    return quoteItems.find(quoteItem => quoteItem.item === item.id);
}
function quoteProcess()
{
    if(isQuote())
    {
        let customer = customerSelector.select2().val(quoteCustomer.id).select2('data');
        customerSelector.select2().trigger({type:'select2:select',params:{data:customer[0]}})

        quoteItems.forEach(item=>{
            let selected =articles.select2().val(item.item).select2('data');

            articles.select2().trigger({type:'select2:select',params:{data:selected[0]}})
        })
        saleType.selectpicker('val','quote').trigger("change")

    }

}

function updateQuote()
{
    for(let item in cart)
    {
        inQuote(cart[item])?updateQuoteItem(cart[item]):setQuoteItem(cart[item]);
    }
}

function updateQuoteItem(item)
{
    $.ajax({
        method: 'PUT',
        url: '/quoteitem/'+item.id,
        data:item,
        dataType: 'JSON'
    })
}
function setQuoteItem(item)
{
    $.ajax({
        method: 'POST',
        url: '/quoteitem',
        data:item,
        dataType: 'JSON'
    });

}
function deleteQuote(id) {
    $.ajax({
        method: 'DELETE',
        url: '/quote/'+id,
        dataType: 'JSON'
    });
}

function showItemByLine(event)
{
    let line = event.currentTarget.dataset.line

    getItemsByLine(line).done(setItemSelector)


}
function getItemsByLine(line)
{
    return $.ajax({
        method: 'GET',
        url: `/item/filtered?line=${line}`,
        dataType: 'JSON'
    })
}
function setItemSelector(items)
{
    let list = items.map(mapItems);
    $("#allArticlesList").select2('destroy')

    $("#allArticlesList").html('').select2({
        placeholder: 'Artículos',
        data: list,
        allowClear:false
    })

}
function mapItems(item)
{
    return {
        "id":item.id,
        "text":  `${item.key}   
                 ${item.brand} 
                 ${item.model} 
                 ${item.color_key}
                 ${item.size??'0'}`,
        "price": `${formatMoney(item.price??0)}`,
        "stock": `${item.stock??'0'}`
    };
}

function formatItem(item) {
    if (!item.id) return item.text;

    let $container = $(`
        <div style="display:flex; justify-content:space-between; width:100%;">
            <span>${item.text}</span>
            <span style="white-space:nowrap;">${item.price} &nbsp; ${item.stock}</span>
        </div>
    `);

    return $container;
}

function setCollapsible(element)
{
    element.addEventListener('click', event => {
        event.preventDefault();
        // Collapse the element
        new bootstrap.Collapse(element.closest('.card').querySelector('.collapse'));
        // Toggle collapsed class in `.card-header` element
        element.closest('.card-header').classList.toggle('collapsed');
        // Toggle class mdi-chevron-down & mdi-chevron-up
        Helpers._toggleClass(element.firstElementChild, 'mdi-chevron-down', 'mdi-chevron-up');
    });
}
function loadLastPatients()
{
    let patientList = '';
    $.ajax({
        method: 'GET',
        url: '/last-consultation',
        dataType: 'JSON'
    }).done(function(consultations){
        consultations.forEach(consultation => {
            let patient = indexedPatients[consultation.patient];
            patientList+=`<div class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer waves-effect">
                    <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <div class="user-info">
                                <h6 class="mb-1">${patient.name+ " "+ patient.last_name}</h6>
                                <div class="d-flex align-items-center">
                                    <div class="user-status me-2 d-flex align-items-center">
                                        <span class="badge badge-dot bg-success me-1"></span>
                                        <small></small>
                                    </div>
                                    <small class="text-muted ms-1">${consultation.ago}</small>
                                </div>
                            </div>
                            <div class="add-btn">
                                <button onclick='addCartCustomer(${JSON.stringify(patient)},${consultation.id})'  class="btn btn-primary btn-sm waves-effect waves-light"><i class="mdi mdi-cart-arrow-down"></i></button>
                            </div>
                        </div>
                    </div>
                </div>`



        });
        $("#offcanvasEndLabelCustom").text("Ultimas consultas")
        $("#lastPatientsList").html(patientList);
    })
}
function selectPrescription(patientId)
{
    let prescriptionsList = '';
    getPrescription(patientId,false)
        .done(function(prescriptions){

            prescriptions.forEach(prescription => {
                prescriptionsList+=` <div class="card card-action mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <span> ${dayjs(prescription.created_at.date).format('DD/MM/YYYY')}</span> 
                        <div class="add-btn">
                            <button
                              onclick='setSalePrescription(${JSON.stringify(prescription)})' 
                              class="btn btn-primary btn-sm waves-effect waves-light">
                            
                                <i class="mdi mdi-cart-arrow-down"></i>
                            </button>
                        </div>
                    </div>
                    <div class="collapse show" style="">
                      <div class="card-body">
                      ${getPrescriptionHtml(prescription)}
                      </div>
                    </div>
                  </div>
                `
            })
            $("#offcanvasEndLabelCustom").text("Graduaciones")
            $("#lastPatientsList").html(prescriptionsList);
        })

}
function getPrescription(id,last = true)
{
    let url = `/prescription-patient/${id}`
    let prescriptionUrl =  last ? `${url}?type=last` : url
    return   $.ajax({
        method: "GET",
        url: prescriptionUrl,
        async: false,
        dataType: "json",
    })
}
function setSalePrescription(prescription)
{

    cart[currentCustomer].prescription = prescription.id;
    cart[currentCustomer].consultation = prescription.consultation;
    $("#body-prescription-"+prescription.patient).html(getPrescriptionHtml(prescription));

}
function getPrescriptionHtml(prescription) {
    return `<div class="col-12 col-lg-12">
        <div class="input-group">
            <input id="last_sphere_r" type="text" value="${prescription.details?.final?.right?.sphere}"
                   class="form-control form-control-sm" readonly/>
            <input id="last_cilinder_r" type="text" value="${prescription.details?.final?.right?.cylinder}"
                   class="form-control form-control-sm" readonly/>
            <input id="last_axis_r" type="text" value="${prescription.details?.final?.right?.axis}"
                   class="form-control form-control-sm" readonly/>
            <input id="last_add_r" type="text" value="${prescription.details?.final?.right?.addition}"
                   class="form-control form-control-sm" readonly/>
        </div>
        <div class="input-group">
            <input id="last_sphere_l" type="text" value="${prescription.details?.final?.left?.sphere}"
                   aria-label="First name" class="form-control form-control-sm" readonly/>
            <input id="last_cilinder_l" type="text" value="${prescription.details?.final?.left?.cylinder}"
                   aria-label="Last name" class="form-control form-control-sm" readonly/>
            <input id="last_axis_l" type="text" value="${prescription.details?.final?.left?.axis}" aria-label=" name"
                   class="form-control form-control-sm" readonly/>
            <input id="last_add_l" type="text" value="${prescription.details?.final?.left?.addition}" aria-label="Last "
                   class="form-control form-control-sm" readonly/>
        </div>
    </div>`
}
function isLensMaterial(item) {
    // Ajusta esta condición a tu modelo real
    return (
        item.line === 'lentes'
        //||
        //7item.category === 'lens' ||
        //item.type === 'material' ||
        //item.is_lens === true
    );
}
