<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ URL::asset('js/jquery-3.2.1.js') }}" type="text/javascript"></script>



    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @section('head') @show
</head>
<body>
<div>

    <h1>SK KEMAS</h1>
</div>
<div>

    @section('content') @show
</div>

</body>

</html>