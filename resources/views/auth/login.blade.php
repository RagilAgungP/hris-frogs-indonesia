<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        :root {
            --primary: #3DB5FF;
            --card-width: 600px;
            --card-min-height: 260px;
            --radius: 16px;
            --input-padding: 10px;
            --text-xs: 12px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: linear-gradient(to bottom, var(--primary), white);
        }

        .card {
            width: 100%;
            max-width: var(--card-width);
            min-height: var(--card-min-height);
            display: flex;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: white;
        }

        .left {
            flex: 1;
            background: linear-gradient(to right, var(--primary)-50%, white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .left img {
            width: 240px;
            height: 120px;
            object-fit: contain;
        }

        .right {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 4px;
        }

        .subtitle {
            font-size: var(--text-xs);
            color: #666;
            margin-bottom: 10px;
        }

        .error {
            background: #ffe5e5;
            color: #d60000;
            padding: 10px;
            font-size: var(--text-xs);
            border-radius: 8px;
            margin-bottom: 14px;
        }

        .success {
            background: #e7ffe7;
            color: #0a7a0a;
            padding: 10px;
            font-size: var(--text-xs);
            border-radius: 8px;
            margin-bottom: 14px;
        }

        label {
            font-size: var(--text-xs);
            margin-bottom: 5px;
            display: block;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: var(--input-padding);
            margin-bottom: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: var(--primary);
        }

        .forgot {
            text-align: right;
            font-size: var(--text-xs);
            margin-bottom: 14px;
        }

        .forgot a {
            color: var(--primary);
            text-decoration: underline;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background: var(--primary);
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .register {
            text-align: center;
            font-size: var(--text-xs);
            margin-top: 14px;
            color: #666;
        }

        .register a {
            color: var(--primary);
            text-decoration: none;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .card {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="card">

    <!-- LEFT -->
    <div class="left">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>

    <!-- RIGHT -->
    <div class="right">

        <h1>Login</h1>
        <div class="subtitle">Welcome back, please login.</div>

        {{-- ERROR --}}
        @if(session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>Email</label>
            <input type="email" name="email" placeholder="Enter email" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>

            <div class="forgot">
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit">Login</button>

        </form>

        <div class="register">
            Don't have an account?
            <a href="{{ route('register') }}">Create Account</a>
        </div>

    </div>

</div>

</body>
</html>