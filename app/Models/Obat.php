<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    
    use HasFactory;

    protected $table = 'obats';
    protected $fillable = [
            'nama_obat',
            'jenis_obat',
            'stock',
            'expired',
            'harga'
        ];
        protected $primaryKey = 'id';
        public function request_obat()
        {
            return $this->hasMany(RequestObat::class);
        }
    
}
