@extends('header')

@section('content')
    <ul>
        @foreach($company as $value)
            <li><a href="{{ route('month', $value->companyID) }}">{{ $value->name }}</a></li>
        @endforeach
    </ul>
@endsection