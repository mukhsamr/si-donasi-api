<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaporanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'bulan' => $this->bulan,
            'pdf' => $this->pdf,
            'created' => $this->created_at->format('d/m/Y')
        ];
    }
}
