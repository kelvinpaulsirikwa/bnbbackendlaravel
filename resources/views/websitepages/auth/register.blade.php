@extends('websitepages.layouts.app')

@section('title', __('website.auth.register_page_title'))
@section('meta_description', __('website.auth.register_page_message'))

@section('content')
    <section class="section" style="text-align: center;">
        <p style="font-size: 1.1rem; color: #1a1a1a; margin-bottom: 0.5rem;">
            {{ __('website.auth.register_page_title') }}
        </p>
        <h1 style="font-size: 2rem; margin-bottom: 1rem;">
            {{ __('website.auth.register_page_message') }}
        </h1>
    </section>
@endsection

