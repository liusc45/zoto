<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Seeds\PreviousConsultations;
use App\Entities\PersonPhone;
use App\Models\BrandModel;
use App\Models\ColorModel;
use App\Models\CompanyModel;
use App\Models\ItemModel;
use App\Models\ExpensesCategoryModel;
use App\Models\ItemPriceModel;
use App\Models\LineModel;
use App\Models\PatientModel;
use App\Models\PersonPhoneModel;
use App\Models\SupplierModel;
use Aws\Credentials\CredentialProvider;
use Aws\Credentials\Credentials;
use Aws\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\ObjectUploader;
use Aws\S3\S3Client;
use Aws\Sdk;
use Aws\AwsClientTrait;
use Aws\S3\S3ClientTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Config\Database;
use GuzzleHttp\Promise\Create;

class Dummy extends BaseController
{
    private S3Client $client;

    public function __construct()
    {
        $this->client = new S3Client([
            'version' => 'latest',
            'region'  => 'us-nyc3',
            'endpoint' => env("iDrive.Endpoint"),
            'use_path_style_endpoint' => false, // Configures to use subdomain/virtual calling format.
            'credentials' =>   new Credentials(
                env("iDrive.Access_Key_ID"),
                env("iDrive.Secret_Access_Key")
            )
        ]);
    }


    
    
    public function debugger()
    {
        $notDate = '';

        $date = Time::parse($notDate);

        dd($date);
       //   return $this->response->setJSON($articles);

    }


    public function storage()
    {
        


        $objects = $this->client->getObject(["Bucket"=>env("iDrive.Bucket"),"Key" => "profile.jpeg"]);

        $body = $objects->get('Body');
        $mimeType = $objects->get('ContentType');
        $this->response->setHeader("Content-Type",$mimeType);
        return $body->getContents();

    }

    public function upload()
    {

        $files = $this->request->getFiles();

        $bucket = env("iDrive.Bucket");


        foreach ($files as $file) {
            $name =$file->getClientName();
            $name = str_replace(" ","_",$name);

            $source = $file->getTempName();
            $key = "optica/". $name;

            try {
                $this->client->putObject([
                    'Bucket' => $bucket,
                    'Key' => $key,
                    "SourceFile" => $source,
                ]);
            }catch (MultipartUploadException $e) {
                return $e->getMessage();
            }
        }

        return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED);



        #$source = fopen(WRITEPATH."uploads/profile.jpeg", 'rb');
        #$source = fopen($_FILES[0]["tmp_name"], 'rb');

        $uploader = new ObjectUploader(
            $this->client,
            $bucket,
            $key,
            $source
        );

        do {
            try {
                $result = $uploader->upload();
                if ($result["@metadata"]["statusCode"] == '200') {
                    print'<p>File successfully uploaded to ' . $result["ObjectURL"] . '.</p>';
                }
                print $result;
                // If the SDK chooses a multipart upload, try again if there is an exception.
                // Unlike PutObject calls, multipart upload calls are not automatically retried.
            } catch (MultipartUploadException $e) {
                rewind($source);
                $uploader = new MultipartUploader($this->client, $source, [
                    'state' => $e->getState(),
                ]);
            }
        } while (!isset($result));

        fclose($source);
        d($result);

    }
    
    public function phones()
    {
        $db = Database::connect("dev");
        
        $customersTable = $db->table('customers');
        
        $customers = $customersTable
            ->select([
                "persons.id as person",
                "customers.internal_id",
                "customers.company",
                
            ])
            ->join("persons", new RawSql("concat(customers.full_name,customers.last_name) = concat(persons.name,persons.last_name)"))
            ->get()->getResultObject();
        
        
        foreach($customers as $customer)
        {
            $patients[] = new \App\Entities\Patient([
                "person"=>$customer->person,
                "company"=>$customer->company,
                "original_id"=>$customer->internal_id,
            ]);
          
        }
        
        try {
            model(PatientModel::class)->insertBatch($patients);
        } catch (\ReflectionException|DatabaseException $e) {
            return $e->getMessage();
        }
        
    }
    public function pricesJson()
    {
        $itemPrice = new ItemPriceModel();

        $prices = $itemPrice->select([
            "item",
            "concat('[',group_concat(json_object('type',type,'amount',amount,'starts_at',starts_at)),']') as prices",
        ])
            ->groupBy("item")
            ->findAll();


        return $this->response->setJSON($prices);
    }


    public function stockable()
    {
        $item =model(ItemModel::class)->find(13479);
        $stockable = $item->isStockable();
        dd($item,$stockable);
    }

    public function sale()
    {

    }

    public function seed()
    {
        ini_set('memory_limit', '-1');
        Database::seeder()->call(PreviousConsultations::class);

    }

    public function filters()
    {
        $filters = [
            "lines" => model(LineModel::class)->findAll(),
            "brands" => model(BrandModel::class)->findAll(),
            "colors" => model(ColorModel::class)->findAll(),
            "models" => model(ItemModel::class)
                ->select(["distinct (model) as model"])
                ->orderBy("model","ASC")
                ->where("model ","IS NOT NULL")
                ->findAll(),
            "suppliers" => model(SupplierModel::class)->findAll(),
            "sizes" => model(ItemModel::class)
                ->select(["distinct(size) as model"])
                ->orderBy("model","ASC")
                ->findAll(),

        ];

        return view("components/catalogs",$filters);

    }
    
}
