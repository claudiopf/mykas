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
                                    <th>Bukti Kunjungan</th>
                                    <th>Sales</th>
                                    <th>Tanggal Kunjungan</th>
                                    <th>Toko</th>
                                    <th>Catatan</th>
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="formAddVisit" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserLabel">Tambah Kunjungan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(auth()->user()->role === 'admin')
                            <div class="mb-3">
                                <label for="tglVisit" class="form-label">Tanggal Kunjungan</label>
                                <input type="datetime-local" class="form-control daterangepicker" name="tgl_visit" id="tglVisit">
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="sales" class="form-label">Sales <code>*</code></label>
                            @if(auth()->user()->role === 'sales')
                                <select name="user_id" class="form-control" id="sales" readonly>
                                    <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>
                                </select>
                            @else
                                <select name="user_id" class="form-control" id="sales">
                                    @foreach($sales as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="retail" class="form-label">Toko <code>*</code></label>
                            <select class="form-select select2" name="retail_id" id="retail" multiple>
                                @foreach ($retails as $retail)
                                    <option value="{{ $retail->id }}">{{ $retail->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="visitBy" class="form-label">Kunjungan Melalui <code>*</code></label>
                            <select name="visit_by" id="visitBy" class="form-select" required>
                                <option value="">Pilih Kunjungan</option>
                                <option value="toko">Toko</option>
                                <option value="telephone">Telephone</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" name="catatan" id="catatan" cols="30" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Bukti Kunjungan <code>*</code></label>
                            <input type="file" name="image" class="form-control" accept="image/*" id="image" required>
                        </div>
                        <div class="mb-3 text-center">
                            <img id="preview-image" src="#" class="img-thumbnail" style="max-height: 150px; display: none;">
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
                    { data: 'image', name: 'image'},
                    { data: 'nama', name: 'nama' },
                    { data: 'tanggal', name: 'tanggal'},
                    { data: 'retail', name: 'retail'},
                    { data: 'catatan', name: 'catatan', orderable: false, searchable: false},
                ]
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#modalAddVisit').on('shown.bs.modal', function () {
                $('#retail').select2({
                    dropdownParent: $('#modalAddVisit'),
                    placeholder: "Pilih Toko"
                });
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

            $('#formAddVisit').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Tambah Kunjungan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $('#formAddVisit')[0];
                        const formData = new FormData(form);

                        $.ajax({
                            url: "{{ route('sales_visit.store') }}",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Kunjungan berhasil ditambahkan',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#modalAddVisit').modal('hide');
                                    $('#formAddVisit')[0].reset();
                                    $('#preview-image').hide();
                                    $('#tableSalesVisit').DataTable().ajax.reload();
                                });
                            },
                            error: function(xhr) {
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
                            }
                        });
                    }
                });
            });
        })
    </script>
@endpush
