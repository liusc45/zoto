### Promociones (Modelo Moderno)

Este documento explica el modelo moderno de Promociones, cómo crearlas/guardarlas, cómo calcular/aplicar descuentos en tiempo real desde el front (sale.js) y cómo persistir la relación entre una venta y la promoción aplicada.

---

#### 1) Esquema y conceptos
Tablas principales (ver migración `app/Database/Migrations/2025-08-21-153942_Promotion.php`):
- `promotions`: define la promoción y sus reglas en JSON.
  - Campos clave: `type`, `scope`, `priority`, `combinable`, `channel (store|online|both)`, `audience (JSON)`, `constraints_json (JSON)`, `rule_json (JSON)`, `starts_at`, `ends_at (nullable)`, `active`.
- `sale_promotions`: relaciona una venta con una o más promociones aplicadas a nivel orden (descuento total o metadatos).
  - Campos: `sale`, `promotion` (nullable si se aplica por `promo_code` sin registro), `promo_code`, `discount_amount`, `meta (JSON)`.
- `sale_item_promotions`: asociación opcional a nivel de renglón/carro (si deseas rastrear descuento por ítem).
  - Campos: `sale`, `sale_item`, `promotion`, `discount_amount`, `meta`.

Tipos de promoción soportados en el modelo:
- `percent`, `fixed`, `bogo`, `bundle`, `tier_amount`, `tier_qty`, `cashback`, `points`, `shipping` (también están definidos `upgrade`, `financing`, `warranty` a futuro).

`rule_json` depende del tipo:
- `percent`: `{ percent, max_discount? }`
- `fixed`: `{ amount }`
- `bogo`: `{ buy, get, discount_percent? }`
- `tier_amount`: `{ tiers: [{ min_amount, percent }, ...] }`
- `tier_qty`: `{ tiers: [{ min_qty, percent }, ...] }`
- `bundle`: `{ items: [{ product_id|item_id, quantity }...], discount_amount }`
- `shipping`: `{}` (el descuento será el costo de envío del contexto)
- `cashback`: `{ percent }` (solo genera meta: `cashback_amount`)
- `points`: `{ points_per_unit }` (solo genera meta: `points_earned`)

`audience` y `constraints_json` permiten filtrar aplicabilidad (segmentos de clientes, productos/categorías, mínimos, etc.).

---

#### 2) Backend: Modelo y Controlador
- Modelo: `app/Models/PromotionModel.php`
  - `getActiveForNow(?string $channel)` devuelve promociones activas considerando fechas, `active=1` y canal.
  - `isApplicable($promotionId, $context)` valida fechas, canal, audiencia y restricciones.
  - `calculateDiscount($promotionId, $context)` aplica salvaguardas, valida aplicabilidad y calcula `discount` + `meta` por tipo.
- Controlador: `app/Controllers/Promotion.php`
  - `preview()` (POST): recibe `promotion_id` + `context` y responde con `{ discount, meta }` usando `calculateDiscount`.
  - `getActivePromotions()` (GET): lista promociones activas opcionalmente filtradas por `channel`.
  - Vistas: `components/promotion/form` (crear/editar). El controlador hace la conversión de JSON de/para el formulario.

Contexto esperado por los cálculos (según tipo):
- Comunes: `amount`, `quantity`, `unit_price`, `channel`, `customer_id`, `customer_group`.
- Específicos: `items` (bundle), `product_id`, `category_id`, `shipping_cost` (shipping), etc.

---

#### 3) Crear y guardar promociones
- Desde UI: usar formulario `components/promotion/form`. El controlador convertirá
  - `audience_*` → `audience` (JSON)
  - `constraint_*` → `constraints_json` (JSON)
  - `rule_*` → `rule_json` (JSON)
- Validaciones clave:
  - `name` requerido, `type` requerido.
  - `starts_at` fecha válida; `ends_at` opcional y, si existe, debe ser posterior a `starts_at`.
  - Reglas por tipo: asegurar campos requeridos (p.ej. `percent` o `amount`, etc.).

Ejemplo de POST (mínimo) para `percent`:
```
name=Promo 10%
type=percent
scope=mixed
channel=both
starts_at=2025-11-01 00:00:00
ends_at=
rule_percent=10
rule_max_discount=100
active=1
```

---

#### 4) Aplicación en tiempo real (sale.js)
Objetivo: al modificar el carrito, recuperar promociones activas, evaluar aplicabilidad y mostrar el descuento en tiempo real.

Flujo recomendado:
1. Obtener promociones activas al cargar la pantalla (o con debounce cuando cambie el carrito/cliente):
```
GET /promotion/active?channel=store
=> { data: [ { id, name, type, rule_json, ... }, ... ] }
```
2. Para cada promoción candidata, enviar `POST /promotion/preview` con un `context` calculado del carrito actual:
```
POST /promotion/preview
Form-Data:
  promotion_id: <id>
  amount: <subtotal>
  quantity: <total_items>
  unit_price: <precio_promedio_opcional>
  channel: store
  customer_id: <id_cliente>
  customer_group: <grupo>
  product_id: <opcional>
  category_id: <opcional>
  items: <JSON del carrito>  // solo si bundle
  shipping_cost: <opcional>
```
3. La respuesta entrega `{ discount, meta }`. Sumar los descuentos de promociones combinables y, si no son combinables, elegir la de mayor prioridad/beneficio según tu regla de negocio.
4. Refleja el total a pagar (`total = subtotal - descuentos`) y muestra detalle de la(s) promoción(es) aplicada(s).

