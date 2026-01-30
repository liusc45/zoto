<?php

namespace App\Database\Seeds;

use App\Entities\Phone;
use App\Models\PhoneModel;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Database\Seeder;
use Config\Database;

class Phones extends Seeder
{
    public function run()
    {
        CLI::write("comienza inserción person phones  🤘🏻");
        
        
        $db = Database::connect("origin");
        
        $customersTable = $db->table('Clientes');
        
        $customers = $customersTable->get()->getResultObject();
        
        
        foreach($customers as $customer)
        {
            $phones[] = new Phone([
                "person"=>$customer->Id,
                "number"=>$customer->home_phone,
                "type"=>"casa"
            ]);
            $phones[] = new Phone([
                "person"=>$customer->Id,
                "number"=>$customer->work_phone,
                "type"=>"trabajo"
            ]);
            $phones[] = new Phone([
                "person"=>$customer->Id,
                "number"=>$customer->other_phone,
                "type"=>"otro"
            ]);
        }
        
        try {
            model(PhoneModel::class)->insertBatch($phones);
        } catch (\ReflectionException|DatabaseException $e) {
            return $e->getMessage();
        }
        
        
        CLI::write("person phones insertado 🤘🏻");
        
    }
}
