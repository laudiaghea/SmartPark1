@extends('layouts.app')

@section('title', 'Edit Tarif')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <p class="text-muted mb-0">
            Ubah data tarif kendaraan
        </p>
    </div>

    <a
        href="/tarif"
        class="btn btn-light border rounded-3 px-4"
    >
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
    </a>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <div id="alertBox"></div>

        <form id="formTarif">

            <!-- JENIS -->
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Jenis Kendaraan
                </label>

                <input
                    type="text"
                    id="jenis_kendaraan"
                    class="form-control form-control-lg rounded-3"
                    placeholder="Contoh: Motor"
                    required
                >

            </div>

            <!-- HARGA -->
            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Harga Per Hari
                </label>

                <input
                    type="number"
                    id="harga_per_hari"
                    class="form-control form-control-lg rounded-3"
                    placeholder="Contoh: 5000"
                    required
                >

            </div>

            <button
                type="submit"
                class="btn btn-primary px-4 py-2 rounded-3"
            >
                <i class="fas fa-save me-2"></i>
                Update Tarif
            </button>

        </form>

    </div>

</div>

<script>

const id =
    window.location.pathname.split('/').pop();

let authToken =
    localStorage.getItem('token');

// LOAD DETAIL
async function loadDetail() {

    try {

        const response = await fetch(
            `http://127.0.0.1:8000/api/tarif/${id}`,
            {
                headers: {
                    'Authorization': 'Bearer ' + authToken,
                    'Accept': 'application/json'
                }
            }
        );

        const tarif = await response.json();

        if(!response.ok){

            document.getElementById('alertBox').innerHTML = `
                <div class="alert alert-danger rounded-3">
                    ${tarif.message ?? 'Data tidak ditemukan'}
                </div>
            `;

            return;
        }

        document.getElementById('jenis_kendaraan').value =
            tarif.jenis_kendaraan;

        document.getElementById('harga_per_hari').value =
            tarif.harga_per_hari;

    } catch(error) {

        console.error(error);

        document.getElementById('alertBox').innerHTML = `
            <div class="alert alert-danger rounded-3">
                Gagal memuat data tarif
            </div>
        `;
    }
}

// UPDATE
document
.getElementById('formTarif')
.addEventListener('submit', async function(e){

    e.preventDefault();

    const jenis_kendaraan =
        document.getElementById('jenis_kendaraan').value;

    const harga_per_hari =
        document.getElementById('harga_per_hari').value;

    try {

        const response = await fetch(
            `http://127.0.0.1:8000/api/tarif/${id}`,
            {
                method: 'PUT',

                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + authToken,
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    jenis_kendaraan,
                    harga_per_hari
                })
            }
        );

        const result = await response.json();

        if(response.ok) {

            document.getElementById('alertBox').innerHTML = `
                <div class="alert alert-success rounded-3">
                    Tarif berhasil diupdate
                </div>
            `;

            setTimeout(() => {

                window.location.href = '/tarif';

            }, 1200);

        } else {

            document.getElementById('alertBox').innerHTML = `
                <div class="alert alert-danger rounded-3">
                    ${result.message ?? 'Gagal update tarif'}
                </div>
            `;
        }

    } catch(error) {

        console.error(error);

        document.getElementById('alertBox').innerHTML = `
            <div class="alert alert-danger rounded-3">
                Terjadi kesalahan server
            </div>
        `;
    }

});

// AUTO LOAD
document.addEventListener('DOMContentLoaded', function () {

    loadDetail();

});

</script>

@endsection
