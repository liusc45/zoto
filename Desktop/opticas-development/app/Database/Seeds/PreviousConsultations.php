<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PreviousConsultations extends Seeder
{
    public function run()
    {
        //$previousConsultations = [];

        $origin = db_connect("origin");
        $previousConsultations = $origin->table("Consultas")->get()->getResultArray();

       $fields = [
            "Ide",
            "Clientes",
            "fecha_consulta",
            "Examino",
            "Salud_General",
            "Material",
            "Tipo",
            "COLOR",
            "tratamiento",
            "Monofocal",
            "Bifocal",
            "AVD",
            "AVI",
            "CVD",
            "CVI",
            "GDESF",
            "GDCIL",
            "GDEJE",
            "GDADD",
            "GIESF",
            "GICIL",
            "GIEJE",
            "GIADD",
            "GAVD",
            "GAVI",
            "GDIP",
            "LCDQ",
            "LCDC",
            "LCDAP",
            "LCDP",
            "LCDRL",
            "LCDFE",
            "LCTIPO",
            "LCMARCA",
            "LCCOLOR",
            "LCIQ",
            "LCIC",
            "LCIAP",
            "LCIP",
            "LCIRL",
            "LCIFE",
            "LCDCB",
            "LCDDIAM",
            "LCICB",
            "LCIDIAM",
            "LCNOTAS",
            "LCDAV",
            "LCIAV",
            "USADOANTEOJOS",
            "SEGMANTPOST",
            "PANTALLEO",
            "NOTAS",
            "CORRECCIONOPTICA",
            "TIPOCORRECCION",
            "AOCORECCIONOPT",
            "TXORTOPTICO",
            "LCUSO",
            "LCFECHAENTREGA",
            "Nombre",
            "Armazon",
            "GDESF2",
            "GDCIL2",
            "GDEJE2",
            "GIESF2",
            "GICIL2",
            "GIEJE2",
            "GDESF3",
            "GDCIL3",
            "GDEJE3",
            "GIESF3",
            "GICIL3",
            "GIEJE3",
            "GAVD3",
            "GAVI3",
            "FACTURA",
            "GDIPPD1",
            "GDIPPD2",
            "GDIPPD3",
            "GDIPPI1",
            "GDIPPI2",
            "GDIPPI3",
            "PANORAMICO",
            "PANTOSCOPICO",
            "DV",
            "INICIALES",
            "LCVarMarc",
            "NV"
        ];
      $jsonData = json_encode($previousConsultations,JSON_PRETTY_PRINT);
        $filePath = WRITEPATH . 'data/my_data.json';
        file_put_contents($filePath, $jsonData);
    }
}
