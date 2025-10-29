<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة الطلب رقم #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            margin: 30px;
            color: #000;
        }
        .invoice {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
        }
        h2, h4 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .summary {
            margin-top: 20px;
            text-align: left;
        }
        .text-end {
            text-align: left;
        }
        .no-print {
            display: block;
            margin-bottom: 15px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice">
        <button class="no-print" onclick="window.print()" style="float:left; margin-bottom:10px;">
            🖨️ طباعة
        </button>

        <h2>فاتورة الطلب</h2>
        <h4>رقم الطلب: #{{ $order->id }}</h4>

        <hr>

        <h4>بيانات العميل</h4>
        <table>
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الهاتف</th>
                <th>المدينة</th>
            </tr>
            <tr>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->user->email ?? 'غير متوفر' }}</td>
                <td>{{ $order->user->phone ?? 'غير متوفر' }}</td>
                <td>{{ $order->city->name ?? 'غير محددة' }}</td>
            </tr>
        </table>

        <h4>تفاصيل المنتجات</h4>
        <table>
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->pivot->price, 2) }}</td>
                    <td>{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <p><strong>إجمالي المنتجات:</strong>
                {{ number_format($order->products->sum(fn($p) => $p->pivot->quantity * $p->pivot->price), 2) }} جنيه
            </p>
            <p><strong>سعر الشحن:</strong> {{ number_format($order->shipping_price, 2) }} جنيه</p>
            <h3><strong>الإجمالي الكلي:</strong> {{ number_format($order->total, 2) }} جنيه</h3>
        </div>

        <hr>
        <p style="text-align:center; font-size:13px; margin-top:10px;">
            شكراً لتعاملكم معنا ❤️
        </p>
    </div>
</body>
</html>
