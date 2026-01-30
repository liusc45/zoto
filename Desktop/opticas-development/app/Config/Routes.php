<?php

use App\Controllers\Item;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
service('auth')
    ->routes($routes,[
    "except"=>[
    ]
]);

$routes->get('/mostrador', 'Home::sale',["filter"=>"session"]);
$routes->get('/inventario', 'Home::inventory',["filter"=>"session"]);
$routes->get('/articulos', 'Home::articles',["filter"=>"session"]);
$routes->get('/pupilentes', 'Contact::new',["filter"=>"session"]);
$routes->get('/perfil', 'Home::profile',["filter"=>"session"]);
$routes->get('/mis-ventas', 'Home::mySales',["filter"=>"session"]);
$routes->get('/ventas', 'Home::salesHistory',["filter"=>"session"]);
$routes->get('/reportes', 'Home::reports',["filter"=>"session"]);
$routes->get('/commission/settings', 'Commission::settings',["filter"=>"session"]);
$routes->post('/commission/settings', 'Commission::settings',["filter"=>"session"]);
$routes->get('/commission/calculate/(:num)', 'Commission::calculate/$1',["filter"=>"session"]);
$routes->post('/commission/pay/(:num)', 'Commission::pay/$1',["filter"=>"session"]);
$routes->get('/report/utilities', 'Report::bestUtility',["filter"=>"session"]);
$routes->get('/entregas', 'Home::deliver',["filter"=>"session"]);
$routes->get('/apartados', 'Home::aside',["filter"=>"session"]);
$routes->get('/categorias', 'Home::categories',["filter"=>"session"]);
$routes->get('/ocupaciones', 'Home::occupations',["filter"=>"session"]);
$routes->get('/pacientes', 'Home::patients',["filter"=>"session"]);
$routes->get('/paciente/(:num)', 'Home::patientDetail/$1',["filter"=>"session"]);
$routes->get('/cumpleanos', 'Home::birthdays',["filter"=>"session"]);
$routes->get('/empleados', 'Employee::main',["filter"=>"session"]);
$routes->get('/usuarios', 'Home::users',["filter"=>"session"]);
$routes->get('/ingresos', 'Home::incomes',["filter"=>"session"]);
$routes->get('/creditos', 'Home::credits',["filter"=>"session"]);
$routes->get('/traspasos', 'Home::transfers',["filter"=>"session"]);
$routes->get('/proveedores', 'Home::suppliers',["filter"=>"session"]);
$routes->get('/laboratorios', 'Home::labs',["filter"=>"session"]);
$routes->get('/convenios', 'Home::contracts',["filter"=>"session"]);
$routes->get('/tiendas', 'Home::store',["filter"=>"session"]);
$routes->get("/inventario/tienda/(:any)/articulo/(:any)","Home::historyItem/$1/$2",["filter"=>"session"]);
$routes->get("/stock",[Item::class,'stock'],["filter"=>"session"]);
$routes->get("/stock/store/(:any)","Inventory::inventory/$1/$2/$3",["filter"=>"session"]);
$routes->get("/inventory/store/(:any)","Inventory::inventory/$1/$2/$3",["filter"=>"session"]);
$routes->get("/sale/(:segment)/(:segment)","Sale::sales/$1/$2",["filter"=>"session"]);
$routes->get("/mi-corte","CashOut::index",["filter"=>"session"]);
$routes->get("/aside/items/(:num)","Aside::items/$1",["filter"=>"session"]);
$routes->get('/garantias', 'Home::warranty',["filter"=>"session"]);
$routes->get('/facturas', 'Invoice::main',["filter"=>"session"]);
$routes->get('/compras', 'Home::purchases',["filter"=>"session"]);
$routes->get('/tarjetas-pago', 'Home::paymentCards',["filter"=>"session"]);
$routes->get('/precios', 'ItemPrice::main',["filter"=>"session"]);
$routes->get('/promociones', 'Promotion::main',["filter"=>"session"]);
$routes->get('/promociones/nueva', 'Promotion::create',["filter"=>"session"]);
$routes->get('/promociones/editar/(:num)', 'Promotion::edit/$1',["filter"=>"session"]);
$routes->post('/promociones/store', 'Promotion::store',["filter"=>"session"]);
$routes->post('/promociones/update/(:num)', 'Promotion::update/$1',["filter"=>"session"]);
$routes->post('/promociones/eliminar/(:num)', 'Promotion::delete/$1',["filter"=>"session"]);
$routes->post('/promociones/toggle/(:num)', 'Promotion::toggleActive/$1',["filter"=>"session"]);
$routes->get('/promocion/(:any)', 'Promotion::promoDetail/$1',["filter"=>"session"]);
$routes->get('/pin', 'Pin::main',["filter"=>"session"]);
$routes->post('/pin/auth', 'Pin::auth',["filter"=>"session"]);
$routes->get("/item/filtered",[Item::class,"showFiltered"],["filter"=>"session"]);



//Catalogs
$routes->get("/lineas", 'Line::main',["filter"=>"session"]);
$routes->get("/marcas", 'Brand::main',["filter"=>"session"]);
$routes->get("/colores", 'Color::main',["filter"=>"session"]);
$routes->get("/materiales", 'Material::main',["filter"=>"session"]);
$routes->get("/micas", 'Lens::main',["filter"=>"session"]);
$routes->get("/rangos", 'Range::main',["filter"=>"session"]);
$routes->get("/articulos/armazones", 'Frame::main',["filter"=>"session"]);

