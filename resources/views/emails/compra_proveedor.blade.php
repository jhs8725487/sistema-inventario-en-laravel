<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra N° {{ $compra->id }}</title>
</head>
<body>
    <h2>Gracias por su compra, {{ $cliente->nombre }} 🎉</h2>

    <p>Le enviamos el detalle de su pedido:</p>

    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="text-align:center;">Nro</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalles as $detalle)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>{{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total:</strong> {{ number_format($compra->total, 2) }} Bs</p>
    <p><strong>Fecha de compra:</strong> {{ $compra->created_at->format('d/m/Y H:i') }}</p>

    <p>Pronto recibirá un mensaje de confirmación cuando su pedido esté listo para entrega.</p>

    <p>Atentamente,<br><strong>El equipo de atención al cliente</strong></p>
</body>
</html>
