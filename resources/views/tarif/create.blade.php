@extends('layouts.app')

@section('title', 'Tambah Tarif')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <p class="text-muted mb-0">
            Input kendaraan yang masuk ke area parkir
        </p>
    </div>

    <a href="/tarif" class="btn btn-light border rounded-3 px-3">
        <i class="fas fa-arrow-left me-2"></i>
        Kembali
    </a>

</div>
<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <div id="alertBox"></div>

        <form id="formTarif">

            <div class="mb-4">

                <label class="form-label">
                    Jenis Kendaraan
                </label>

                <input
                    type="text"
                    id="jenis_kendaraan"
                    class="form-control form-control-lg"
                    required
                >

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Harga Per Hari
                </label>

                <input
                    type="number"
                    id="harga_per_hari"
                    class="form-control form-control-lg"
                    required
                >

            </div>

           <button
                type="submit" class="btn btn-primary btn-lg rounded-3 px-4">
                <i class="fas fa-save me-2"></i>
                Simpan Kendaraan
            </button>

        </form>

    </div>

</div>

<script>

document
.getElementById('formTarif')
.addEventListener('submit', async function(e){

    e.preventDefault();

    const token = localStorage.getItem('token');

    const response = await fetch(
        'http://127.0.0.1:8000/api/tarif',
        {
            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token
            },

            body: JSON.stringify({
                jenis_kendaraan:
                    document.getElementById('jenis_kendaraan').value,

                harga_per_hari:
                    document.getElementById('harga_per_hari').value
            })
        }
    );

    const result = await response.json();

    if(response.ok){

        window.location.href = '/tarif';

    } else {

        document.getElementById('alertBox').innerHTML = `
            <div class="alert alert-danger">
                ${result.message}
            </div>
        `;
    }
});

</script>

@endsection
