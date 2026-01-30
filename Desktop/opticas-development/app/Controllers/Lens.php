<?php

namespace App\Controllers;

use AllowDynamicProperties;
use App\Controllers\BaseController;
use App\Models\AdditionalTreatmentModel;
use App\Models\ItemModel;
use App\Models\LensColorModel;
use App\Models\LensDesignModel;
use App\Models\LensMaterialModel;
use App\Models\LensModel;
use App\Models\LensTreatmentModel;
use App\Models\LensTypeModel;
use App\Models\TreatmentModel;
use App\Services\LensService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Lens extends BaseController
{
    use ResponseTrait;
    protected LensModel $lensModel;

    public function __construct()
    {

        $this->lensModel = new LensModel();
    }

    public function index(): ResponseInterface
    {
        $lenses = $this->lensModel
            ->select([
                "lenses.id id",
                "lenses.item item",
                "lens_designs.name design",
                "category_sphere",
                "range_sphere" ,
                "category_cylinder",
                "range_cylinder",
                "max_graduation" ,
                "over_processed" ,
                "arrival_days" ,
                "frame_type" ,
                "optical_correction" ,
                "lens_materials.name material" ,
                "lens_types.name type" ,
                "lens_colors.name color" ,
                "lens_correction_types.name correction_type",
                "lens_treatments.name treatment",
                "comments",
                "item_prices.amount price",
            ])
            ->join("item_prices","item_prices.item = lenses.item and item_prices.type = 'regular'")
            ->join("lens_designs","lens_designs.id = lenses.design","left")
            ->join("lens_materials","lens_materials.id = lenses.material","left")
            ->join("lens_types","lens_types.id = lenses.type","left")
            ->join("lens_correction_types","lens_correction_types.id = lenses.correction_type","left")
            ->join("lens_colors","lens_colors.id = lenses.color","left")
            ->join("lens_treatments","lens_treatments.id = lenses.treatment","left")
            ->findAll();

        return $this->respond($lenses);
    }

    public function create(): ResponseInterface
    {
        $postData = $this->request->getPost();

        // Primero crear el item si es necesario
        $itemModel = new ItemModel();
        $itemModel->save($this->request->getPost());;

        // Agregar el item_id a los datos del lente
        $postData['item'] = $itemModel->getInsertID();

        $lens = new \App\Entities\Lens($postData);

        try {
            $saved = $this->lensModel->save($lens);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $saved?
            $this->respondCreated($this->lensModel->find($this->lensModel->getInsertID())):
            $this->fail($this->lensModel->errors());

    }

    public function update($id): ResponseInterface
    {
        $lens = $this->lensModel->find($id);
        $lens->fill($this->request->getRawInput());
        $lens->fill(["updated_at" =>Time::now()]);
        try {
            $updated = $this->lensModel->save($lens);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }

        return $updated?
            $this->respondUpdated($lens):
            $this->fail($this->lensModel->errors());
    }

    public  function delete($id): ResponseInterface
    {
        $lens = $this->lensModel->find($id);
        $this->lensModel->delete($id);
        return $this->respondDeleted($lens);
    }
    public function main()
    {
        $lensService = new LensService();
        $data = [
            "catalogs"=>$lensService->getCatalogs(),
            ...$lensService->getCatalogsData(),

        ];

        
        return view('components/lens/main', $data);

    }
}
