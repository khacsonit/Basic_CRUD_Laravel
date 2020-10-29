@extends('layout')

@section('title', 'Danh mục sách')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />    
@endsection

@section('jscss')
      {{-- //cho table --}}

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<style>
    body {
        color: #404E67;
        background: #F5F7FA;
        font-family: 'Open Sans', sans-serif;
    }
    .table-wrapper {
        width: 100%;
        margin: 10px auto;
        background: #fff;
        padding: 20px;	
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
    }
    .table-title h2 {
        margin: 6px 0 0;
        font-size: 22px;
    }
    .table-title .add-new {
        float: right;
        height: 30px;
        font-weight: bold;
        font-size: 12px;
        text-shadow: none;
        min-width: 100px;
        border-radius: 50px;
        line-height: 13px;
    }
    .table-title .add-new i {
        margin-right: 4px;
    }
    table.table {
        table-layout: fixed;
    }
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table th:last-child {
        width: 100px;
    }
    table.table td a {
        cursor: pointer;
        display: inline-block;
        margin: 0 5px;
        min-width: 24px;
    }    
    table.table td a.add {
        color: #27C46B;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }
    table.table td a.add i {
        font-size: 24px;
        margin-right: -1px;
        position: relative;
        top: 3px;
    }    
    table.table .form-control {
        height: 32px;
        line-height: 32px;
        box-shadow: none;
        border-radius: 2px;
    }
    table.table .form-control.error {
        border-color: #f50000;
    }
    table.table td .add {
        display: none;
    }
    
    </style>
<script>
    var idSachSua;
    $(document).ready(function(){
        var actions = $("table td:last-child").html();
        // Append table with add row form on add new button click
        $(".add-new").click(function(){
            // $(this).attr("disabled", "disabled");
            // var index = $("table tbody tr:last-child").index();
            // var row = '<tr>' +
            //     '<td><input type="text" class="form-control" name="name" id="name"></td>' +
            //     '<td><input type="text" class="form-control" name="department" id="department"></td>' +
            //     '<td><input type="text" class="form-control" name="phone" id="phone"></td>' +
            //     '<td>' + actions + '</td>' +
            // '</tr>';
            // $("table").append(row);		
            // $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
            // $('[data-toggle="tooltip"]').tooltip();
        });
        // Add row on add button click
        $(document).on("click", ".add", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"]');
            input.each(function(){
                if(!$(this).val()){
                    $(this).addClass("error");
                    empty = true;
                } else{
                    $(this).removeClass("error");
                }
            });
            $(this).parents("tr").find(".error").first().focus();
            if(!empty){
                input.each(function(){
                    $(this).parent("td").html($(this).val());
                });			
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").removeAttr("disabled");
            }		
        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function(){
            

            var tr = $(this).parents().parents();	
            console.log(tr.attr('key'));
            idSachSua = tr.attr('key');
            $.ajaxSetup({
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                });
                $.ajax({
                    url : "{{url('sach/laysach')}}",
                    type: 'GET',
                    cache: false,
                    data: {
                        id: tr.attr('key')
                    },
                    success: function(result){
                        console.log(result);
                        // console.log('Xóa thành công'+result);
                        // var kq = "Xoá sách <b>"+result+"</b> thành công";
                        // $('#thongBao').html(kq);
                        // $('.toast').toast('show');  
                        // window.location.href = "#page-top";
                        $('#modalSuaSach').modal('show');
                        $('#tensachs').val(result.TenSach);
                        $('#motas').val(result.MoTa);
                        $('#namxuatbans').val(result.NamXb);
                        $('#soluongs').val(result.SoLuong);
                        var idtacgia = "#tacgias option[value="+result.IdTacGia+"]";
                        var idtheloai = "#theloais option[value="+result.IdTheLoai+"]";
                        $(idtacgia).prop("selected", true);
                        $(idtheloai).prop("selected", true);
                        
                        
                        
                    },
                });

        });
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            var tr = $(this).parents().parents();		
            console.log(tr.attr('key'));	
            
            var tenSach  = $(this).parents().parents().children().eq(0).text();
            var imageSource  = $(this).parents().parents().children().eq(3).children().attr('src');
            console.log($(this).parents().parents().children().eq(3).children().attr('src'));
            $('#exampleModalLongTitle').html("Xóa sách "+tenSach+" ?");
            $('#modalBody').html("<img src='"+ imageSource + "' style='height:80%;width:100%' />");
            $('#modalYesNo').modal('show');

            //action after confirm delete
            var t = this;
            $('#btnXacNhanXoa').on('click',function(){
                $(t).parents("tr").remove();
                $(".add-new").removeAttr("disabled");

                $.ajaxSetup({
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                });
                $.ajax({
                    url : "{{url('sach/xoasach')}}",
                    type: 'GET',
                    cache: false,
                    data: {
                        id: tr.attr('key'),
                        srcImage: imageSource
                    },
                    success: function(result){
                        console.log('Xóa thành công'+result);
                        var kq = "Xoá sách <b>"+result+"</b> thành công";
                        $('#thongBao').html(kq);
                        $('.toast').toast('show');  
                        window.location.href = "#page-top";
                    },
                });
            });
            
        });
        
        $('#edit_form').on('submit',function(e){
            e.preventDefault();
            var formdata = new FormData(this);
            formdata.append('id',idSachSua);
            formdata.append('tensach',$('#tensachs').val());
            formdata.append('mota',$('#motas').val());
            formdata.append('namxuatban',$('#namxuatbans').val());
            formdata.append('file',$('#files').val());
            formdata.append('soluong',$('#soluongs').val());
            formdata.append('tacgia',$('#tacgias').val());
            formdata.append('theloai',$('#theloais').val());

            console.log();
            $.ajaxSetup({
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
            });
            $.ajax({
                url: "{{url('sach/suasach')}}",
                type: 'POST',
                contentType: false,
                processData: false,
                data: formdata,
                dataType: 'JSON',
                cache: false,
                success: function(result){
               
                    var kq = "Cập nhật sách thành công";
                    $('#thongBao').html(kq);
                    $('.toast').toast('show');
                    window.location.href = "#page-top";
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                    var kq = "Không thể  cập nhật sách";
                    $('#thongBao').html(kq);
                    $('.toast').toast('show');
                    window.location.href = "#page-top";
                }
            });
        });
        
        $(document).on("click","#btnSuaSach",function(){
            
            $('#modalSuaSach').modal('hide');
            $('.modal-backdrop').hide();
            

        });

        $(document).on("click","#btnThemsach",function(){
            
            $('#modalThemsach').modal('hide');
            $('.modal-backdrop').hide();
            

        });
        $('#upload_form').on('submit',function(e){
            e.preventDefault();
            var formdata = new FormData(this);
            formdata.append('tensach',$('#tensach').val());
            formdata.append('mota',$('#mota').val());
            formdata.append('namxuatban',$('#namxuatban').val());
            formdata.append('file',$('#file').val());
            formdata.append('soluong',$('#soluong').val());
            formdata.append('tacgia',$('#tacgia').val());
            formdata.append('theloai',$('#theloai').val());

            $.ajaxSetup({
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
            });
            $.ajax({
                url: "{{url('sach/themmoi')}}",
                type: 'POST',
                contentType: false,
                processData: false,
                data: formdata,
                dataType: 'JSON',
                cache: false,
                success: function(result){
                    console.log(result);
                    var ht = "<tr key='"+result.sach.id+"'>"+ 
                        "<td>"+result.sach.TenSach+"</td> "+
                        "<td>"+result.sach.MoTa+"</td>"+
                        "<td>"+result.sach.NamXb+"</td> "+
                        "<td><img src='"+result.sach.Anh+"' style='width: 50px;height: 50px;'/></td>"+
                        "<td>"+result.sach.SoLuong+"</td> " +
                        "<td>"+result.theloai+"</td> " +
                        "<td>"+result.tacgia+"</td> " +
                        "<td>"+
                            "<a class='add' title='Add' data-toggle='tooltip'><i class='material-icons'>&#xE03B;</i></a>"+
                            "<a class='edit' title='Edit' data-toggle='tooltip'><i class='material-icons'>&#xE254;</i></a>"+
                            "<a class='delete' title='Delete' data-toggle='tooltip'><i class='material-icons'>&#xE872;</i></a>"+
                        "</td>"+
                    "</tr>";
                    $("table").append(ht);

                    
                    var kq = "Thêm sách <b>"+result.sach.TenSach+"</b> thành công";
                    $('#thongBao').html(kq);
                    $('.toast').toast('show');
                    window.location.href = "#page-top";
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                    var kq = "Không thể  thêm sách";
                    $('#thongBao').html(kq);
                    $('.toast').toast('show');
                    window.location.href = "#page-top";
                }
            });
        });
    });
    </script>

@endsection

@section('content')
    @parent

    {{-- table --}}

    <div class="container-lg">
        <div class="table-responsive" style="width: 110%; margin-left: -3rem">
            <div class='toast' data-delay='7000' style='position: absolute;top: 25px; right: 5px; width:500px; text-align:center'>
                <div class='toast-header' >
                 <h3> Thông báo</h3>
                </div>
                <div class='toast-body'>
                <h4 id="thongBao"></h4>
                </div>
            </div>
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Bảng chi tiết <b>sách</b></h2></div>
                        <div class="col-sm-4">
                            <h2>
                                <div class="text-center">
                                    <a href="" class="btn btn-primary " data-toggle="modal" data-target="#modalThemsach">Thêm mới sách</a>
                                </div>
                            </h2>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên sách</th>
                            <th>Mô tả</th>
                            <th>Năm xuất bản</th>
                            <th>Ảnh</th>
                            <th>Số lượng</th>
                            <th>Thể loại</th>
                            <th>Tác giả</th>
                            <th>Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($sach)>0)
                            @foreach ($sach as $item)
                                <tr key="{{$item->id}}">
                                    <td>{{$item->TenSach}}</td>
                                    <td>{{$item->MoTa}}</td>
                                    <td>{{$item->NamXb}}</td>
                                    <td><img src="{{$item->Anh}}" style="width: 50px;height: 50px;"/></td>
                                    <td>{{$item->SoLuong}}</td>
                                    <td>{{$item->theloai->TenTheLoai}}</td>
                                    <td>{{$item->tacgia->TenTacGia}}</td>
                                    <td>
                                        <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                        <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                                Không có bản ghi nào
                        @endif   
                    </tbody>
                </table>

                {{-- form --}}
                <form method="GET" action="" enctype="multipart/form-data" id="upload_form">
                    <div class="modal fade" id="modalThemsach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Nhập thông tin sách</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">
                                <div class="md-form mb-1">
                                <i class="fas fa-envelope prefix grey-text"></i>
                                <input type="text" id="tensach" name="tensach" class="form-control ">
                                <label >Tên sách</label>
                                </div>

                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>
                                    <input type="text" id="mota" name="mota" class="form-control ">
                                    <label >Mô tả</label>
                                </div>

                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>
                                    <input type="text" id="namxuatban" name="namxuatban"class="form-control ">
                                    <label >Năm xuất bản</label>
                                </div>

                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>
                                    <div class="file-field">
                                        <div class="btn btn-primary btn-sm float-left">
                                        <span>Chọn ảnh</span>
                                        <input type="file" id="file" name="file">
                                        </div>
                                    
                                    </div>
                                </div>
                                <br/>
                                <br/>
                                <br/>
                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>
                                    <input type="text" id="soluong" name="soluong" class="form-control ">
                                    <label >Số lượng</label>
                                </div>
                                
                            
                            
                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>

                                    <select class="browser-default custom-select" id="tacgia" name="tacgia" >
                                        @if(count($tacgia)>0)
                                            @foreach ($tacgia as $item)
                                                <option value="{{$item->id}}">{{$item->TenTacGia}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label >Tác giả</label>
                                </div>

                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>
                                    <select class="browser-default custom-select" id="theloai" name="theloai" >
                                        @if(count($theloai)>0)
                                            @foreach ($theloai as $item)
                                                <option value="{{$item->id}}">{{$item->TenTheLoai}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label >Thể loại</label>
                                </div>

                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <input type="submit" class="btn btn-primary" id="btnThemsach" value="Thêm mới" />
                            </div>
                            </div>
                        </div>
                    </div>
                </form>
                
                {{--  --}}
                {{--  --}}
                <form method="POST" action="" enctype="multipart/form-data" id="edit_form">
                    <div class="modal fade" id="modalSuaSach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Sửa sách</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">
                                <div class="md-form mb-1">
                                <i class="fas fa-envelope prefix grey-text"></i>
                                <input type="text" id="tensachs" name="tensach" class="form-control ">
                                <label >Tên sách</label>
                                </div>

                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>
                                    <input type="text" id="motas" name="mota" class="form-control ">
                                    <label >Mô tả</label>
                                </div>

                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>
                                    <input type="text" id="namxuatbans" name="namxuatban"class="form-control ">
                                    <label >Năm xuất bản</label>
                                </div>

                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>
                                    <div class="file-field">
                                        <div class="btn btn-primary btn-sm float-left">
                                        <span>Chọn ảnh</span>
                                        <input type="file" id="files" name="file">
                                        </div>
                                    
                                    </div>
                                </div>
                                <br/>
                                <br/>
                                <br/>
                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>
                                    <input type="text" id="soluongs" name="soluong" class="form-control ">
                                    <label >Số lượng</label>
                                </div>
                                
                            
                            
                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>

                                    <select class="browser-default custom-select" id="tacgias" name="tacgia" >
                                        @if(count($tacgia)>0)
                                            @foreach ($tacgia as $item)
                                                <option value="{{$item->id}}">{{$item->TenTacGia}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label >Tác giả</label>
                                </div>

                                <div class="md-form mb-1">
                                    <i class="fas fa-envelope prefix grey-text"></i>
                                    <select class="browser-default custom-select" id="theloais" name="theloai" >
                                        @if(count($theloai)>0)
                                            @foreach ($theloai as $item)
                                                <option value="{{$item->id}}">{{$item->TenTheLoai}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label >Thể loại</label>
                                </div>

                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <input type="submit" class="btn btn-primary" id="btnSuaSach" value="Cập nhật" />
                            </div>
                            </div>
                        </div>
                    </div>
                </form>
                {{--  --}}
                <div id="modalYesNo" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="modalBody">
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                          <button type="button" class="btn btn-primary" id="btnXacNhanXoa" data-dismiss="modal">Xác nhận</button>
                        </div>
                      </div>
                    </div>
                </div>

                {{--  --}}
            </div>
        </div>
    </div>
@endsection

