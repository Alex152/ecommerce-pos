<!-- #ANTERIOR
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Sales Report</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Sales</th>
                <th>Revenue (USD)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row['date'] }}</td>
                <td>{{ $row['sales'] }}</td>
                <td>${{ number_format($row['revenue'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
-->

<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { display: flex; justify-content: space-between; }
        .meta { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Ventas</h1>
        <div>Fecha de generación: {{ now()->format('Y-m-d H:i') }}</div>
    </div>
    
    <div class="meta">
        <p><strong>Periodo:</strong> {{ $params['start_date'] }} al {{ $params['end_date'] }}</p>
        <p><strong>Tipo de Reporte:</strong> {{ ucfirst($params['report_type']) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Ventas totales</th>
                <th>Ganancias (USD)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['sales'] }}</td>
                    <td>${{ number_format($row['revenue'], 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No se encontraron datos de ventas para este período</td>
                </tr>
            @endforelse
            
            @if(!empty($data))
                <tr style="font-weight: bold;">
                    <td>Total</td>
                    <td>{{ array_sum(array_column($data, 'sales')) }}</td>
                    <td>${{ number_format(array_sum(array_column($data, 'revenue')), 2) }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>