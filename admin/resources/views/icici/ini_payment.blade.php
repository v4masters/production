<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Order Form</h2>
   
          <form  class="mb-3"  action="{{url('/') }}/pay"  method="POST"> 
            @csrf
            
        <!-- Amount Field -->
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" class="form-control" name="amount" value="100" placeholder="Enter amount" required>
        </div>

        <!-- Order ID Field -->
        <div class="mb-3">
            <label for="order_id" class="form-label">Order ID</label>
            <input type="text" class="form-control" value="{{date('YmdHis').time()}}" name="order_id" placeholder="Enter Order ID" required>
        </div>

        <!-- Phone Number Field -->
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" name="phone_number" value="6239961199" placeholder="Enter phone number" >
        </div>

        <!-- Email Field -->
        <div class="mb-3">
            <label for="email" class="form-label">user name</label>
            <input type="text" class="form-control" name="username" value="Demon" >
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
