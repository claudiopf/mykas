@extends('layouts.app_admin')
@section('content')
    <h3>Edit Transaksi</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form id="formEditTransaction">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="mb-3">
                                    <label for="retail" class="form-label">Toko <code>*</code></label>
                                    <select class="form-select select2" name="retail_id" id="retail">
                                        <option value="">Pilih Toko</option>
                                        @foreach($retails as $retail)
                                            <option value="{{ $retail->id }}" {{ $transaction->salesOrder->retail_id == $retail->id ? 'selected' : '' }}>
                                                {{ $retail->nama }}
                                            </option>
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
                                        <option value="0" {{ $transaction->salesOrder->top == 0 ? 'selected' : '' }}>0 Hari</option>
                                        <option value="7" {{ $transaction->salesOrder->top == 7 ? 'selected' : '' }}>7 Hari</option>
                                        <option value="14" {{ $transaction->salesOrder->top == 14 ? 'selected' : '' }}>14 Hari</option>
                                        <option value="25" {{ $transaction->salesOrder->top == 25 ? 'selected' : '' }}>25 Hari</option>
                                        <option value="28" {{ $transaction->salesOrder->top == 28 ? 'selected' : '' }}>28 Hari</option>
                                        <option value="30" {{ $transaction->salesOrder->top == 30 ? 'selected' : '' }}>30 Hari</option>
                                        <option value="60" {{ $transaction->salesOrder->top == 60 ? 'selected' : '' }}>60 Hari</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="top" class="form-label">Status Order <code>*</code></label>
                                    <select class="form-select" name="status_order" id="status_order">
                                        <option value="">Pilih Status Order</option>
                                        <option value="approved" {{ $transaction->status_order == 'approved' ? 'selected' : '' }}>Approve</option>
                                        <option value="rejected" {{ $transaction->status_order == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="pending" {{ $transaction->status_order == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="note" class="form-label">Catatan SS Admin</label>
                                    <textarea name="note_ssadmin" class="form-control" id="note" cols="30" rows="5">{{ $transaction->note_ssadmin ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary">Batal</button>
                                <span class="mx-1"></span>
                                <button type="submit" class="btn btn-primary" id="btnEditTransaction">Ubah</button>
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
            // Inisialisasi Select2
            $('.select2').select2();

            // AJAX Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Tampilkan produk existing
            @php
                $existingDetails = $transaction->salesOrder->salesOrderDetails->sortBy(function($detail) {
                    return $detail->product->nama ?? '';
                })->values();
            @endphp
            const existingDetails = @json($existingDetails);

            if (existingDetails.length > 0) {
                $('#produk-container').show();
                existingDetails.forEach(function (detail) {
                    const productId = detail.product.id;
                    const productName = detail.product.nama;
                    const qty = detail.qty;
                    const discount = detail.discount;

                    const tableRow = `
                        <tr data-id="${productId}">
                            <td class="text-center">
                                <input type="hidden" name="product_id[]" value="${productId}">
                                <input type="text" class="form-control" value="${productName}" readonly>
                            </td>
                            <td class="text-center">
                                <input type="number" name="qty[]" class="form-control text-center" value="${qty}">
                            </td>
                            <td class="text-center">
                                <input type="number" name="discount[]" class="form-control text-center" value="${discount}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this, '${productId}')">Hapus</button>
                            </td>
                        </tr>`;

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
                                    <input type="number" name="qty[]" class="form-control text-center" value="${qty}">
                                </div>
                                <div class="mb-2">
                                    <label>Diskon</label>
                                    <input type="number" name="discount[]" class="form-control text-center" value="${discount}">
                                </div>
                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusCard(this, '${productId}')">Hapus</button>
                            </div>
                        </div>`;

                    if ($(window).width() >= 576) {
                        $('#produkBody').append(tableRow);
                    } else {
                        $('#produkMobileBody').append(mobileCard);
                    }
                });
            }

            // Event tambah produk
            $('#product-select').on('change', function () {
                const productId = $(this).val();
                const productName = $(this).find('option:selected').data('nama');

                if (!productId) return;

                if ($('#produkBody tr[data-id="' + productId + '"]').length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Produk duplikat',
                        text: 'Produk sudah dipilih sebelumnya.'
                    });
                    return;
                }

                $('#produk-container').show();

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
                    </tr>`;

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
                    </div>`;

                if ($(window).width() >= 576) {
                    $('#produkBody').append(tableRow);
                } else {
                    $('#produkMobileBody').append(mobileCard);
                }

                $(this).val('').trigger('change');
            });

            // Submit pakai SweetAlert2
            $('#formEditTransaction').on('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin menyimpan perubahan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitEditTransaction();
                    }
                });
            });

            function submitEditTransaction() {
                const form = $('#formEditTransaction');
                const formData = form.serialize();
                const url = "{{ route('transaction.update', $transaction->id) }}";

                $('#btnEditTransaction').prop('disabled', true).text('Menyimpan...');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('transaction.index') }}";
                        });
                    },
                    error: function (xhr) {
                        let message = 'Terjadi kesalahan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: message
                        });

                        $('#btnEditTransaction').prop('disabled', false).text('Ubah');
                    }
                });
            }
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

