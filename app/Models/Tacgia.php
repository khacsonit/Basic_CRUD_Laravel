<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tacgia extends Model
{
    protected $table = 'tacgia';
    public $timestamps = FALSE;
    public function sach(){
        return $this->hasMany('App\Models\Sach','IdTacGia','id');
    }
}
