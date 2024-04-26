@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between d-flex d-inline">
          <h4 class="card-title"> Data Profit-Loss</h4>
        </div>
        <div class="ml-3 justify-content-between d-flex d-inline mr-2">
            <button onclick="window.location.reload();" class="btn btn-sm btn-primary">
                <i class="now-ui-icons loader_refresh"></i> Refresh
            </button>
        </div>
        <p class="ml-3" style="color: grey"><i>Ini untuk total keuntungan/rugi, secara default hari ini. <br>Profit Loss = Total Penjualan - Total Pembelian </i></p>
        <div class="card-body">
            <form action="{{ route('admin.profit-loss.index') }}">
                <div class="row mb-3">
                        <div class="col-4">
                            <label for="from_date">Dari Tanggal</label>
                            <input type="date" id="from_date" name="from_date" value="{{Request::get('from_date')}}" class="form-control">
                        </div>
                        <div class="col-4">
                            <label for="to_date">Hingga Tanggal</label>
                            <input type="date" id="to_date" name="to_date" value="{{Request::get('to_date')}}" class="form-control">
                        </div>
                        <div class="col-4">
                            <div class="col-4" style="margin-top: 10px;">
                                <input type="submit" value="Cari" class="btn btn-primary text-white">
                            </div>
                        </div>
                </div>
                </form>
            <div class="row mb-3">
                <div class="col-lg-6">
                    <div class="card card-chart pb-3">
                        <div class="card-header">
                            <h5 class="card-category">Total Penjualan</h5>
                            <h4 class="card-title">@currency($transactions)</h4>
                            <div class="dropdown">
                                <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                                    <i class="now-ui-icons loader_gear"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('admin.report.index') }}">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-chart pb-3">
                        <div class="card-header">
                            <h5 class="card-category">Total Pembelian</h5>
                            <h4 class="card-title">@currency($supplies)</h4>
                            <div class="dropdown">
                                <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                                    <i class="now-ui-icons loader_gear"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('admin.supply.index') }}">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-chart pb-3">
                        <div class="card-header">
                            <h5 class="card-category">Profit - Loss</h5>
                            <h4 class="card-title">@currency($transactions - $supplies)</h4>
                        </div>
                    </div>
                </div>
            </div>
              
        </div>
      </div>
    </div>
  </div>
@endsection
