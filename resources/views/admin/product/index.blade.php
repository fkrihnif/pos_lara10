@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between d-flex d-inline">
          <h4 class="card-title"> Data Produk</h4>
          <a href="#" data-toggle="modal" data-target="#tambah"><i class="btn btn-sm btn-primary shadow-sm">+ Tambah</i></a>
        </div>
        <div class="ml-3">
            <button onclick="window.location.reload();" class="btn btn-sm btn-primary">
                <i class="now-ui-icons loader_refresh"></i> Refresh
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.product.index') }}">
            
                <div class="row">
                        <div class="col-4">
                            <label for="search_product">Cari Nama Barang/Barcode:</label>
                            <input type="text" id="search_product" name="search_product" value="{{Request::get('search_product')}}" class="form-control" autofocus>
                        </div>
                        <div class="col-3">
                            <label for="search_product">Cari Kategori Item:</label>
                            <select name="category_item_search" id="category_item_search" class="custom-select">
                                <option value="">~ Pilih Kategori Item ~</option>
                                @foreach($category_items as $ci)
                                    <option value="{{ $ci->category_item }}">{{ $ci->category_item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="search_product">Cari Kategori:</label>
                            <select name="category_search" id="category_search" class="custom-select">
                                <option value="">~ Pilih Kategori ~</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->name }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="submit" value="Cari" class="btn btn-primary text-white">
                        </div>
                </div>
            @if (Request::get('category_item_search'))
            <p>Menampilkan Pencarian Kategori Item : <b>{{ Request::get('category_item_search') }}</b></p>
            @elseif (Request::get('category_search'))
            <p>Menampilkan Pencarian Kategori : <b>{{ Request::get('category_search') }}</b></p>
            @endif
            </form>
            <form action="{{ route('admin.product.index') }}">
                <input type="submit" value="Lihat Semua" class="btn btn-warning text-white">
            </form>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="text-primary">
                <tr>
                    <td>
                        No.
                    </td>
                    <td>
                      Kode Produk
                    </td>
                    <td style="width: 30%">
                      Nama
                    </td>
                    <td>
                      Stok
                    </td>
                    <td>
                        Harga Modal
                      </td>
                    <td> Harga Jual</td>
                    <td style="width: 10%">Kategori</td>
                    <td>Kategori Item</td>
                    <td>
                      Aksi
                    </td>
                </tr>
              </thead>
              <tbody>
                  <?php 
                    $i = 1;
                    ?>
                  @foreach($products as $product)
                  <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $product->product_code }}</td>
                      <td>{{ $product->name }}</td>
                      <td>{{ $product->quantity }}</td>
                      <td style="color: Orange"><b>@currency($product->capital_price)</b></td>
                      <td><b>@currency($product->price)</b></td>
                      <td>{{ $product->category->name }}</td>
                      <td>{{ $product->categoryItem->category_item }}</td>
                      <td>
                          <a href="#" data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                            data-code="{{ $product->product_code }}" data-quantity="{{ $product->quantity }}" data-price="{{ $product->price }}" data-category="{{ $product->category_id }}" data-categoryitem="{{ $product->category_item_id }}" data-capitalprice="{{ $product->capital_price }}"  data-toggle="modal" data-target="#edit"><i class="fas fa-edit"></i></a>
                          <a href="#" data-target="#delete" data-toggle="modal" data-id="{{ $product->id }}" data-name="{{ $product->name }}"><i class="fas fa-trash"></i></a>
                      </td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
            {{  $products->appends(request()->input())->links()}}
          </div>
        </div>
      </div>
    </div>
  </div>
  
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.product.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Ubah</span> Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product_code">Kode Produk</label>
                        <input type="text" class="form-control @error('product_code') is-invalid @enderror" id="product_code" name="product_code">
                        @error('product_code')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autocomplete="off">
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
                        <label for="category_item_id_edit">Kategori Item</label>
                        <select name="category_item_id" id="category_item_id" class="custom-select @error('category_item_id') is-invalid @enderror">
                            <option value="">~ Pilih Kategori Item ~</option>
                            @foreach($category_items as $ci)
                                <option value="{{ $ci->id }}">{{ $ci->category_item }}</option>
                            @endforeach
                        </select>
                        @error('category_item_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="quantity">Stok</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" required autocomplete="off">
                        @error('quantity')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" required autocomplete="off">
                        @error('price')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="capital_price">Harga Modal</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="capital_price" name="capital_price" value="{{ old('capital_price') }}" required autocomplete="off">
                        @error('capital_price')
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

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.product.delete') }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="id">
                <div class="modal-header">
                    <h5 class="modal-title"><span>Hapus</span> Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="textDelete"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                </div>
            </form>
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
                        <label for="quantity">Stok</label>
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
                    <div class="form-group">
                        <label for="price">Harga Modal</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="capital_price" value="{{ old('capital_price') }}" required autocomplete="off">
                        @error('capital_price')
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
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function(){
        $("#tambah").on('shown.bs.modal', function(){
            $(this).find('#product_code').focus();
        });
    });


    $("#edit").on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        var code = $(e.relatedTarget).data('code');
        var name = $(e.relatedTarget).data('name');
        var quantity = $(e.relatedTarget).data('quantity');
        var price = $(e.relatedTarget).data('price');
        var category = $(e.relatedTarget).data('category');
        var categoryitem = $(e.relatedTarget).data('categoryitem');
        var capitalprice = $(e.relatedTarget).data('capitalprice');
        
        $('#edit').find('input[name="id"]').val(id);
        $('#edit').find('input[name="product_code"]').val(code);
        $('#edit').find('input[name="name"]').val(name);
        $('#edit').find('input[name="quantity"]').val(quantity);
        $('#edit').find('input[name="price"]').val(price);
        $('#edit').find('select[name="category_id"]').val(category);
        $('#edit').find('select[name="category_item_id"]').val(categoryitem);
        $('#edit').find('input[name="capital_price"]').val(capitalprice);
    });
    
    $('#delete').on('show.bs.modal', (e) => {
        var id = $(e.relatedTarget).data('id');
        var name = $(e.relatedTarget).data('name');
        console.log(id);
        $('#delete').find('input[name="id"]').val(id);
        document.getElementById("textDelete").innerHTML = 'Yakin ingin menghapus <b>' + name + '</b>? <br> Barang yang telah dihapus tidak dapat dikembalikan lagi';

    });
</script>
@endpush