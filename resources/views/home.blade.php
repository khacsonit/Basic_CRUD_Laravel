@extends('layout')

@section('title', 'Danh mục sách')

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
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
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
            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
            });		
            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").attr("disabled", "disabled");
        });
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");
        });
    });
    </script>

@endsection

@section('content')
    @parent

    {{-- table --}}

    <div class="container-lg">
        <div class="table-responsive" style="width: 110%; margin-left: -3rem">
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
                                    <td>{{$item->Anh}}</td>
                                    <td>{{$item->SoLuong}}</td>
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
                <div class="modal fade" id="modalThemsach" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header text-center">
                            <h4 class="modal-title w-100 font-weight-bold">Nhập thông tin sách</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body mx-3">
                            <div class="md-form mb-1">
                            <i class="fas fa-envelope prefix grey-text"></i>
                            <input type="text"  class="form-control ">
                            <label >Tên sách</label>
                            </div>

                            <div class="md-form mb-1">
                                <i class="fas fa-envelope prefix grey-text"></i>
                                <input type="text"  class="form-control ">
                                <label >Mô tả</label>
                            </div>

                            <div class="md-form mb-1">
                                <i class="fas fa-envelope prefix grey-text"></i>
                                <input type="text"  class="form-control ">
                                <label >Năm xuất bản</label>
                            </div>

                            <div class="md-form mb-1">
                                <i class="fas fa-envelope prefix grey-text"></i>
                                <div class="file-field">
                                    <div class="btn btn-primary btn-sm float-left">
                                      <span>Chọn ảnh</span>
                                      <input type="file">
                                    </div>
                                   
                                </div>
                            </div>
                            <br/>
                            <br/>
                            <br/>
                            <div class="md-form mb-1">
                                <i class="fas fa-envelope prefix grey-text"></i>
                                <input type="text"  class="form-control ">
                                <label >Số lượng</label>
                            </div>
                            
                         
                        
                            <div class="md-form mb-1">
                                <i class="fas fa-envelope prefix grey-text"></i>

                                <select class="browser-default custom-select" id="tacgia" >
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
                                <select class="browser-default custom-select" id="theloai" >
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
                            <button class="btn btn-primary" id="themmoi">Thêm mới</button>
                        </div>
                        </div>
                    </div>
                </div>

                
                {{--  --}}
            </div>
        </div>
    </div>
@endsection
