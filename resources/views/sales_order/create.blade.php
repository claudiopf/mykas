@extends('layouts.app_admin')
@section('content')
    <h3>Sales Order</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <form id="formAddSO">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label for="retail" class="form-label">Toko</label>
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
                                <label for="product" class="form-label">Pilih Produk</label>
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
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary">Batal</button>
                            <span class="mx-1"></span>
                            <button type="submit" class="btn btn-primary" id="btnAddUser">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
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
                                                <input type="hidden" name="produk_id[]" value="${productId}">
                                                <input type="text" class="form-control" value="${productName}" readonly>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" name="qty[]" class="form-control" required>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" name="diskon[]" class="form-control" required>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this, '${productId}')">Hapus</button>
                                            </td>
                                        </tr>
                                    `;
                    $('#produkBody').append(tableRow);

                    // Mobile Card
                    const mobileCard = `
                                            <div class="card mb-2" data-id="${productId}">
                                                <div class="card-body">
                                                    <input type="hidden" name="produk_id[]" value="${productId}">
                                                    <div class="mb-2">
                                                        <label>Nama Produk</label>
                                                        <input type="text" class="form-control" value="${productName}" readonly>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label>Qty</label>
                                                        <input type="number" name="qty[]" class="form-control" required>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label>Diskon</label>
                                                        <input type="number" name="diskon[]" class="form-control" required>
                                                    </div>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusCard(this, '${productId}')">Hapus</button>
                                                </div>
                                            </div>
                                        `;
                    $('#produkMobileBody').append(mobileCard);

                    // Reset select
                    $(this).val('').trigger('change');
                }
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
