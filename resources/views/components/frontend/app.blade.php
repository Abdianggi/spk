<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? __('No Title') }} - {{ config('app.name') }}</title>
    
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap-theme.min.css') }}" rel="stylesheet" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert/sweetalert.min.css') }}">

    @stack('custom_styles')
</head>
    <body>
        <div id="app">
            <x-frontend.navbar />

            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>
                
                {{-- <x-layouts.heading
                    :title="$title"
                /> --}}

                <div class="page-content">
                    {{ $slot }}
                </div>

            </div>
        </div>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
        <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
        <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
        <script type="text/javascript">
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
            @if(Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}";
                switch(type){
                    case 'info':
                        Toast.fire({
                            // icon: 'info',
                            title: '{{ Session::get('message') }}'
                        });
                        break;
                    case 'warning':
                        Toast.fire({
                            // icon: 'warning',
                            title: '{{ Session::get('message') }}'
                        });
                        break;
                    case 'success':
                        Toast.fire({
                            // icon: 'success',
                            title: '{{ Session::get('message') }}'
                        });
                        break;
                    case 'error':
                        Toast.fire({
                            // icon: 'error',
                            title: '{{ Session::get('message') }}'
                        });
                        break;
                }
            @endif
    
            @if(isset($errors->all()[0]))
                Toast.fire({
                    // icon: 'error',
                    title: '{{ $errors->all()[0] }}'
                });
            @endif
        </script>


        @stack('custom_script')
    </body>
</html>
