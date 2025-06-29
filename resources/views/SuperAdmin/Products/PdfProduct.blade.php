<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fiche Produit - {{ $product->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .product-info { margin: 30px 0; }
        .footer { margin-top: 50px; font-size: 12px; text-align: center; color: #666; }
        h1 { color: #2c3e50; }
        h2 { color: #3490dc; }
        .product-detail { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Fiche Technique du Produit</h1>
        <p>Généré le: {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <div class="product-info">
        <h2>{{ $product->name }}</h2>
        
        <div class="product-detail">
            <strong>Référence:</strong> PROD-{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}
        </div>
        
        <div class="product-detail">
            <strong>Prix:</strong> {{ number_format($product->price, 2, ',', ' ') }} CFA
        </div>
        
        <div class="product-detail">
            <strong>Description:</strong><br>
            {!! nl2br(e($product->description)) !!}
        </div>
    </div>

    <div class="footer">
        © {{ date('Y') }} {{ config('app.name') }} - Tous droits réservés
    </div>
</body>
</html>
