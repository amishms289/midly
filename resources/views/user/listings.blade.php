@extends('layouts.app')

@php
    $title = 'User Listings';
@endphp

@section('title', $title)

@section('content_header')
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $title }}</h1>
        </div>
    </div>
@stop

<style type="text/css">
    svg.w-5.h-5 {
        width: 15px;
        height: 15px;
    }
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Listing For <strong>{{ $user->name }}</strong></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                              <th scope="col">Listning Id</th>
                              <th scope="col">Spotify Track Id</th>
                              <th scope="col">Track Name</th>
                              <th scope="col">Played At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($listingData->count() > 0)
                                @foreach ($listingData as $listing)
                                    <tr>
                                        <th scope="row">{{ $listing->id }}</th>
                                        <td>{{ $listing->spotify_track_id }}</td>
                                        <td>{{ $listing->track_name }}</td>
                                        <td>{{ $listing->played_at }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" align="center">No data found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    {!! $listingData->links() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

