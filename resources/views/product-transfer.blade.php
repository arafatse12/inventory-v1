
<!DOCTYPE html>
<html>
<head>
    <title>Product Transfer Report</title>
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
    <h4>Product Transfer Report</h4>
    <p>{{ $date }}</p>
    <div class="item-table">
        <table class="table-bordered">
            <tr>
                <th class="item"> Code </th>
                <th class="item"> Name </th>
                <th class="item"> Price </th>
                <th class="item"> From </th>
                <th class="item"> To </th>
                <th class="item"> Transfer Qty </th>
            </tr>
                @foreach ($products as $product)
                @php
                $data = App\Models\Product::where('id','=',$product->product_id)->first();
                $officeFrom = App\Models\Office::where('id','=',$product->office_id_from)->first();
                $officeTo = App\Models\Office::where('id','=',$product->office_id_to)->first();
                @endphp
                <tr>
                    <td class="item">{{ $data->item_code }}</td>
                    <td class="item">{{ $data->name }}</td>
                    <td class="item">{{ $data->sell_price }}</td>
                    <td class="item">{{ $officeFrom->name }}</td>
                    <td class="item">{{ $officeTo->name }}</td>
                    <td class="item">{{ $product->totalQty }}</td>
                </tr>          
                @endforeach
            <tr>
                <th class="item"> Grand Total</th>
                <th class="item"> --- </th>
                <th class="item"> --- </th>
                <th class="item"> --- </th>
                <th class="item"> --- </th>
                <th class="item"> {{$products->sum('totalQty')}} </th>
            </tr>
        </table>
    </div>
</body>
</html>
