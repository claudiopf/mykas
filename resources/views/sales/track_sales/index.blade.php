@extends('layouts.app_admin')
@section('content')
    <h3>Sales Tracker</h3>
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div id="sales_tracker" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            const mapElement = document.getElementById('sales_tracker');
            if (!mapElement) {
                alert("Element #sales_tracker tidak ditemukan.");
                return;
            }

            const salesTracker = L.map('sales_tracker').setView([-6.2, 106.816], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(salesTracker);

            const locations = [
                { latitude: -6.2000, longitude: 106.8166, nama_sales: 'Max', tanggal_bertemu: '2025-06-19' },
                { latitude: -6.2146, longitude: 106.8451, nama_sales: 'Oscar Piastri', tanggal_bertemu: '2025-06-18' },
                { latitude: -6.1745, longitude: 106.8227, nama_sales: 'Charles Leclerc', tanggal_bertemu: '2025-06-17' },
                { latitude: -6.1214, longitude: 106.7741, nama_sales: 'Lando Norris', tanggal_bertemu: '2025-06-16' }
            ];

            const branchMapping = {
                'Max': 'Aladdin',
                'Oscar Piastri': 'Fast Print',
                'Charles Leclerc': 'Cano',
                'Lando Norris': 'Era'
            };

            const cabangColors = {
                'Aladdin': 'red',
                'Buring': 'blue',
                'Cano': 'green',
                'Era': 'orange',
                'Fast Print': 'darkblue',
                'Depress': 'lightblue',
                'default': 'gray'
            };

            locations.forEach(({ latitude, longitude, nama_sales, tanggal_bertemu }) => {
                const cabang = branchMapping[nama_sales] || 'default';
                const color = cabangColors[cabang] || cabangColors['default'];

                L.circleMarker([latitude, longitude], {
                    radius: 8,
                    fillColor: color,
                    color: '#fff',
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.85
                })
                    .addTo(salesTracker)
                    .bindPopup(`
                    <b>${nama_sales}</b><br>
                    📅 ${tanggal_bertemu}<br>
                    🏢 <i>${cabang}</i>
                `);
            });
        });
    </script>
@endpush
