@extends('layouts.app_admin')
@section('content')
    <h3>Kunjungan Sales</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-1"
                                data-bs-toggle="modal" data-bs-target="#modalAddVisit">
                            <iconify-icon icon="solar:add-circle-linear" class="fs-5"></iconify-icon>
                            <span>Tambah Kunjungan</span>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="display" id="tableSalesVisit">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sales</th>
                                    <th>Tanggal</th>
                                    <th>Toko</th>
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
    <div class="modal fade" id="modalAddVisit" tabindex="-1" aria-labelledby="addVisitLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formAddVisit" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserLabel">Tambah Kunjungan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Sales</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="retail" class="form-label">Toko</label>
                            <input type="text" name="retail_id" class="form-control" id="retail" placeholder="Masukan toko" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Bukti Kunjungan</label>
                            <input type="file" name="image" class="form-control" accept="image/*" id="image">
                        </div>
                        <div class="mb-3">
                            <img id="preview-image" src="#" class="img-thumbnail mx-auto d-block" style="max-height: 150px; display: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnAddRetail">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#tableSalesVisit').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('sales_visit.index') }}',
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'nama', name: 'nama' },
                    { data: 'tanggal', name: 'tanggal'},
                    { data: 'retail', name: 'retail', orderable: false, searchable: false},
                ]
            });

            $('#image').on('change', function () {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview-image').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                }
            });
        })
    </script>
@endpush
