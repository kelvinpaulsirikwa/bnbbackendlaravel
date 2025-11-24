@extends('websitepages.layouts.app')

@section('title', __('website.contact.meta_title'))
@section('meta_description', __('website.contact.meta_description'))


@section('content')
  
@include('websitepages.components.contact-section')

@endsection

