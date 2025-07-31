@extends('layouts.app_admin')
@section('content')
    <h3>Sales Order</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <a href="{{ route('sales_order.create') }}" type="button" class="btn btn-primary d-inline-flex align-items-center gap-1">
                            <iconify-icon icon="solar:add-circle-linear" class="fs-5"></iconify-icon>
                            <span>Input Sales Order</span>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="display expandable-table" id="tableSO">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Toko</th>
                                    <th>Tanggal Order</th>
                                    <th class="text-center">Produk</th>
                                    <th>Total Penjualan</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function ()  {
            $('#tableSO').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('sales_order.index') }}',
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'toko', name: 'toko' },
                    { data: 'tgl_order', name: 'tgl_order' },
                    { data: 'product', name: 'product' },
                    { data: 'total_penjualan', name: 'total_penjualan', orderable: false, searchable: false }
                ]
            });
        })
    </script>
@endpush
