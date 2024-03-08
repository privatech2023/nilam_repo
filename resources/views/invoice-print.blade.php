<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Privatech | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/common/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/common/dist/css/adminlte.min.css')}}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12" >
        <h2 class="page-header">
          <img src="{{ asset('assets/frontend/images/web-logo.png')}}" style="width: 100px; height: 100px;"> PRIVATECH GARDEN LLP
          <small class="float-right" style="margin-top: 2rem;">Date: {{ $invoice->invoice_date}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info" style="margin-top: 2rem;">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>Privatech Garden Llp</strong><br>
          Hatkhowapara, Azara<br>
          Guwahati-781017<br>
          Phone: 03613154041<br>
          Email: privatech0000@gmail.com
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong>{{$client->name}}</strong><br>
          Phone: {{$client->mobile_number}}<br>
          Email: {{ $client->email}}
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice {{ $invoice->invoice_number }}</b><br>
        <br>
        <b>Order ID:</b> {{ $txn->txn_id}}<br>
        <b>Payment Date:</b> {{$invoice->billing_date }}<br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Qty</th>
            <th>Product</th>
            <th>Validity</th>
            <th>Subtotal</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>1</td>
            <td>{{ $product }}</td>
            <td>{{ $txn->plan_validity_days }} days</td>
            <td>{{ $invoice->total_amount }}</td>
          </tr>


          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
      <!-- accepted payments column -->
      {{-- <div class="col-6">
        <p class="lead">Payment Methods:</p>
        <img src="../../dist/img/credit/visa.png" alt="Visa">
        <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
        <img src="../../dist/img/credit/american-express.png" alt="American Express">
        <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
          Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
          jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
        </p>
      </div> --}}
      <!-- /.col -->
      <div class="col-6">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>{{$invoice->total_amount}}</td>
            </tr>
            <tr>
            <th>Tax ({{ $txn->tax_amt == 0 ? 0 : $gst_rate }}%)</th>
              <td>{{ $txn->tax_amt == null ? 0 : $txn->tax_amt }}</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td>{{$invoice->total_amount}}</td>
            </tr>            
            <tr>
                <th>Paid amount:</th>
                <td>{{$invoice->total_amount}}</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script>
</body>
</html>
