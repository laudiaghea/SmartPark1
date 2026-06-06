@extends('layouts.app')

@section('title')

@section('content')

<style>

    .search-card {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
    }

    .ticket-input {
        height: 60px;
        font-size: 20px;
        font-weight: 600;
        letter-spacing: 2px;
    }

    .detail-label {
        font-size: 13px;
        color: #9ca3af;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
    }

    .payment-box {
        background: #f9fafb;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid #f1f5f9;
    }

    .total-price {
        font-size: 42px;
        font-weight: 800;
        color: #dc2626;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: #dbeafe;
        color: #2563eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 35px;
        margin: auto;
    }

</style>

<div class="row justify-content-center">

    <div class="col-lg-8">

        <!-- SEARCH -->
        <div class="card border-0 shadow-lg rounded-4 search-card mb-4">

            <div class="card-body p-5">

                <div class="text-center mb-4">

                    <i class="fas fa-ticket-alt fs-1 mb-3"></i>

                    <h2 class="fw-bold mb-2">
                        Kendaraan Keluar
                    </h2>

                    <p class="mb-0 opacity-75">
                        Masukkan kode tiket kendaraan
                    </p>

                </div>

                <div id="alertBox"></div>

                <form id="formKeluar">

                    <div class="input-group input-group-lg">

                        <input
                            type="text"
                            id="kode_unik"
                            class="form-control ticket-input border-0"
                            placeholder="PKR001"
                            autocomplete="off"
                            required
                        >

                        <button
                            class="btn btn-dark px-5 fw-semibold"
                            type="submit"
                        >
                            Cari
                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- RESULT -->
        <div
            class="card border-0 shadow-lg rounded-4 d-none"
            id="resultCard"
        >

            <div class="card-body p-5">

                <div class="success-icon mb-4">
                    <i class="fas fa-car"></i>
                </div>

                <div class="text-center mb-5">

                    <h3 class="fw-bold">
                        Detail Pembayaran
                    </h3>

                    <p class="text-muted">
                        Pastikan pembayaran dilakukan sebelum kendaraan keluar
                    </p>

                </div>

                <!-- DETAIL -->
                <div class="row g-4 mb-5">

                    <div class="col-md-6">
                        <div class="payment-box">
                            <div class="detail-label">
                                Kode Tiket
                            </div>

                            <div id="kodeText" class="detail-value"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="payment-box">
                            <div class="detail-label">
                                Plat Nomor
                            </div>

                            <div id="platText" class="detail-value"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="payment-box">
                            <div class="detail-label">
                                Jenis Kendaraan
                            </div>

                            <div
                                id="jenisText"
                                class="detail-value text-capitalize"
                            ></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="payment-box">
                            <div class="detail-label">
                                Tarif / Hari
                            </div>

                            <div id="hargaText" class="detail-value"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="payment-box">
                            <div class="detail-label">
                                Durasi Parkir
                            </div>

                            <div id="durasiText" class="detail-value"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="payment-box">
                            <div class="detail-label">
                                Waktu Masuk
                            </div>

                            <div id="masukText" class="detail-value"></div>
                        </div>
                    </div>

                </div>

                <!-- TOTAL -->
                <div class="payment-box text-center">

                    <p class="text-muted mb-2">
                        Total Pembayaran
                    </p>

                    <div
                        id="totalText"
                        class="total-price mb-4"
                    >
                        Rp 0
                    </div>

                    <button
                        id="payButton"
                        class="btn btn-success btn-lg px-5 rounded-3 fw-semibold"
                        onclick="bayarParkir()"
                    >
                        <i class="fas fa-money-bill-wave me-2"></i>
                        Bayar & Kendaraan Keluar
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

let parkingId = null;

