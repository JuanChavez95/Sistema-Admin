<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f3f4f6;
            color: #1f2937;
        }

        header {
            background-color: #1f2937;
            color: #ffffff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 1.4rem;
        }

        .btn-logout {
            background-color: #dc2626;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-logout:hover {
            background-color: #b91c1c;
        }

        .container {
            display: flex;
            padding: 30px;
            gap: 30px;
        }

        .main-content {
            flex: 2;
            background-color: #ffffff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .sidebar {
            flex: 1;
            background-color: #ffffff;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            height: fit-content;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 1.2rem;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 10px;
        }

        .alert-success {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            color: #b91c1c;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            list-style: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.9rem;
        }

        th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #4b5563;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #4b5563;
        }

        input, select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 0.9rem;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #2563eb;
        }

        .btn-primary {
            width: 100%;
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-edit {
            background-color: #f59e0b;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .btn-delete {
            background-color: #dc2626;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>Panel de Administración - Gestión ABM</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Cerrar Sesión</button>
        </form>
    </header>

    <div class="container">
        <div class="main-content">
            <h2>Usuarios Registrados (Disponibles)</h2>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($personas as $p)
                        <tr>
                            <td>{{ $p->usuario }}</td>
                            <td>{{ $p->nombre }} {{ $p->apellido }}</td>
                            <td>{{ $p->correo }}</td>
                            <td>{{ $p->telefono }}</td>
                            <td>{{ $p->rol }}</td>
                            <td class="action-buttons">
                                <button class="btn-edit" onclick="cargarDatos({{ json_encode($p) }})">Editar</button>
                                
                                <form action="{{ route('personas.destroy', $p->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="sidebar">
            <h2 id="form-title">Registrar Nuevo Usuario</h2>
            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
                    <form id="persona-form" action="{{ route('personas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="method-field" name="_method" value="POST">

                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej. Juan Carlos">
                        </div>

                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required placeholder="Ej. Chavez Machaca">
                        </div>

                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="text" id="usuario" name="usuario" value="{{ old('usuario') }}" required placeholder="Ej. Juan123">
                        </div>

                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" name="correo" value="{{ old('correo') }}" required placeholder="ejemplo@gmail.com">
                        </div>

                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" required placeholder="Ej. 73266245">
                        </div>

                        <div class="form-group">
                            <label for="password" id="pass-label">Contraseña</label>
                            <input type="password" id="password" name="password" required placeholder="Ej. Juan1234*">
                        </div>

                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <select id="rol" name="rol" required>
                                <option value="usuario" {{ old('rol') == 'usuario' ? 'selected' : '' }}>Usuario</option>
                                <option value="administrador" {{ old('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select id="estado" name="estado" required>
                                <option value="Disponible" {{ old('estado') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="Bloqueado" {{ old('estado') == 'Bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                            </select>
                        </div>

                        <button type="submit" id="btn-submit" class="btn-primary">Guardar Usuario</button>
                        <button type="button" id="btn-cancel" class="btn-delete" style="margin-top: 10px; display: none; width: 100%;" onclick="cancelarEdicion()">Cancelar Edición</button>
                    </form>
        </div>
    </div>

    <script>
        function cargarDatos(persona) {
            document.getElementById('form-title').innerText = 'Modificar Usuario';
            const form = document.getElementById('persona-form');

            // Cambiar la ruta del action al modificar
            form.action = '/personas/' + persona.id;
            document.getElementById('method-field').value = 'PUT';
            // Llenar los campos
            document.getElementById('nombre').value = persona.nombre;
            document.getElementById('apellido').value = persona.apellido;
            document.getElementById('usuario').value = persona.usuario;
            document.getElementById('correo').value = persona.correo;
            document.getElementById('telefono').value = persona.telefono;
            document.getElementById('rol').value = persona.rol;
            document.getElementById('estado').value = persona.estado;

            document.getElementById('password').required = false;
            document.getElementById('pass-label').innerText = 'Contraseña (Dejar vacío para no cambiar)';

            document.getElementById('btn-cancel').style.display = 'block';
            document.getElementById('btn-submit').innerText = 'Actualizar Usuario';
        }
        function cancelarEdicion() {
            document.getElementById('form-title').innerText = 'Registrar Nuevo Usuario';
            const form = document.getElementById('persona-form');
            
            form.action = "{{ route('personas.store') }}";
            document.getElementById('method-field').value = 'POST';

            form.reset();

            document.getElementById('password').required = true;
            document.getElementById('pass-label').innerText = 'Contraseña';
            document.getElementById('btn-cancel').style.display = 'none';
            document.getElementById('btn-submit').innerText = 'Guardar Usuario';
        }
    </script>
</body>
</html>