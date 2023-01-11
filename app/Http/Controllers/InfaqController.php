<?php

namespace App\Http\Controllers;

use App\Http\Resources\InfaqResource;
use App\Models\Infaq;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InfaqController extends Controller
{
    use HasTryCatch;

    public function index()
    {
        $all = Infaq::all();
        return InfaqResource::collection($all);
    }

    public function find(Infaq $infaq)
    {
        return new InfaqResource($infaq);
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

                Infaq::create($request->input());
            },
            message: 'tambah kategori'
        );

        return $message;
    }

    public function update(Request $request)
    {
        $find = Infaq::find($request->id);

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
            message: 'edit kategori'
        );

        return $message;
    }

    public function destroy($id)
    {
        $find = Infaq::find($id);

        $message = $this::execute(
            try: function () use ($find) {

                // Hapus gambar lama
                $path = 'images/' . $find->gambar;
                if (File::exists('storage/' . $path)) {
                    Storage::delete($path);
                }

                $find->delete();
            },
            message: 'hapus kategori'
        );

        return $message;
    }
}