Sugerencia de estructura mínima en sale.js:
- Mantener un estado `activePromotions` (cargado de `/promotion/active`).
- Cada vez que cambie el carrito:
  - Construir el `context`.
  - Mapear `activePromotions` → `Promise.all` de previews.
  - Consolidar descuentos y actualizar UI.

Pseudocódigo:
```
async function recalcPromotions() {
  const promos = await fetchJSON('/promotion/active?channel=store');
  const context = buildContextFromCart();
  const previews = await Promise.all(promos.data.map(p => previewPromo(p.id, context)));
  const {discount, applied} = consolidate(previews, promos.data);
  setSaleDiscount(discount, applied);
}
```

---

#### 5) Persistir relación de venta y promoción aplicada
Modelos disponibles:
- `App/Models/SalePromotionModel` → tabla `sale_promotions`
- `App/Models/SaleItemPromotionModel` → tabla `sale_item_promotions`

Al confirmar la venta en backend (por ejemplo en `Sale::store` o método equivalente):
1. Recalcular/validar en servidor el set de promociones efectivamente aplicadas para evitar manipulación del cliente.
2. Insertar un registro en `sale_promotions` por cada promoción aplicada a nivel orden:
```
model('SalePromotionModel')->insert([
  'sale' => $saleId,
  'promotion' => $promotionId, // puede ser null si solo hubo promo_code
  'promo_code' => $submittedCode, // opcional
  'discount_amount' => $discount,
  'meta' => json_encode($meta) // opcional
]);
```
3. Si manejas descuentos a nivel ítem, insertar también en `sale_item_promotions` por fila con su `discount_amount` correspondiente.
4. Restar el descuento del total de la venta y guardar el total neto.

Notas:
- Si una promoción no es combinable (`combinable = 0`), aplica solo una según prioridad y beneficio. Ordena por `priority ASC` (menor = más prioridad) y verifica el mejor descuento neto.
- Siempre valida en servidor con el mismo `context` que usaste en la vista previa, reconstruido desde la orden real.

---

#### 6) Buenas prácticas
- Zona horaria: el modelo usa `DateTimeImmutable` con TZ de `config('App')->appTimezone`. Asegura que esté configurada correctamente.
- Sanitizar `context`: asegúrate de enviar números y estructuras válidas (p. ej. `items` como arreglo `[{ item_id, product_id, quantity, unit_price }, ...]`).
- Tope de descuento: `calculateDiscount()` limita el descuento a `amount` y nunca negativo.
- Auditoría: guarda en `meta` información útil (porcentaje aplicado, tier elegido, artículos en bundle, etc.).

---

#### 7) Endpoints de referencia
- Listar activas: `GET /promotion/active?channel=store`
  - Respuesta: `{ data: Promotion[] }`
- Vista previa: `POST /promotion/preview`
  - Body: `promotion_id` + campos de `context` según tipo
  - Respuesta: `{ discount: number, meta: object }`

---

#### 8) Deprecaciones (legado)
- No usar `promotion_items` ni `status` en `promotions`.
- Evitar `PromotionItemModel` y scripts como `test_promotion.php` basados en ese modelo.
- El controlador duplicado en `Views/components/pin/promotions_controller.php` debe considerarse obsoleto.

---

Si necesitas, puedo agregar funciones utilitarias en `sale.js` para integrar estos endpoints y consolidar descuentos, o exponer un endpoint que reciba el carrito completo y retorne la mejor combinación de promociones en un solo request.

---

#### 9) Datos de prueba (Seeder)
Para probar promociones en tiempo real, incluye y ejecuta el seeder `PromotionSeeder`:

- Archivo: `app/Database/Seeds/PromotionSeeder.php`
- Crea 5 promociones de ejemplo, compatibles con el modelo moderno:
  - `POS10`: 10% en mostrador (combinable, prioridad 50)
  - `FIJO100`: $100 fijos desde $800 (combinable)
  - `BOGO2x1`: compra 2 y lleva 1 gratis (no combinable, prioridad 10)
  - `TIERS$`: descuento escalonado por monto (no combinable)
  - `BUNDLE300`: combo de 2 productos con $300 de descuento (combinable)

Ejecución local:
```
php spark db:seed PromotionSeeder
```

Docker/Compose (contenedor aplica según tu servicio):
```
docker compose exec php php spark db:seed PromotionSeeder
# o
docker exec -it opticas-app php spark db:seed PromotionSeeder
```

Notas:
- Las promociones inician hace 1 hora (`starts_at = now - 1h`); algunas no tienen `ends_at` y otras expiran en 30 días.
- `BUNDLE300` contiene `product_id: [1,2]` como ejemplo; ajusta a IDs existentes para que aplique en tu catálogo real.
- Valida con `GET /promotion/active?channel=store` y en `/promociones`.
- En `/mostrador`, al agregar artículos verás los descuentos reflejados en tiempo real (sale.js).