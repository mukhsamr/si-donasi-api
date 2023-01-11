<?php

use App\Models\Infaq;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Infaq::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('order_id');
            $table->string('status_code');
            $table->string('transaction_id')->unique();
            $table->string('transaction_status');
            $table->unsignedInteger('gross_amount')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
