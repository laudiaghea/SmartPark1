<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - SmartPark</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f1f5f9;
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        .layout {
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, #0f172a, #111827);
            color: white;
            padding: 25px 18px;
            overflow-y: auto;
            z-index: 1000;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 40px;
            padding: 10px;
        }

        .brand-icon {
            width: 55px;
            height: 55px;
            border-radius: 18px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .brand h4 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .brand p {
            margin: 0;
            color: #94a3b8;
            font-size: 13px;
        }

        .menu-title {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin: 25px 10px 10px;
        }

        .menu {
            list-style: none;
            padding: 0;
        }

        .menu li {
            margin-bottom: 10px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            border-radius: 16px;
            text-decoration: none;
            color: #cbd5e1;
            transition: 0.25s;
            font-weight: 500;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.08);
            color: white;
            transform: translateX(4px);
        }

        .menu-item.active {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35);
        }

        .menu-item i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        /* MAIN */
        .main {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            height: 80px;
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .user-info h6 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .user-info p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
        }

        .logout-btn {
            border-radius: 14px;
            padding: 10px 18px;
            font-weight: 600;
        }

        /* CONTENT */
        .content {
            padding: 30px;
        }

        .page-title {
            font-size: 30px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 5px;
        }

        .page-subtitle {
            color: #64748b;
            margin-bottom: 30px;
        }

        /* CARD GLOBAL */
        .card {
            border: none !important;
            border-radius: 24px !important;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        }

        .btn {
            border-radius: 14px !important;
            font-weight: 600 !important;
        }

        .table thead {
            background: #f8fafc;
        }

        .table th {
            color: #475569;
            font-weight: 700;
            border-bottom: none;
        }

        .table td {
            vertical-align: middle;
        }

        @media(max-width: 992px) {

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main {
                width: 100%;
                margin-left: 0;
            }

            .layout {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <script>
        const token = localStorage.getItem('token');

        if (!token) {
            window.location.href = '/login';
        }
    </script>

    <div class="layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="brand">

                <div class="brand-icon">
                    <i class="fas fa-car"></i>
                </div>

                <div>
                    <h4>SmartPark</h4>
                    <p>Smart Parking System</p>
                </div>

            </div>

            <div class="menu-title">
                Main Menu
            </div>

            <ul class="menu">

                <li>
                    <a href="/dashboard" class="menu-item">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="/parkir" class="menu-item">
                        <i class="fas fa-car-side"></i>
                        Kendaraan Masuk
                    </a>
                </li>

                <li>
                    <a href="/parkir/keluar" class="menu-item">
                        <i class="fas fa-ticket-alt"></i>
                        Kendaraan Keluar
                    </a>
                </li>

                <li>
                    <a href="/tarif" class="menu-item">
                        <i class="fas fa-money-bill-wave"></i>
                        Tarif Parkir
                    </a>
                </li>

            </ul>

        </aside>

        <!-- MAIN -->
        <main class="main">

            <!-- TOPBAR -->
            <div class="topbar">

                <div>
                    <div style="font-size:20px; color:#64748b;">
                        Selamat datang kembali
                    </div>

                </div>

                <div class="d-flex align-items-center gap-3">

                    <div class="user-box">

                        <div class="avatar">
                            <i class="fas fa-user"></i>
                        </div>

                        <div class="user-info">
                            <h6 id="userName">Petugas</h6>
                            <p id="currentDate"></p>
                        </div>

                    </div>

                    <button
                        class="btn btn-danger logout-btn"
                        onclick="logout()"
                    >
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Logout
                    </button>

                </div>

            </div>

            <!-- CONTENT -->
            <div class="content">

                <div class="page-title">
                    @yield('title')
                </div>

                @yield('content')

            </div>

        </main>

    </div>

    <script>

        const currentPath = window.location.pathname;

        document.querySelectorAll('.menu-item').forEach(link => {

            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });

        function loadUser() {

            const user = JSON.parse(localStorage.getItem('user'));

            if (user) {
                document.getElementById('userName').innerText = user.name;
            }
        }

        function showDate() {

            const date = new Date().toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            document.getElementById('currentDate').innerText = date;
        }

        async function logout() {

            const token = localStorage.getItem('token');

            try {

                await fetch('http://127.0.0.1:8000/api/logout', {
                    method: 'POST',

                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

                localStorage.removeItem('token');
                localStorage.removeItem('user');

                window.location.href = '/login';

            } catch(error) {

                console.error(error);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadUser();
            showDate();
        });

    </script>

</body>

</html>
