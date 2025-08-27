<!DOCTYPE html>
<html>
   <head>
      <title>How to Upload Image in AWS S3 in Laravel 10 - Techsolutionstuff</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   </head>
   <body>
      <div class="container">
         <div class="panel panel-primary">
            <div class="panel-heading">
               <h2>Laravel 10 Image upload in AWS S3 bucket - Techsolutionstuff</h2>
            </div>
            <div class="panel-body">
               @if ($message = Session::get('success'))
                   <div class="alert alert-success alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>{{ $message }}</strong>
                   </div>
               @endif
 
               @if (count($errors) > 0)
               <div class="alert alert-danger">
                  <strong>Whoops!</strong> There were some problems with your input.
                  <ul>
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif
 
               <form action="{{url('/') }}/add_image" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="col-md-6">
                        <input type="file" name="image" class="form-control"/>
                     </div>
                     <div class="col-md-6">
                        <button type="submit" class="btn btn-success">Upload File...</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>