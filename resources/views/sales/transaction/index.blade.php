@extends('layouts.app_admin')
@section('content')
    <h3>Transaksi</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="display" id="tableTransaction">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Order</th>
                                    <th>Nama Toko</th>
                                    <th>Sales</th>
                                    <th>Note Sales</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
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

    <!-- Modal -->
    <div class="modal fade" id="modalAddTransaction" tabindex="-1" aria-labelledby="addTransactionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formAddTransaksi">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTransaksiLabel">Tambah Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnAddTransaction">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#tableTransaction').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('transaction.index') }}',
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'no_order' },
                    { data: 'nama_toko' },
                    { data: 'sales' },
                    { data: 'note_sales' },
                    { data: 'status' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });
        })
    </script>
@endpush
