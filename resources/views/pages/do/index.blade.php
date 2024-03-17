@extends('layouts.master')
@section('title')
Delivery Order
@endsection
@section('content')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@component('components.breadcrumb')
@slot('li_1')
Delivery Order
@endslot
@slot('title')
List
@endslot
@endcomponent

@include('layouts.errors')
@include('layouts.message')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">List Delivery Order</h5>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-2">
                    <div class="col-lg-auto">
                        <div class="hstack gap-2">
                            <!-- Buttons with Label -->
                            <a href="{{ route('do.create',)}}" class="btn btn-primary btn-label waves-effect waves-light">
                                <i class="ri-add-circle-line  label-icon align-middle fs-16 me-2"></i> Tambah Delivery Order
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive ">
                    <table class="table align-middle table-striped mb-2">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" width="1%">#</th>
                                <th scope="col">Nomor Do</th>
                                <th scope="col">Tanggal DO</th>
                                <th scope="col">Nomor Order</th>
                                <th scope="col">Tanggal Order</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Telp</th>
                                <th scope="col">Jasa Pengirim</th>
                                <th scope="col">Biaya</th>
                                <th scope="col">Status</th>
                                <th scope="col" colspan="3" width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($do as $key => $value)
                            <tr>
                                <td>{{ ($do->currentpage()-1) * $do->perpage() + $loop->index + 1 }}</td>
                                <td>
                                    @if($value->do_number)
                                    <a href="{{ route('do.show',$value->do_id)  }}" class="fw-medium link-primary"> {{ $value->do_number  }}</a>
                                    @endif
                                </td>
                                <td>{{ $value->do_date}}</td>
                                <td>{{ $value->order_number}}</td>
                                <td>{{ $value->order_date}}</td>
                                <td>{{ $value->cust_name}}</td>
                                <td>{{ $value->cust_phone}}</td>
                                <td>{{ $value->courier_name}}</td>
                                <td>{{ $value->shipping_price}}</td>
                                <td>{!! $value->do_status_badge !!}</td>

                                <td>
                                    <a href="{{ route('do.show',$value->do_id)}}" class="btn   btn-info btn-sm">Detail</a>
                                </td>
                                <td>
                                    @if($value->do_status != 'Approve')
                                    <a href="javascript:;" class="btn   btn-danger btn-sm deleteBtn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{route('do.destroy', $value->do_id)}}" data-name="{{$value->do_number}}">Hapus</a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <strong>Maaf!</strong> Belum ada data delivery order
                            @endforelse
                        </tbody>
                    </table>
                    {{ $do->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div><!--end col-->
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