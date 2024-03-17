@extends('layouts.master')
@section('title')
Delivery Order
@endsection
@section('content')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    th {
        padding: 10em, importance;

    }

    tr {
        padding: 10em;

    }
</style>
@endsection
@component('components.breadcrumb')
@slot('li_1')
Delivery Order
@endslot
@slot('title')
Detail
@endslot
@endcomponent

@include('layouts.errors')
@include('layouts.message')

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">

                <h5 class="card-title mb-0 flex-grow-1">Detail Delivery Order {!! $do->do_status_badge!!}</h5>
                <div class="flex-shrink-0">
                    @if($do->do_status != 'Approve' && $do->do_status != 'Reject')
                    <a href="{{ route('do.edit',$do->do_id)}}" class="btn btn-warning btn-sm"><i class="ri-pencil-fill align-bottom"></i> Edit
                    </a>
                    <a href="javascript:;" class="btn  btn-danger btn-sm deleteBtn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{route('do.destroy', $do->do_id)}}" data-name="{{$do->do_number}}"><i class="ri-delete-bin-line  align-bottom"></i> Hapus
                    </a>
                    @endif

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="ps-0" scope="row">Nomor DO </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->do_number }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Tanggal DO </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->do_date }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Nomor Order </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->order_number }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Tanggal Order </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->order_date }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Nama Customer </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->cust_name }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Telp Customer </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->cust_phone }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Email Customer </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->cust_email }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Alamat Customer </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->cust_address }}</td>
                            </tr>

                            <tr>
                                <th class="ps-0" scope="row">Catatan </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->do_notes }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-header align-items-center d-flex">

                <h5 class="card-title mb-0 flex-grow-1">Detail Produk</h5>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-stripped mb-0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($do->products as $produk)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $produk->product_name}}</td>
                                <td>{{ $produk->product_qty}}</td>
                                <td>{{ $produk->product_price}}</td>
                                <td>{{ $produk->total_price}}</td>
                            </tr>
                            @empty
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Maaf!</strong> Belum ada data produk
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div><!--end col-->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h5 class="card-title mb-0 flex-grow-1">Detail Pengiriman</h5>
                <div class="flex-shrink-0">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr style="padding: 2.em;">
                                <th class="ps-0" scope="row">Jasa Pengirim </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->courier_name }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Layanan </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->courier_service_name }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Estimasi Pengiriman </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->shipping_duration }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Biaya </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->shipping_price }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Alamat Pengirim </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->do_from_detail }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Alamat Penerima </th>
                                <td>:</td>
                                <td class="text-muted">{{ $do->do_to_detail }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        <div>
            <h5 class="mb-4">Riwayat</h5>
            <div class="timeline-2">

                <div class="timeline-continue">
                    @foreach($do->history as $key => $value)
                    <div class="row timeline-right">
                        <div class="col-12">
                            <p class="timeline-date">
                                {{ $value->created_at_format}}
                            </p>
                        </div>
                        <div class="col-12">
                            <div class="timeline-box">
                                <div class="timeline-text">
                                    <h5>{{ $value->owner->name}} - {!! $value->do_status_badge!!}</h5>
                                    <p class="text-muted mb-0">{{ $value->history_notes}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>


            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus DO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin menghapus DO <strong id="deleteName"></strong>?
                <form action="" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="deleteForm" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')

<script src="{{ URL::asset('/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    $('.deleteBtn').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#deleteForm').attr('action', id)
        $('#deleteName').html(name);
    })
</script>
@endsection