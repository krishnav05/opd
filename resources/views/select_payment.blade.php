@extends('layouts.master')

@section('content')

<div class="container">
  
  <!-- <div class="row">
    <div class="col text-center">
      <img src="{{asset('assets/img/hero-select-payment.svg')}}" class="img-fluid">
    </div>
  </div> -->

  <div class="row">
    <div class="col otp-card">
      <h1 class="mb-2">Pay & start chatting now </h1>
      <form action="" method="get" id="">
        <div class="form-check mt-2 pl-0">
          <ul class="pay-option">
            <li> 
              <input class="form-check-input" type="radio" name="amount" id="exampleRadios1" value="199" checked>
              <label class="form-check-label" for="exampleRadios1">
                1 Consultation <p> Chat, audio & video consultation now. </p>
              </label>
              <span class="fee"> ₹199 <br> <b>₹500</b></span>
            </li>
            <li> 
              <input class="form-check-input" type="radio" name="amount" id="exampleRadios1" value="360">
              <label class="form-check-label" for="exampleRadios1">
                2 Consultation <p> Chat, audio & video consultation now. </p>
              </label>
              <span class="fee"> ₹360 <br> <b>₹1000</b></span>
            </li>
            <li> 
              <input class="form-check-input" type="radio" name="amount" id="exampleRadios1" value="850">
              <label class="form-check-label" for="exampleRadios1">
                5 Consultation <p> Chat, audio & video consultation now. </p>
              </label>
              <span class="fee"> ₹850 <br> <b>₹2500</b></span>
            </li>
          </ul>
          <input id="paynow" type="button" value="Select payment method" class="btn btn-primary form-control form-control-lg mt-3">
        </div>  
      </form>
    </div>
  </div>

  <!-- <div class="row">
    <div class="col text-center">
      <p> Are you a doctor? <br> <a href="contact-us">Contact Us</a> </p>
    </div>
  </div> -->
  
</div>

@endsection

@section('footer')

<script src="https://checkout.razorpay.com/v1/checkout.js" defer></script>
<script type="text/javascript">
  function demoSuccessHandler(transaction) {
        // You can write success code here. If you want to store some data in database.
        // $("#paymentDetail").removeAttr('style');
        // $('#paymentID').text(transaction.razorpay_payment_id);
        // var paymentDate = new Date();
        // $('#paymentDate').text(
        //         padStart(paymentDate.getDate()) + '.' + padStart(paymentDate.getMonth() + 1) + '.' + paymentDate.getFullYear() + ' ' + padStart(paymentDate.getHours()) + ':' + padStart(paymentDate.getMinutes())
        //         );

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
                                "amount": $("input[name='amount']:checked").val()
                            },
                            complete: function (r) {
                               console.log(r);
                               
                               window.location = 'find-doc';
                            }
                        })               
               // window.location = 'find-doc';
            }
        })
    }


  document.getElementById('paynow').onclick = function () {
      //any one is checked
       var options = {
        key: "{{ env('RAZORPAY_KEY') }}",
        amount: ($("input[name='amount']:checked").val()*100),
        name: 'OPD',
        description: 'Consultation',
        image: '',
        handler: demoSuccessHandler
    }
      window.r = new Razorpay(options);
        r.open();
     
    }
    // $('#paynow').attr('data-price')
</script>

@endsection