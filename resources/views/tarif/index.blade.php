@extends('layouts.app')

@section('title', 'Tarif Kendaraan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <a
        href="/tarif/create"
        class="btn btn-primary px-4"
    >
        <i class="fas fa-plus me-2"></i>
        Tambah Tarif
    </a>

</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h5><i class="fas fa-car me-2"></i>Data tarif</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Jenis Kendaraan</th>
                        <th>Harga / Hari</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableTarif"></tbody>

            </table>

        </div>

    </div>

</div>

<script>

async function loadTarif() {

    const token = localStorage.getItem('token');

    const response = await fetch(
        'http://127.0.0.1:8000/api/tarif',
        {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        }
    );

    const data = await response.json();

    let html = '';

    data.forEach(item => {

        html += `
            <tr>

                <td class="text-capitalize fw-semibold">
                    ${item.jenis_kendaraan}
                </td>

                <td>
                    Rp ${Number(item.harga_per_hari)
                        .toLocaleString('id-ID')}
                </td>

                <td>

                    <a
                        href="/tarif/edit/${item.id}"
                        class="btn btn-warning btn-sm"
                    >
                        <i class="fas fa-edit"></i>
                    </a>

                    <button
                        class="btn btn-danger btn-sm"
                        onclick="hapusTarif(${item.id})"
                    >
                        <i class="fas fa-trash"></i>
                    </button>

                </td>

            </tr>
        `;
    });

    document.getElementById('tableTarif').innerHTML = html;
}

async function hapusTarif(id) {

    if(!confirm('Yakin hapus tarif?')) return;

    const token = localStorage.getItem('token');

    await fetch(
        `http://127.0.0.1:8000/api/tarif/${id}`,
        {
            method: 'DELETE',

            headers: {
                'Authorization': 'Bearer ' + token
            }
        }
    );

    loadTarif();
}

loadTarif();

</script>

@endsection