//Consultations
$routes->get("/nueva-consulta/(:num)","Consultation::new/$1",["filter"=>"session"]);
$routes->get("/nueva-consulta/rollback/(:num)","Consultation::delete/$1",["filter"=>"session"]);
$routes->get("/consulta/(:num)","Consultation::edit/$1",["filter"=>"session"]);


//EXPENSES
$routes->get('/gastos', 'Expenses::new');


//LANDING
$routes->get('/inicio', 'Landing::index' );
$routes->get('/armazones', 'Landing::frames' );
$routes->get('/armazon/(:num)', 'Frame::edit/$1',["filter"=>"session"]);
$routes->get('/signin', 'Landing::signin' );
$routes->get('/mi-perfil', 'Landing::profile' );
$routes->get('/', 'Landing::index' );
$routes->post('/login-action', 'Landing::loginAction' );
$routes->get('/salir', 'Landing::logoutAction' );


$routes->resource("prescription",["filter"=>"session"]);
$routes->resource("prescriptionDetail",["filter"=>"session"]);
$routes->get("/prescription-patient/(:num)","Prescription::prescriptionByPatient/$1",["filter"=>"session"]);
$routes->get("/last-consultation","Consultation::lastConsultation",["filter"=>"session"]);


$routes->resource("consultation");
$routes->resource("consultationgb",["controller"=> "GeneralBackground", "filter"=>"session"]);
$routes->resource("consultationvb",["controller"=> "VisualBackground", "filter"=>"session"]);
$routes->resource("consultationve",["controller"=> "VisualEvaluation", "filter"=>"session"]);
$routes->resource("consultationcl",["controller"=> "ConsultationContact", "filter"=>"session"]);
$routes->resource("patient",["filter"=>"session"]);
$routes->resource("person");
$routes->resource("company");
$routes->resource("supplier");
$routes->resource("contract");
$routes->resource("lab");
$routes->resource("employee");
$routes->resource("lens");
$routes->resource("expenses");
$routes->resource("inventory");
$routes->resource("payment");
$routes->resource("item");
$routes->resource("income");
$routes->resource("itemCategory");
$routes->resource("store");
$routes->resource("user");
$routes->resource("transfer");
$routes->resource("sale");
$routes->resource("saleItem");
$routes->resource("customer");
$routes->resource("report");
$routes->resource("credit");
$routes->resource("delivery");
$routes->resource("aside");
$routes->resource("occupation");
$routes->resource("line");
$routes->resource("brand");
$routes->resource("color");
$routes->resource("material");
$routes->resource("range");
$routes->patch("pin","Pin::update");
$routes->get('/range/(:num)/intervals', 'Range::intervals/$1',["filter"=>"session"]);
$routes->post('/range/(:num)/interval', 'Range::createInterval/$1',["filter"=>"session"]);
$routes->delete('/range/interval/(:num)', 'Range::deleteInterval/$1',["filter"=>"session"]);
$routes->resource("purchase");
$routes->resource("persontax",["controller"=>"PersonTax","filter"=>"session"]);;
$routes->resource("phone");
$routes->resource("contact");
$routes->resource("frame");
$routes->resource("order");
$routes->resource("paymentcard");
$routes->resource("bankaccount");
$routes->get('/invoice/sale/(:num)', 'Invoice::saleDetails/$1',["filter"=>"session"]);
$routes->post('/invoice/from-sale', 'Invoice::createFromSale',["filter"=>"session"]);
$routes->resource("invoice", ["filter"=>"session"]);

$routes->resource('price', ['controller' =>'ItemPrice']);
$routes->get('item-prices/active/(:num)', 'ItemPrice::getActivePrices/$1');
$routes->get('item-prices/active', 'ItemPrice::getActivePrices');

//$routes->resource('promotion');
$routes->get('promotion/getFilteredItems', 'Promotion::getFilteredItems');
$routes->get('promotion/getPromotionItems/(:num)', 'Promotion::getPromotionItems/$1');
$routes->get('promotion/active', 'Promotion::getActivePromotions');
$routes->post('promotion/preview', 'Promotion::preview');
$routes->get('promotion/test', 'Promotion::testPromotionItems');

$routes->get('/ordenes', 'Order::main',["filter"=>"session"]);
$routes->get('/nueva-orden/venta/(:num)/paciente/(:num)', 'Order::new/$1/$2',["filter"=>"session"]);
$routes->get('/nueva-orden/venta/(:num)', 'Order::new/$1',["filter"=>"session"]);

$routes->post("/user/store","User::myStore");
$routes->get("/ticket/(:any)","Sale::ticket/$1");
$routes->get("/tickets","Sale::tickets");
$routes->get("/apartado/(:any)","Aside::ticket/$1");
$routes->get("/abono/(:any)","Credit::ticket/$1");
$routes->get("/uuid","Sale::uuid");
#$routes->post("/purchase", "Inventory::purchase");




//Dummies
$routes->post("/upload","Dummy::upload");
$routes->get("debugger","Dummy::debugger");
$routes->get("transact","Dummy::deleteTransaction");
$routes->get("filtros","Dummy::filters",["filter"=>"session"]);
//$routes->get("phones","Dummy::phones");
$routes->get("storage","Dummy::storage");
$routes->get("price-list","Dummy::pricesJson");
$routes->get("stockable","Dummy::stockable");
$routes->get("/seed","Dummy::seed");
$routes->get("/fechas","Dummy::fechas");
