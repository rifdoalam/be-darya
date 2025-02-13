<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestObat extends Model
{
    use HasFactory;
    protected $table = 'request_obats';

    protected $fillable = [
        'user_id',
        'obat_id',
        'quantity',
        'status',
        'request_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
