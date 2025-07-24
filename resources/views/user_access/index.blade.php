@extends('layouts.app_admin')
@section('content')
    <h3>Hak Akses</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="display" id="tableHakAkses">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sales</th>
                                    <th>SS</th>
                                    <th>Area</th>
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
            $('#tableHakAkses').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user_access.index') }}',
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'sales', name: 'sales' },
                    { data: 'ss' },
                    { data: 'area' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.btnEditUser', function () {
                $('#edit-id').val($(this).data('id'));
                $('#edit-name').val($(this).data('name'));
                $('#edit-email').val($(this).data('email'));
                $('#edit-role').val($(this).data('role'));
                $('#edit_password').val('');
                $('#modalEditUser').modal('show');
            });

            $('#formEditUser').on('submit', function (e) {
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
                            url: `/user-management/${id}`,
                            method: 'PATCH',
                            data: formData,
                            success: function (res) {
                                Swal.fire('Berhasil', 'User berhasil diperbarui', 'success');
                                $('#modalEditUser').modal('hide');
                                $('#formEditUser')[0].reset();
                                $('#tableUser').DataTable().ajax.reload();
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

            $(document).on('click', '.btnDeleteUser', function (e) {
                e.preventDefault();

                let userId = $(this).data('id');

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
                            url:  '/user-management/' + userId,
                            type: 'DELETE',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'User berhasil dihapus',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#tableUser').DataTable().ajax.reload();
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal menghapus user. Silakan coba lagi.',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
