@extends('layouts.app_admin')
@section('content')
    <h3>Sales Order</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <form id="formAddSO">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label for="retail" class="form-label">Toko</label>
                                <select class="form-select select2" name="retail_id" id="retail" multiple>
                                    @foreach($retails as $retail)
                                        <option value="{{ $retail->id }}">{{ $retail->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="product" class="form-label">Product</label>
                                <select class="form-select select2" name="product_id" id="product" multiple>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary">Batal</button>
                            <span class="mx-1"></span>
                            <button type="submit" class="btn btn-primary" id="btnAddUser">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function ()  {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#retail').select2({
                placeholder: "Pilih Toko"
            });

            $('#product').select2({
                placeholder: "Pilih Product"
            });
        })
    </script>
@endpush
