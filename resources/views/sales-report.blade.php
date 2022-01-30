
<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
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
    <h4>Sales Report </h4>
    <p>{{ $date }}</p>
    <div class="item-table">
        <table class="table-bordered">
            <tr>
                <th class="item"> Code </th>
                <th class="item"> Name </th>
                {{-- <th class="item"> Qty On Hand </th> --}}
                <th class="item"> Qty Sold </th>
                <th class="item"> Sales Price </th>
                <th class="item"> Total Price </th>
                {{-- <th class="item"> Profit </th> --}}
            </tr>
                @foreach ($products as $data)
                <tr>
                    <td class="item">{{ $data->product->name }}</td>
                    <td class="item">{{ $data->product->item_code }}</td>
                    {{-- <td class="item">{{ $stockInTotal }}</td>
                    <td class="item">{{ $stockIn }}</td> --}}
                    <td class="item">{{ $data->quantity }}</td>
                    <td class="item">{{ $data->product->sell_price }}</td>
                    <td class="item">{{ $data->total }}</td>
                </tr>
                @endforeach
            <tr>
                <th class="item"> Grand Total</th>
                <th class="item"> --- </th>
                <th class="item"> {{ $products->sum('quantity') }} </th>
                <th class="item"> --- </th>
                <th class="item"> {{ $products->sum('total') }} </th>
                {{-- <th class="item"> {{$products->sum('totalQty')}} </th> --}}
            </tr>
        </table>
    </div>
</body>
</html>
