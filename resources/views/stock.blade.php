
<!DOCTYPE html>
<html>
<head>
    <title>Stock Report</title>
    <style>
        .item-table table{
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }
        .blank-cell{
            min-width: 50px;
        }
        .item{
            padding: 8px;
            text-align: left;
        }
        .item-table table th.item, .item-table table td.item {
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <h2>{{ $office['name'] }}</h2>
    <h4>Physical Inventory Report </h4>
    <p>{{$date}}</p>
    <div class="item-table">
        <table class="table-bordered">
            <tr>
                <th class="item"> Item Code </th>
                <th class="item"> Item Name </th>
                <th class="item"> Price </th>
                <th class="item"> Qty Sold </th>
                <th class="item"> Qty In Hand </th>
            </tr>
            @php
            $sum = 0;
            $price = 0;
            @endphp
            @foreach($products as $product)
             @php
             $sold = $soldQty->where('product_id','=',$product->id)->first();
             if(!empty($sold)){
                $sum += $sold->quantity;
             }else{
                $sum += 0;
             }
             $price +=  $product->sell_price;
            
             @endphp
                <tr>
                    <td class="item">{{$product->item_code}}</td>
                    <td class="item">{{ $product->name }}</td>
                    <td class="item">{{$product->sell_price}}</td>
                    @if(!empty($sold))
                    <td class="item">{{ $sold->quantity}}</td>
                    @else
                    <td class="item">0</td></td>
                    @endif
                    <td class="item">{{ ($product->stockIn - $product->stockOut)}}</td>

                </tr>
            @endforeach
            <tr>
                <th class="item"> Grand Total</th>
                <th class="item"> ----- </th>
                <th class="item"> {{$price}} </th>
                <th class="item"> {{ $sum }} </th>
                <th class="item"> {{ $products->sum('stockIn')-$products->sum('stockOut') }} </th>
            </tr>
        </table>
    </div>
</body>
</html>
