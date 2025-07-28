@extends('layouts.app_admin')
@section('content')
    <h3>Hak Akses</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
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

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEditHakAkses" tabindex="-1" aria-labelledby="editHakAksesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formEditHakAkses">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Sales</label>
                            <input type="text" class="form-control" name="name" id="edit-sales">
                        </div>
                        <div class="mb-3">
                            <label for="edit-ss" class="form-label">SS</label>
                            <select class="form-select" name="ss_id" id="edit-ss">
                                <option value="">Pilih SS</option>
                                @foreach ($roleSs as $ss)
                                    <option value="{{ $ss->id }}">{{ $ss->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-area" class="form-label">Area</label>
                            <select class="form-select select2" name="area_id[]" id="edit-area" multiple>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->kode_area }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
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
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.btnEditHakAkses', function () {
                const ssId = $(this).data('ss');
                const areaData = $(this).data('area');
                const areaIds = areaData ? areaData.toString().split(',') : [];

                $('#edit-id').val($(this).data('id'));
                $('#edit-sales').val($(this).data('sales'));
                $('#edit-ss').val(ssId).trigger('change');

                $('#modalEditHakAkses').off('shown.bs.modal').on('shown.bs.modal', function () {
                    $('#edit-area').select2({
                        dropdownParent: $('#modalEditHakAkses'),
                        placeholder: "Pilih Area"
                    });

                    $('#edit-area').val(areaIds).trigger('change');
                });

                $('#modalEditHakAkses').modal('show');
            });

            $('#formEditHakAkses').on('submit', function (e) {
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
                            url: `/user-access/${id}`,
                            method: 'PATCH',
                            data: formData,
                            success: function (res) {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Hak Akses berhasil diperbarui',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                $('#modalEditHakAkses').modal('hide');
                                $('#formEditHakAkses')[0].reset();
                                $('#tableHakAkses').DataTable().ajax.reload();
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
        });
    </script>
@endpush
