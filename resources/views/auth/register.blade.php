<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #3DB5FF;
            --card-radius: 24px;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: linear-gradient(to bottom, #3DB5FF 0%, #ffffff 80%);
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border-radius: var(--card-radius);
            padding: 32px;
        }

        .title {
            text-align: center;
            margin-bottom: 24px;
        }

        .title h1 {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
        }

        .title p {
            font-size: 13px;
            color: #6b7280;
            margin-top: 6px;
        }

        label {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            outline: none;
            font-size: 14px;
            margin-bottom: 14px;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(61, 181, 255, 0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .footer {
            text-align: center;
            margin-top: 16px;
            font-size: 12px;
            color: #6b7280;
        }

        .footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .error {
            background: #ffe5e5;
            color: #d60000;
            padding: 10px;
            border-radius: 10px;
            font-size: 12px;
            margin-bottom: 14px;
        }
    </style>
</head>

<body>

<div class="card">

    <div class="title">
        <h1>Create Account</h1>
        <p>Register to start using the system</p>
    </div>

    {{-- ERROR VALIDATION --}}
    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Create Account</button>

    </form>

    <div class="footer">
        Already have an account?
        <a href="{{ route('login') }}">Login</a>
    </div>

</div>

</body>
</html>