// CEK DATA PARKIR
document
.getElementById('formKeluar')
.addEventListener('submit', async function(e) {

    e.preventDefault();

    const token = localStorage.getItem('token');

    const kode_unik =
        document.getElementById('kode_unik').value;

    const alertBox =
        document.getElementById('alertBox');

    try {

        const response = await fetch(
            'http://127.0.0.1:8000/api/parkir/cek-keluar',
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    kode_unik
                })
            }
        );

        const result = await response.json();

        if(response.ok) {

            const data = result.data;

            parkingId = data.id;

            document
                .getElementById('resultCard')
                .classList.remove('d-none');

            document.getElementById('kodeText')
                .innerText = data.kode_unik;

            document.getElementById('platText')
                .innerText = data.plat_nomor;

            document.getElementById('jenisText')
                .innerText = data.jenis_kendaraan;

            document.getElementById('hargaText')
                .innerText =
                    'Rp ' +
                    Number(data.harga_per_hari)
                    .toLocaleString('id-ID');

            document.getElementById('durasiText')
                .innerText =
                    data.durasi_hari + ' Hari';

            document.getElementById('masukText')
                .innerText =
                    new Date(data.waktu_masuk)
                    .toLocaleString('id-ID');

            document.getElementById('totalText')
                .innerText =
                    'Rp ' +
                    Number(data.total_bayar)
                    .toLocaleString('id-ID');

            alertBox.innerHTML = '';

        } else {

            document
                .getElementById('resultCard')
                .classList.add('d-none');

            alertBox.innerHTML = `
                <div class="alert alert-danger rounded-3">
                    ${result.message}
                </div>
            `;
        }

    } catch(error) {

        console.error(error);

        alertBox.innerHTML = `
            <div class="alert alert-danger rounded-3">
                Terjadi kesalahan server
            </div>
        `;
    }

});

// PROSES BAYAR
async function bayarParkir() {

    const token = localStorage.getItem('token');

    const button =
        document.getElementById('payButton');

    button.disabled = true;

    button.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2"></span>
        Memproses...
    `;

    try {

        const response = await fetch(
            'http://127.0.0.1:8000/api/parkir/keluar',
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    id: parkingId
                })
            }
        );

        const result = await response.json();

        if(response.ok) {

            document.getElementById('resultCard').innerHTML = `

                <div class="card-body p-5 text-center">

                    <div
                        style="
                            width:100px;
                            height:100px;
                            background:#dcfce7;
                            color:#16a34a;
                            border-radius:50%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            margin:auto;
                            font-size:45px;
                        "
                        class="mb-4"
                    >
                        <i class="fas fa-check"></i>
                    </div>

                    <h2 class="fw-bold mb-3 text-success">
                        Pembayaran Berhasil
                    </h2>

                    <p class="text-muted mb-4">
                        Kendaraan berhasil keluar dari area parkir
                    </p>

                    <div class="bg-light rounded-4 p-4 mb-4">

                        <div class="text-muted mb-2">
                            Total Pembayaran
                        </div>

                        <div
                            style="
                                font-size:40px;
                                font-weight:800;
                                color:#dc2626;
                            "
                        >
                            Rp ${Number(result.data.total_bayar)
                                .toLocaleString('id-ID')}
                        </div>

                    </div>

                    <button
                        class="btn btn-primary btn-lg rounded-3 px-5"
                        onclick="resetForm()"
                    >
                        <i class="fas fa-check me-2"></i>
                        Selesai
                    </button>

                </div>
            `;

        } else {

            button.disabled = false;

            button.innerHTML = `
                <i class="fas fa-money-bill-wave me-2"></i>
                Bayar & Kendaraan Keluar
            `;

            document.getElementById('alertBox').innerHTML = `
                <div class="alert alert-danger rounded-3">
                    ${result.message}
                </div>
            `;

        }

    } catch(error) {

        console.error(error);

        alert(error.message);

    }

    button.disabled = false;

    button.innerHTML = `
        <i class="fas fa-money-bill-wave me-2"></i>
        Bayar & Kendaraan Keluar
    `;
}

function resetForm() {

    parkingId = null;

    document.getElementById('kode_unik').value = '';

    document.getElementById('resultCard').classList.add('d-none');

    document.getElementById('resultCard').innerHTML = '';

    document.getElementById('alertBox').innerHTML = '';
}

</script>

@endsection
