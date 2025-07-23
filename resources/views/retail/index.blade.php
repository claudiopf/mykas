@extends('layouts.app_admin')
@section('content')
    <h3>Master Toko</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-1"
                                data-bs-toggle="modal" data-bs-target="#modalAddRetail">
                            <iconify-icon icon="solar:add-circle-linear" class="fs-5"></iconify-icon>
                            <span>Tambah Toko</span>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="display" id="tableRetail">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Toko</th>
                                    <th>Kode BP</th>
                                    <th>Kecamatan</th>
                                    <th>Kode Area</th>
                                    <th>Sales</th>
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
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#tableRetail').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('retail.index') }}',
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'nama' },
                    { data: 'kode_bp'},
                    { data: 'kecamatan'},
                    { data: 'kode_area', name: 'kode_area'},
                    { data: 'sales', name: 'sales'},
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#formAddRetail').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Tambah Retail?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = $(this).serialize();
                        $.post("{{ route('retail.store') }}", formData)
                            .done(function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Retail berhasil ditambahkan',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#modalAddRetail').modal('hide');
                                    $('#formAddRetail')[0].reset();
                                    $('#tableRetail').DataTable().ajax.reload();
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

            $(document).on('click', '.btnEditRetail', function () {
                $('#edit-id').val($(this).data('id'));
                $('#edit-nama').val($(this).data('nama'));
                $('#modalEditBrand').modal('show');
            });

            $('#formEditRetail').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Simpan perubahan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const id = $('#edit-id').val();
                        const formData = $(this).serialize();
                        Swal.fire({
                            title: 'Memproses...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        $.ajax({
                            url: `/retail/${id}`,
                            method: 'PATCH',
                            data: formData,
                            success: function (res) {
                                Swal.fire('Berhasil', 'Retail berhasil diperbarui', 'success');
                                $('#modalEditRetail').modal('hide');
                                $('#formEditRetail')[0].reset();
                                $('#tableRetail').DataTable().ajax.reload();
                            },
                            error: function (xhr) {
                                let message = 'Terjadi kesalahan';
                                if (xhr.responseJSON?.errors) {
                                    message = Object.values(xhr.responseJSON.errors).flat().join('\n');
                                } else if (xhr.responseJSON?.message) {
                                    message = xhr.responseJSON.message;
                                }
                                Swal.fire('Gagal', message, 'error');
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.btnDeleteRetail', function (e) {
                e.preventDefault();

                let retailId = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Aksi ini tidak bisa dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:  '/retail/' + retailId,
                            type: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'Retail berhasil dihapus',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#tableRetail').DataTable().ajax.reload();
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal menghapus retail. Silakan coba lagi.',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
