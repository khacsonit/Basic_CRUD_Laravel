<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sach as Sach;
use App\Models\Tacgia as Tacgia;

class AuthorController extends Controller
{
    //
    public function showListBook($id){
        $sach = Tacgia::find($id)->sach;

        return Response()->json($sach);
    }
    public function showAuthor($id){
        $tacgia = Sach::find($id)->tacgia;

        return Response()->json($tacgia);
    }
}
