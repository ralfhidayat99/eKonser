@extends('layouts.app')

@section('title', 'Konser')

@section('content')
<div class=" mb-5">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('concerts.create') }}" class="btn btn-primary mb-3">Tambah Konser Baru</a>

    @if($concerts->isEmpty())
    <p>No concerts found.</p>
    @else
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach($concerts as $concert)
        <div class="col">
            <a href="{{ route('concerts.detail', $concert) }}" class="text-decoration-none text-dark">
                <div class="card h-100">
                    @if($concert->banner)
                    <img src="{{ $concert->banner }}" class="card-img-top concert-banner" alt="Banner of {{ $concert->title }}">
                    @else
                    <img src="{{ asset('assets/img/default-150x150.png') }}" class="card-img-top concert-banner" alt="Default banner">
                    @endif

                    <div class="card-body">
                        <h5>{{$concert->title}}</h5>

                    </div>
                  
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
    .concert-banner {
        height: 200px;
        object-fit: cover;
    }
</style>

@endsection