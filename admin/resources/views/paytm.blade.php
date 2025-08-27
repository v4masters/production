
<!DOCTYPE html>
<html>
<head>
    <title>Payment gateway using Paytm</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container" width="500px">
    <div class="panel panel-primary" style="margin-top:110px;">
        <div class="panel-heading"><h3 class="text-center">Payment gateway using Paytm Laravel 7</h3></div>
        <div class="panel-body">
            <form action="{{url('/api') }}/payment" method="POST" enctype="multipart/form-data">
            
                                          @csrf


                @if($message = Session::get('message'))
                        <p>{!! $message !!}</p>
                    <?php Session::forget('success'); ?>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <strong>user_id:</strong>
                        <input type="text" name="user_id" value="WXKAFKCWH1" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="col-md-12">
                        <strong>order_id No:</strong>
                        <input type="text" name="order_id" value="{{ date('YmdHis').rand().'WXKAFKCWH1'}}" class="form-control" placeholder="Mobile No." required>
                    </div>
                    <div class="col-md-12">
                        <strong>total_amount:</strong>
                        <input type="number" class="form-control" value="10" placeholder="total_amount" name="total_amount" required>
                    </div>
                    <div class="col-md-12" >
                        <br/>
                        
                    </div>
                    
            

                    <div class="col-md-12">
                        <br/>
                        <button type="submit" class="btn btn-success">Paytm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>