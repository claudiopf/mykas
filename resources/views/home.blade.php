@extends('layouts.app_admin')
@section('content')
    <!--Awal Grafik Penjualan & Ranking Sales-->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title text-center">
                            <h5 class="card-title text-center">
                                <iconify-icon icon="solar:chart-bold"></iconify-icon>
                                Grafik Brand Penjualan
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="chart-penjualan" height="350"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">
                            Rank Sales
                        </h5>
                    </div>
                    <div class="card-body">
                        <table id="rank-sales" class="display">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Sales</th>
                                <th>Cabang</th>
                                <th>Total Penjualan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Max Verstappen</td>
                                <td>Aladdin</td>
                                <td>Rp 20.000.000</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Oscar Piastri</td>
                                <td>Cano</td>
                                <td>Rp 18.500.000</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Kimi Antonelli</td>
                                <td>Cano</td>
                                <td>Rp 17.000.000</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Lewis Hamilton</td>
                                <td>DePress</td>
                                <td>Rp 15.000.000</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Norris</td>
                                <td>Era</td>
                                <td>Rp 11.000.000</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Faria</td>
                                <td>Buring</td>
                                <td>Rp 10.000.000</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Antonelli</td>
                                <td>Buring</td>
                                <td>Rp 8.000.000</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Kimi</td>
                                <td>Buring</td>
                                <td>Rp 7.500.000</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Oscar</td>
                                <td>Cano</td>
                                <td>Rp 6.000.000</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Mogan</td>
                                <td>Aladdin</td>
                                <td>Rp 5.000.000</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Akhir Grafik Penjualan & Ranking Sales-->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const tableRankSales = $('#rank-sales').DataTable({
                searching: false,
                lengthMenu: [10, 25, 50, 100]
            });

            const chartPenjualan = $('#chart-penjualan');
            if (chartPenjualan.length) {
                new Chart(chartPenjualan, {
                    type: 'line',
                    data: {
                        labels: ['Philips', 'Panasonic', 'Schneider', 'Supreme', 'Legrand', 'Orenchi'],
                        datasets: [
                            {
                                label: 'Philips',
                                data: [5300000, 2400000, 190000, 800000],
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Panasonic',
                                data: [1800000, 1000000, 500000, 0],
                                backgroundColor: 'rgba(207,118,80,0.5)',
                                borderColor: 'rgb(181,109,50)',
                                borderWidth: 1
                            },
                            {
                                label: 'Schneider',
                                data: [2550000, 0, 0, 0],
                                backgroundColor: 'rgba(19,147,143,0.5)',
                                borderColor: 'rgb(5,244,237)',
                                borderWidth: 1
                            },
                            {
                                label: 'Supreme',
                                data: [1500000, 1500000, 0, 2400000],
                                backgroundColor: 'rgba(234,3,44,0.5)',
                                borderColor: 'rgb(186,20,20)',
                                borderWidth: 1
                            },
                            {
                                label: 'Legrand',
                                data: [2230000, 2230000, 320000, 1850000],
                                backgroundColor: 'rgba(136, 84, 208, 0.5)',
                                borderColor: 'rgb(106, 44, 180)',
                                borderWidth: 1
                            },
                            {
                                label: 'Orenchi',
                                data: [0, 0, 3800000, 0],
                                backgroundColor: 'rgba(255, 206, 86, 0.5)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1
                            }
                        ],
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
                });
            }
        })
    </script>
@endpush
