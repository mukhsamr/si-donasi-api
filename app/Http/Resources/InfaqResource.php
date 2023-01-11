<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InfaqResource extends JsonResource
{
    public function toArray($request)
    {
        $find = $request->route()->parameter('infaq');

        $terkumpul = $this->transaksis()
            ->whereIn('transaction_status', ['settlement', 'capture'])
            ->sum('gross_amount');

        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'deskripsi' => $find
                ? $this->deskripsi
                : substr($this->deskripsi, 0, 80) . '...',

            'bank' => $this->bank,
            'rekening' => $this->rekening,
            'target' => $this->target,
            'gambar' => $this->gambar,
            'created' => $this->when($find, $this->created_at->format('d/m/Y')),

            'terkumpul' => number_format($terkumpul, 0, ',', '.'),

            'persentase' => $terkumpul > 0
                ? $terkumpul * 100 / $this->target
                : 0
        ];
    }
}
