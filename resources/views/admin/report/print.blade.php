<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
            * {
    font-size: 13px;
    font-family: 'calibri';
}

table {
    border-collapse: collapse;
}

td.description,
th.description {
    width: 15mm;
    max-width: 15mm;
}

td.quantity,
th.quantity {
    width: 13mm;
    max-width: 13mm;
    word-break: break-all;
}

td.price,
th.price {
    width: 10mm;
    max-width: 10mm;
    word-break: break-all;
}

.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 40mm;
    max-width: 40mm;
}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}
        </style>
        <title>{{ App\Models\Company::take(1)->first()->name }}</title>
    </head>
    <body>
        <div class="ticket">
            <p class="centered">{{ App\Models\Company::take(1)->first()->name }}
                <br>{{ App\Models\Company::take(1)->first()->address }}
            </p>
            <div style="font-size: 80%">{{ $transactionn->user->name }}</div>
          
            <div style="font-size: 80%">{{$transactionn->transaction_code}} -  {{ $transactionn->method }} </div>
            -------------------------------------
            <table>
        
                <tbody>
                    

                    @foreach ($productTransactions as $product)
                    <tr>
                        @php
                 
                          $price = $product->product->price;
                    
                   
                       $discountItem = $product->disc_rp + (($product->disc_prc/100) * ($price * $product->quantity));
                       @endphp
                        <td class="description" colspan="2" style="width: 35mm; max-width:35mm;"><div style="font-size: 80%;"> {{ \Illuminate\Support\Str::limit($product->product->name, 33, $end='.') }}</div>
                      
                        <div style="font-size: 80%">{{ $product->quantity }} x @ {{ format_uang($price)  }}</div>
                        @if ($product->disc_rp != null || $product->disc_prc != null)
                            <div style="font-size: 70%"> - disc {{format_uang($discountItem)}}</div>
                        @endif <div></div>
                        </td>
                        <td class="price" style="font-size: 80%; text-align: right">{{ format_uang(($price * $product->quantity)- $discountItem) }}</td>
                    </tr>
                        
                    @endforeach
                    @if ($transactionn->disc_total_prc != null || $transactionn->disc_total_rp != null)
                    @php
                    $discPercent = ($transactionn->disc_total_prc / 100) * $transactionn->totalSementara;
                    $discount = $discPercent + $transactionn->disc_total_rp;
                    @endphp
                    <tr style="  border-top: 1px solid black;
                      border-collapse: collapse;">
                        <td class="quantity"></td>
                        <td class="description" style="font-size: 80%">-Disc</td>
                        <td class="price" style="font-size: 70%; text-align: right">{{ format_uang($discount)  }}</td>
                    </tr>
                    @endif
                    <tr style="  border-top: 0.4px solid black;
                    border-collapse: collapse;"> 
                        <td class="quantity"></td>
                        <td class="description" style="font-size: 80%">Total</td>
                        <td class="price" style="font-size: 70%; text-align: right">{{ format_uang($transactionn->purchase_order)  }}</td>
                    </tr>
                    <tr>
                        <td class="quantity"></td>
                        <td class="description" style="font-size: 80%">Cash</td>
                        <td class="price" style="font-size: 70%; text-align: right">{{ format_uang($transactionn->pay)  }}</td>
                    </tr>
                    <tr>
                        <td class="quantity"></td>
                        <td class="description" style="font-size: 80%">Kembali</td>
                        <td class="price" style="font-size: 70%; text-align: right">{{ format_uang($transactionn->return)  }}</td>
                    </tr>
         
                </tbody>
            </table>

            <div style="font-size: 90%; text-align:center">Terima Kasih</div>
            <div style="font-size: 50%; text-align:center">Barang yg sudah dibeli tdk dapat dikembalikan lagi.</div>
            <div style="font-size: 70%; text-align:center">{{ date('d-M-Y H:i:s', strtotime($transactionn->created_at)) }}</div>
        </div>
        
        <script type="text/javascript">
            document.onkeyup = function(e) {
                if (e.which == 8) {
                window.location.href = "{{ route('admin.transaction.index')}}";
                } else if (e.which == 80) {
                window.print();
                }  
            };
        </script>
        
    </body>
</html>