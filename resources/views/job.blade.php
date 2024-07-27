@extends('layout')

@section('content')
    <h1>Job id: {{ $job['id'] }}</h1>
    <h2>Job title: {{ $job['title'] }}</h2>
    <p>Job description: {{ $job['description'] }}</p>
@endsection
