<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- Font & Icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #5f7cff, #7b4dff);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 380px;
            background: white;
            border-radius: 14px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            overflow: hidden;
        }

        .header {
            text-align: center;
            padding: 30px 20px 20px;
        }

        .icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #5f7cff, #7b4dff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 42px;
        }

        .header h2 {
            margin: 0;
            font-weight: 700;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 17px;
            color: #6c757d;
        }

        .divider {
            height: 2px;
            background: #5f7cff;
        }

        .content {
            padding: 25px;
        }

        label {
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #888;
        }

        input {
            width: 100%;
            padding: 10px 10px 10px 35px;
            border-radius: 6px;
            border: 1px solid #ddd;
            outline: none;
        }

        input:focus {
            border-color: #5f7cff;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #5f7cff, #7b4dff);
            border: none;
            color: white;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            opacity: 0.9;
        }

        .link {
            text-align: center;
            font-size: 14px;
            margin-top: 15px;
        }

            .error {
            color: red;
            font-size: 13px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="card">

    <div class="header">
        <div class="icon">
            <i class="fa-duotone fa-solid fa-car-rear"></i>
        </div>
        <h2>SmartPark</h2>
        <p>Silahkan login untuk melanjutkan</p>
    </div>

    <div class="divider"></div>

    <div class="content">

        <form id="loginForm">
            <label>Email</label>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" placeholder="email@example.com" required>
            </div>

            <label>Password</label>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" placeholder="Password" required>
            </div>

            <button type="submit">
                <i class="fas fa-sign-in-alt"></i> LOGIN
            </button>
        </form>

        <div class="error" id="error"></div>

    </div>
</div>

<script>
    const form = document.getElementById('loginForm');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('http://127.0.0.1:8000/api/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    body: JSON.stringify({ email, password })
});

const text = await response.text();
console.log(text);

const data = JSON.parse(text);

            if (response.ok) {
                localStorage.setItem('token', data.token);
                localStorage.setItem('user', JSON.stringify(data.user));
                window.location.href = '/dashboard';
            } else {
                document.getElementById('error').innerText = data.message;
            }

        } catch (error) {
            document.getElementById('error').innerText = 'Terjadi kesalahan';
        }
    });


</script>

</body>
</html>
