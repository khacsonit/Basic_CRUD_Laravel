<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sach as Sach;
use App\Models\Tacgia as Tacgia;
use App\Models\Theloai as Theloai;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $sach = Sach::all();
        $tacgia = Tacgia::all();
        $theloai = Theloai::all();
        return view('home',['sach' => $sach, 'tacgia' => $tacgia ,'theloai' => $theloai]);        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $sach = new Sach();
        $sach->TenSach = $request->tensach;
        $sach->MoTa = $request->mota;
        $sach->NamXb = $request->namxuatban;

        $photo = $request->file('file');
        $rand = rand() . '.' . $photo->getClientOriginalExtension();
        $sach->Anh = 'images/' . $rand;
        $photo->move(public_path('images'),$rand);

        $sach->SoLuong = $request->soluong;
        $sach->IdTacGia = $request->tacgia;
        $sach->IdTheLoai = $request->theloai;
        $sach->save();
      
        return Response()->json(['sach' => $sach,
                                'tacgia' => $sach->tacgia->TenTacGia,
                                'theloai' => $sach->theloai->TenTheLoai
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //

        $sach = Sach::find($request->id);
        return $sach;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $sach = Sach::find($request->id);
        $srcImage = $sach->Anh;
        File::delete($srcImage);

        $sach->TenSach = $request->tensach;
        $sach->MoTa = $request->mota;
        $sach->NamXb = $request->namxuatban;

        $photo = $request->file('file');
        $rand = rand() . '.' . $photo->getClientOriginalExtension();
        $sach->Anh = 'images/' . $rand;
        $photo->move(public_path('images'),$rand);

        $sach->SoLuong = $request->soluong;
        $sach->IdTacGia = $request->tacgia;
        $sach->IdTheLoai = $request->theloai;
        $sach->save();
        return true;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        $srcImage = $request->srcImage;
        $sach = Sach::find($id);
        $TenSach = $sach->TenSach;
        $sach->delete();
        File::delete($srcImage);
        return $TenSach;
    }
}
