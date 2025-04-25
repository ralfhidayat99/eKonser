@extends('layouts.welcome')

@section('title', 'Selamat Datang di eKonser')

@section('content')
<h1 class="mb-3">Selamat Datang di eKonser</h1>
<p class="lead">Temukan konser menakjubkan yang berlangsung di dekat Anda!</p>

<!-- Secret Admin Login Button -->
<a href="{{ route('login') }}" class="btn btn-link p-0" style="opacity: 0.1; position: fixed; bottom: 10px; right: 10px;" title="Login Admin">
    &#128274;
</a>

<!-- Concert List Section -->
<h2>Konser Mendatang</h2>
<div class="concert-list d-flex flex-wrap gap-3">
    @foreach ($concerts as $concert)
    <a href="{{ route('concerts.show', $concert) }}" class="card text-decoration-none text-dark" style="flex: 1 1 24rem; min-width: 18rem; max-width: 100%;">
        @if ($concert->banner)
        <img src="{{ $concert->banner }}" class="card-img-top" alt="Concert Banner" style="height: 240px; object-fit: cover;">
        @else
        <img src="{{ asset('assets/img/default-150x150.png') }}" class="card-img-top" alt="Default Banner" style="height: 240px; object-fit: cover;">
        @endif
        <div class="card-body p-2">
            <h5 class="card-title mb-1">{{ $concert->title }}</h5>
            <p class="card-text mb-1"><strong>Artis:</strong> {{ $concert->artist }}</p>
            <p class="card-text mb-1"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($concert->date)->format('F d, Y') }}</p>
            <p class="card-text mb-1"><strong>Lokasi:</strong> {{ $concert->location }}</p>
        </div>
    </a>
    @endforeach
</div>
@endsection
