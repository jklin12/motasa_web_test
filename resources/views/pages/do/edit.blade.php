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
Create
@endslot
@endcomponent

@include('layouts.message')
@include('layouts.errors')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Delivery Order</h5>
            </div>
            <div class="card-body">
                <form action="{{route('do.update',$do->do_id)}}" class="needs-validation" method="post" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label class="form-label mb-2">Tanggal Order</label>
                        <input type="text" name="order_date" value="{{ $do->order_date}}" class="form-control  @error('order_date') is-invalid @enderror flatpickr-input" data-provider="flatpickr" data-date-format="d M, Y" readonly="readonly">
                        @error('order_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label">Nomor Order</label>
                        <input type="text" name="order_number" value="{{ $do->order_number}}" class="form-control  @error('order_number') is-invalid @enderror" id="">
                        @error('order_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label">Nama Customer</label>
                        <input type="text" name="cust_name" value="{{ old('cust_name',$do->cust_name)}}" class="form-control  @error('cust_name') is-invalid @enderror" id="">
                        @error('cust_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label">No Telp Customer</label>
                        <input type="text" name="cust_phone" value="{{ old('cust_phone',$do->cust_phone)}}" class="form-control  @error('cust_phone') is-invalid @enderror" id="">
                        @error('cust_phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label">Email Customer</label>
                        <input type="text" name="cust_email" value="{{ old('cust_email',$do->cust_email)}}" class="form-control  @error('cust_email') is-invalid @enderror" id="">
                        @error('cust_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label">Alamat Customer</label>
                        <input type="text" name="cust_address" value="{{ old('cust_address',$do->cust_address)}}" class="form-control  @error('cust_address') is-invalid @enderror" id="">
                        @error('cust_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <div>
                            <label for="input-catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" id="input-catatan" name="do_notes" rows="3">{{ $do->do_notes}}</textarea>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="mb-2">
                                <label for="input-do-from" class="form-label ">Alamat Pengirim</label>
                                <select class="form-control  @error('do_from') is-invalid @enderror" name="do_from" id="input-do-from">
                                </select>
                                @error('do_from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <div>
                                    <label for="input-detail-pengirim" class="form-label">Detail Alamat Pengirim</label>
                                    <textarea class="form-control  @error('do_from_detail') is-invalid @enderror" id="input-detail-pengirim" name="do_from_detail" rows="3">{{ old('do_from_detail',$do->do_from_detail)}}</textarea>
                                    @error('do_from_detail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-2">
                                <label for="input-do-to" class="form-label ">Alamat Penerima</label>
                                <select class="form-control  @error('do_to') is-invalid @enderror" name="do_to" id="input-do-to">
                                </select>
                                @error('do_to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <div>
                                    <label for="input-detail-penerima" class="form-label">Detail Alamat Penerima</label>
                                    <textarea class="form-control  @error('do_to_detail') is-invalid @enderror" id="input-detail-penerima" name="do_to_detail" rows="3">{{ old('do_to_detail',$do->do_to_detail)}}</textarea>
                                    @error('do_to_detail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12 mb-2">
                        <div class="mb-2">
                            <label for="input-courier-name" class="form-label ">Jasa Pengirim</label>
                        </div>


                        <div class="table-responsive table-card">
                            <table class="table table-striped mb-0">
                                <thead class="table-stripped">
                                    <tr>
                                        <th scope="col">
                                            #
                                        </th>
                                        <th scope="col">Kurir</th>
                                        <th scope="col">Layanan</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Durasi</th>
                                        <th scope="col">Harga</th>
                                    </tr>
                                </thead>
                                <tbody id="courier-table">

                                </tbody>
                            </table>
                        </div>



                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="Row">
                            <label class="col-form-label col-md-4">Produk</label>
                            <label class="col-form-label col-md-2">Qty</label>
                            <label class="col-form-label col-md-3">Harga</label>
                        </div>

                    </div>
                    <div class="from-gorup">
                        @foreach($do->products as $val)
                        <div class="row row-kategori">
                            <div class="col-md-4">
                                <input type="text" class="form-control mb-2" name="edit[{{ $val->product_id}}][produk]" value="{{ $val->product_name}}" />
                            </div>

                            <div class="col-md-2">
                                <input type="number" class="form-control mb-2 input-qty" name="edit[{{ $val->product_id}}][qty]" value="{{ $val->product_qty}}" min="1" />
                            </div>

                            <div class="col-md-2">
                                <div class="input-group mb-3 ">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" class="form-control input-total" name="edit[{{ $val->product_id}}][price]" value="{{ $val->getRawOriginal('product_price')}}" />
                                </div>

                            </div>
                            <div class="col-md-2">
                                <a href="javascript:;" class="btn rounded-pill btn-danger btn-sm deleteBtn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{route('p_order.destroy', $val->product_id)}}" data-name="{{$val->product_name}}">hapus</a>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="form-group" id="dynamic_form">

                        <div class="row row-kategori">
                            <div class="col-md-4">
                                <input type="text" class="form-control mb-2" name="produk" value="" />
                            </div>

                            <div class="col-md-2">
                                <input type="number" class="form-control mb-2 input-qty" name="qty" value="1" min="1" />
                            </div>

                            <div class="col-md-2">
                                <div class="input-group mb-3 ">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="text" class="form-control input-total" name="price" value="" />
                                </div>

                            </div>
                            <div class="col-md-2">
                                <a href="javascript:;" class="btn rounded-pill btn-primary btn-sm btn-tambah" id="plus5">Tambah</a>
                                <a href="javascript:;" class="btn rounded-pill btn-danger btn-sm btn-edit" id="minus5">hapus</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mt-4">
                                <button class="btn btn-primary w-100" value="1" name="draft" type="submit">Simpan Draft</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Kirim</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!--end col-->
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin menghapus produk <strong id="deleteName"></strong>?
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/dynamic-form.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    $('#input-do-from').select2({
        placeholder: "Cari alamat pengirim",
        ajax: {
            url: '<?= route('ajax.getAreaID') ?>',
            processResults: function(data) {
                return data;
            },
            cache: true
        },

    })
    $('#input-do-to').select2({
        placeholder: "Cari alamat pengirim",
        ajax: {
            url: '<?= route('ajax.getAreaID') ?>',
            processResults: function(data) {
                return data;
            },
            cache: true
        }
    })



    function iniShipping() {
        var dataPengirim = new Option('<?= $do->do_from_detail ?>', '<?= $do->do_from ?>', false, false);
        $('#input-do-from').append(dataPengirim).trigger('change');
        var dataPenerima = new Option('<?= $do->do_to_detail ?>', '<?= $do->do_to ?>', false, false);
        $('#input-do-to').append(dataPenerima).trigger('change');
        checkCourier()
        setTimeout(function() {
            var radios = $('input:radio[name=selected_courier]');
            console.log(radios)
            if (radios.is(':checked') === false) {
                radios.filter('[value=<?= $do->courier_name ?>]').prop('checked', true);
            }
        }, 2000);


    }
    iniShipping()

    function checkCourier() {

        var pengirimId = $('#input-do-from').val()
        var penerimaId = $('#input-do-to').val()
        if (pengirimId && penerimaId) {
            //console.log(penerimaId+penerimaId);
            $.ajax({
                url: '<?= route('ajax.getCourierRate') ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    from: pengirimId,
                    to: penerimaId
                },
                success: function(data) {
                    $('#courier-table').html(data)
                }
            })
        }

    }

    $('#input-do-from').change(function() {
        checkCourier()
        var data = $("#input-do-from option:selected").text();

        $("#input-detail-pengirim").val(data);
    })
    $('#input-do-to').change(function() {
        checkCourier()
        var data = $("#input-do-to option:selected").text();

        $("#input-detail-penerima").val(data);
    })

    $(".btn-tambah").on('click', function() {});
    var dynamic_form = $("#dynamic_form").dynamicForm("#dynamic_form", "#plus5", "#minus5", {
        limit: 10,
        formPrefix: "product_data",
        normalizeFullForm: false
    });
    $("#dynamic_form #minus5").on('click', function() {
        var initDynamicId = $(this).closest('#dynamic_form').parent().find("[id^='dynamic_form']").length;
        if (initDynamicId === 2) {
            $(this).closest('#dynamic_form').next().find('#minus5').hide();
        }
        $(this).closest('#dynamic_form').remove();
    });

    $('.deleteBtn').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');

        $('#deleteForm').attr('action', id)
        $('#deleteName').html(name);
    })
</script>
@endsection