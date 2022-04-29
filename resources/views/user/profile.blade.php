@extends('layouts.app')

@php
    $title = 'Profile';
@endphp

@section('title', $title)

@section('content_header')
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $title }}</h1>
        </div>
    </div>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="col-md-2"><strong>User Id:</strong></label>
                            <label>{{ $user->id ?? '' }}</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="col-md-2"><strong>Name:</strong></label>
                            <label>{{ $user->name ?? '' }}</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="col-md-2"><strong>Email:</strong></label>
                            <label>{{ $user->email ?? '' }}</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="col-md-2"><strong>Avatar:</strong></label>
                            @if ($user->avatar)
                                <img src="{{ $user->avatar ?? '' }}" width="50" height="50" />
                            @else
                                <label>-</label>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="col-md-2"><strong>Spotify id:</strong></label>
                            <label>{{ $user->spotify_id ?? '' }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

