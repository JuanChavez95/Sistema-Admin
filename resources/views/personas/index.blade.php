<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Juan Carlos Chavez Machaca">
    <meta name="description" content="Sistema de login y manejo de roles Usuario y Admin">
    <title>Inicio de Sesión</title>
    <style>
        * {
            box-sizing: border-box; margin: 0; padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f3f4f6;
            display: flex; justify-content: center; align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .student-name {
            text-align: center;
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        h2 {
            text-align: center;
            color: #1f2937; margin-bottom: 24px; font-size: 1.8rem;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #4b5563;
            font-weight: 500;
            font-size: 0.9rem;
        }
        input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
            color: #1f2937;
            outline: none;
        }
        input:focus {
            border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 211, 0.2);
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-submit:hover {
            background-color: #1d4ed8;
        }
        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            color: #b91c1c;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.875rem;
        }
        .alert-error ul {
            list-style: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="student-name">Estudiante: Juan Carlos Chavez Machaca</div> 
        <h2>Iniciar Sesión</h2>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="{{ old('usuario') }}">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit" class="btn-submit">Ingresar</button>
        </form>
    </div>

    <dialog id="credenciales-dialog" open style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #1e1e24; color: #fff; border: 2px solid #2563eb; padding: 20px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.6); z-index: 9999; font-family: sans-serif; text-align: center; margin: 0;">
        <p style="margin: 0 0 15px 0; font-size: 15px; font-weight: bold;">
            omarqm (admin) y omarqm2 (user), misma contraseña Omar411*
        </p>
        <button onclick="document.getElementById('credenciales-dialog').close()" style="background: #2563eb; color: white; border: none; padding: 6px 15px; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 13px;">
            Entendido
        </button>
    </dialog>
</body>
</html>