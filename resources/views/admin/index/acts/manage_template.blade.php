@extends('adm_theme::layouts.app')
@section('content')
    <a class="btn btn-primary">+</a>
    <table class="table table-bordered">
    @foreach ($rows as $row)
        <tr>
            <td>{{ $row->id }}</td>

        </tr>
    @endforeach
    </table>
@endsection