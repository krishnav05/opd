<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width">
  <meta name="csrf-token" content="{{ csrf_token() }}">
        <style type="text/css">
          html, body {
    height: 100%;
}

div {
    height: 99%;
}

object {
    width: 100%;
    min-height: 100%;
}       

        </style>
  <title></title>
</head>
<body>
<div id="siteloader"></div>


</body>
<script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js" defer></script>
<script type="text/javascript">
          $("#siteloader").html('<object data="https://doksaa.com/select-doctor.html" />');
            function demoSuccessHandler(transaction) {

        $.ajax({
            method: 'post',
            url: "dopayment",
            data: {
                "_token": "{{ csrf_token() }}",
                "razorpay_payment_id": transaction.razorpay_payment_id
            },
            complete: function (r) {
               console.log(r);
                $.ajax({
                            method: 'post',
                            url: "addcredits",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "amount": 199
                            },
                            complete: function (r) {
                               console.log(r);
                               
                               window.location = 'find-doc';
                            }
                        })               
            }
        })
    }

    $('#paynow').on('click',function(){
      var options = {
        key: "{{ env('RAZORPAY_KEY') }}",
        amount: 19900,
        name: 'Doksaa',
        description: 'Consultation',
        image: '',
        handler: demoSuccessHandler
    }
      window.r = new Razorpay(options);
        r.open();
    });
  
</script>
</html>