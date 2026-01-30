<?php

namespace App\Database\Seeds;

use App\Models\ItemModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class Inventory extends Seeder
{
    public function run()
    {
        $today = Time::today()->toDateString();
        $articles = model(ItemModel::class)->findAll();
        $inventory = [];
        foreach ($articles as $key => $article)
        {
            $inventory[$key] = [
                "code" => '',
                "item" => $article->id,
                "supplier" => 1,
                "store" => 1,
                "stock" => 20,
                "bill" => 'abc123',
                "enter_at" => $today ,
 
            ];
        }
       $this->db->table("inventory")->insertBatch($inventory);
    }
}
