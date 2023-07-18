<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net"> --}}
        {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> --}}
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
        @vite('resources/js/app.js')
    </head>
    <body class="antialiased">
        <textarea name="phones" id="phones" cols="30" rows="10">0776284441</textarea>
        <button id="login" class="btn-green">Login</button>
        <button id="crawl" class="btn-green">Lấy dữ liệu</button>
        
        <script src="./assets/jquery-3.7.0.min.js"></script>
        {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
        <script>
            /* $('#login').click(function() {
                $.ajax({
                    method: 'post',
                    url: '{{ route('c2c.login') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function({data}) {
                        const token = data.pw;
                    }
                }).done(function(resp) {
                    console.log(resp);
                });
            });
            $('#crawl').click(function() {
                let phones = $('#phones').val();
                // parse list phone to object
                $.ajax({
                    method: 'post',
                    url: '{{ route('c2c.parsePhones') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        phones: phones,
                    },
                    success: function({data}) {
                        phones = data;
                    }
                });

                // crawl data
                $.ajax({
                    method: 'post',
                    url: '{{ route('c2c.crawl') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        phone: phone,
                    },
                    success: function({data}) {
                        const token = data.pw;
                    }
                }).done(function(resp) {
                    console.log(resp);
                });
            }); */
        </script>
    </body>
</html>
