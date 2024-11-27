<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
class EmpaquetadoExport implements FromCollection,ShouldAutoSize, WithHeadings
{
    public $produccion = [];
    public $headers = [];
    function __construct($produccion,$headers){
        $this->produccion = $produccion;
        $this->headers = $headers;
        $this->articulos = $headers;
        for($i = 0 ; $i <=3;$i++){
            array_shift($this->articulos);
        }
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = new Collection();

      
            $result = [];
            foreach($this->produccion['pedidos'] as $pedido){
                $result = [
                    $pedido['pedido']['nro'],
                    $pedido['pedido']['cliente']['nombre_fiscal'],
                    $pedido['pedido']['total_bolas'],
                ];
                foreach($this->articulos as $articulo){
                    if(isset($pedido[$articulo['text']])){
                        $result[]= $pedido[$articulo['text']];
                    }
                    else{
                        $result[] = '';
                    }
                }
                $data->push($result);
            }
          
        
        //
        return $data ;
    }
    public function headings(): array
    { 
        $result = [];
        foreach($this->headers as $header){
            $result[] = $header['text'];
        }
        return $result;
    }
}
