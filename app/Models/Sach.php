<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sach extends Model
{
    protected $table = 'sach';
    public $timestamps = FALSE;
    public function tacgia(){
        return $this->belongsTo('App\Models\Tacgia','IdTacGia','id');
    }
    public function theloai(){
        return $this->belongsTo('App\Models\Theloai','IdTheLoai','id');
    }
}
