@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!--begin::Container-->
<div class="container-fluid">
  <!--begin::Row-->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box text-bg-primary">
        <span class="info-box-icon"> <i class="bi bi-ticket-fill"></i> </span>
        <div class="info-box-content">
          <span class="info-box-text">Tiket Terjual</span>
          <span class="info-box-number">{{ $ticketSoldCount }}/2388</span>
          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <span class="progress-description"> 70% Terjual </span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box text-bg-success">
        <span class="info-box-icon"> <i class="bi bi-music-note"></i> </span>
        <div class="info-box-content">
          <span class="info-box-text">Konser Mendatang</span>
          <span class="info-box-number">{{ $upcomingConcertCount }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <span class="progress-description"> Sedang Berlangsung </span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box text-bg-warning">
        <span class="info-box-icon"> <i class="bi bi-people"></i> </span>
        <div class="info-box-content">
          <span class="info-box-text">User Terdaftar</span>
          <span class="info-box-number">{{ $registeredUserCount }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="progress-description"> Terdaftar </span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box text-bg-info">
        <span class="info-box-icon"> <i class="bi bi-currency-dollar"></i> </span>
        <div class="info-box-content">
          <span class="info-box-text">Total Pendapatan</span>
          <span class="info-box-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: 80%"></div>
          </div>
          <span class="progress-description"> Dari Penjualan Tiket </span>
        </div>
      </div>
    </div>
  </div>

  <!-- Concert status row -->
  <div class="row mt-3">
    <div class="col-md-4 col-sm-6 col-12">
      <div class="info-box bg-light">
        <span class="info-box-icon text-success"> <i class="bi bi-calendar-event"></i> </span>
        <div class="info-box-content">
          <span class="info-box-text">Konser Sedang Berlangsung</span>
          <span class="info-box-number">{{ $ongoingConcertCount }}</span>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12">
      <div class="info-box bg-light">
        <span class="info-box-icon text-secondary"> <i class="bi bi-calendar3"></i> </span>
        <div class="info-box-content">
          <span class="info-box-text">Konser Selesai</span>
          <span class="info-box-number">{{ $pastConcertCount }}</span>
        </div>
      </div>
    </div>
  </div>


 <div class="d-flex justify-content-between mt-4">
   <!-- Recent user registrations -->
   <div class="card p-4" style="width: 100%;">
    <h4>Registrasi User Terbaru</h4>
    <ul class="list-group">
      @foreach($recentUserRegistrations as $user)
      <li class="list-group-item">{{ $user->name }} - {{ $user->created_at->format('d M Y') }}</li>
      @endforeach
    </ul>
  </div>

  <!-- Recent ticket purchases -->
  <div class="card p-4" style="width: 100%;">
    <h4>Pembelian Tiket Terbaru</h4>
    <ul class="list-group">
      @foreach($recentTicketPurchases as $ticket)
      <li class="list-group-item">Tiket #{{ $ticket->id }} - {{ $ticket->created_at->format('d M Y') }}</li>
      @endforeach
    </ul>
  </div>
 </div>

  <!-- Quick links -->
  <div class="mt-4">
    <h4>Quick Links</h4>
    <div class="d-flex gap-3">
      <a href="/concerts" class="btn btn-primary">Kelola Konser</a>
      <a href="/users" class="btn btn-secondary">Kelola User</a>
      <a href="/tickets" class="btn btn-success">Kelola Tiket</a>
    </div>
  </div>
</div>
<!--end::Container-->
@endsection
