<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
class OrdenFabricacionExport implements FromCollection,ShouldAutoSize, WithHeadings
{
    public $ordenes = [];
    function __construct($ordenes){
        $this->ordenes = $ordenes;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = new Collection();
        $headers=[
            ['titulo'=>'Inventario inicial','key'=>'inventario_inicial'],
            ['titulo'=>'Total pedidos año pasado','key'=>'total_pedidos'],
            ['titulo'=>'Total a fabricar','key'=>'total_fabricar'],
            ['titulo'=>'Total de cajas a fabricar','key'=>'cajas'],
            ['titulo'=>'Total de torres a fabricar','key'=>'torres'],
        ];
        foreach($headers as $header){
            $result = [];
            $result[] = $header['titulo'];
            foreach($this->ordenes['articulos'] as $articulo){
                $result[] = number_format( $articulo[$header['key']],2,'.','');
            }
            $data->push($result);
        }
        //
        return $data ;
    }
    public function headings(): array
    { 
        $result = ['Articulo'];
        foreach($this->ordenes['articulos'] as $articulo){
            $result[] = $articulo['articulo']['descripcion'];
        }
        return $result;
    }
}
