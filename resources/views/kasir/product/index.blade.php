@extends('layouts.template')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between d-flex d-inline">
          <h4 class="card-title"> Data Produk</h4>
        </div>
        <div class="ml-3">
            <button onclick="window.location.reload();" class="btn btn-sm btn-primary">
                <i class="now-ui-icons loader_refresh"></i> Refresh
            </button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered data-table"  id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                  @php
                      $i = 1;
                  @endphp
                  @foreach ($products as $product)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $product->product_code }}</td>
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->category->name }}</td>
                      <td>@currency($product->price)</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection