<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BeritaResource extends JsonResource
{
    public function toArray($request)
    {
        $find = $request->route()->parameter('berita');

        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'deskripsi' => $find
                ? $this->deskripsi
                : substr($this->deskripsi, 0, 80) . '...',

            'gambar' => $this->gambar,
            'created' => 'Dibuat: ' . $this->created_at->format('d/m/Y')
        ];
    }
}
