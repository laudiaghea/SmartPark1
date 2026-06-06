@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="row mb-4">

    <div class="col-md-4">
        <div class="card bg-primary text-white p-3 stat-card">
            <h5>Kendaraan Masuk</h5>
            <p id="total">0</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white p-3 stat-card">
            <h5>Kendaraan Keluar</h5>
            <p id="keluar">0</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-warning text-white p-3 stat-card">
            <h5>Parkir Aktif</h5>
            <p id="aktif">0</p>
        </div>
    </div>

</div>


<div class="row mt-4">

   <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                Grafik Pendapatan
            </div>
            <div class="card-body" style="height: 320px;">
                <canvas id="chartPendapatan"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                Kendaraan Masuk vs Keluar
            </div>
            <div class="card-body" style="height: 320px;">
                <canvas id="chartKendaraan"></canvas>
            </div>
        </div>
    </div>

</div>

<style>
.stat-card {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeUp 0.6s ease forwards;
}

@keyframes fadeUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card:hover {
    transform: translateY(-5px);
    transition: 0.3s;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let dashboardData = null;
let chartPendapatanInstance = null;
let chartKendaraanInstance = null;


async function loadDashboard() {
    const token = localStorage.getItem('token');

    try {
        const response = await fetch('http://127.0.0.1:8000/api/dashboard', {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });

        if (response.status === 401) {
            localStorage.removeItem('token');
            window.location.href = '/login';
            return;
        }

        const data = await response.json();

        dashboardData = data;

        animateNumber(document.getElementById('total'), data.total_kendaraan);
        animateNumber(document.getElementById('keluar'), data.kendaraan_keluar);
        animateNumber(document.getElementById('aktif'), data.parkir_aktif);

        setTimeout(loadChart, 300);

    } catch (error) {
        console.error('Error:', error);
    }
}

async function loadChart() {
    const token = localStorage.getItem('token');

    const response = await fetch('http://127.0.0.1:8000/api/chart-pendapatan', {
        headers: {
            'Authorization': 'Bearer ' + token
        }
    });

    const res = await response.json();

    // =====================
    // CHART PENDAPATAN
    // =====================
    const ctx = document.getElementById('chartPendapatan').getContext('2d');

    if (chartPendapatanInstance) {
        chartPendapatanInstance.destroy();
    }

    chartPendapatanInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: res.labels,
            datasets: [{
                label: 'Pendapatan Harian',
                data: res.values,
                borderColor: 'blue',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    const ctx2 = document.getElementById('chartKendaraan').getContext('2d');

    if (chartKendaraanInstance) {
        chartKendaraanInstance.destroy();
    }

    chartKendaraanInstance = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Masuk', 'Keluar'],
            datasets: [{
                data: [
                    dashboardData.total_kendaraan,
                    dashboardData.kendaraan_keluar
                ],
                backgroundColor: ['blue', 'green']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
}

function animateNumber(element, target) {
    let start = 0;
    const duration = 800;
    const stepTime = 20;

    const step = target / (duration / stepTime);

    const interval = setInterval(() => {
        start += step;

        if (start >= target) {
            start = target;
            clearInterval(interval);
        }

        element.innerText = Math.floor(start);
    }, stepTime);
}

loadDashboard();

</script>

@endsection
