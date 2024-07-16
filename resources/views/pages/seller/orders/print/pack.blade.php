@extends('layouts.default')

@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<main role="main" class="container">
    <div class="row">
        <div class="col-8">
            <h1>Lucky Star Convenient Store</h1>
            <svg class="barcode" id="receipt-barcode" 
            jsbarcode-value="{{$order_number}}"
            jsbarcode-textmargin="0"
            jsbarcode-width="5"
            jsbarcode-height="150"
            >
            ></svg>
            <h5 class="text-left" style="padding-top:10px;">Order Notice!</h5>
            <p class="text-left">
                Upon successful packaging, please cut the receipt and scan the barcode above to 
                <br>update the order status. This document also serves as a proof.<br>
                Note: You can also manually update the status of order if you have access in the system.
            </p>
        </div>
        <div class="col-4 border border-dark">
            {{-- <img src="http://www.api2pdf.com/wp-content/uploads/2018/07/download-1.png" /> --}}
            <svg class="barcode" id="receipt-barcode" 
            jsbarcode-value="{{$order_number}}"
            jsbarcode-textmargin="0"
            jsbarcode-fontoptions="bold">
            ></svg>
            <h4>Order Information</h4>
            <p>Purchase Date: {{$orders[0]->created_at->format('M-d-Y - h:i A')}}</p>
            <p>Mode of Payment: {{strtoupper($orders[0]->mode_of_payment)}}</p>
            <p>Amount to Pay: Php {{number_format($total_amount, 2)}}</p>

            <h4>Shipping To</h4>
            <p>{{$orders[0]->getCustomerRelation->last_name}}, {{$orders[0]->getCustomerRelation->first_name}} - {{$orders[0]->getUserRelation->mobile}} </p>
            <p>Address: {{$orders[0]->deliveryAddress->getFormattedAddress()}} </p>
        </div>
    </div>
    <hr/>
    <table class="table table-md">
        <thead>
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $key=>$order)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        <img src="{{asset('storage/uploads/images/'.$order->getProductRelation->image_folder.'/'.$order->getProductRelation->variation.'.jpg')}}" alt="Image" class="img-thumbnail" width="75px" height="75px">
                    </td>
                    <td>{{$order->getProductRelation->product_name}} {{$order->getProductRelation->variation}}</td>
                    <td>{{$order->quantity}}</td>
                </tr>
            @endforeach
    </table>
</main>

@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{asset('assets/seller/js/JsBarcode.all.min.js')}}"></script>

<script>
    $(document).ready(function(){
        JsBarcode(".barcode").init();
        window.print();
    })
</script>
@endsection
