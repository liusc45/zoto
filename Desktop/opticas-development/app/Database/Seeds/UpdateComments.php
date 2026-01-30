<?php

namespace App\Database\Seeds;

use App\Models\ConsultationModel;
use CodeIgniter\Database\Seeder;

class UpdateComments extends Seeder
{
    
    public function run()
    {
        $consultationModel = new ConsultationModel();
        $db = db_connect("origin");
        $table  = $db->table("Laboratorio");
        $legacyOrders = $table->get()->getResultObject();
        
        $this->processOrders($legacyOrders);
        
//        $data = $table->get()->getResultArray();
    }
    
    public function processOrders($orders)
    {
        $consultationModel = new ConsultationModel();
        
        
        foreach($orders as $order)
        {
            $actualOrder = $consultationModel
                ->like('comments',"Ide: 	$order->consulta_id\n","both")
                ->first();
            if($actualOrder)
            {
                $toConcat= '';
                foreach($order as $key => $value)
                {
                    $toConcat .= "$key : \t $value: \n" ;
                    
                }
                $actualOrder->comments .="orden legada :". $toConcat;
                $consultationModel->save($actualOrder);
            }
        }
        
    }
}
