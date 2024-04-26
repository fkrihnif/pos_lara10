<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ App\Models\Company::take(1)->first()->name }} - Transaksi</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ url('transaction/img/faviconn.png') }}" rel="icon">
  <link href="{{ url('transaction/img/apple-touch-iconn.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ url('transaction/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ url('transaction/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('transaction/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ url('transaction/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ url('transaction/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ url('transaction/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ url('transaction/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ url('transaction/css/style.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Arsha - v4.10.0
  * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body onload="startTime()">

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-inner-pages">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="#">{{ App\Models\Company::take(1)->first()->name }}</a></h1>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="getstarted scrollto" href="{{ route('admin.product.index') }}">Kembali</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <section class="inner-page">
      <div class="container">
        <style>
            .card-header{
                background-color: #1B3A5D !important;
                color: white !important;
            }
            .fa-eye:hover {
                cursor: pointer;
            }
            .fade {
            -webkit-transition: opacity 0.01s linear;
                -moz-transition: opacity 0.01s linear;
                -ms-transition: opacity 0.01s linear;
                    -o-transition: opacity 0.01s linear;
                    transition: opacity 0.01s linear;
            }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <div class="pesan">
        
        </div>
        <div class="row mt-4">
            <div class="col-8">
                <div class="card">
                  <div class="card-header justify-content-between d-flex d-inline">
                        <h5 class="card-title">Transaksi</h5>
						<div id="tampil"></div>
                        <div id="txt" style="color: blanchedalmond"></div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <label for="get_product_code">Barcode Produk</label>
                                <input type="text" id="get_product_code" placeholder="scan barcode" class="form-control" autofocus autocomplete="off">
                            </div>
                            <div class="col-3" style="margin-top:22px;">
                                <input type="button" value="Cari (Enter)" id="addToCart" class="btn btn-primary text-white">
                            </div>
                            <div class="col-8">
                                <label for="get_product_code2">Nama Produk</label>
                                    <select class="js-example-basic-single select2" name="get_product_code2" id="get_product_code2" style="width: 100% !important;">
                                        <option value="" selected></option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->product_code }}">{{ $product->name }} (@currency($product->price))</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="col-3">
                                {{-- <label for="get_product_quantity">Jumlah</label> --}}
                                <input type="number" hidden id="get_product_quantity" disabled placeholder="Jumlah" class="form-control" min="0">
                            </div>
                            <div class="col-3">
                                {{-- <label for="get_product_disc_rp">Discount Rp</label> --}}
                                <input type="number" hidden id="get_product_disc_rpp" disabled placeholder="Discount Rp" class="form-control" min="0">
                            </div>
                            <div class="col-3">
                                {{-- <label for="get_product_disc_prc">Discount %</label> --}}
                                <input type="number" hidden id="get_product_disc_prcc" disabled placeholder="Discount %" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><small><i>F2 utk edit barang terakhir, F8 utk hapus barang terakhir, Shift+F8 Hapus Semua</i></small></div>
                        </div>
                        <div class="table-responsive mt-3">
                            <div class="overflow-auto" style="height:420px;
                            overflow-y: scroll;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>Nama Produk</td>
                                        <td>Jumlah</td>
                                        <td>Harga</td>
                                        <td>Diskon</td>
                                        <td>Total</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody id="posts-crud">
                                    
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header justify-content-between d-flex d-inline">
                        <h1 class="card-title" id="totalBuy" style="font-size: 300%;" ></h1>
                    </div>
                    <div class="card-body" style="background-color: antiquewhite">
                        <form action="{{ route('admin.transaction.pay') }}" method="post">
                            @csrf
                            <label>
                                <input type="radio" name="method" id="method" value="offline" checked> Offline
                            </label> |
                            <label>
                                <input type="radio" name="method" id="method" value="online"> Online
                            </label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="get_total_disc_rp">Discount Rp</label>
                                        <input type="number" class="form-control" id="get_total_disc_rp" name="get_total_disc_rp">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="get_total_disc_prc">Discount %</label>
                                        <input type="number" class="form-control" id="get_total_disc_prc" name="get_total_disc_prc">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="payment">Bayar (F9)</label>
                                <input type="number" class="form-control" id="payment" name="payment">
                            </div>
                            <div class="form-group">
                                <label for="return">Kembalian</label>
                                <input type="number" class="form-control" id="return" readonly name="return">
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary" id="tPayment" disabled> Bayar (F10)</button>
                            </div>
                        </form>

                        <form action="{{ route('admin.transaction.payDirectly') }}" method="post">
                            @csrf
                            <div class="form-group mt-2">
                                <button type="submit" class="btn" id="tPaymentDirectly"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        
            <!-- Modal -->
        <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">EDIT POST</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
        
                        <input type="hidden" id="productTransaction_id">
        
                        <div class="form-group">
                            <label for="quantity" class="control-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity-edit" autofocus>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-quantity-edit"></div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="get_product_disc_rp" class="control-label">Disc Rp</label>
                                    <input type="number" class="form-control" id="get_product_disc_rp">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="get_product_disc_prc" class="control-label">Disc %</label>
                                    <input type="number" class="form-control" id="get_product_disc_prc">
                                </div>
                            </div>
                        </div>
        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                        <button type="button" class="btn btn-primary" id="update-quantity">UPDATE (F4)</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">


    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>{{ App\Models\Company::take(1)->first()->name }}</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  {{-- <div id="preloader"></div> --}}
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!--   Core JS Files   (dari template sblumnya)-->
  <script src="{{ url('template/admin_temp/assets/js/core/jquery.min.js') }}"></script>
  <script src="{{ url('template/admin_temp/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ url('template/admin_temp/assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>

  <!-- Vendor JS Files -->
  <script src="{{ url('transaction/vendor/aos/aos.js') }}"></script>
  <script src="{{ url('transaction/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('transaction/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ url('transaction/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ url('transaction/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ url('transaction/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ url('transaction/vendor/php-email-form/validate.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Template Main JS File -->
  <script src="{{ url('transaction/js/main.js') }}"></script>

  <script>
    $(document).ready(function(){
        $('.js-example-basic-single').select2();
        const totalBuy = document.getElementById('totalBuy');
        function fetchstudent() {
            $.ajax({
                type: "GET",
                url: '{{ route('admin.transaction.indexs') }}',
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('tbody').html("");
                    $.each(response.data, function (key, item) {
                    var harga = item.product.price;
                    var hargaa = formatRupiah(item.product.price);
                    let content = `<tr>\
                        <td>${item.product.name}</td>\
                        <td>${item.quantity}</td>\
                        <td style="background-color:#34495e; color:white; font-size:140%;">${hargaa}</td>\
                        <td>${+item.disc_rp + ((item.disc_prc / 100) * (harga * item.quantity)) }</td>\
                        <td>${item.quantity * harga - item.disc_rp - ((item.disc_prc / 100) * (harga * item.quantity))}</td>\
                        <td>
                            <a href="javascript:void(0)" value="${item.id}" data-id="${item.id}" class="btn btn-primary btn-sm edit-btn">EDIT</a>
                            <button type="button" value="${item.id}" data-id="${item.id}" class="btn btn-danger delete-btn btn-sm">Hapus</button></td>\
                    \</tr>`
                    $('tbody').append(content);
                    });
                }
            });
        }
        fetchstudent();
        getTotalBuy();
        let productCode = document.getElementById('get_product_code');
        let productCode2 = document.getElementById('get_product_code2');
        let productName = document.getElementById('get_product_name');
   
        const addToCart = document.getElementById('addToCart');
        const addToCart2 = document.getElementById('addToCart2');
        $(function() {
            $(document).keydown(function(e) {
                if (!$("#addToCart").is(":disabled")) {
                    switch(e.which) { 
                    case 13: // up key
                        tambahkan();
                    } 
                }
                if (!$("#tPayment").is(":disabled")) {
                    switch(e.which) { 
                    case 121: // up key
                        $('#tPayment').trigger('click');
                    } 
                }
                switch(e.which) { 
                case 120:
                    $("#payment").focus();
                }
                
                if (e.which == 113) {
                    //f2
                    editLastProduct();
                }
                if (e.which == 119) {
                    //f8
                    deleteLastProduct();
                }

                if (e.which == 115) {
                    //f4
                    $('#update-quantity').trigger('click');
                }

                if (e.which == 16) {
                    // shift
                    $("#get_product_code").focus();
                }
            });

            var map = {}; // You could also use an array
            onkeydown = onkeyup = function(e){
                e = e || event; // to deal with IE
                map[e.keyCode] = e.type == 'keydown';
                /* insert conditional here */
                //DELETE ALL PRODUCT IN CART
                if(map[16] && map[119]){ // SHIFT+F8
                    deleteAllCart();
                    map = {};
                }else if(map[16] && map[120]){ // shift+f9 utk langsung bayar (pegen cepat)
                    $('#tPaymentDirectly').trigger('click');
                    map = {};
                }

            }
        });
        
        addToCart.addEventListener('click', function() {
            tambahkan();
        })
        function tambahkan() {
            $productCode = $('#get_product_code');            
            if ($productCode.val() != '') {
                $productCode = $('#get_product_code');
            } else {
                $productCode = $('#get_product_code2');
            }

            if ($productCode.val() != ''){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    dataType: 'json',
                    data: {'product_code':$productCode.val()},
                    url: '{{ route('admin.transaction.addToCart') }}',
                    success: function(data){
                        $('#get_product_code').val('');
                        $('.js-example-basic-single').val(0).trigger('change.select2');
                        document.getElementById("get_product_code").focus();
                        fetchstudent();
                        getTotalBuy();
                    },
                    error: function(){
                        alert($productCode.val() + ' Tidak Ada!');
                        $('#get_product_code').val('');
                        document.getElementById("get_product_code").focus();
                }
            })
            } else {
                alert('Tidak ada inputan!');
                $('#get_product_code').val('');
                document.getElementById("get_product_code").focus();
            }
        }

        //utk edit data di keranjang dgn id terakhir
        function editLastProduct() {
            let id = '1';
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'GET',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('admin.transaction.showLastProduct') }}',
                    success:function(response){

                        //fill data to form
                        $('#productTransaction_id').val(response.data.id);
                        $('#quantity-edit').val(response.data.quantity);

                        //open modal
                        $('#modal-edit').modal('show');
                        $(document).ready(function(){
                            $("#modal-edit").on('shown.bs.modal', function(){
                                $(this).find('#quantity-edit').focus();
                                var autoselect = document.getElementById('quantity-edit');
	                            autoselect.select();
                            });
                        });

                        }
                });
        }

        //utk hapus data di keranjang dgn id terakhir
        function deleteLastProduct() {
            let id = '1';
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'DELETE',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('admin.transaction.deleteLastProduct') }}',
                    success: function(data){
                        fetchstudent();
                        getTotalBuy();
                        fetchstudent();
                        getTotalBuy();
                        document.getElementById("get_product_code").focus();
                    },
                    error: function(){
                        alert('Gagal!');

                }
                });
        }

        //utk hapus semua barang di keranjang
        function deleteAllCart() {
            let id = '1';
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'DELETE',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('admin.transaction.deleteAllCart') }}',
                    success: function(data){
                        fetchstudent();
                        getTotalBuy();
                        fetchstudent();
                        getTotalBuy();
                        document.getElementById("get_product_code").focus();
                    },
                    error: function(){
                        alert('Gagal!');

                }
                });
        }
    
        const customer_container = document.querySelector('.table');
        const thumbs = document.querySelectorAll('tombol');
        customer_container.addEventListener('click', function(e) {
            if(e.target.classList.contains('delete-btn')){
                let id = e.target.dataset.id;
                e.target.disabled = true;
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'DELETE',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('admin.transaction.deleteCart') }}',
                });
                fetchstudent();
                getTotalBuy();
                fetchstudent();
                getTotalBuy();
                document.getElementById("get_product_code").focus();
            } else if (e.target.classList.contains('edit-btn')) {
                let id = e.target.dataset.id;
                e.target.disabled = true;
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'GET',
                    dataType: 'json',
                    data: {'id':id},
                    url: '{{ route('admin.transaction.show') }}',
                    success:function(response){

                        //fill data to form
                        $('#productTransaction_id').val(response.data.id);
                        $('#quantity-edit').val(response.data.quantity);
                        $('#get_product_disc_rp').val(response.data.disc_rp);
                        $('#get_product_disc_prc').val(response.data.disc_prc);

                        //open modal
                        $('#modal-edit').modal('show');
                        $(document).ready(function(){
                            $("#modal-edit").on('shown.bs.modal', function(){
                                $(this).find('#quantity-edit').focus();
                                var autoselect = document.getElementById('quantity-edit');
	                            autoselect.select();
                            });
                        });

                        }
                });
            }
        })


        //////
        //action update quantity
        const updateQuantity = document.getElementById('update-quantity');
        updateQuantity.addEventListener('click', function() {
            
            //define variable
            let productTransaction_id = $('#productTransaction_id').val();
            let quantity   = $('#quantity-edit').val();
            let productDiscRp   = $('#get_product_disc_rp').val();
            let productDiscPrc   = $('#get_product_disc_prc').val();
            let token   = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `/admin/transaction/update/${productTransaction_id}`,
                type: "PUT",
                cache: false,
                data: {
                    "quantity": quantity,
                    "disc_rp": productDiscRp,
                    "disc_prc": productDiscPrc,
                    "_token": token
                },
                success:function(response){

                    //data post
                    fetchstudent();
                    getTotalBuy();
                    $('#get_product_disc_rp').val('');
                    $('#get_product_disc_prc').val('');

                    //close modal
                    $('#modal-edit').modal('hide');
                    document.getElementById("get_product_code").focus();
                    

                }
            })
        });


        /////

        const productQuantity = document.getElementById('get_product_quantity');
        const productDiscRp = document.getElementById('get_product_disc_rp');
        const productDiscPrc = document.getElementById('get_product_disc_prc');
        
        [productQuantity].map(element => element.addEventListener('input', function(){        
        // let productPrice = document.getElementById('get_product_price');
        // let productTotal = document.getElementById('get_product_total');

        productPrice.value=productPrice.value;
                   

        let hasilDiscPrc = (productDiscPrc.value / 100) * (productPrice.value * productQuantity.value);
        let total = productPrice.value * productQuantity.value - productDiscRp.value - hasilDiscPrc;
        productTotal.value = total;

        if($(this).val() = 0){
            $('#addToCart').prop('disabled', true);
        }else{
            $('#addToCart').prop('disabled', false);
            }
        }))

        function getTotalBuy(){
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.transaction.totalBuy') }}',
                dataType: 'json',
                success: function(data){
                    let totalBuy = document.getElementById('totalBuy');
                    totalBuy.innerHTML = "Total " + formatRupiah(data.data, 'Rp. ');
                },
                error: function(data){
                    console.log('gagal');
                }
            })    
        }

        function formatRupiah(angka, prefix){
			var number_string = angka.toString().replace(/[^,\d]/g, ''),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

        // const productQuantity = document.getElementById('get_product_quantity');


        const totalDiscRp = document.getElementById('get_total_disc_rp');
        const totalDiscPrc = document.getElementById('get_total_disc_prc');
        [totalDiscRp, totalDiscPrc].map(element => element.addEventListener('input', function(){  
            $.ajax({
                type: 'GET',
                url: '{{ route('admin.transaction.totalBuy') }}',
                dataType: 'json',
                success: function(data){
                    let totalBuy = document.getElementById('totalBuy');
                    totalBuy.innerHTML = "Total " + formatDiskon(data.data, 'Rp. ');
                    hitung();
                },
                error: function(data){
                    console.log('gagal');
                }
            })  
        }))

        function formatDiskon(angka, prefix){
            
            var number = angka;
            let diskon = document.getElementById('get_total_disc_rp');
            let diskonPrc = document.getElementById('get_total_disc_prc');
            var totalDscPrc = (diskonPrc.value / 100) * (number);
            var totalDsc = number-diskon.value-totalDscPrc ;
            var format = totalDsc.toString().replace(/[^,\d]/g, ''),
            split   		= format.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

        var payment = document.getElementById('payment');
        [payment].map(element => element.addEventListener('input', function(){  
            hitung();
        }))

        function hitung() {
            let tPayment = document.getElementById('tPayment');
            let vReturn = document.getElementById('return');
            let totalBuy = document.getElementById('totalBuy');
            let split = totalBuy.innerHTML.split(' ');
            if(split[2] <= 0){
                alert('Belum ada pesanan');
            }
            let split1 = split[2].replace('.','');
            let split2 = split1.replace('.','');
            let result = parseInt(payment.value) - split2;
            if(result >= 0) {
                tPayment.disabled = false;
            }else{
                tPayment.disabled = true;
            }
            vReturn.value = result;
        }
    })     

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
    
  </script>
  
	 <script>
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
	
	<script>
	//auto refresh saat tdk ada presskey atau mouseover
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });

     function refresh() {
         if(new Date().getTime() - time >= 120000) 
             window.location.reload(true);
         else 
             setTimeout(refresh, 10000);
     }

     setTimeout(refresh, 10000);
</script>

</body>

</html>