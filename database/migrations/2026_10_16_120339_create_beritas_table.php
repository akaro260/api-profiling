<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->string('gambar');
            $table->string('judul', 255);
            $table->longText('isian');
            $table->timestamps(); // Menghasilkan created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
