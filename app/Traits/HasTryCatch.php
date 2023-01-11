<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

/**
 * Try Catch Trait
 */
trait HasTryCatch
{
    public static function execute(callable $try, callable $catch = null, $message = null): array
    {
        try {
            $try();

            $cond = true;
        } catch (\Throwable $th) {

            if (app()->isLocal()) dd($th);

            if ($catch) $catch();

            Log::error($th);
            $cond = false;
        }

        return [
            'type' => $cond,
            'message' => ($cond ? 'Berhasil ' : 'Gagal ') . $message
        ];
    }
}
