@extends('zealov::layout.frame')

@section('icon'){{""}}@endsection
@section('title'){{app('SystemConfig')->value('siteTitle')}}@endsection
@section('keywords'){{app('SystemConfig')->value('siteKeywords')}}@endsection
@section('description'){{app('SystemConfig')->value('siteDescription')}}@endsection

