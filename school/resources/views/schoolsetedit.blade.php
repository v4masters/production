<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no minimum-scale=1.0, maximum-scale=1.0" />
    <title>Edit Set</title>
    <meta name="description" content="" />

    <!-- headerscript -->
    @include('includes.header_script')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('includes.sidebar')
            <!-- / Menu -->


            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('includes.header')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home / Manage Set / </span> Edit Set</h4>

                        <!-- Basic Layout -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Manage Set</h5>
                                        <small class="text-muted float-end"></small>
                                    </div>
                                    <div class="card-body">
                                        <form id="submitform" class="p-5 mb-3" action="{{url('/') }}/edit_school_set" method="POST" enctype="multipart/form-data">

                                            @csrf

                                            @if ($errors->any())

                                            <div class="alert alert-danger">

                                                <ul>

                                                    @foreach ($errors->all() as $error)

                                                    <li>{{ $error }}</li>

                                                    @endforeach

                                                </ul>

                                            </div>

                                            @endif

                                            @if(session('success'))

                                            <div class="alert alert-primary">

                                                {{ session('success') }}

                                            </div>

                                            @endif

                                            <div class="card mt-2 mb-4">
                                                <div class="card-body">
                                                   
                                                    <div class="row">


	
                                        	<input type="hidden" name="id" value={{$set_id}}>

                                              
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Set Category</label>

                                                        <select class="form-select" name="set_cat" id="form-select-md-set-cat" data-placeholder="Select" requiredrequired>

                                                            <option selected disabled value="">--Select--</option>
                                                            <option value="0">N/A </option>
                                                            @foreach($set_cat as $key => $set_cat)
                                                            @if($old_info->set_category==$set_cat->id)
                                                            
                                                            <option value="{{$set_cat->id}}" selected>{{$set_cat->title}}</option>
                                                           
                                                            
                                                            @else

                                                            <option value="{{$set_cat->id}}">{{$set_cat->title}}</option>
                                                            @endif

                                                            @endforeach

                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Set Type</label>
                                                        <select class="form-select" name="set_type" id="form-select-md-set-type" data-placeholder="Select" requiredrequired>

                                                            <option selected disabled value="">--Select--</option>
                                                            <option value="0">N/A </option>
                                                            @foreach($set_type as $key => $set_type)
                                                              @if($old_info->set_type==$set_type->id)
                                                              
                                                              <option value="{{$set_type->id}}" selected>{{$set_type->title}}</option>
                                                              @else

                                                          

                                                            <option value="{{$set_type->id}}">{{$set_type->title}}</option>
                                                            @endif

                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                
                                                  <div class="col-sm-4">
                                                    <div class="form-group mb-3">

                                                        <label class="form-label">Class</label>
                                                        <select class="form-select" name="set_class" id="set_class" data-placeholder="Select" required>

                                                            <option selected disabled value="">--Select--</option>
                                                            <option value="0">N/A </option>
                                                            @foreach($class as $key => $class)
                                                            
                                                             @if($old_info->set_class==$class->id)

                                                             <option value="{{$class->id}}" selected>{{$class->title}}</option>
                                                             @else
                                                             <option value="{{$class->id}}">{{$class->title}}</option>
                                                             @endif


                                                            @endforeach

                                                        </select>

                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                            </div>

                                            
                                             <div class="list_wrapper mt-5">

                                                 @foreach($item_array as $key => $items)




                                               
                                                <div class="row">
                                                      
                                                    <div class="col-sm-6">

                                                        <div class="form-group mb-3">

                                                            <input type="text" onclick="{this.select();}"  value="{{$items['itemname']}}" onkeydown="getitemlist(this.id)" class="form-control itemname"  id='itemname_{{$key}}' placeholder="Itemname" required>

                                                        </div>

                                                    </div>

                                                    <div class="col-sm-2">

                                                        <div class="form-group mb-3">

                                                            <input type="number" value="{{$items['qty']}}" class="form-control" value="1" min="1" placeholder="Item Qty" id='qty_{{$key}}' name="item_qty[]" required >

                                                        </div>

                                                    </div>

                                                    <div class="col-sm-3">

                                                        <div class="form-group mb-3">


                                                              <input type="text" value="{{$items['unit_price']}}" class="form-control" placeholder="Price" id='unitprice_{{$key}}'  readonly required>
                                                              <input type='hidden' value="{{$items['item_id']}}" name="itemid[]" class='form-control' id='itemid_{{$key}}' readonly required>
                                                              
		
                                                        </div>

                                                    </div>

                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-danger "><i class="fa fa-remove list_remove_button"></i></button>
                                                    </div>

                                                </div>
                                                
                                                  @endforeach
                                                  <script>
                                                       var x = {{$key}};
                                                  </script>

                                            </div>

                                            <div class="form-group mb-3">

                                                <label class="form-label"></label>

                                                <button type="button" class="list_add_button btn btn btn-primary">Add More <i class="menu-icon tf-icons bx bx-plus"></i></button>

                                                <br><br><br><br>

                                                <button type="submit" class="btn btn-success">Save</button>

                                            </div>



                                                    
                                                </div>
                                            </div>

                                            

                                           

                                        </form>
                                    </div>
                                </div>
                            </div>
                         
                            </div>
                        </div>
                        <!--/ Content-->
                        <!-- Footer -->
                        <footer class="default-footer">
                            @include('includes.footer')
                            <!-- / Footer -->
                            <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper-->
                </div>
                <!-- / Layout page -->
            </div>
            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->
       
          @include('includes.footer_script')
       
          
