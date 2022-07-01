<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <title>Print Shipment Details</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        @media print {
            .page-break {
                display: block;
                page-break-before: always;
            }
        }

        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 2mm;
            margin: 0 auto;
            width: 104mm;
            background: #FFF;
            font-size: 12px;
        }

        #invoice-POS ::selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS ::moz-selection {
            background: #f31544;
            color: #FFF;
        }
    </style>
    <script>
        window.console = window.console || function (t) {
        };
    </script>
    <script>
        if (document.location.search.match(/type=embed/gi)) {
            window.parent.postMessage("resize", "*");
        }
    </script>
</head>
<body translate="no">
<div id="invoice-POS">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 border-right p-0">
                <img src="/images/{{basic_information()->company_logo}}" width="100%">
            </div>
            <div class="col-8">
                <h6>MERCHANT: {{$shipment->user->shop_name}}</h6>
                <p class="mb-0">{{$shipment->user->address}}</p>
                <p class="mb-0">{{$shipment->user->phone}}</p>
            </div>
        </div><hr class="my-0">
        <div class="row">
            <div class="col-8 border-right">
                <p class="mb-0">CUSTOMER: {{$shipment->name}}</p>
                <p class="mb-0">{{$shipment->phone}}</p>
                <p class="mb-0">{{$shipment->address}}</p>
            </div>
            <div class="col-4">
                AREA: {{$shipment->AREA->name}}<br>
                HUB: {{$shipment->AREA->hub->name}}
            </div>
        </div><hr class="my-0"><hr class="mb-0" style="margin-top: 2px">
        <div class="row">
            <div class="col-7">
                <p class="mb-0">INVOICE: {{$shipment->invoice_id}}</p>
            </div>
            <div class="col-5">
                CASH: {{$total_price}}
            </div>
        </div><hr class="mb-0" style="margin-top: 2px">
        <div class="row justify-content-center">
            <div class="col-7 py-2 text-center">
                <?php echo DNS1D::getBarcodeHTML($shipment->tracking_code, 'UPCA'); ?>
                {{$shipment->tracking_code}}
            </div>
        </div><hr class="mb-0" style="margin-top: 2px">
    </div>
</body>
</html>
