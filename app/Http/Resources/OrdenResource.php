<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'fecha'=>$this->fecha,
            'factor_inc'=>$this->factor_inc,
            'observaciones'=>$this->observaciones,
            'urgencia'=>$this->urgencia,
            'finalizada'=>$this->finalizada,
            'articulos'=>$this->articulos,

        ];
    }
}
