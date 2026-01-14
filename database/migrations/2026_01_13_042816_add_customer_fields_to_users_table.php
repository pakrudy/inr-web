<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Mengubah default role untuk registrasi baru
            $table->string('role')->default('pelanggan')->comment('admin, editor, pelanggan')->change();

            // Menambahkan kolom baru untuk data pelanggan
            $table->string('nama_lengkap')->nullable()->after('name');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('nama_lengkap');
            $table->text('biodata')->nullable()->after('jenis_kelamin');
            $table->string('nomor_whatsapp')->nullable()->after('biodata');
            $table->string('jabatan_terkini')->nullable()->after('nomor_whatsapp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('editor')->change();
            
            $table->dropColumn([
                'nama_lengkap',
                'jenis_kelamin',
                'biodata',
                'nomor_whatsapp',
                'jabatan_terkini',
            ]);
        });
    }
};