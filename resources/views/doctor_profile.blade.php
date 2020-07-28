<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width">
  <title>Doksaa</title>
</head>
<body>
<iframe id="frameID" src="https://doksaa.com/select-doctor.html" onload="onMyFrameLoad(this)"></iframe>
</body>
<script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
        <script src="https://checkout.razorpay.com/v1/checkout.js" defer></script>
<script type="text/javascript">
  document.domain = 'doksaa.com';
  function onMyFrameLoad() {
 var iFrameDOM = $("iframe#frameID").contents();

  iFrameDOM.find('.paynow').on('click',function(){
    var options = {
        key: "{{ env('RAZORPAY_KEY') }}",
        amount: 100,
        name: 'Doksaa',
        description: 'Consultation',
        image: '',
        handler: demoSuccessHandler
    }
      window.r = new Razorpay(options);
        r.open();
  });
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
};
</script>
</html>