<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\SolarFrame;
use App\Models\BrandModel;
use App\Models\ColorModel;
use App\Models\CompanyModel;
use App\Models\FrameModel;
use App\Models\ItemModel;
use App\Models\LineModel;
use App\Models\MaterialModel;
use App\Models\SolarFrameModel;
use App\Models\SupplierModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Frame extends BaseController
{
    use ResponseTrait;
    protected FrameModel $frameModel;

    public function __construct()
    {
        $this->frameModel = new FrameModel();
    }

    public function index(): ResponseInterface
    {
        $itemModel = new ItemModel();
        $frames = $itemModel
            ->select([
                "frames.id",
                "frames.item",
                "frames.published",
                "items.key",
                "items.name",
                
                "lines.name as line",
                "brands.name as brand",
                "items.model",
                "items.color",
                "items.color_key",
                "items.size item_size",
                "item_prices.amount as price"

            ])
            ->join("frames","frames.item = items.id"    )
            ->join("item_prices","item_prices.item = items.id AND item_prices.type = 'regular'","left")
            ->join("lines","lines.id = items.line")
            ->join("brands","brands.id = items.brand")
            ->findAll();
       // $this->logger->info($this->frameModel->db->getLastQuery());
        return $this->respond( $frames);

    }

    public function main(): string

    {
        $this->viewData['path'] = '/artículos/armazones';
        $this->viewData['title'] = 'Armazones';
        $this->viewData['lines'] = model(LineModel::class)
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['suppliers'] = model(SupplierModel::class)
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['brands'] = model(BrandModel::class)
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['colors'] = model(ColorModel::class)
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['materials'] = model(MaterialModel::class)
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['styles'] = ['full'=>'Armazón completo','slotted'=> 'Ranurado','pieces'=> '3 Piezas'];
        return view('components/frame/main', $this->viewData);
    }

    public function edit(int $id): string
    {
        // Reuse the same data as in main() to render the form
        $this->viewData['path'] = '/artículos/armazones';
        $this->viewData['title'] = 'Editar armazón';
        $this->viewData['lines'] = model(LineModel::class)
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['suppliers'] = model(SupplierModel::class)
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['brands'] = model(BrandModel::class)
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['colors'] = model(ColorModel::class)
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['materials'] = model(MaterialModel::class)
            ->orderBy('id', 'ASC')
            ->findAll();
        $this->viewData['styles'] = ['full'=>'Armazón completo','slotted'=> 'Ranurado','pieces'=> '3 Piezas'];
        $this->viewData['editId'] = $id;

        return view('components/frame/main', $this->viewData);
    }
    public function show($frameId)
    {
        // Return a hydrated record joining items + frames (and some catalogs) to prefill the edit form
        $itemModel = new ItemModel();
        $frame = $itemModel
            ->select([
                "frames.id",
                "frames.item",
                "frames.published",
                "items.key",
                "items.name",
                "items.barcode",
                "items.model",
                "items.color_key",
                "items.line as line_id",
                "lines.name as line",
                "items.brand as brand_id",
                "brands.name as brand",
                "items.color as color_id",
                "frames.size",
                "items.supplier as supplier_id"
            ])
            ->join("frames", "frames.item = items.id")
            ->join("lines", "lines.id = items.line")
            ->join("brands", "brands.id = items.brand")
            ->where("frames.id", $frameId)
            ->first();

        return $this->respond($frame);
    }
    public function create(): ResponseInterface
    {
        $db = $this->frameModel->db;

        $itemModel = new ItemModel($db);
        $solarFrameModel = new SolarFrameModel($db);

        $db->transException(true)->transBegin();

        try {
            $post = $this->request->getPost();

            $item = new \App\Entities\Item($post);
            $itemId = $itemModel->insert($item, true);

            $frame = new \App\Entities\Frame($post);
            $frame->solar = (int) $this->request->getPost('is_solar');
            $frame->item = $itemId;

            $this->frameModel->save($frame);
            $frameId = (int) $this->frameModel->getInsertID();

            if ($frame->isSolar()) {
                $solarData = (array) ($this->request->getPost('solar') ?? []);
                $solar = new SolarFrame(array_merge([
                    'item'  => $itemId,
                    'frame' => $frameId,
                ], $solarData));

                $solarFrameModel->save($solar);
            }

            $db->transCommit();

            // Hidrata la respuesta con relaciones clave
            $item->frame = $frame;
            if ($frame->isSolar()) {
                $item->frame->solar = $solarFrameModel
                    ->where('frame', $frameId)
                    ->first();
            }

            return $this->respondCreated($item);
        } catch (\Throwable $e) {
            if ($db->transStatus() !== false) {
                $db->transRollback();
            }
            return $this->failServerError('No se pudo crear el armazón: ' . $e->getMessage());
        }
    }

    public function update($id = null)
    {
        $db = $this->frameModel->db;
        $itemModel = new ItemModel($db);

        if ($id === null) {
            return $this->failValidationError('ID requerido');
        }

        $frame = $this->frameModel->find($id);
        if (!$frame) {
            return $this->failNotFound('Armazón no encontrado');
        }

        $data = $this->request->getRawInput() ?: $this->request->getPost();

        $db->transException(true)->transBegin();
        try {
            // Update item
            $itemId = $frame->item ?? ($frame['item'] ?? null);
            if ($itemId) {
                $itemPayload = [];
                foreach ([
                    'key','name','barcode','model','color_key','color','line','brand','supplier'
                ] as $field) {
                    if (array_key_exists($field, $data)) {
                        $itemPayload[$field] = $data[$field];
                    }
                }
                // map alternative names coming from form
                if (isset($data['key_color'])) {
                    $itemPayload['color_key'] = $data['key_color'];
                }
                if (!empty($itemPayload)) {
                    $itemPayload['id'] = $itemId;
                    $itemModel->save($itemPayload);
                }
            }

            // Update frame
            $framePayload = [];
            if (array_key_exists('size', $data)) {
                $framePayload['size'] = $data['size'];
            } else {
                // Build size from individual fields if provided
                $size = [];
                foreach ([
                    'horizontal' => 'size_h',
                    'vertical'   => 'size_v',
                    'bridge'     => 'size_b',
                    'rod'        => 'size_r',
                ] as $k => $input) {
                    if (isset($data[$input]) && $data[$input] !== '') {
                        $size[$k] = (int) $data[$input];
                    }
                }
                if (!empty($size)) {
                    $framePayload['size'] = $size;
                }
            }
            if (!empty($framePayload)) {
                $framePayload['id'] = $id;
                $this->frameModel->save($framePayload);
            }

            $db->transCommit();

            // Return updated resource via show()
            return $this->show($id);
        } catch (\Throwable $e) {
            if ($db->transStatus() !== false) {
                $db->transRollback();
            }
            return $this->failServerError('No se pudo actualizar el armazón: ' . $e->getMessage());
        }
    }
    public function delete()
    {

    }
}
