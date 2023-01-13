<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaporanRequest;
use App\Http\Resources\LaporanResource;
use App\Models\Laporan;
use App\Traits\HasTryCatch;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    use HasTryCatch;

    public function bulan()
    {
        return Laporan::select('bulan')->pluck('bulan');
    }

    public function index()
    {
        $all = Laporan::all();
        return LaporanResource::collection($all);
    }

    public function find(Laporan $laporan)
    {
        return new LaporanResource($laporan);
    }

    public function store(LaporanRequest $request)
    {
        $message = $this::execute(
            try: function () use ($request) {

                // Cek pdf
                if ($pdf = $request->file('pdf')) {
                    $request->merge(['pdf' => base64_encode(file_get_contents($pdf->getPathname()))]);
                }

                Laporan::create($request->input());
            },
            message: 'tambah laporan'
        );

        return $message;
    }

    public function update(LaporanRequest $request)
    {
        $find = Laporan::find($request->id);

        $message = $this::execute(
            try: function () use ($request, $find) {

                // Cek pdf
                if ($pdf = $request->file('pdf')) {
                    $request->merge(['pdf' => base64_encode(file_get_contents($pdf->getPathname()))]);
                }

                $update = collect($request->input())->except(['_method', 'id']);
                $find->update($update->toArray());
            },
            message: 'edit laporan'
        );

        return $message;
    }

    public function destroy($id)
    {
        $find = Laporan::find($id);

        $message = $this::execute(
            try: function () use ($find) {

                // Hapus pdf lama
                $path = 'pdf/' . $find->pdf;
                if (File::exists('storage/' . $path)) {
                    Storage::delete($path);
                }

                $find->delete();
            },
            message: 'hapus laporan'
        );

        return $message;
    }
}
