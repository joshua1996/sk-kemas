@extends('header')

@section('head')
    <script src="{{ URL::asset('js/service.flextabledit.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/service.dialog.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/jquery-ui.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/service.flextabledit.jquery.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/service.dialog.jquery.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery-ui.css') }}">


@endsection

@section('content')
    <style>
        body {
            font-size: 15px;
        }

        .syntaxhighlighter {
            overflow-y: hidden !important;
            overflow-x: auto !important;
        }

        .myTable {
            border-collapse: collapse;
            border-spacing: 0;
            margin-top: 0.8333em;
            margin-bottom: 30px;
            width: 100%;

        }
        .myTable{
            background: #f4f6f5;
        }
        .myTable th:first-child,
        .myTable td:first-child {
            width: 32px;
            text-align: center;
        }
        .myTable th,
        .myTable td {
            border: 1px solid #b3bcba;
        }
    </style>
    <ul>
        @foreach($place as $value)
            <li><a href="{{ route('summaryPlace', ['summaryID' => $summaryID, 'place' => $value->placeID]) }}">{{ $value->place }}</a></li>
        @endforeach
    </ul>



    <form action="" method="post">
        <input type="text" class="datecreate" name="datecreate">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="myTable"></div>
        <input type="submit" value="Save">
    </form>


    <label for="" class="finaltotal"></label>


    <script type="text/javascript">
        $('document').ready(function () {
            $('.datecreate').datepicker({dateFormat: 'dd/mm/yy'});
            $(".datecreate").datepicker( "setDate" , new Date());

            var data = [
                ["Date", "D/O No.", "Vechile No.", "Load", "Unload", "Quantity(mt)", "U/Price(RM)", "Total(RM)", "Time In", "Time Out", "Cycle Time"],
                ["", "", "", "", "", "", "", "", "", "", ""]
            ];
            $('.myTable').flextabledit({
                content: data
            });



            $('.flexTable tbody tr').each(function () {
                $(this).find('td:nth-child(1) span').attr('name', 'no[]');
                $(this).find('td:nth-child(2) input').datepicker({dateFormat: 'dd/mm/yy'}).attr('name', 'date[]');
                $(this).find('td:nth-child(3) input').attr('name', 'dono[]');
                $(this).find('td:nth-child(4) input').attr('name', 'vechile[]');
                $(this).find('td:nth-child(5) input').attr('name', 'loads[]');
                $(this).find('td:nth-child(6) input').attr('name', 'unload[]');
                $(this).find('td:nth-child(7) input').addClass('quantity').attr('name', 'quantity[]');;
                $(this).find('td:nth-child(8) input').addClass('price').attr('name', 'price[]');;
                $(this).find('td:nth-child(9) input').addClass('total').attr('name', 'total[]');;
                $(this).find('td:nth-child(10) input').addClass('timein').attr('name', 'timein[]');;
                $(this).find('td:nth-child(11) input').addClass('timeout').attr('name', 'timeout[]');;
                $(this).find('td:nth-child(12) input').addClass('cycletime').attr('name', 'cycletime[]');;
                $(this).find('td:nth-child(9) input').attr('readonly', '');
                $(this).find('td:nth-child(12) input').attr('readonly', '');
                $(this).find('td:nth-child(10) input').inputmask("99:99:99");
                $(this).find('td:nth-child(11) input').inputmask("99:99:99");
            });

            $(document).on('change', '.quantity', function () {
                var quantity = $(this).val();
                var price = $(this).closest('tr').find('.price').val();
                $(this).closest('tr').find('.total').val(quantity * price);
                finaltotal();
            });

            $(document).on('change', '.price', function () {
                var price = $(this).val();
                var quantity = $(this).closest('tr').find('.quantity').val();
                $(this).closest('tr').find('.total').val(quantity * price);
                finaltotal();
            });

            $(document).on('change', '.timein', function () {
                var now = $(this).closest('tr').find('.timeout').val();
                var then = $(this).val();
                var ms = moment(now,"HH:mm:ss").diff(moment(then,"HH:mm:ss"));
                var d = moment.duration(ms);
                $(this).closest('tr').find('.cycletime').val(Math.floor(d.asHours()) + moment.utc(d.asMilliseconds()).format(":mm:ss"));
            });

            $(document).on('change', '.timeout', function () {
                var now =$(this).val();
                var then =  $(this).closest('tr').find('.timein').val();
                var ms = moment(now,"HH:mm:ss").diff(moment(then,"HH:mm:ss"));
                var d = moment.duration(ms);
                console.log(Math.floor(d.asHours()) + moment.utc(d.asMilliseconds()).format(":mm:ss"));
                $(this).closest('tr').find('.cycletime').val(Math.floor(d.asHours()) + moment.utc(d.asMilliseconds()).format(":mm:ss"));
            });

            function finaltotal()
            {
                var total = "";
                $('.flexTable tbody tr').each(function () {
                    total += $(this).find('td:nth-child(9) input').val();
                });
                $('.finaltotal').html(total);
            }
        });


    </script>
@endsection