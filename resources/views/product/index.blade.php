@extends('layouts.app_admin')
@section('content')
    <h3>Master Product</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-1"
                                data-bs-toggle="modal" data-bs-target="#modalAddProduct">
                            <iconify-icon icon="solar:add-circle-linear" class="fs-5"></iconify-icon>
                            <span>Tambah Product</span>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="display" id="tableProduct">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Idem</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Brand</th>
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
    <div class="modal fade" id="modalAddProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formAddProduct">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBrandLabel">Tambah Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="no_idem" class="form-label">No Idem</label>
                            <input type="text" name="no_idem" class="form-control" id="no_idem" placeholder="Masukkan no idem" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="text" name="harga" class="form-control" id="harga" placeholder="Masukkan harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select class="form-select" name="brand_id" id="brand_id">
                                    <option value="">Pilih Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status_aktif" class="form-label">Status</label>
                            <select class="form-select" name="status_aktif" id="status_aktif">
                                <option value="">Pilih Status Aktif</option>
                                <option value="aktif">Aktif</option>
                                <option value="tidak aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnAddProduct">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#tableProduct').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('product.index') }}',
                columns: [
                    {data: 'id'},
                    {data: 'no_idem'},
                    {data: 'nama'},
                    {data: 'harga'},
                    {data: 'brand'},
                    {data: 'status'},
                    {data: 'action', orderable: false, searchable: false}
                ]
            });

            $('#harga').on('input', function () {
                let angka = $(this).val().replace(/\D/g, '');
                let format = new Intl.NumberFormat('id-ID').format(angka);
                $(this).val(format);
            });

            $('#formAddProduct').on('submit', function (e) {
                let hargaDB = $('#harga').val().replace(/\./g, '');
                $('#harga').val(hargaDB);
            });

            $('#formAddProduct').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Tambah Product?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = $(this).serialize();
                        $.post("{{ route('product.store') }}", formData)
                            .done(function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Product berhasil ditambahkan',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#modalAddProduct').modal('hide');
                                    $('#formAddProduct')[0].reset();
                                    $('#tableProduct').DataTable().ajax.reload();
                                });
                            })
                            .fail(function(xhr) {
                                let message = 'Terjadi kesalahan';
                                if (xhr.responseJSON?.errors) {
                                    message = Object.values(xhr.responseJSON.errors).flat().join('\n');
                                } else if (xhr.responseJSON?.message) {
                                    message = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: message
                                });
                            });
                    }
                });
            });
        });
    </script>
@endpush
