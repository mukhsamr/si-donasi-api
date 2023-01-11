<?php

namespace App\Http\Controllers;

use App\Http\Resources\BeritaResource;
use App\Models\Berita;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    use HasTryCatch;

    public function index()
    {
        $all = Berita::all();
        return BeritaResource::collection($all);
    }

    public function find(Berita $berita)
    {
        return new BeritaResource($berita);
    }

    public function store(Request $request)
    {
        $message = $this::execute(
            try: function () use ($request) {

                // Cek gambar
                if ($gambar = $request->file('gambar')) {
                    $nama = Str::slug($request->judul) . '.' . $gambar->extension();

                    $gambar->storePubliclyAs('images', $nama);
                    $request->merge(['gambar' => $nama]);
                }

                Berita::create($request->input());
            },
            message: 'tambah berita'
        );

        return $message;
    }

    public function update(Request $request)
    {
        $find = Berita::find($request->id);

        $message = $this::execute(
            try: function () use ($request, $find) {

                // Cek gambar
                if ($gambar = $request->file('gambar')) {

                    // Hapus gambar lama
                    $path = 'images/' . $find->gambar;
                    if (File::exists('storage/' . $path)) {
                        Storage::delete($path);
                    }

                    $nama = Str::slug($request->judul) . '.' . $gambar->extension();
                    $gambar->storePubliclyAs('images', $nama);
                    $request->merge(['gambar' => $nama]);
                }

                $update = collect($request->input())->except(['_method', 'id']);
                $find->update($update->toArray());
            },
            message: 'edit berita'
        );

        return $message;
    }

    public function destroy($id)
    {
        $message = $this::execute(
            try: function () use ($id) {

                $find = Berita::find($id);

                // Hapus gambar
                $path = 'images/' . $find->gambar;
                if (File::exists('storage/' . $path)) {
                    Storage::delete($path);
                }

                $find->delete();
            },
            message: 'hapus berita'
        );

        return $message;
    }
}
