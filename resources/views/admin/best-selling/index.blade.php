@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header ">
                <i class="now-ui-icons loader_refresh spin"></i> &nbsp; <b>Barang Terlaris :</b> 
            </div>
            <div class="card-body ">
                <form action="{{ route('admin.best-selling.index') }}">
                    <div class="row">
                            <div class="col-4">
                                <label for="from_date">Dari Tanggal</label>
                                <input type="date" id="from_date" name="from_date" value="{{Request::get('from_date')}}" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="to_date">Hingga Tanggal</label>
                                <input type="date" id="to_date" name="to_date" value="{{Request::get('to_date')}}" class="form-control">
                            </div>
                            <div class="col-4">
                                <input type="submit" value="Cari" class="btn btn-primary text-white btn-sm mt-4">
                            </div>
                    </div>
                </form>
                <form action="{{ route('admin.best-selling.index') }}">
                    <input type="submit" value="Lihat Keseluruhan" class="btn btn-warning btn-sm text-white">
                </form>
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
                        @for ($i = 0; $i < $totalData; $i++)
                        <tr>
                            <td>{{ $result['code'][$i] }} - {{ $result['product'][$i] }}</td>
                            <td>{{ $result['categoryItem'][$i] }}</td>
                            <td>@currency($result['price'][$i])</td>
                            <td>{{ $result['total'][$i] }}</td>
                        </tr>
                        @endfor
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
