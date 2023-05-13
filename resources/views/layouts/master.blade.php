@include('layouts.head')
@include('layouts.nav')
<body>
<div class="wrapper" id="app">
    <div class="container">
        @yield('content')
    </div>
</div>

{{--<footer>--}}
{{--    <strong>Copyright &copy; {{ now()->format('Y') }}</strong> Todos os direitos reservados--}}
{{--</footer>--}}
@stack('funcao-autocomlete')

</body>

</html>
