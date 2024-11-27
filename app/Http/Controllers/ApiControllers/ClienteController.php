<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\ClienteGrupo;
use App\Models\TipoCliente;
use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function getClientes(Request $request)
    {
        $clientes = Cliente::with(['Grupo', 'DireccionFacturacion', 'DireccionEnvio']);
        if ($request->busqueda) {
            $clientes->where(function ($query) use ($request) {
                $query->where('nombre_fiscal', 'like', '%'.$request->busqueda.'%');
                $query->orWhere('nombre', 'like', '%'.$request->busqueda.'%');
                $query->orWhere('apellidos', 'like', '%'.$request->busqueda.'%');
                $query->orWhere('cif', 'like', '%'.$request->busqueda.'%');
                $query->orWhere('email', 'like', '%'.$request->busqueda.'%');
                //   $query->orWhere('telefono','like','%'.$request->busqueda.'%');
            });
        }
        $clientes = $clientes->paginate($request->cantidad ?? 15);

        return $clientes;
    }

    public function getCliente($id)
    {
        $cliente = Cliente::with(['Grupo', 'DireccionFacturacion', 'DireccionEnvio'])->find($id);
        if ($cliente->direccion_envio == null) {
            $cliente->direccion_envio = ['id' => null];
        }
        if ($cliente->direccion_facturacion == null) {
            $cliente->direccion_facturacion = ['id' => null];
        }

        return $cliente;
    }

    public function deleteCliente($id)
    {
        $cliente = Cliente::find($id)->delete();
    }

    public function saveCliente(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            $msg = $messages[0];

            return response()->json(['status' => false,  'message' => $msg], 400);
        }

        return DB::transaction(function () use ($request) {
            $clientes = Cliente::updateOrCreate(['id' => $request->id], $request->all());

            $direccion_envio = $this->saveDireccion($request->direccion_envio);
            $direccion_facturacion = $this->saveDireccion($request->direccion_facturacion);
            $clientes->update([
                'id_direccion_envio' => $direccion_envio->id,
                'id_direccion_facturacion' => $direccion_facturacion->id,
            ]);
        });
    }

    public function saveDireccion($datos)
    {
        $direccion = Direccion::updateOrCreate(['id' => $datos['id'] ?? null], [
            'telefono' => $datos['telefono'] ?? null,
            'direccion' => $datos['direccion'] ?? null,
            'ciudad' => $datos['ciudad'] ?? null,
            'id_provincia' => $datos['id_provincia'] ?? null,
            'id_pais' => $datos['id_pais'] ?? null,
            'codigo_postal' => $datos['codigo_postal'] ?? null,
        ]);

        return $direccion;
    }

    // Aux
    public function getGrupos()
    {
        return ClienteGrupo::all();
    }

    public function getTipoCliente() {
        return TipoCliente::all();
    }
}
