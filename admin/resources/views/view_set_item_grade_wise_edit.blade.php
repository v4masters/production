<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <title>Edit Set</title>
    <meta name="description" content="">
    <!-- Headerscript -->
    @include('includes.header_script')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('includes.sidebar')
            <!-- Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('includes.header')
                <!-- Navbar -->

                <!-- Centered Form -->
                <div class="container mt-3">
                    <div class="card">
                         <div class="card-header justify-content-between align-items-center">


                        <h5 class="card-header ">Edit  Set  </h5>
                       
                               
                        </div>
                        <div class="card-body">
                           
                           
                           @if($is_data==1)
                            
                                                    
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



                                               <input type="hidden" name="old_organisation" value="{{$old_info['org']}}">
                                               <input type="hidden" name="old_board" value="{{$old_info['board']}}">
                                               <input type="hidden" name="old_grade" value="{{$old_info['grade']}}">
                                               <input type="hidden" name="old_set_class" value="{{$old_info['set_class']}}">
                                               <input type="hidden" name="old_set_cat" value="{{$old_info['set_cat']}}">
                                               <input type="hidden" name="old_set_type" value="{{$old_info['set_type']}}">
                                               
                                               
                                             <div class="card mt-2 mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group mb-3">

                                                                <label class="form-label">Organisation </label>
                                                                <select class="form-select" name="organisation" id="organisation" data-placeholder="Select" required>

                                                                    <option selected disabled value="">--Select--</option>
                                                                    <option value="0">N/A </option>
                                                                    @foreach($organisation as $key => $organisation)
                                                                    
                                                                    @if($organisation->id==$old_info['org'])
                                                                    <option value="{{$organisation->id}}" selected>{{$organisation->name}}</option>
                                                                    
                                                                    @else
                                                                    
                                                                    <option value="{{$organisation->id}}" >{{$organisation->name}}</option>
                                                                    @endif
                                                                    
                                                                    @endforeach

                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group mb-3">

                                                                <label class="form-label">Board</label>
                                                                <select class="form-select" name="board" id="board" data-placeholder="Select" required>

                                                                    <option selected disabled value="">--Select--</option>
                                                                    <option value="0">N/A </option>
                                                                    
                                                                    @foreach($board as $key => $board)
                                                                    
                                                                    @if($board->id==$old_info['board'])
                                                                    <option value="{{$board->id}}" selected>{{$board->title}}</option>
                                                                     @else
                                                                    <option value="{{$board->id}}" >{{$board->title}}</option>
                                                                     @endif
                                                                     
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group mb-3">

                                                                <label class="form-label">Grade</label>
                                                                <select class="form-select"   name="grade" id="form-select-md-grade" data-placeholder="Select" required>
                                                                <!--onchange="selected_school(this.value)"-->
                                                                    <option selected disabled value="">--Select--</option>
                                                                    <option value="0">N/A </option>

                                                                    @foreach($grade as $key => $grade)

                                                                    @if($grade->id==$old_info['grade'])
                                                                    <option value="{{$grade->id}}" selected>{{$grade->title}}</option>
                                                                    @else
                                                                    <option value="{{$grade->id}}">{{$grade->title}}</option>
                                                                    @endif
                                                                    
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <!--<div class="col-sm-6">-->
                                                        <!--    <div class="form-group mb-3">-->

                                                        <!--        <label class="form-label">School</label><br>-->
                                                                   
                                                        <!--            <select class="selectpicker" id="school_list" name="school[]"  multiple aria-label="size 3 select example">-->
                                                                       
                                                        <!--            </select>-->
                                                                 
                                                        <!--    </div>-->
                                                        <!--</div>-->
                                                    </div>
                                                    
                                                    
                                                    <div class="row">


                                              
                                                <div class="col-sm-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Set Category</label>

                                                        <select class="form-select" name="set_cat" id="form-select-md-set-cat" data-placeholder="Select" requiredrequired>

                                                            <option selected disabled value="">--Select--</option>
                                                            <option value="0">N/A </option>
                                                            @foreach($set_cat as $key => $set_cat)
                                                            
                                                             @if($set_cat->id==$old_info['set_cat'])
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
                                                            
                                                            @if($set_type->id==$old_info['set_type'])
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
                                                            
                                                            @if($class->id==$old_info['set_class'])
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
                                                        <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-remove list_remove_button"></i></button>
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



                                                <div  id="alertmsg" > </div>
                                                 
                                                <button type="submit" class="btn btn-success">Save</button>

                                            </div>

    
                                                </div>
                                            </div>
                                        </form> 
                                        
                                        @else
                                        <h5 class="text-danger">Set Doesn't Exist</h5>
                                        @endif
                        
              
                   
                    </div>
                    </div>
                </div>
                <!-- Centered Form -->

                <!-- Footer -->
                <footer class="default-footer">
                    @include('includes.footer')
                </footer>
                <!-- / Footer -->
                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- Layout page -->
    </div>

    <!-- Overlay and Footer Script -->
    <div class="layout-overlay layout-menu-toggle"></div>
    @include('includes.footer_script')
    <!-- Footerscript -->
    
    
              
