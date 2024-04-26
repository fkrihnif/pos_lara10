@extends('layouts.template')
@section('content')

<div class="row mb-4">
    <div class="col-lg-3">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">Total Kategori Produk</h5>
                <h4 class="card-title">{{ $categories }}</h4>
                <div class="dropdown">
                    <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                        <i class="now-ui-icons loader_gear"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.category.index') }}">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <a href="{{ route('admin.category.index') }}"><i class="now-ui-icons ui-1_zoom-bold"></i> Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">Total Produk</h5>
                <h4 class="card-title">{{ $products }}</h4>
                <div class="dropdown">
                    <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                        <i class="now-ui-icons loader_gear"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.product.index') }}">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <a href="{{ route('admin.product.index') }}"><i class="now-ui-icons ui-1_zoom-bold"></i> Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">Total Transaksi</h5>
                <h4 class="card-title">{{ $transactions }}</h4>
                <div class="dropdown">
                    <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                        <i class="now-ui-icons loader_gear"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.report.index') }}">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <a href="{{ route('admin.report.index') }}"><i class="now-ui-icons ui-1_zoom-bold"></i> Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-chart">
            <div class="card-header">
                <h5 class="card-category">Total Pembelian</h5>
                <h4 class="card-title">{{ $supplies }}</h4>
                <div class="dropdown">
                    <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
                        <i class="now-ui-icons loader_gear"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.supply.index') }}">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <a href="{{ route('admin.supply.index') }}"><i class="now-ui-icons ui-1_zoom-bold"></i> Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header ">
                <i class="now-ui-icons loader_refresh spin"></i> &nbsp; <b>Transaksi Penjualan Hari Ini :</b> 
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered display">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <th>Kode Transaksi</th>
                            <th>Waktu</th>
                            <th>Total Pembelian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $purchaseOrder = [];
                        @endphp
                        @foreach($transactionGet as $key => $transaction)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $transaction->transaction_code }}  <a href="{{ route('admin.report.show', $transaction->id) }}"><i class="fas fa-eye"></i></a>
                            
                                <div style="font-size: 75%">{{ $transaction->user->name }}</div>
                            </td>
                            <td>{{ date('d M Y H:i:s', strtotime($transaction->created_at)) }}</td>
                            <td>@currency($transaction->purchase_order) <br>
                                {{ $transaction->method }}
                            </td>
                        </tr>
                        @php
                            $purchaseOrder[] = $transaction->purchase_order;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
                @php
                $totalPurchase = array_sum($purchaseOrder);
                 @endphp
            <b>Total Penjualan Hari ini: @currency($totalPurchase)</b>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header ">
                <i class="now-ui-icons loader_refresh spin"></i> &nbsp; <b>Transaksi Pembelian Hari Ini :</b> 
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table class="table table-bordered display2" id="">
                    <thead>
                      <th>
                        Nama Penjual
                      </th>
                      <th>
                        Total Item
                      </th>
                      <th>
                        Total Pembelian
                      </th>
                    </thead>
                    <tbody>
                        @php
                        $totalBuy = [];
                        @endphp
                        @foreach($supplierToday as $key => $supply)
                        <tr>
                            <td>{{ $supply->supplier_name }}</td>
                            <td>{{ $supply->productSupply()->count() }}</td>
                            <td>@currency($supply->total)  <a href="{{ route('admin.supply.show', $supply->id) }}"><i class="fas fa-eye"></i></a></td>
                        </tr>
                        @php
                        $totalBuy[] = $supply->total;
                        @endphp
                        @endforeach
                    </tbody>
                  </table>
                </div>
                @php
                $total = array_sum($totalBuy);
                @endphp
                <b>Total Pembelian Hari Ini: @currency($total)</b>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header ">
                <i class="now-ui-icons loader_refresh spin"></i> &nbsp; <b>Barang Yang Terjual Hari ini :</b> 
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                    <thead>
                      <th>
                        Barcode - Nama Barang
                      </th>
                      <th>Kategori Item</th>
                      <th>
                        Harga
                      </th>
                      <th>
                        Total Terjual
                      </th>
                    </thead>
                    <tbody>
                        @if ($selling == 0)
                        <tr>
                            <td colspan="4" style="text-align: center">Belum Ada Penjualan Hari ini</td>
                        </tr>
                        @else
                        @for ($i = 0; $i < $totalData; $i++)
                        <tr>
                            <td>{{ $result['code'][$i] }} - {{ $result['product'][$i] }}</td>
                            <td>{{ $result['categoryItem'][$i] }}</td>
                            <td>@currency($result['price'][$i])</td>
                            <td>{{ $result['total'][$i] }}</td>
                        </tr>
                        @endfor
                        @endif
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('table.display').DataTable();
    });

    $(document).ready(function () {
        $('table.display2').DataTable();
    });
</script>
@endpush
