@extends('layouts.template')
@section('content')
<style>
    .card-header{
        background-color: #1B3A5D !important;
        color: white !important;
    }
    .fa-eye:hover {
        cursor: pointer;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="pesan">

</div>
<div class="row">
    <div class="col-9">
        <div class="card">
            <div class="card-header justify-content-between d-flex d-inline">
                <h5 class="card-title">Input Data Supplier</h5>
                <a href="#" data-toggle="modal" data-target="#tambah"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah Produk</i></a>
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.supply.storeProduct') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-8">
                            <label for="product_id">Nama Produk</label>
                                <select class="js-example-basic-single select2" name="product_id" id="product_id" style="width: 100% !important;" required>
                                    <option value="" selected></option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_code }} - {{ $product->name }} (@currency($product->price)) / stok {{ $product->quantity }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-4 mt-4">
                            <label>
                                <input type="radio" name="is_ppn" id="is_ppn" value="1" checked>PPN 11%
                            </label> |
                            <label>
                                <input type="radio" name="is_ppn" id="is_ppn" value="0">Tanpa PPN
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group" style="margin-top:20px;">
                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="qty" required>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group" style="margin-top:20px;">
                                <input type="number" class="form-control" id="total_price" name="total_price" placeholder="Harga Total" required>
                            </div>
                        </div>
                        <div class="col-3" style="margin-top:10px;">
                            <button type="submit" class="btn btn-primary"> Tambah</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive mt-3">
                    <div class="overflow-auto" style="height:720px;
                    overflow-y: scroll;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td><b>Nama Produk <br> Barcode</b></td>
                                <td><b>Stok</b></td>
                                <td><b>Hrg Jual Toko</b></td>
                                <td><b>Hrg Beli Satuan <hr> Keuntungan</b> </td>
                                <td><b>Qty</b></td>
                                <td><b>Hrg Beli Total</b></td>
                                <td><b>PPN 11%?</b></td>
                                <td><b>Action</b></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productSupply as $ps)
                            <tr>
                                <td>{{ $ps->product->name }} <br> <b>{{ $ps->product->product_code }}</b></td>
                                <td>{{ $ps->product->quantity }}</td>
                                <td style="color: blue">@currency($ps->product->price)</td>
                                <td>@currency($ps->price) <hr> 
                                    @php
                                        $difference = $ps->product->price - $ps->price;
                                        if ($difference > 0) {
                                            $percentProfit = ($difference/$ps->price)*100;
                                        } else {
                                            $percentProfit = 0;
                                        }
                                    @endphp
                                    @if ($difference > 0)
                                        <b style="color: green">@currency($difference)  ({{ round($percentProfit) }}%)</b>
                                    @else
                                        <b style="color: red">@currency($difference)</b>
                                    @endif
                                </td>
                                <td>+ {{ $ps->quantity }}</td>
                                    @php
                                        $profitTotal = $difference * $ps->quantity;
                                    @endphp
                                <td>@currency($ps->total_price)</td>
                                <td>
                                    @if ($ps->is_ppn == 1)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-warning">No</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" data-idproductsupply="{{ $ps->id }}" data-qtyproductsupply="{{ $ps->quantity }}" data-totalpricesupply="{{ $ps->total_price }}" data-differencesupply="{{ $difference }}" data-isppn="{{ $ps->is_ppn }}" data-idproduct="{{ $ps->product->id }}" data-nameproduct="{{ $ps->product->name }}" data-codeproduct="{{ $ps->product->product_code }}" data-qtyproduct="{{ $ps->product->quantity }}" data-priceproduct="{{ $ps->product->price }}" data-capitalpriceproduct="{{ $ps->product->capital_price }}" data-toggle="modal" data-target="#editProductSupply">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </a> 
                                    <form action="{{ route('admin.supply.deleteProduct', $ps->id) }}" method="POST"
                                        class="d-inline" onclick="return confirm('Yakin ingin menghapus?');">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-header justify-content-between d-flex d-inline">
                <p>{{ $totalItem }} item</p>
                <h3 class="card-title">@currency($totalPrice)</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.supply.storeSupply') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="supplier_name">Nama Supplier</label>
                        <input type="text" class="form-control" id="supplier_name" name="supplier_name">
                    </div>
                    <div class="form-group">
                        <label for="supply_date">Tanggal Beli</label>
                        <input type="date" class="form-control" id="supply_date" name="supply_date">
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary"> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.product.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Tambah</span> Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>
                        <input type="checkbox" name="otomatic" id="otomatic"><a style="color: orange" data-toggle="tooltip" title="Centang jika ingin membuat kode produk otomatis, dan kode produk tidak perlu diisi"> Kode Produk otomatis</a> 
                    </label>
                    <div class="form-group">
                        <label for="product_code">Kode Produk</label>
                        <input type="text" class="form-control @error('product_code') is-invalid @enderror" id="product_code" name="product_code" value="{{ old('product_code') }}" autocomplete="off" autofocus>
                        @error('product_code')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autocomplete="off">
                        @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Kategori Produk</label>
                        <select name="category_id" id="category_id" class="custom-select @error('category_id') is-invalid @enderror">
                            <option value="">~ Pilih Kategori Produk ~</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_item_id">Kategori Item</label>
                        <select name="category_item_id" id="category_item_id" class="custom-select @error('category_item_id') is-invalid @enderror">
                            <option value="">~ Pilih Kategori Item ~</option>
                            @foreach($category_items as $cii)
                                <option value="{{ $cii->id }}">{{ $cii->category_item }}</option>
                            @endforeach
                        </select>
                        @error('category_item_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity">Jumlah</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="0" required autocomplete="off">
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required autocomplete="off">
                        @error('price')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="editProductSupply" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.supply.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="idProductSupply">
                <input type="hidden" name="idProduct">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Ubah Data</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row input_fields_wrap_new">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="code_product">Barcode</label>
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="codeProduct" name="codeProduct" required autocomplete="off" readonly>
                                @error('code_product')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="product_name">Nama Barang</label>
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="nameProduct" name="nameProduct" required autocomplete="off">
                                @error('product_name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="quantity">Harga Modal Sblmnya</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="capitalPriceProduct" name="capitalPriceProduct" value="{{ old('capitalPriceProduct') }}" required autocomplete="off" readonly>
                                @error('quantity')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="quantity">Harga Jual Toko</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="priceProduct" name="priceProduct" value="{{ old('priceProduct') }}" required autocomplete="off">
                                @error('quantity')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="quantity">Stok</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="qtyProduct" name="qtyProduct" value="{{ old('qtyProduct') }}" required autocomplete="off">
                                @error('quantity')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4 class="mt-0 mb-2">Pembelian Barang</h4>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="qtyProductSupply">Qty</label>
                                <input type="text" class="form-control @error('qtyProductSupply') is-invalid @enderror" id="qtyProductSupply" name="qtyProductSupply" >
                                @error('qtyProductSupply')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="totalPriceSupply">Harga Beli Total</label>
                                <input type="text" class="form-control @error('totalPriceSupply') is-invalid @enderror" id="totalPriceSupply" name="totalPriceSupply">
                                @error('totalPriceSupply')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="is_PPN">PPN 11%?</label>
                                <select name="isPPN" id="isPPN" class="custom-select @error('isPPN') is-invalid @enderror">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                                @error('isPPN')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

    $('.js-example-basic-single').select2();

    $("#editProductSupply").on('show.bs.modal', (e) => {
        var idProductSupply = $(e.relatedTarget).data('idproductsupply');
        var qtyProductSupply = $(e.relatedTarget).data('qtyproductsupply');
        var totalPriceSupply = $(e.relatedTarget).data('totalpricesupply');
        var differenceSupply = $(e.relatedTarget).data('differencesupply');
        var isPPN = $(e.relatedTarget).data('isppn');

        var idProduct = $(e.relatedTarget).data('idproduct');
        var nameProduct = $(e.relatedTarget).data('nameproduct');
        var codeproduct = $(e.relatedTarget).data('codeproduct');
        var qtyProduct = $(e.relatedTarget).data('qtyproduct');
        var priceProduct = $(e.relatedTarget).data('priceproduct');
        var capitalPriceProduct = $(e.relatedTarget).data('capitalpriceproduct');

        $('#editProductSupply').find('input[name="idProductSupply"]').val(idProductSupply);
        $('#editProductSupply').find('input[name="qtyProductSupply"]').val(qtyProductSupply);
        $('#editProductSupply').find('input[name="totalPriceSupply"]').val(totalPriceSupply);
        $('#editProductSupply').find('select[name="isPPN"]').val(isPPN);
        
        $('#editProductSupply').find('input[name="idProduct"]').val(idProduct);
        $('#editProductSupply').find('input[name="codeProduct"]').val(codeproduct);
        $('#editProductSupply').find('input[name="nameProduct"]').val(nameProduct);
        $('#editProductSupply').find('input[name="qtyProduct"]').val(qtyProduct);
        $('#editProductSupply').find('input[name="priceProduct"]').val(priceProduct);
        $('#editProductSupply').find('input[name="capitalPriceProduct"]').val(capitalPriceProduct);
    });
    
    //jam digital
    function startTime() {
        const today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').innerHTML =  h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }


        var date = new Date();
        var tahun = date.getFullYear();
        var bulan = date.getMonth();
        var tanggal = date.getDate();
        var hari = date.getDay();
        var jam = date.getHours();
        var menit = date.getMinutes();
        var detik = date.getSeconds();
        switch(hari) {
            case 0: hari = "Minggu"; break;
            case 1: hari = "Senin"; break;
            case 2: hari = "Selasa"; break;
            case 3: hari = "Rabu"; break;
            case 4: hari = "Kamis"; break;
            case 5: hari = "Jum'at"; break;
            case 6: hari = "Sabtu"; break;
        }
        switch(bulan) {
            case 0: bulan = "Januari"; break;
            case 1: bulan = "Februari"; break;
            case 2: bulan = "Maret"; break;
            case 3: bulan = "April"; break;
            case 4: bulan = "Mei"; break;
            case 5: bulan = "Juni"; break;
            case 6: bulan = "Juli"; break;
            case 7: bulan = "Agustus"; break;
            case 8: bulan = "September"; break;
            case 9: bulan = "Oktober"; break;
            case 10: bulan = "November"; break;
            case 11: bulan = "Desember"; break;
        }
        var tampilTanggal = "" + hari + ", " + tanggal + " " + bulan + " " + tahun;
 
        document.getElementById("tampil").innerHTML = tampilTanggal;
    </script>
@endpush