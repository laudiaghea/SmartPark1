@extends('layouts.app')

@section('title', 'Tambah Kendaraan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <p class="text-muted mb-0">
            Input kendaraan yang masuk ke area parkir
        </p>
    </div>

    <a href="/parkir" class="btn btn-light border rounded-3 px-3">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
    </a>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <div id="alertBox"></div>

        <form id="parkirForm">

            <!-- Plat Nomor -->
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Plat Nomor
                </label>

                <input
                    type="text"
                    id="plat_nomor"
                    class="form-control form-control-lg rounded-3"
                    placeholder="Contoh: L 1234 AB"
                    required
                >

            </div>

            <!-- Jenis Kendaraan -->
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Jenis Kendaraan
                </label>

                <select
                    id="tarif_id"
                    class="form-select form-select-lg rounded-3"
                    required
                >
                    <option value="" disabled selected>
                        -- Pilih Kendaraan --
                    </option>
                </select>

            </div>

            <!-- Button -->
            <button
                type="submit"
                class="btn btn-primary btn-lg rounded-3 px-4"
            >
                <i class="fas fa-save me-2"></i>
                Simpan Kendaraan
            </button>

        </form>

    </div>
</div>

<script>

// LOAD DROPDOWN TARIF
async function loadTarif() {

    const token = localStorage.getItem('token');

    const alertBox =
        document.getElementById('alertBox');

    try {

        const response = await fetch(
            'http://127.0.0.1:8000/api/tarif',
            {
                method: 'GET',

                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            }
        );

        // DEBUG
        console.log('STATUS TARIF:', response.status);

        // kalau token invalid
        if (response.status === 401) {

            localStorage.removeItem('token');
            localStorage.removeItem('user');

            window.location.href = '/login';

            return;
        }

        // kalau server error
        if (!response.ok) {
            throw new Error('Gagal mengambil data tarif');
        }

        const data = await response.json();

        const select =
            document.getElementById('tarif_id');

        // reset option awal
        select.innerHTML = `
            <option value="" disabled selected>
                -- Pilih Kendaraan --
            </option>
        `;

        data.forEach(item => {

            select.innerHTML += `
                <option value="${item.id}">
                    ${item.jenis_kendaraan}
                </option>
            `;
        });

    } catch(error) {

        console.error('ERROR LOAD TARIF:', error);

        alertBox.innerHTML = `
            <div class="alert alert-danger">
                Gagal memuat data tarif
            </div>
        `;
    }
}

// SUBMIT FORM
document
.getElementById('parkirForm')
.addEventListener('submit', async function(e) {

    e.preventDefault();

    const token = localStorage.getItem('token');

    const plat_nomor =
        document.getElementById('plat_nomor').value;

    const tarif_id =
        document.getElementById('tarif_id').value;

    const alertBox =
        document.getElementById('alertBox');

    try {

        const response = await fetch(
            'http://127.0.0.1:8000/api/parkir',
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    plat_nomor,
                    tarif_id
                })
            }
        );

        const data = await response.json();

        if(response.ok){

            alertBox.innerHTML = `
                <div class="alert alert-success">
                    Kendaraan berhasil ditambahkan
                </div>
            `;

            document.getElementById('parkirForm').reset();

            setTimeout(() => {
                window.location.href = '/parkir';
            }, 1000);

        } else {

            alertBox.innerHTML = `
                <div class="alert alert-danger">
                    ${data.message ?? 'Gagal menambahkan kendaraan'}
                </div>
            `;
        }

    } catch(error){

        console.error('ERROR SUBMIT:', error);

        alertBox.innerHTML = `
            <div class="alert alert-danger">
                Terjadi kesalahan server
            </div>
        `;
    }
});

// AUTO LOAD
document.addEventListener('DOMContentLoaded', function() {

    loadTarif();

});

</script>

@endsection
