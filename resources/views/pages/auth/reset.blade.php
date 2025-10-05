<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña - WorkScrum</title>
    <style>
        /* ========== ESTILOS BASE ========== */
        body {
            margin: 0;
            padding: 0;
            background: #f5f6fa;
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
        }


        a { text-decoration: none; }

        .wrapper {
            width: 100%;
            padding: 30px 0;
            background: #f5f6fa;
        }

        .mail-container {
            background: #ffffff;
            width: 520px;
            margin: 0 auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .header {
            text-align: center;
            padding: 30px 20px 10px;
        }

        .header img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
        }

        .header h2 {
            margin: 10px 0 0;
            color: #3b82f6;
            font-weight: 700;
        }

        .content {
            padding: 20px 40px;
            color: #333;
        }

        .content p {
            margin-bottom: 16px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background-color: #3b82f6;
            color: #fff !important;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #9ca3af;
        }

        /* ========== MODO OSCURO ========== */
        @media (prefers-color-scheme: dark) {
            body, .wrapper {
                background: #0f172a !important;
                color: #e2e8f0 !important;
            }

            .mail-container {
                background: #1e293b !important;
                box-shadow: 0 4px 10px rgba(0,0,0,0.5);
            }

            .content {
                color: #e2e8f0 !important;
            }

            .btn {
                background-color: #2563eb !important;
                color: #ffffff !important;
            }

            .footer {
                color: #94a3b8 !important;
            }

            .header h2 {
                color: #60a5fa !important;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="mail-container">
            <!-- Encabezado -->
            <div class="header">
            <img src="{{ $message->embed(public_path('assets/images/logos/workscrum.png')) }}" alt="WorkScrum Logo" width="60" height="60">
                <h2>WorkScrum</h2>
            </div>

            <!-- Contenido -->
            <div class="content">
                <p>Hola {{ $user->nombre ?? 'usuario' }},</p>

                <p>Hemos recibido una solicitud para restablecer tu contraseña. Haz clic en el siguiente botón para continuar:</p>

                <p style="text-align:center; margin: 25px 0;">
                    <a href="{{ $url }}" class="btn">Restablecer contraseña</a>
                </p>

                <p style="font-size: 14px; color: #6b7280;">
                    Este enlace expirará en 60 minutos. Si no solicitaste un cambio, puedes ignorar este correo.
                </p>

                <p style="font-size: 14px; color: #6b7280; margin-top: 24px;">
                    Saludos,<br>
                    <strong>El equipo de WorkScrum</strong>
                </p>
            </div>

            <!-- Pie -->
            <div class="footer">
                © {{ date('Y') }} WorkScrum. Todos los derechos reservados.
            </div>
        </div>
    </div>
</body>
</html>
