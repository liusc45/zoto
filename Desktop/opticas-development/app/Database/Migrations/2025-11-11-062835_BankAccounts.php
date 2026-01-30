<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class BankAccounts extends Migration
{
    public function up()
    {
//        $this->forge->addColumn("payment_cards",[
//            "bank_payment_type"=>[
//                "type"=>"INT",
//                "constraint"=>11,
//                "unsigned"=>true,
//                "null"=>true,
//                "after"=>"commission",
//            ],
//            "store"=>[
//                "type"=>"INT",
//                "constraint"=>11,
//                "unsigned"=>true,
//                "null"=>true,
//                "after"=>"bank_payment_type",
//            ],
//            "bank_account"=> [
//                "type"=>"INT",
//                "constraint"=>11,
//                "unsigned"=>true,
//                "null"=>true,
//                "after"=>"store",
//            ]
//
//        ]);
//        $this->forge->addField([
//            "id"=>[
//                "type"=>"INT",
//                "constraint"=>11,
//                "unsigned"=>true,
//                "auto_increment"=>true
//            ],
//            "bank_name"=>[
//                "type"=>"VARCHAR",
//                "constraint"=>255,
//            ],
//            "alias"=>[
//                "type"=>"VARCHAR",
//                "constraint"=>255,
//            ],
//            "account_number"=>[
//                "type"=>"VARCHAR",
//                "constraint"=>255,
//                "null"=>true,
//            ],
//            "clabe"=>[
//                "type"=>"VARCHAR",
//                "constraint"=>255,
//                "null"=>true,
//            ],
//            "owner_name"=>[
//                "type"=>"VARCHAR",
//                "constraint"=>255,
//                "null"=>true,
//            ],
//            "store"=>[
//                "type"=>"INT",
//                "constraint"=>11,
//                "unsigned"=>true,
//                "null"=>true,
//
//            ],
//            "currency"=>[
//                "type"=>"varchar",
//                "constraint"=>11,
//            ],
//            "created_at"=>[
//                "type"=>"DATETIME",
//                "default"=>new RawSql("CURRENT_TIMESTAMP")
//
//            ],
//            "updated_at"=>[
//                "type"=>"DATETIME",
//                "null"=>true,
//                "default"=>new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP")
//            ],
//            "deleted_at"=>[
//                "type"=>"DATETIME",
//                "null"=>true,
//            ]
//        ])
//            ->addPrimaryKey("id")
//            ->addForeignKey("store","stores","id","CASCADE","SET NULL")
//            ->createTable("bank_accounts",true,["ENGINE"=>"InnoDB"]);
//        $this->db->disableForeignKeyChecks();
//
//        $this->forge->addForeignKey(
//            "bank_account",
//            "bank_accounts",
//            "id",
//            "CASCADE",
//            "SET NULL")->processIndexes("payment_cards");
//
//        $accounts = [
//            [
//                "bank_name" => "Banco Santander",
//                "alias" => "santander",
//                "store" => 1,
//                "currency" => "MXN",
//            ]
//            ,
//            [
//                "bank_name" =>"BBVA",
//                "alias" =>"BBVA",
//                "store" => 1,
//            ],
//            [
//                "bank_name" =>"CITI BANAMEX",
//                "alias" =>"BNMX",
//                "store"=>1,
//                "currency"=>"MXN",
//            ],
//            [
//                "name" =>"American Express",
//                "alias"=>"AMEX",
//                "store"=>1,
//                "currency"=>"MXN",
//            ]
//        ];
//        $this->db->table("bank_accounts")->insertBatch($accounts);
//        $cards = [
//            ["bank_account"=>1, "bank_payment_type" =>1,"commission"=>3.50 ],
//            ["bank_account"=>1, "bank_payment_type" =>2,"commission"=>3.50  ],
//            ["bank_account"=>1, "bank_payment_type" =>3,"commission"=>14.16  ],
//            ["bank_account"=>1, "bank_payment_type" =>4,"commission"=>14.16  ],
//            ["bank_account"=>1, "bank_payment_type" =>6,"commission"=>20.11  ],
//            ["bank_account"=>2, "bank_payment_type" =>1,"commission"=>1.75 ],
//            ["bank_account"=>2, "bank_payment_type" =>2,"commission"=>2.38 ],
//            ["bank_account"=>2, "bank_payment_type" =>3,"commission"=>2.38  ],
//            ["bank_account"=>2, "bank_payment_type" =>4,"commission"=>10.79  ],
//            ["bank_account"=>2, "bank_payment_type" =>6,"commission"=>17.27  ],
//            ["bank_account"=>3, "bank_payment_type" =>1,"commission"=>1.88 ],
//            ["bank_account"=>3, "bank_payment_type" =>2,"commission"=>2.87 ],
//            ["bank_account"=>3, "bank_payment_type" =>3,"commission"=>9.25  ],
//            ["bank_account"=>3, "bank_payment_type" =>4,"commission"=>13.01  ],
//            ["bank_account"=>3, "bank_payment_type" =>6,"commission"=>17.06  ],
//            ["bank_account"=>4, "bank_payment_type" =>2,"commission"=>3.10 ],
//
//        ];
//
//        $this->db->table("payment_cards")->insertBatch($cards);

    }

    public function down()
    {
        $this->forge->dropTable("bank_accounts");
    }
}
