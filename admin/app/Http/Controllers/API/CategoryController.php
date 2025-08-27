<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\API\CatOne;
use App\Models\API\CatTwo;
use App\Models\API\CatThree;
use App\Models\API\CatFour;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
   
class CategoryController extends BaseController
{
    /* allcategory */
    public function allcategory(Request $request): JsonResponse
    {
      $res1=[];
  
      $where1=['del_status'=>0,'status'=>1];
      $cat_one = CatOne::where($where1)->get();
      $count=count($cat_one);
      for($i=0;$i<$count;$i++)
      {
          $res2=[];
          $catone['cat_name']=$cat_one[$i]['name'];
          $catone['cat_id']=$cat_one[$i]['id'];
          $catone['cat_img']=$cat_one[$i]['img'];
          $catone['folder']=$cat_one[$i]['folder'];
          //sub cat
          $where2=['del_status'=>0,'status'=>1,'cat_id'=>$cat_one[$i]['id']];
          $cat_two = CatTwo::where($where2)->get();
          $counttwo=count($cat_two);
          
          for($j=0;$j<$counttwo;$j++)
          {  
             $subcat['subcat_name']=$cat_two[$j]['name'];
             $subcat['subcat_id']=$cat_two[$j]['id'];
              
             //sub cat three
             $where3=['del_status'=>0,'status'=>1,'cat_id'=>$cat_one[$i]['id'],'sub_cat_id'=>$cat_two[$j]['id']];
             $cat_three = CatThree::where($where3)->get();
             $kcount=count($cat_three);
            
             $abc=[];
             for($k=0;$k<$kcount;$k++)
             {
                $subcat2['subcat2_name'] = $cat_three[$k]['title'];
                $subcat2['subcat2_id'] = $cat_three[$k]['id'];
                $where4 = ['del_status'=>0, 'status'=>1, 'cat_id'=>$cat_one[$i]['id'], 'sub_cat_id'=>$cat_two[$j]['id'], 'sub_cat_id_two'=>$cat_three[$k]['id']];
                $cat_four = CatFour::where($where4)->get();
                $lcount=count($cat_four);
                
                $subcatres=[];
                for($l=0; $l<$lcount; $l++)
                {
                    $subcat3['subcat3_name']=$cat_four[$l]['title'];
                    $subcat3['subcat3_id']=$cat_four[$l]['id'];
                    array_push($subcatres,$subcat3);
                }
                
                $subcat2['subcat3']=$subcatres;
                array_push($abc,$subcat2);
             }
             
             $subcat['subcat2']=$abc;
             array_push($res2,$subcat);
          }
         
         $catone['subcat']= $res2;
         array_push($res1,$catone);
      }
      
      return $this->sendResponse(1, $res1, 'Success');
        
    }
}