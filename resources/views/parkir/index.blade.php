@extends('layouts.app')

@section('title', 'Kendaraan Masuk')

@section('content')

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">


</div><a href="/parkir/tambah" class="btn btn-primary mb-3">
        <i class="fa-solid fa-plus me-2"></i>Tambah
    </a>

<!-- CARD TABLE -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h5><i class="fas fa-car me-2"></i>Data kendaraan yang sedang parkir</h5>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table align-middle table-hover">

                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Plat Nomor</th>
                        <th>Jenis</th>
                        <th>Waktu Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody id="tableParkir">
                    <tr>
                        <td colspan="5" class="text-center text-muted">Loading...</td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>
</div>


<!-- SCRIPT -->
<script>
async function loadParkir() {
    const token = localStorage.getItem('token');

    const response = await fetch('http://127.0.0.1:8000/api/parkir', {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    });

    const data = await response.json();

    let html = '';

    if (data.length === 0) {
        html = `<tr><td colspan="5" class="text-center text-muted">Belum ada data</td></tr>`;
    } else {
        data.forEach(item => {
            html += `
                <tr>
                    <td class="fw-semibold">${item.kode_unik}</td>
                    <td>${item.plat_nomor}</td>
                    <td>
                        <span class="badge bg-info text-dark text-uppercase">
                            ${item.tarif.jenis_kendaraan}
                        </span>
                    </td>
                    <td>${new Date(item.waktu_masuk).toLocaleString('id-ID')}</td>
                    <td>
                        <span class="badge bg-success">Masuk</span>
                    </td>
                </tr>
            `;
        });
    }

    document.getElementById('tableParkir').innerHTML = html;
}

document.addEventListener('DOMContentLoaded', function () {
    loadParkir();
});
</script>

@endsection
