<?php

namespace App\Imports;
//modelos principales
use App\Models\Pedido\Pedido;
use App\Models\Pedido\PedidoLinea;
use App\Models\Pedido\PedidoLineaAccesorio;
use App\Models\Pedido\PedidoLineaDimension;
use App\Models\Pedido\PedidoLineaDireccion;
use App\Models\Pedido\PedidoLineaPerfil;
use App\Models\Pedido\PedidoLineaProducto;
use App\Models\Pedido\PedidoLineaVidrio;
use App\Models\Pedido\ParametrosPedido;
use App\Models\Pedido\PedidoJuntas;
use App\Models\Pedido\PedidoPerfilPared;
use App\Models\Pedido\PedidoDireccionTipo;
use App\Models\Pedido\PedidoColorVidrio;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Carbon;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\FromCollection;

class PedidoImport implements OnEachRow, FromCollection
{
    public $fecha = '';
    public $pedido = null;

    public function collection()
    {
        //$liquidaciones = Liquidacione::all();
        $data = new Collection();
        
        
        return $data ;
    }
    
   
    public function onRow(Row $row)
    {
    
        
    }
}