<script>

//submitform
$("#submitform").on("submit",function(e)
{   
    e.preventDefault();
    
    
	$(".loader").css("display","block");
	var obj = $(this), action_name = obj.attr('name'); /*Define variables*/
	$.ajax
	({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&tag="+action_name,
		cache: false,
		success: function (response) 
		{
			//alert(JSON.stringify(response));
			if (response.success==1) 
			{
			
				   $.toast({ heading:  response.success_msg, position: 'top-right',stack: false,icon: 'success'})
			
				    $(".loader").css("display","none");
			window.location.reload();
				    
				    
			
			} 
			else 
			{
		    	$(".loader").css("display","none");
				$.toast({  heading: 'Error', text: response.error_msg, position: 'top-right',stack: false,icon: 'error'})
	      
			}
		}
	});
    
});
              
              
              
              const set_item_list=[];
              
               function getitemlist(id){
               
                var splitid = id.split('_');
                var index = splitid[1];

                $( '#'+id ).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:  "{{url('/') }}/get_set_item_like",
                            type: 'post',
                            dataType: "json",
                            data: { search:  request.term,"_token": "{{ csrf_token() }}"},
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },
                    
                    select: function (event,ui) {
                      
                        
                          if(set_item_list.includes(ui.item.value)==true)
                          {
                               	$.toast({  heading: 'Error', text: 'Item already added to set!', position: 'mid-center',stack: false,icon: 'error'});
                              
                          }
                          else
                          {
                              $(this).val(ui.item.label); // display the selected text
                              var userid = ui.item.value; // selected id to input

                                 // AJAX
                                $.ajax({
                                    url: "{{url('/') }}/get_set_item_details",
                                    type: 'post',
                                    data: {itemid:userid,"_token": "{{ csrf_token() }}"},
                                    dataType: 'json',
                                    success:function(response){
                                       
                                    //   alert(JSON.stringify(response));
                                            document.getElementById('itemid_'+index).value = response.id;
                                            document.getElementById('unitprice_'+index).value = response.unit_price;
                                    
                                            set_item_list.push(response.id);
                                      
                                    }
                                });
        
                              
                          }
                   
                   
                        return false;
                        
                    }
                });
              }
     





            $(document).ready(function() {
                var list_maxField = 30; //Input fields increment limitation

                $('.list_add_button').click(function() {

                    if (x < list_maxField) {

                        x++; //Increment field counter
                        var sn=x+1;
                        var list_fieldHTML = '<div class="row new_item_row"> <div class="col-sm-6"> <div class="form-group mb-3"> <input type="text"  onkeydown="getitemlist(this.id)" class="form-control itemname"   id="itemname_'+x+'" placeholder="Itemname" required></div></div><div class="col-sm-2"><div class="form-group mb-3"><input type="number" class="form-control"  placeholder="Item Qty" value="1" min="1" id="qty_'+x+'" name="item_qty[]" required></div></div><div class="col-sm-3"><div class="form-group mb-3"><input type="text" class="form-control" placeholder="Price" id="unitprice_'+x+'"  readonly  required><input type="hidden" name="itemid[]" class="form-control" id="itemid_'+x+'" readonly></div></div><div class="col-sm-1"><button type="button" class="btn btn-danger"><i class="fa fa-remove list_remove_button"></i></button></div></div>';
                        $('.list_wrapper').append(list_fieldHTML); //Add field html

                    }

                });

                //Once remove button is clicked

                $('.list_wrapper').on('click', '.list_remove_button', function() {

                    $(this).closest('.row').remove(); //Remove field html

                    x--; //Decrement field counter

                });

            });
        </script>
</body>

</html>