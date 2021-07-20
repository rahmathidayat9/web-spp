<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;

class Spp extends Model
{
    use HasFactory;

    protected $table = 'spp';

    protected $fillable = [
    	'tahun',
    	'nominal',
    ];

    public function siswa()
    {
    	return $this->hasMany(Siswa::class);
    }
}
