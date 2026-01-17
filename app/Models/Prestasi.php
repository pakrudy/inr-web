<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';
    protected $primaryKey = 'prestasi_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'judul_prestasi',
        'foto_sertifikat',
        'pemberi_rekomendasi',
        'status_prestasi',
        'validitas',
        'nomor_sertifikat_prestasi',
        'rekomendasi',
        'badge',
        'status_rekomendasi',
    ];

    /**
     * Get the user that owns the aforisme.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
        public function getRouteKeyName()
        {
            return 'prestasi_id';
        }
    
        /**
         * Get all of the prestasi's transactions.
         */
        public function transactions()
        {
            return $this->morphMany(Transaction::class, 'transactionable');
        }
    }
    