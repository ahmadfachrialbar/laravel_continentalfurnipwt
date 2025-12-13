@extends('layouts.app')
@section('content')

        <!-- hero section -->
        @include('components.sections.hero')

        <!-- section 2 -->
        @include('components.sections.categories')

        <!-- section 3 -->
        @include('components.sections.about')

        <!-- section 4 -->
        @include('components.sections.features')

        <!-- section 5 -->
        @include('components.sections.products')

        @endsection