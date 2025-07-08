<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fatura #{{ $fatura->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        .logo {
            max-width: 150px;
            max-height: 80px;
            margin-right: 15px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin: 0;
        }
        .company-info {
            font-size: 14px;
            color: #444;
            margin-bottom: 10px;
        }
        .invoice-title {
            font-size: 32px;
            color: #495057;
            margin: 10px 0;
        }
        .invoice-number {
            font-size: 18px;
            color: #6c757d;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .info-box {
            flex: 1;
            margin: 0 10px;
        }
        .info-box h3 {
            color: #007bff;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .info-box p {
            margin: 5px 0;
            color: #495057;
        }
        .amount-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 30px 0;
        }
        .amount-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .amount-value {
            font-size: 36px;
            font-weight: bold;
            color: #28a745;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #d4edda; color: #155724; }
        .status-overdue { background: #f8d7da; color: #721c24; }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            text-align: center;
            color: #6c757d;
            font-size: 12px;
        }
        .date {
            color: #6c757d;
            font-size: 14px;
        }
        .client-photo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e9ecef;
            margin-bottom: 10px;
        }
        .client-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .client-details {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-container">
                <div>
                    <h1 class="company-name">GROW AND BUILD</h1>
                    <div class="company-info">
                        <strong>CNPJ:</strong> 53.656.017/0001-68<br>
                        <strong>Dono:</strong> Alexandre Rodrigues Tavares
                    </div>
                </div>
            </div>
            <h1 class="invoice-title">FATURA</h1>
            <div class="invoice-number">#{{ $fatura->id }}</div>
            <div class="date">{{ now()->format('d/m/Y') }}</div>
        </div>

        <div class="info-section">
            <div class="info-box">
                <h3>CLIENTE</h3>
                <div class="client-info">
                    @if($fatura->client && $fatura->client->photo)
                        <img src="{{ Storage::url($fatura->client->photo) }}" alt="Foto do cliente" class="client-photo">
                    @else
                        <div class="client-photo" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #6c757d;">👤</div>
                    @endif
                    <div class="client-details">
                        <p><strong>{{ $fatura->client->name ?? 'Cliente não informado' }}</strong></p>
                        <p>{{ $fatura->client->email ?? 'Email não informado' }}</p>
                        @if($fatura->client && $fatura->client->phone)
                            <p>{{ $fatura->client->phone }}</p>
                        @endif
                        @if($fatura->client && $fatura->client->company)
                            <p>{{ $fatura->client->company }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="info-box">
                <h3>DETALHES</h3>
                <p><strong>Data:</strong> {{ $fatura->created_at->format('d/m/Y') }}</p>
                <p><strong>Status:</strong> 
                    <span class="status-badge status-{{ strtolower($fatura->status ?? 'pending') }}">
                        {{ $fatura->status ?? 'Pendente' }}
                    </span>
                </p>
            </div>
        </div>

        <div class="amount-section">
            <div class="amount-label">VALOR TOTAL</div>
            <div class="amount-value">R$ {{ number_format($fatura->total ?? 0, 2, ',', '.') }}</div>
        </div>

        {{-- Detalhamento dos Serviços/Itens da Fatura --}}
        <h3 style="margin-top: 30px; color: #007bff;">Serviços/Itens</h3>
        <table width="100%" border="1" cellspacing="0" cellpadding="8" style="border-collapse: collapse; margin-bottom: 30px;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th>Descrição</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fatura->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td style="text-align: right;">R$ {{ number_format($item->total, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #888;">Nenhum serviço/item lançado nesta fatura.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <p>Obrigado por escolher nossos serviços!</p>
            <p>Para dúvidas, entre em contato conosco.</p>
        </div>
    </div>
</body>
</html> 