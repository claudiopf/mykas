@extends('layouts.app_admin')
@section('content')
    <h3>Sales Order</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form id="formAddSO">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label for="retail" class="form-label">Toko <code>*</code></label>
                                    <select class="form-select select2" name="retail_id" id="retail">
                                        <option value="">Pilih Toko</option>
                                        @foreach($retails as $retail)
                                            <option value="{{ $retail->id }}">{{ $retail->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="product" class="form-label">Produk <code>*</code></label>
                                    <select class="form-select select2" id="product-select">
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-nama="{{ $product->nama }}">{{ $product->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div id="produk-container" style="display: none;">
                                        <!-- Table (desktop/tablet) -->
                                        <table class="table table-bordered d-none d-sm-table mt-3" id="produkTable" style="border-color: lightgrey;">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Produk</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Diskon</th>
                                                <th class="text-center">#</th>
                                            </tr>
                                            </thead>
                                            <tbody id="produkBody"></tbody>
                                        </table>

                                        <!-- Mobile/Card -->
                                        <div id="produkMobileBody" class="d-block d-sm-none mt-3"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="top" class="form-label">TOP <code>*</code></label>
                                    <select class="form-select" id="top" name="top">
                                        <option value="">Pilih TOP</option>
                                        <option value="0">0 Hari</option>
                                        <option value="7">7 Hari</option>
                                        <option value="14">14 Hari</option>
                                        <option value="25">25 Hari</option>
                                        <option value="28">28 Hari</option>
                                        <option value="30">30 Hari</option>
                                        <option value="60">60 Hari</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="note" class="form-label">Catatan Sales</label>
                                    <textarea name="note_sales" class="form-control" id="note_sales" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary">Batal</button>
                                <span class="mx-1"></span>
                                <button type="submit" class="btn btn-primary" id="btnAddSO">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.btn-remove-row', function () {
                $(this).closest('.item-row').remove();
            });

            $('.select2').select2();

            $('#product-select').on('change', function () {
                const productId = $(this).val();
                const productName = $(this).find('option:selected').data('nama');

                if (productId) {
                    // Tampilkan container jika belum tampil
                    $('#produk-container').show();

                    // Cegah produk duplikat
                    if ($('#produkBody tr[data-id="' + productId + '"]').length > 0) {
                        alert("Produk sudah dipilih.");
                        return;
                    }

                    // Table Row
                    const tableRow = `
                                        <tr data-id="${productId}">
                                            <td class="text-center">
                                                <input type="hidden" name="product_id[]" value="${productId}">
                                                <input type="text" class="form-control" value="${productName}" readonly>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" name="qty[]" class="form-control text-center">
                                            </td>
                                            <td class="text-center">
                                                <input type="number" name="discount[]" class="form-control text-center">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this, '${productId}')">Hapus</button>
                                            </td>
                                        </tr>
                                    `;

                    // Mobile Card
                    const mobileCard = `
                                            <div class="card mb-2" data-id="${productId}">
                                                <div class="card-body">
                                                    <input type="hidden" name="product_id[]" value="${productId}">
                                                    <div class="mb-2">
                                                        <label>Nama Produk</label>
                                                        <input type="text" class="form-control" value="${productName}" readonly>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label>Qty</label>
                                                        <input type="number" name="qty[]" class="form-control text-center">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label>Diskon</label>
                                                        <input type="number" name="discount[]" class="form-control text-center">
                                                    </div>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusCard(this, '${productId}')">Hapus</button>
                                                </div>
                                            </div>
                                        `;

                    if ($(window).width() >= 576) {
                        $('#produkBody').append(tableRow);
                    } else {
                        $('#produkMobileBody').append(mobileCard);
                    }

                    $(this).val('').trigger('change');
                }
            });

            $('#formAddSO input, #formAddSO select, #formAddSO textarea').each(function () {
                const isHidden = $(this).css('display') === 'none' || $(this).css('visibility') === 'hidden' || $(this).parents(':hidden').length > 0;
                if (isHidden) {
                    $(this).prop('disabled', true);
                }
            });

            $('#formAddSO').on('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Simpan Sales Order?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $('#formAddSO')[0];
                        const formData = new FormData(form);

                        $.ajax({
                            url: "{{ route('sales_order.store') }}",
                            method: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                $('#btnAddSO').prop('disabled', true).text('Menyimpan...');
                            },
                            success: function (res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: res.message ?? 'Sales Order berhasil disimpan',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#formAddSO')[0].reset();
                                    $('#produkBody').empty();
                                    $('#produkMobileBody').empty();
                                    $('#produk-container').hide();
                                    $('.select2').val(null).trigger('change');
                                    $('#btnAddSO').prop('disabled', false).text('Simpan');
                                });
                            },
                            error: function (xhr) {
                                let errorText = 'Terjadi kesalahan.';
                                if (xhr.status === 422) {
                                    const errors = xhr.responseJSON.errors;
                                    errorText = Object.values(errors).map(errArr => errArr[0]).join('\n');
                                } else if (xhr.responseJSON?.error) {
                                    errorText = xhr.responseJSON.error;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: errorText
                                });
                                $('#btnAddSO').prop('disabled', false).text('Simpan');
                            }
                        });
                    }
                });
            });
        });

        function hapusBaris(btn, productId) {
            $(btn).closest('tr').remove();
            $('#produkMobileBody').find(`[data-id="${productId}"]`).remove();
            cekKosong();
        }

        function hapusCard(btn, productId) {
            $(btn).closest('.card').remove();
            $('#produkTable').find(`[data-id="${productId}"]`).remove();
            cekKosong();
        }

        function cekKosong() {
            if ($('#produkBody tr').length === 0 && $('#produkMobileBody .card').length === 0) {
                $('#produk-container').hide();
            }
        }
    </script>
@endpush
