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
          <span class="info-box-text">Tiket</span>
          <span class="info-box-number">{{ $ticketSoldCount }}/2388</span>
          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <span class="progress-description"> 70% Terjual </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box text-bg-success">
        <span class="info-box-icon"> <i class="bi bi-music-note"></i> </span>
        <div class="info-box-content">
          <span class="info-box-text">Konser</span>
          <span class="info-box-number">{{ $upcomingConcertCount }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <span class="progress-description"> Sedang Berlangsung </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box text-bg-warning">
        <span class="info-box-icon"> <i class="bi bi-music-note"></i> </span>
        <div class="info-box-content">
          <span class="info-box-text">User</span>
          <span class="info-box-number">{{ $registeredUserCount }}</span>
          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
          <span class="progress-description"> Terdaftar </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <!--end::Row-->
</div>
<!--end::Container-->
@endsection