<script>
var set_item_list=[];

//submitform
$("#submitform").on("submit",function(e)
{   
    e.preventDefault();
    
     let div = document.getElementById("alertmsg");
         div.replaceChildren();

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
			
// 			alert(response.alertmsg)
				$.toast({ heading:  response.success_msg, position: 'top-right',stack: false,icon: 'success'})
			    $(".loader").css("display","none");
			    window.reload();
				    
			
			} 
			else 
			{
		    	$(".loader").css("display","none");
				$.toast({  heading: 'Error', text: response.error_msg, position: 'top-right',stack: false,icon: 'error'})
	      
			}
		}
	});
    
});
              
              
              
           
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
     

// function selected_school(grade) {
// $(".loader").css("display","block"); 

// var board=document.getElementById('board').value;
// var org=document.getElementById('organisation').value;



// $('#school_list').find('option').remove().end();
// var school_list=document.getElementById('school_list');

//             $.ajax({
//                 type: "POST",
//                 url: "{{url('/') }}/get_school_list",
//                 data: {"_token": "{{ csrf_token() }}","org": org,'grade':grade,'board':board},
//                 dataType: 'json',
//                 cache: false,
//                 success: function(response) {
                  
//                 //   alert(response);
//               	for(var i=0;i<response.length;i++)
// 				 {
//                   school_list.options[school_list.options.length] = new Option(response[i].school_name, response[i].id);
//                  }
                 
//                     $(".selectpicker").selectpicker("refresh");    
//                   	$(".loader").css("display","none");
                
//                 }
//             });
//         }




       

// $('#selectAll').click(function() {
//     $('#school_select option').attr("selected","selected");
//     $("#selectAll").attr("id", "deselectAll");   
    
// });   
// $('#deselectAll').click(function() {
//     $('#school_select option').removeAttr("selected");
// });


// $('#school_select').selectpicker();
            
            $(document).ready(function() {
                
                
                 
                var list_maxField = 30; //Input fields increment limitation

                $('.list_add_button').click(function() {

                    if (x < list_maxField) {

                        x++; //Increment field counter
                        var sn=x+1;
                        var list_fieldHTML = '<div class="row new_item_row"> <div class="col-sm-6"> <div class="form-group mb-3"> <input type="text"  onkeydown="getitemlist(this.id)" class="form-control itemname"   id="itemname_'+x+'" placeholder="Itemname" required></div></div><div class="col-sm-2"><div class="form-group mb-3"><input type="number" class="form-control"  placeholder="Item Qty" value="1" min="1" id="qty_'+x+'" name="item_qty[]" required></div></div><div class="col-sm-3"><div class="form-group mb-3"><input type="text" class="form-control" placeholder="Price" id="unitprice_'+x+'"  readonly  required><input type="hidden" name="itemid[]" class="form-control" id="itemid_'+x+'" readonly></div></div><div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-remove list_remove_button"></i></button></div></div>';
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

	
