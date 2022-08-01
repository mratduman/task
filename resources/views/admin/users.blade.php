@extends('admin.layouts.master')

@push('custom-scripts')
    <script type="text/javascript">
        function submit(id) {
            document.getElementById('form_'+id).onsubmit;
        }
    </script>
@endpush

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
            <h4>Kullanıcılar</h4>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th><b>Kullanıcı</b></th>
                    <th><b>Durum</b></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <form id="form_{{$user->id}}" method="post" action="{{route('user.update',$user->id)}}">
                        @csrf
                        <tr id="row_{{$user->id}}">
                            <td>{{$user->name}}</td>
                            <td>
                                <select class="form-control" name="status" onchange="submit()" required>
                                    <option value="1" {{($user->status==\App\Models\User::VIP) ? 'selected' : ''}}>VIP</option>
                                    <option value="0" {{($user->status==\App\Models\User::RISKLI) ? 'selected' : ''}}>RISKLI</option>
                                </select>
                            </td>
                        </tr>
                    </form>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
