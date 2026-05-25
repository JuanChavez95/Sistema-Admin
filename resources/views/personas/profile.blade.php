<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .profile-container {
            background-color: #ffffff;
            width: 100%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-header {
            background-color: #1f2937;
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }

        .profile-header h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .profile-header .role-badge {
            background-color: #10b981;
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .profile-body {
            padding: 30px 20px;
        }

        .info-group {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 0;
        }

        .info-group:last-of-type {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #4b5563;
            font-size: 0.95rem;
        }

        .info-value {
            color: #1f2937;
            font-size: 0.95rem;
        }

        .profile-footer {
            padding: 0 20px 30px 20px;
            text-align: center;
        }

        .btn-logout {
            width: 100%;
            padding: 12px;
            background-color: #dc2626;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-logout:hover {
            background-color: #b91c1c;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>{{ $persona->nombre }} {{ $persona->apellido }}</h2>
            <span class="role-badge">{{ $persona->rol }}</span>
        </div>

        <div class="profile-body">
            <div class="info-group">
                <span class="info-label">Usuario:</span>
                <span class="info-value">{{ $persona->usuario }}</span>
            </div>
            
            <div class="info-group">
                <span class="info-label">Correo Electrónico:</span>
                <span class="info-value">{{ $persona->correo }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Teléfono:</span>
                <span class="info-value">{{ $persona->telefono }}</span>
            </div>

            <div class="info-group">
                <span class="info-label">Estado de Cuenta:</span>
                <span class="info-value" style="color: #10b981; font-weight: 600;">{{ $persona->estado }}</span>
            </div>
        </div>

        <div class="profile-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
