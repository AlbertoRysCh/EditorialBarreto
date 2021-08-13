<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="LogiHouse delivery para empresas y personas naturales." />
    <meta name="keywords" content="logi, house, logihouse, delivery, empresa, envio" />
    <meta name="author" content="Logi House" />
    <meta name="caffeinated" content="false">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Editorial') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/images/ico/cropped-favicones.png')}}">
    <link href="{{asset('css/fontfamily-montserrat.css')}}" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link href="{{asset('css/vendors.min.css')}}" rel="stylesheet">

    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-extended.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/colors.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/components.css')}}" rel="stylesheet">
    <link href="{{asset('css/vertical-menu.min.css')}}" rel="stylesheet">

    <!-- BEGIN: Librerias CSS-->
    <link href="{{asset('css/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/wizard.css')}}" rel="stylesheet">
    <link href="{{asset('css/daterangepicker.css')}}" rel="stylesheet">
    <link href="{{asset('css/fileinput.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-datepicker.standalone.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap-datepicker.css')}}" rel="stylesheet">
    <link href="{{asset('css/durationpicker.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


    
    <!-- END: Librerias CSS-->

    <!-- BEGIN: Custom CSS-->
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet">

    <!-- END: Custom CSS-->
    @yield('custom-css')
    

</head>
