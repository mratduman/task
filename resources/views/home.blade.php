@extends('layouts.master')

@push('custom-scripts')
    <script type="text/javascript">
        function newPoint() {
            let data = $('#newPoint').serialize();

            $.post("{{route('point.create')}}", data, function (result) {
                if (result.success) {
                    location.reload();
                }
                alert(result.message);
            });
        }
    </script>
@endpush

@section('content')

    <div class="container">
        <div class="row">
            <form id="newPoint" method="post" action="{{route('point.create')}}">
                @csrf
                <h4>Puan Taleplerim <button type="submit" class="btn btn-default btn-sm">Yeni Puan Talebi Gönder</button></h4>
            </form>
        </div>
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

            <table class="table">
                <thead>
                    <tr>
                        <th><b>Puan</b></th>
                        <th><b>Durum</b></th>
                        <th><b>Talep Tarihi</b></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($points as $point)
                    <tr>
                        <td>{{$point->point}}</td>
                        <td>{{(new \App\Models\Point())->pointStatus($point->status)}}</td>
                        <td colspan="2">{{$point->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
