@extends('frontend.layouts.app')

@section('title')
    Kalkulus Kalkulator
@endsection

@section('_konten_')
    <div class="container my-5">

        <h2 class="mb-4">@yield('title')</h2>

        @include('frontend.pages.kalkulus.partials._form')

        <div id="result" class="mt-4"></div>

        @include('frontend.pages.kalkulus.partials._table')

    </div>
@endsection

@push('addScript')
    @include('frontend.pages.kalkulus.partials._script')
@endpush
