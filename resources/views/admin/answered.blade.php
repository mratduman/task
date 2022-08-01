@extends('admin.layouts.master')

@section('content')
    <div class="container">
        @if(Session::has('message'))
            <div class="row">
                @if(Session::get('success'))
                    <div class="alert alert-success" role="alert">
                        {{Session::get('message')}}
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('message')}}
                    </div>
                @endif
            </div>
        @endif
        <div class="row">
            <h4>Yanıtlanmış Talepler</h4>
            <form method="post" action="{{route('answered')}}">
                <div class="row">
                    <div class="col col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Kullanıcı Ad Soyad">
                    </div>
                    <div class="col col-md-3">
                        <select class="form-control" name="status">
                            <option value="">Statü seç</option>
                            <option value="1">VIP</option>
                            <option value="0">RISK</option>
                        </select>
                    </div>
                    <div class="col col-md-3">
                        <select class="form-control" name="admin">
                            <option value="">Admin mi?</option>
                            <option value="1">Admin</option>
                            <option value="0">Standart Kullanıcı</option>
                        </select>
                    </div>
                    <div class="col col-md-3">
                        @csrf
                        <button class="btn btn-primary" name="button" value="search" type="submit">Ara</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th><b>Kullanıcı</b></th>
                    <th><b>Talep Tarihi</b></th>
                    <th><b>Puan</b></th>
                    <th><b>Durum</b></th>
                </tr>
                </thead>
                <tbody>
                @foreach($points as $point)
                    <form id="form_{{$point->id}}" method="post" action="{{route('pointStatusUpdate',$point->id)}}">
                        @csrf
                        <tr id="row_{{$point->id}}">
                            <td>{{$point->name}}</td>
                            <td>{{$point->created_at}}</td>
                            <td>{{($point->point==0) ? '-' : $point->point}}</td>
                            <td>
                                @if($point->status==\App\Models\Point::ONAY)
                                    <div class="alert alert-success" role="alert">
                                        Onaylandı
                                    </div>
                                @else
                                    <div class="alert alert-danger" role="alert">
                                        Reddedildi
                                    </div>
                                @endif
                            </td>
                            <td>
                            </td>
                        </tr>
                    </form>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
