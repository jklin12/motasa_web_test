@extends('layouts.master')
@section('title')
Dashboard
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1')
Dashboards
@endslot
@slot('title')
HC App
@endslot
@endcomponent
  
@endsection
@section('script') 
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection