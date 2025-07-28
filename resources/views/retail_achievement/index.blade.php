@extends('layouts.app_admin')
@section('content')
    <h3>Pencapaian Toko</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="display" id="tableRetailAchievement">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Capaian</th>
                                    <th>Jumlah Toko</th>
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
        $(document).ready(function() {
            $('#tableRetailAchievement').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('retail_achievement.index') }}',
                columns: [
                    { data: 'DT_RowIndex' },
                    { data: 'name' },
                    { data: 'capaian', name: 'capaian' },
                    { data: 'jmlToko', name: 'jmlToko',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
