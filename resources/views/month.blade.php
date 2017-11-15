@extends('header')

@section('content')
    <h1></h1>
    <table>
        <tr>
            <th>Month</th>
        </tr>
        @foreach($month as $value)
            <tr>
                <td><a href="{{ route('summaryPlace',[ 'summaryID' => $value->monthID, 'place' =>  $place->placeID]) }}">{{ $value->name }}</a></td>
            </tr>
        @endforeach
    </table>

    <form action="" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="text" name="month">
        <input type="hidden" value="{{ Session::get('companyID') }}">
        <input type="submit" value="ADD">
    </form>
@endsection