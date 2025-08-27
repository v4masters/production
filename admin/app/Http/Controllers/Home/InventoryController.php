<?php



namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Home;

use App\Models\InventoryModel;
use App\Models\InventoryCatModel;
use App\Models\InventoryImgModel;

use App\Models\InventoryVenImgModel;

use App\Models\MasterinventoryformsModel;
use App\Models\ManagecategoryModel;
use App\Models\managesubcategoryModel;
use App\Models\managesubcategorytwoModel;
use App\Models\managesubcategorythreeModel;
use App\Models\managemasterbrandModel;
use App\Models\InventoryformsModel;
use App\Models\InventoryVendorModel;
use App\Models\VendorModel;
use App\Models\MasterformrouteModel;
use App\Models\managemasterqtyModel;
use App\Models\managemastercolourModel;
use App\Models\managemasterclassModel;
use App\Models\managemastergstModel;
use App\Models\managemasterstreamModel;
use App\Models\InventoryNewModel;

use File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller

{


    public function output($Return = array())
    {
        @header('Cache-Control: no-cache, must-revalidate');
        @header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($Return));
        die;
    }

    public function upload_image($file, $folder)
    {
        $image_name = date('YmdHis') . '-' . time() . "-" . rand(10, 100) . '.' . $file->getClientOriginalExtension();
        $filePath = $folder . $image_name;
        $res = Storage::disk('s3')->put($filePath, file_get_contents($file));
        // $res = Storage::disk('s3')->put($filePath, file_get_contents($file), ['ACL' => 'public-read']);
        if ($res) {
            return $image_name;
        } else {
            return false;
        }
    }


    public function add_inventory_catalog(Request $request)
    {
        $data = array(
            "cat_one" => $request->cat_id,
            "cat_two" => $request->cat_id_two,
            "cat_three" => $request->cat_id_three,
            "cat_four" => $request->cat_id_four,
            "status" =>  1,
            "created_at" => date('Y-m-d H:i:s')
        );
        $res = InventoryCatModel::create($data);
        $res_cat_id = $res->id;
        $catdata = managesubcategorythreeModel::where('id', $request->cat_id_four)->first();
        $formcatdata = MasterinventoryformsModel::where('id', $catdata->form_id)->first();
        if ($res) {
            return redirect()->to($formcatdata->route_name . '/' . $res_cat_id);
        } else {
            return redirect('manageCategory')->withErrors(['' => 'Somthing went wrong!']);
        }
    }


    public function add_all_inventory(Request $request)
    {

        if (isset($request->product_name)) {
            $product_name = $request->product_name;
        } else {
            $product_name = NULL;
        }
        if (isset($request->description)) {
            $description = $request->description;
        } else {
            $description = NULL;
        }
        if (isset($request->author)) {
            $author = $request->author;
        } else {
            $author = NULL;
        }
        if (isset($request->book_format)) {
            $book_format = $request->book_format;
        } else {
            $book_format = NULL;
        }
        if (isset($request->youtube_url)) {
            $youtube_url = $request->youtube_url;
        } else {
            $youtube_url = NULL;
        }
        if (isset($request->printer_details)) {
            $printer_details = $request->printer_details;
        } else {
            $printer_details = NULL;
        }
        if (isset($request->publish_year)) {
            $publish_year = $request->publish_year;
        } else {
            $publish_year = NULL;
        }
        if (isset($request->importer_detail)) {
            $importer_detail = $request->importer_detail;
        } else {
            $importer_detail = NULL;
        }
        if (isset($request->laptop_capacity)) {
            $laptop_capacity = $request->laptop_capacity;
        } else {
            $laptop_capacity = NULL;
        }
        if (isset($request->material)) {
            $material = $request->material;
        } else {
            $material = NULL;
        }
        if (isset($request->warranty)) {
            $warranty = $request->warranty;
        } else {
            $warranty = NULL;
        }
        if (isset($request->water_resistant)) {
            $water_resistant = $request->water_resistant;
        } else {
            $water_resistant = NULL;
        }
        if (isset($request->type)) {
            $type = $request->type;
        } else {
            $type = NULL;
        }
        if (isset($request->country_of_origin)) {
            $country_of_origin = $request->country_of_origin;
        } else {
            $country_of_origin = NULL;
        }
        if (isset($request->manufacturer_detail)) {
            $manufacturer_detail = $request->manufacturer_detail;
        } else {
            $manufacturer_detail = NULL;
        }
        if (isset($request->packer_detail)) {
            $packer_detail = $request->packer_detail;
        } else {
            $packer_detail = NULL;
        }
        if (isset($request->material_type)) {
            $material_type = $request->material_type;
        } else {
            $material_type = NULL;
        }
        if (isset($request->paper_finish)) {
            $paper_finish = $request->paper_finish;
        } else {
            $paper_finish = NULL;
        }
        if (isset($request->paper_size)) {
            $paper_size = $request->paper_size;
        } else {
            $paper_size = NULL;
        }
        if (isset($request->weight_unit)) {
            $weight_unit = $request->weight_unit;
        } else {
            $weight_unit = NULL;
        }
        if (isset($request->product_weight)) {
            $product_weight = $request->product_weight;
        } else {
            $product_weight = NULL;
        }
        if (isset($request->fssai_license_number)) {
            $fssai_license_number = $request->fssai_license_number;
        } else {
            $fssai_license_number = NULL;
        }
        if (isset($request->shelf_life)) {
            $shelf_life = $request->shelf_life;
        } else {
            $shelf_life = NULL;
        }
        if (isset($request->veg_nonveg)) {
            $veg_nonveg = $request->veg_nonveg;
        } else {
            $veg_nonveg = NULL;
        }
        if (isset($request->product_length)) {
            $product_length = $request->product_length;
        } else {
            $product_length = NULL;
        }
        if (isset($request->product_type)) {
            $product_type = $request->product_type;
        } else {
            $product_type = NULL;
        }
        if (isset($request->product_unit)) {
            $product_unit = $request->product_unit;
        } else {
            $product_unit = NULL;
        }
        if (isset($request->character)) {
            $character = $request->character;
        } else {
            $character = NULL;
        }
        if (isset($request->no_of_compartment)) {
            $no_of_compartment = $request->no_of_compartment;
        } else {
            $no_of_compartment = NULL;
        }
        if (isset($request->backpack_style)) {
            $backpack_style = $request->backpack_style;
        } else {
            $backpack_style = NULL;
        }
        if (isset($request->bag_capacity)) {
            $bag_capacity = $request->bag_capacity;
        } else {
            $bag_capacity = NULL;
        }
        if (isset($request->gender)) {
            $gender = $request->gender;
        } else {
            $gender = NULL;
        }
        if (isset($request->pattern)) {
            $pattern = $request->pattern;
        } else {
            $pattern = NULL;
        }
        if (isset($request->recommended_age)) {
            $recommended_age = $request->recommended_age;
        } else {
            $recommended_age = NULL;
        }
        if (isset($request->fabric)) {
            $fabric = $request->fabric;
        } else {
            $fabric = NULL;
        }
        if (isset($request->fit)) {
            $fit = $request->fit;
        } else {
            $fit = NULL;
        }
        if (isset($request->neck)) {
            $neck = $request->neck;
        } else {
            $neck = NULL;
        }
        if (isset($request->sleeve_length)) {
            $sleeve_length = $request->sleeve_length;
        } else {
            $sleeve_length = NULL;
        }
        if (isset($request->stitch_type)) {
            $stitch_type = $request->stitch_type;
        } else {
            $stitch_type = NULL;
        }
        if (isset($request->bottom_type)) {
            $bottom_type = $request->bottom_type;
        } else {
            $bottom_type = NULL;
        }
        if (isset($request->bottomwear_color)) {
            $bottomwear_color = $request->bottomwear_color;
        } else {
            $bottomwear_color = NULL;
        }
        if (isset($request->bottomwear_fabric)) {
            $bottomwear_fabric = $request->bottomwear_fabric;
        } else {
            $bottomwear_fabric = NULL;
        }
        if (isset($request->kurta_color)) {
            $kurta_color = $request->kurta_color;
        } else {
            $kurta_color = NULL;
        }
        if (isset($request->kurta_fabric)) {
            $kurta_fabric = $request->kurta_fabric;
        } else {
            $kurta_fabric = NULL;
        }
        if (isset($request->length)) {
            $length = $request->length;
        } else {
            $length = NULL;
        }
        if (isset($request->set_type)) {
            $set_type = $request->set_type;
        } else {
            $set_type = NULL;
        }
        if (isset($request->occasion)) {
            $occasion = $request->occasion;
        } else {
            $occasion = NULL;
        }
        if (isset($request->ornamentation)) {
            $ornamentation = $request->ornamentation;
        } else {
            $ornamentation = NULL;
        }
        if (isset($request->pattern_type)) {
            $pattern_type = $request->pattern_type;
        } else {
            $pattern_type = NULL;
        }
        if (isset($request->sleeve_styling)) {
            $sleeve_styling = $request->sleeve_styling;
        } else {
            $sleeve_styling = NULL;
        }
        if (isset($request->sole_material)) {
            $sole_material = $request->sole_material;
        } else {
            $sole_material = NULL;
        }
        if (isset($request->connectivity)) {
            $connectivity = $request->connectivity;
        } else {
            $connectivity = NULL;
        }
        if (isset($request->operating_system)) {
            $operating_system = $request->operating_system;
        } else {
            $operating_system = NULL;
        }
        if (isset($request->ram)) {
            $ram = $request->ram;
        } else {
            $ram = NULL;
        }
        if (isset($request->warranty_service_type)) {
            $warranty_service_type = $request->warranty_service_type;
        } else {
            $warranty_service_type = NULL;
        }
        if (isset($request->dual_camera)) {
            $dual_camera = $request->dual_camera;
        } else {
            $dual_camera = NULL;
        }
        if (isset($request->expandable_storage)) {
            $expandable_storage = $request->expandable_storage;
        } else {
            $expandable_storage = NULL;
        }
        if (isset($request->headphone_jack)) {
            $headphone_jack = $request->headphone_jack;
        } else {
            $headphone_jack = NULL;
        }
        if (isset($request->internal_memory)) {
            $internal_memory = $request->internal_memory;
        } else {
            $internal_memory = NULL;
        }
        if (isset($request->no_of_primary_camera)) {
            $no_of_primary_camera = $request->no_of_primary_camera;
        } else {
            $no_of_primary_camera = NULL;
        }
        if (isset($request->no_of_secondary_camera)) {
            $no_of_secondary_camera = $request->no_of_secondary_camera;
        } else {
            $no_of_secondary_camera = NULL;
        }
        if (isset($request->primary_camera)) {
            $primary_camera = $request->primary_camera;
        } else {
            $primary_camera = NULL;
        }
        if (isset($request->screen_length_size)) {
            $screen_length_size = $request->screen_length_size;
        } else {
            $screen_length_size = NULL;
        }
        if (isset($request->secondary_camera)) {
            $secondary_camera = $request->secondary_camera;
        } else {
            $secondary_camera = NULL;
        }
        if (isset($request->sim)) {
            $sim = $request->sim;
        } else {
            $sim = NULL;
        }
        if (isset($request->sim_type)) {
            $sim_type = $request->sim_type;
        } else {
            $sim_type = NULL;
        }
        if (isset($request->add_ons)) {
            $add_ons = $request->add_ons;
        } else {
            $add_ons = NULL;
        }
        if (isset($request->body_material)) {
            $body_material = $request->body_material;
        } else {
            $body_material = NULL;
        }
        if (isset($request->burner_material)) {
            $burner_material = $request->burner_material;
        } else {
            $burner_material = NULL;
        }
        if (isset($request->no_of_burners)) {
            $no_of_burners = $request->no_of_burners;
        } else {
            $no_of_burners = NULL;
        }
        if (isset($request->packaging_breadth)) {
            $packaging_breadth = $request->packaging_breadth;
        } else {
            $packaging_breadth = NULL;
        }
        if (isset($request->packaging_height)) {
            $packaging_height = $request->packaging_height;
        } else {
            $packaging_height = NULL;
        }
        if (isset($request->packaging_length)) {
            $packaging_length = $request->packaging_length;
        } else {
            $packaging_length = NULL;
        }
        if (isset($request->packaging_unit)) {
            $packaging_unit = $request->packaging_unit;
        } else {
            $packaging_unit = NULL;
        }
        if (isset($request->product_breadth)) {
            $product_breadth = $request->product_breadth;
        } else {
            $product_breadth = NULL;
        }
        if (isset($request->product_height)) {
            $product_height = $request->product_height;
        } else {
            $product_height = NULL;
        }


        if (isset($request->brand)) {
            if (gettype($request->brand) == 'integer') {
                $brand = $request->brand;
            } else {
                $branddata = array(
                    "title" => $request->brand,
                    'status' => 0,
                    "created_at" =>  date('Y-m-d H:i:s')
                );

                $branddatares = managemasterbrandModel::create($branddata);
                $brand = $branddatares->id;
            }
        } else {

            $brand = "";
        }


        if (isset($request->cat_type)) {
            $colname = 'class';
        } else {
            $colname = "color";
        }
        $resrow = 0;
        $size = $request->size;
        $size_id = $request->size_id;
        $count = count($size);
        for ($s = 0; $s < $count; $s++) {

            $i = 0;
            $i = $size_id[$s];


            $class_title = "class_title" . $i;
            $quantity_ = "quantity_" . $i;
            $min_qyt = "min_qyt" . $i;
            $rqty_unit = "qty_unit" . $i;
            $hsncode = "hsncode" . $i;
            $barcode = "barcode_" . $i;
            $isbn = "isbn" . $i;
            $net_weight = "net_weight" . $i;
            $rmrp = "mrp" . $i;
            $rdiscount = "discount" . $i;
            $rdiscounted_price = "dis_price" . $i;
            $rsales_price = "sales_price" . $i;
            $rgst = "gst" . $i;
            $rshipping_charges = "shipping_charges" . $i;
            $redition = "edition" . $i;

            $subclass = $request->$class_title;
            $net_quantity = $request->$quantity_;
            $min_quantity = $request->$min_qyt;
            $qty_unit = $request->$rqty_unit;
            $class_hsncode = $request->$hsncode;
            $class_barcode = $request->$barcode;
            $class_isbn = $request->$isbn;
            $class_net_weight = $request->$net_weight;
            $mrp = $request->$rmrp;
            $discount = $request->$rdiscount;
            $discounted_price = $request->$rdiscounted_price;
            $sales_price = $request->$rsales_price;
            $gst = $request->$rgst;
            $shipping_charges = $request->$rshipping_charges;

            if (isset($request->$redition)) {
                $edition = $request->$redition;
            } else {
                $edition = [];
            }

            if ($request->file('book_pdf' . $i) != NULL) {
                $book_pdf = $request->file('book_pdf' . $i);
            } else {
                $book_pdf = [];
            }

            $subdata = [];
            for ($j = 0; $j < count($subclass); $j++) {

                $lastprodata = InventoryformsModel::orderBy('id', 'DESC')->first();
                $product_id = rand(10, 100000) . $lastprodata->id + 1;

                if (isset($book_pdf[$j])) {

                    $book_pdfdata = $this->upload_image($book_pdf[$j], 'inventory/pdf/');
                } else {
                    $book_pdfdata = "";
                }

                if (isset($net_quantity[$j])) {
                    $newnet_quantity = $net_quantity[$j];
                } else {
                    $newnet_quantity = NULL;
                }
                if (isset($min_quantity[$j])) {
                    $newmin_qyt = $min_quantity[$j];
                } else {
                    $newmin_qyt = NULL;
                }
                if (isset($qty_unit[$j])) {
                    $newqty_unit = $qty_unit[$j];
                } else {
                    $newqty_unit = NULL;
                }
                if (isset($class_hsncode[$j])) {
                    $newhsncode = $class_hsncode[$j];
                } else {
                    $newhsncode = NULL;
                }
                if (isset($class_barcode[$j])) {
                    $newbarcode = $class_barcode[$j];
                } else {
                    $newbarcode = NULL;
                }
                if (isset($class_isbn[$j])) {
                    $newisbn = $class_isbn[$j];
                } else {
                    $newisbn = NULL;
                }
                if (isset($class_net_weight[$j])) {
                    $newnet_weight = $class_net_weight[$j];
                } else {
                    $newnet_weight = NULL;
                }
                if (isset($mrp[$j])) {
                    $newmrp = $mrp[$j];
                } else {
                    $newmrp = NULL;
                }
                if (isset($discount[$j])) {
                    $newdiscount = $discount[$j];
                } else {
                    $newdiscount = NULL;
                }
                if (isset($discounted_price[$j])) {
                    $newdiscounted_price = $discounted_price[$j];
                } else {
                    $newdiscounted_price = NULL;
                }
                if (isset($sales_price[$j])) {
                    $newsales_price = $sales_price[$j];
                } else {
                    $newsales_price = NULL;
                }
                if (isset($gst[$j])) {
                    $newgst = $gst[$j];
                } else {
                    $newgst = NULL;
                }
                if (isset($shipping_charges[$j])) {
                    $newshipping_charges = $shipping_charges[$j];
                } else {
                    $newshipping_charges = NULL;
                }
                if (isset($edition[$j])) {
                    $newedition = $edition[$j];
                } else {
                    $newedition = NULL;
                }


                $subdata = [

                    //colomn feild
                    $colname => $subclass[$j],
                    'net_quantity' => $newnet_quantity,
                    "min_qyt" => $newmin_qyt,
                    "qty_unit" => $newqty_unit,
                    'hsncode' => $newhsncode,
                    'barcode' => $newbarcode,
                    'isbn' => $newisbn,
                    'net_weight' => $newnet_weight,
                    'mrp' => $newmrp,
                    'discount' => $newdiscount,
                    'discounted_price' => $newdiscounted_price,
                    'sales_price' => $newsales_price,
                    'gst' => $newgst,
                    'shipping_charges' => $newshipping_charges,
                    'edition' => $newedition,
                    //  //end

                    'book_pdf' => $book_pdfdata,
                    "product_id" => $product_id,
                    "product_name" => $product_name,
                    "description" => $description,
                    "author" => $author,
                    "book_format" => $book_format,
                    "youtube_url" => $youtube_url,
                    "brand" => $brand,
                    "printer_details" => $printer_details,
                    "publish_year" => $publish_year,
                    "importer_detail" => $importer_detail,
                    "laptop_capacity" => $laptop_capacity,
                    "material" => $material,
                    "warranty" => $warranty,
                    "water_resistant" => $water_resistant,
                    "type" => $type,
                    "country_of_origin" => $country_of_origin,
                    "manufacturer_detail" => $manufacturer_detail,
                    "packer_detail" => $packer_detail,
                    "material_type" => $material_type,
                    "paper_finish" => $paper_finish,
                    "paper_size" => $paper_size,
                    "weight_unit" => $weight_unit,
                    "product_weight" => $product_weight,
                    "fssai_license_number" => $fssai_license_number,
                    "shelf_life" => $shelf_life,
                    "veg_nonveg" => $veg_nonveg,
                    "product_length" => $product_length,
                    "product_type" => $product_type,
                    "product_unit" => $product_unit,
                    "character" => $character,
                    "no_of_compartment" => $no_of_compartment,
                    "backpack_style" => $backpack_style,
                    "bag_capacity" => $bag_capacity,
                    "gender" => $gender,
                    "pattern" => $pattern,
                    "recommended_age" => $recommended_age,
                    "fabric" => $fabric,
                    "fit" => $fit,
                    "neck" => $neck,
                    "sleeve_length" => $sleeve_length,
                    "stitch_type" => $stitch_type,
                    "bottom_type" => $bottom_type,
                    "bottomwear_color" => $bottomwear_color,
                    "bottomwear_fabric" => $bottomwear_fabric,
                    "kurta_color" => $kurta_color,
                    "kurta_fabric" => $kurta_fabric,
                    "length" => $length,
                    "set_type" => $set_type,
                    "occasion" => $occasion,
                    "ornamentation" => $ornamentation,
                    "pattern_type" => $pattern_type,
                    "sleeve_styling" => $sleeve_styling,
                    "sole_material" => $sole_material,
                    "connectivity" => $connectivity,
                    "operating_system" => $operating_system,
                    "ram" => $ram,
                    "warranty_service_type" => $warranty_service_type,
                    "dual_camera" => $dual_camera,
                    "expandable_storage" => $expandable_storage,
                    "headphone_jack" => $headphone_jack,
                    "internal_memory" => $internal_memory,
                    "no_of_primary_camera" => $no_of_primary_camera,
                    "no_of_secondary_camera" => $no_of_secondary_camera,
                    "primary_camera" => $primary_camera,
                    "screen_length_size" => $screen_length_size,
                    "secondary_camera" => $secondary_camera,
                    "sim" => $sim,
                    "sim_type" => $sim_type,
                    "add_ons" => $add_ons,
                    "body_material" => $body_material,
                    "burner_material" => $burner_material,
                    "no_of_burners" => $no_of_burners,
                    "packaging_breadth" => $packaging_breadth,
                    "packaging_height" => $packaging_height,
                    "packaging_length" => $packaging_length,
                    "packaging_unit" => $packaging_unit,
                    "product_breadth" => $product_breadth,
                    "product_height" => $product_height,

                    //static
                    "created_at" =>  date('Y-m-d H:i:s'),
                    "cat_id" => $request->cat_id,
                    'size' => $size[$s]
                ];

                $res = InventoryformsModel::create($subdata);
                $lastinsertid = $res->id;

                if ($request->file($i . $j . 'pro_img') != NULL) {
                    $pro_imgname = "";
                    $pro_imgname = $request->file($i . $j . 'pro_img');

                    $countimg = count($pro_imgname);
                    for ($m = 0; $m < $countimg; $m++) {
                        $subdataimg = [];

                        if (isset($pro_imgname[$m])) {
                            $pro_imgnameorg = $this->upload_image($pro_imgname[$m], 'inventory/');
                        } else {
                            $pro_imgnameorg = "";
                        }


                        if ($m == 0) {
                            $dp_status = 1;
                        } else {
                            $dp_status = 0;
                        }
                        $subdataimg = [
                            'item_id' => $lastinsertid,
                            'status' => 1,
                            'alt' => "",
                            'size_id' => $size[$s],
                            'image' => $pro_imgnameorg,
                            'dp_status' => $dp_status,
                            "created_at" => date('Y-m-d H:i:s')
                        ];

                        $subresimg = InventoryImgModel::create($subdataimg);
                    }
                }
            }
            $resrow++;
        }

        if ($count == $resrow) {
            return redirect()->back()->with('success', 'Submitted successfully.');
        } else {
            return redirect('inventory_books')->withErrors(['' => 'Somthing went wrong!']);
        }
    }



    public function inventory()
    {
        $data = InventoryModel::where('del_status', 0)->get();
        return view('inventory', ['pagedata' => $data]);
    }



    public function view_vendor_inventory()
    {
        $array = array('status' => 0, 'del_status' => 0);
        $data = InventoryVendorModel::orderBy('id', 'DESC')->where($array)->get();
        for ($i = 0; $i < count($data); $i++) {
            $vendor = VendorModel::where(['unique_id' => $data[$i]->vendor_id])->first();
            $data[$i]->vendor_info = $vendor;
        }

        return view('inventory_view_vendor', ['pagedata' => $data]);
    }


    // inventory_vendor_approve
    public function inventory_vendor_approve(string $id)
    {
        $data = InventoryVendorModel::where(['id' => $id])->first();
        $lastprodata = InventoryformsModel::orderBy('id', 'DESC')->first();
        $product_id = rand(10, 100000) . $lastprodata->id + 1;

        $inv_data = [
            "vendor_id" => $data->vendor_id,
            "cat_id" => $data->cat_id,
            "net_weight" => $data->net_weight,
            "min_qyt" => $data->min_qyt,
            "product_id" => $product_id,
            "product_name" => $data->product_name,
            "size" => $data->size,
            "size_chart" => $data->size_chart,
            "barcode" => $data->barcode,
            "description" => $data->description,
            "mrp" => $data->mrp,
            "discount" => $data->discount,
            "discounted_price" => $data->discounted_price,
            "sales_price" => $data->sales_price,
            "shipping_charges" => $data->shipping_charges,
            "hsncode" => $data->hsncode,
            "gst" => $data->gst,
            "country_of_origin" => $data->country_of_origin,
            "color" => $data->color,
            "type" => $data->type,
            "manufacturer_detail" => $data->manufacturer_detail,
            "packer_detail" => $data->packer_detail,
            "manufacturing_date" => $data->manufacturing_date,
            "brand" => $data->brand,
            "material_type" => $data->material_type,
            "material" => $data->material,
            "paper_finish" => $data->paper_finish,
            "paper_size" => $data->paper_size,
            "importer_detail" => $data->importer_detail,
            "author" => $data->author,
            "edition" => $data->edition,
            "book_pdf" => $data->book_pdf,
            "stream" => $data->stream,
            "class" => $data->class,
            "printer_details" => $data->printer_details,
            "publish_year" => $data->publish_year,
            "pages" => $data->pages,
            "language" => $data->language,
            "youtube_url" => $data->youtube_url,
            "isbn" => $data->isbn,
            "book_format" => $data->book_format,
            "net_quantity" => $data->net_quantity,
            "qty_unit" => $data->qty_unit,
            "product_type" => $data->product_type,
            "product_unit" => $data->product_unit,
            "product_length" => $data->product_length,
            "product_breadth" => $data->product_breadth,
            "product_weight" => $data->product_weight,
            "product_height" => $data->product_height,
            "weight_unit" => $data->weight_unit,
            "warranty" => $data->warranty,
            "water_resistant" => $data->water_resistant,
            "laptop_capacity" => $data->laptop_capacity,
            "character" => $data->character,
            "no_of_compartment" => $data->no_of_compartment,
            "backpack_style" => $data->backpack_style,
            "bag_capacity" => $data->bag_capacity,
            "gender" => $data->gender,
            "pattern" => $data->pattern,
            "recommended_age" => $data->recommended_age,
            "fssai_license_number" => $data->fssai_license_number,
            "shelf_life" => $data->shelf_life,
            "veg_nonveg" => $data->veg_nonveg,
            "connectivity" => $data->connectivity,
            "operating_system" => $data->operating_system,
            "ram" => $data->ram,
            "warranty_service_type" => $data->warranty_service_type,
            "dual_camera" => $data->dual_camera,
            "expandable_storage" => $data->expandable_storage,
            "headphone_jack" => $data->headphone_jack,
            "internal_memory" => $data->internal_memory,
            "primary_camera" => $data->primary_camera,
            "no_of_primary_camera" => $data->no_of_primary_camera,
            "secondary_camera" => $data->secondary_camera,
            "no_of_secondary_camera" => $data->no_of_secondary_camera,
            "screen_length_size" => $data->screen_length_size,
            "sim" => $data->sim,
            "sim_type" => $data->sim_type,
            "add_ons" => $data->add_ons,
            "body_material" => $data->body_material,
            "burner_material" => $data->burner_material,
            "no_of_burners" => $data->no_of_burners,
            "packaging_breadth" => $data->packaging_breadth,
            "packaging_height" => $data->packaging_height,
            "packaging_length" => $data->packaging_length,
            "packaging_unit" => $data->packaging_unit,
            "sole_material" => $data->sole_material,
            "fabric" => $data->fabric,
            "fit" => $data->fit,
            "neck" => $data->neck,
            "sleeve_length" => $data->sleeve_length,
            "sleeve_styling" => $data->sleeve_styling,
            "occasion" => $data->occasion,
            "ornamentation" => $data->ornamentation,
            "pattern_type" => $data->pattern_type,
            "bottom_type" => $data->bottom_type,
            "bottomwear_color" => $data->bottomwear_color,
            "bottomwear_fabric" => $data->bottomwear_fabric,
            "kurta_color" => $data->kurta_color,
            "kurta_fabric" => $data->kurta_fabric,
            "length" => $data->length,
            "set_type" => $data->set_type,
            "stitch_type" => $data->stitch_type,
            "sale_rate" => $data->sale_rate,
            "sale_rate_status" => $data->sale_rate_status,
            "status" => 1,
            "created_at" => date('Y-m-d H:i:s'),
            "created_by" => 1
        ];

        $inv_add = InventoryformsModel::create($inv_data);
        if ($inv_add) {
            if ($data->book_pdf != NULL) {
                Storage::disk('s3')->copy($data->folder . "/pdf/" . $data->book_pdf, "inventory/pdf/" . $data->book_pdf);
            }

            $imgdata = InventoryVenImgModel::where(['item_id' => $id, 'del_status' => 0])->get();
            $count = count($imgdata);
            $row = 0;
            for ($i = 0; $i < $count; $i++) {
                if ($imgdata[$i]->image != NULL) {
                    Storage::disk('s3')->copy($imgdata[$i]->folder . "/" . $imgdata[$i]->image, "inventory/" . $imgdata[$i]->image);
                }

                $subdataimg = [
                    'item_id' => $inv_add->id,
                    'status' => 1,
                    'alt' => $imgdata[$i]->alt,
                    'size_id' => $imgdata[$i]->size_id,
                    'image' => $imgdata[$i]->image,
                    'dp_status' => $imgdata[$i]->dp_status,
                    "created_at" => date('Y-m-d H:i:s')
                ];

                $subresimg = InventoryImgModel::create($subdataimg);
                if ($subresimg) {
                    $row++;
                }
            }


            $update_pen_status = InventoryVendorModel::where("id", $id)->update(['status' => 1]);
            if ($row == $count) {
                return redirect()->back()->with('success', 'Approved successfully.');
            } else {
                return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
            }
        } else {
            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }




    // edit approved inventory
    public function update_inventory(Request $request)
    {
        if ($request->file('book_pdf') != NULL) {
            $book_pdf = $request->file('book_pdf');
        } else {
            $book_pdf = $request->old_book_pdf;
        }
        $access = InventoryformsModel::where("id", request('id'));
        $data = array(
            "book_pdf" => $book_pdf,
            "product_name" =>  $request->product_name,
            "description" =>  $request->description,
            "importer_detail" =>  $request->importer_detail,
            "class" =>  $request->inv_class,
            "color" =>  $request->color,
            "net_quantity" =>  $request->net_quantity,
            "min_qyt" =>  $request->min_qyt,
            "qty_unit" =>  $request->qty_unit,
            "hsncode" =>  $request->hsncode,
            "barcode" =>  $request->barcode,
            "isbn" =>  $request->isbn,
            "net_weight" =>  $request->net_weight,
            "mrp" =>  $request->mrp,
            "discount" =>  $request->discount,
            "discounted_price" =>  $request->discounted_price,
            "sales_price" =>  $request->sales_price,
            "gst" =>  $request->gst,
            "shipping_charges" =>  $request->shipping_charges,
            "edition" =>  $request->edition,
            "size_chart" =>  $request->size_chart,
            "brand" =>  $request->brand,
            "country_of_origin" =>  $request->country_of_origin,
            "manufacturer_detail" =>  $request->manufacturer_detail,
            "packer_detail" =>  $request->packer_detail,
            "pattern_type" =>  $request->pattern_type,
            "sleeve_length" =>  $request->sleeve_length,
            "sleeve_styling" =>  $request->sleeve_styling,
            "stitch_type" =>  $request->stitch_type,
            "occasion" =>  $request->occasion,
            "ornamentation" =>  $request->ornamentation,
            "pattern" =>  $request->pattern,
            "kurta_fabric" =>  $request->kurta_fabric,
            "length" =>  $request->length,
            "neck" =>  $request->neck,
            "set_type" =>  $request->set_type,
            "bottomwear_fabric" =>  $request->bottomwear_fabric,
            "fabric" =>  $request->fabric,
            "fit" =>  $request->fit,
            "kurta_color" =>  $request->kurta_color,
            "bottom_type" =>  $request->bottom_type,
            "bottomwear_color" =>  $request->bottomwear_color,
            "material" =>  $request->material,
            "product_length" =>  $request->product_length,
            "product_type" =>  $request->product_type,
            "product_unit" =>  $request->product_unit,
            "type" =>  $request->type,
            "paper_size" =>  $request->paper_size,
            "paper_finish" =>  $request->paper_finish,
            "material_type" =>  $request->material_type,
            "secondary_camera" =>  $request->secondary_camera,
            "sim" =>  $request->sim,
            "sim_type" =>  $request->sim_type,
            "warranty_service_type" =>  $request->warranty_service_type,
            "no_of_primary_camera" =>  $request->no_of_primary_camera,
            "no_of_secondary_camera" =>  $request->no_of_secondary_camera,
            "primary_camera" =>  $request->primary_camera,
            "screen_length_size" =>  $request->screen_length_size,
            "dual_camera" =>  $request->dual_camera,
            "expandable_storage" =>  $request->expandable_storage,
            "headphone_jack" =>  $request->headphone_jack,
            "internal_memory" =>  $request->internal_memory,
            "operating_system" =>  $request->operating_system,
            "ram" =>  $request->ram,
            "connectivity" =>  $request->connectivity,
            "backpack_style" =>  $request->backpack_style,
            "bag_capacity" =>  $request->bag_capacity,
            "recommended_age" =>  $request->recommended_age,
            "gender" =>  $request->gender,
            "character" =>  $request->character,
            "no_of_compartment" =>  $request->no_of_compartment,
            "product_height" =>  $request->product_height,
            "product_breadth" =>  $request->product_breadth,
            "add_ons" =>  $request->add_ons,
            "body_material" =>  $request->body_material,
            "burner_material" =>  $request->burner_material,
            "no_of_burners" =>  $request->no_of_burners,
            "sole_material" =>  $request->sole_material,
            "fssai_license_number" =>  $request->fssai_license_number,
            "shelf_life" =>  $request->shelf_life,
            "veg_nonveg" =>  $request->veg_nonveg,
            "product_weight" =>  $request->product_weight,
            "weight_unit" =>  $request->weight_unit,
            "water_resistant" =>  $request->water_resistant,
            "laptop_capacity" =>  $request->laptop_capacity,
            "printer_details" =>  $request->printer_details,
            "stream" =>  $request->stream,
            "book_format" =>  $request->book_format,
            "youtube_url" =>  $request->youtube_url,
            "publish_year" =>  $request->publish_year,
            "author" =>  $request->author,
            "status" => $request->status
        );
        $res = $access->update($data);
        $subimgdata = [];
        $invimg = $request->file('image');
        if ($invimg) {
            $count = count($invimg);

            for ($i = 0; $i < $count; $i++) {
                if ($invimg[$i]) {
                    $invimage = $this->upload_image($invimg[$i], 'inventory/');
                } else {
                    $invimage = "";
                }

                $subimgdata = [
                    'image' => $invimage,
                    'status' => 1,
                    'alt' => "",
                    'created_at' => date('Y-m-d H:i:s'),
                    'item_id' => $request->id,
                    'size_id' => $request->size,
                ];

                $subresimg = InventoryImgModel::create($subimgdata);
            }
        }
        if ($res) {

            return redirect('view_approved_inventory')->with('success', 'Updated successfully.');
        } else {

            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

  
    public function updateapproveddpstatus(Request $request){
        $where=['item_id'=>$request->item_id];
        $getimagedata = InventoryImgModel::where($where)->update(['dp_status'=>0]);
        if($getimagedata){
            $data = InventoryImgModel::where('id', Request('image_id'));
            $updData=['dp_status'=>1];
            $res = $data->update($updData);
           if ($res) {
                $response['success'] = 1;
                $response['msg'] = 'Updated successfully!';
                $this->output($response);
            } else {
                $response['success'] = 0;
                $response['msg'] = 'Somthing went wrong!';
                $this->output($response);
            }
        }
    }
    
    public function removeinvimg(Request $request)
    {
        $data = InventoryImgModel::where('id', Request('id'));
        $updData = array( 'del_status' => 1 );
        $res = $data->update($updData);
        if ($res) {
            $response['success'] = 1;
            $response['msg'] = 'Deleted successfully!';
            $this->output($response);
        } else {
            $response['success'] = 0;
            $response['msg'] = 'Somthing went wrong!';
            $this->output($response);
        }
    }

    //view_inventory_form
    public function view_inventory_form()
    {
        $array = array('del_status' => 0);
        $data = InventoryVendorModel::orderBy('id', 'DESC')->where($array)->get();
        for ($i = 0; $i < count($data); $i++) {
            $vendor = VendorModel::where(['unique_id' => $data[$i]->vendor_id])->first();
            $data[$i]->vendor_info = $vendor;
        }
        return view('inventory_form_view', ['pagedata' => $data]);
    }

    //update_vendor_sale_rate
    public function update_vendor_sale_rate(Request $request)
    {
        $access = InventoryVendorModel::where("id", request('id'));
        $data = array("sale_rate" => $request->sale_rate);
        $res = $access->update($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //update_vendor_net_quantity
    public function update_vendor_net_quantity(Request $request)
    {
        $access = InventoryVendorModel::where("id", request('id'));
        $data = array("net_quantity" => $request->net_quantity);
        $res = $access->update($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    // delete_inventory
    public function delete_inventory(Request $request)
    {
        $data = InventoryVendorModel::where('id', Request('id'));
        $updData = array(
            'del_status' => 1
        );
        $res = $data->update($updData);
        if ($res) {
            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {
            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    // view full inventory detail
    public function vendor_inventorydetail(string $id)
    {
        $where = array('inventory_vendor.id' => $id,);
        $data = DB::table('inventory_vendor')
            ->leftJoin('master_taxes', 'master_taxes.id', '=', 'inventory_vendor.gst')
            ->leftJoin('master_classes', 'master_classes.id', '=', 'inventory_vendor.class')
            ->leftJoin('master_brand', 'master_brand.id', '=', 'inventory_vendor.brand')
            ->leftJoin('master_qty_unit', 'master_qty_unit.id', '=', 'inventory_vendor.qty_unit')
            ->leftJoin('master_category_sub_three', 'master_category_sub_three.id', '=', 'inventory_vendor.cat_id')
            ->select('master_category_sub_three.cat_id as inv_cat_one', 'master_category_sub_three.sub_cat_id as inv_cat_two', 'master_category_sub_three.sub_cat_id_two as inv_cat_three', 'master_category_sub_three.id as inv_cat_four', 'inventory_vendor.*',  'master_taxes.title as gst_title',  'master_classes.title as class_title',  'master_qty_unit.title as qty_unit_title',  'master_brand.title as brand_title')
            ->where($where)
            ->first();

        $cat_one = ManagecategoryModel::select('name')->where('id', $data->inv_cat_one)->first();
        $cat_two = managesubcategoryModel::select('name')->where('id', $data->inv_cat_two)->first();
        $cat_three = managesubcategorytwoModel::select('title')->where('id', $data->inv_cat_three)->first();
        $cat_four = managesubcategorythreeModel::select('title')->where('id', $data->inv_cat_four)->first();

        $imgwhere = array('item_id' => $data->id, 'del_status' => 0);
        $inv_images = InventoryVenImgModel::select('image', 'alt', 'folder')->where($imgwhere)->get();

        $cat_detail = array('cat_one' => $cat_one->name, 'cat_two' => $cat_two->name, 'cat_three' => $cat_three->title, 'cat_four' => $cat_four->title);
        $arraydata = array('inventory' => $data, 'cat_detail' => $cat_detail, 'inv_images' => $inv_images);

        return view('inventory_detail', $arraydata);
    }

    public function edit_full_inventory_data(string $id)
    {
        $where = array('inventory_vendor.id' => $id,);
        $data = DB::table('inventory_vendor')
            ->leftJoin('master_category_sub_three', 'master_category_sub_three.id', '=', 'inventory_vendor.cat_id')
            ->select('master_category_sub_three.cat_id as inv_cat_one', 'master_category_sub_three.sub_cat_id as inv_cat_two', 'master_category_sub_three.sub_cat_id_two as inv_cat_three', 'master_category_sub_three.id as inv_cat_four', 'master_category_sub_three.form_id as form_id', 'master_category_sub_three.size as size', 'inventory_vendor.*')
            ->where($where)
            ->first();

        $cat_one = ManagecategoryModel::select('name')->where('id', $data->inv_cat_one)->first();
        $cat_two = managesubcategoryModel::select('name')->where('id', $data->inv_cat_two)->first();
        $cat_three = managesubcategorytwoModel::select('title')->where('id', $data->inv_cat_three)->first();
        $cat_four = managesubcategorythreeModel::select('title')->where('id', $data->inv_cat_four)->first();

        $imgwhere = array('item_id' => $data->id, 'del_status' => 0);
        $inv_images = InventoryVenImgModel::select('id', 'image', 'alt', 'folder','dp_status','vendor_id','item_id')->where($imgwhere)->get();

        $route = MasterformrouteModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $classes = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $qty = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $stream = managemasterstreamModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $cat_detail = array('cat_one' => $cat_one->name, 'cat_two' => $cat_two->name, 'cat_three' => $cat_three->title, 'cat_four' => $cat_four->title);
        return view('inventory_full_inv_edit', array('cat_detail' => $cat_detail, 'pagedata' => $data, 'route' => $route, 'inv_images' => $inv_images, 'classes' => $classes, 'gst' => $gst, 'qty' => $qty, 'brand' => $brand, 'colour' => $colour, 'stream' => $stream));
    }

    // edit full inventory
    public function update_full_inventory(Request $request)
    {
        if ($request->file('book_pdf') != NULL) {
            $book_pdf = $request->file('book_pdf');
        } else {
            $book_pdf = $request->old_book_pdf;
        }

        $access = InventoryVendorModel::where("id", request('id'));

        $data = array(
            "book_pdf" => $book_pdf,
            "product_name" =>  $request->product_name,
            "description" =>  $request->description,
            "importer_detail" =>  $request->importer_detail,
            "class" =>  $request->inv_class,
            "color" =>  $request->color,
            "net_quantity" =>  $request->net_quantity,
            "min_qyt" =>  $request->min_qyt,
            "qty_unit" =>  $request->qty_unit,
            "hsncode" =>  $request->hsncode,
            "barcode" =>  $request->barcode,
            "isbn" =>  $request->isbn,
            "net_weight" =>  $request->net_weight,
            "mrp" =>  $request->mrp,
            "discount" =>  $request->discount,
            "discounted_price" =>  $request->discounted_price,
            "sales_price" =>  $request->sales_price,
            "gst" =>  $request->gst,
            "shipping_charges" =>  $request->shipping_charges,
            "edition" =>  $request->edition,
            "size_chart" =>  $request->size_chart,
            "brand" =>  $request->brand,
            "country_of_origin" =>  $request->country_of_origin,
            "manufacturer_detail" =>  $request->manufacturer_detail,
            "packer_detail" =>  $request->packer_detail,
            "pattern_type" =>  $request->pattern_type,
            "sleeve_length" =>  $request->sleeve_length,
            "sleeve_styling" =>  $request->sleeve_styling,
            "stitch_type" =>  $request->stitch_type,
            "occasion" =>  $request->occasion,
            "ornamentation" =>  $request->ornamentation,
            "pattern" =>  $request->pattern,
            "kurta_fabric" =>  $request->kurta_fabric,
            "length" =>  $request->length,
            "neck" =>  $request->neck,
            "set_type" =>  $request->set_type,
            "bottomwear_fabric" =>  $request->bottomwear_fabric,
            "fabric" =>  $request->fabric,
            "fit" =>  $request->fit,
            "kurta_color" =>  $request->kurta_color,
            "bottom_type" =>  $request->bottom_type,
            "bottomwear_color" =>  $request->bottomwear_color,
            "material" =>  $request->material,
            "product_length" =>  $request->product_length,
            "product_type" =>  $request->product_type,
            "product_unit" =>  $request->product_unit,
            "type" =>  $request->type,
            "paper_size" =>  $request->paper_size,
            "paper_finish" =>  $request->paper_finish,
            "material_type" =>  $request->material_type,
            "secondary_camera" =>  $request->secondary_camera,
            "sim" =>  $request->sim,
            "sim_type" =>  $request->sim_type,
            "warranty_service_type" =>  $request->warranty_service_type,
            "no_of_primary_camera" =>  $request->no_of_primary_camera,
            "no_of_secondary_camera" =>  $request->no_of_secondary_camera,
            "primary_camera" =>  $request->primary_camera,
            "screen_length_size" =>  $request->screen_length_size,
            "dual_camera" =>  $request->dual_camera,
            "expandable_storage" =>  $request->expandable_storage,
            "headphone_jack" =>  $request->headphone_jack,
            "internal_memory" =>  $request->internal_memory,
            "operating_system" =>  $request->operating_system,
            "ram" =>  $request->ram,
            "connectivity" =>  $request->connectivity,
            "backpack_style" =>  $request->backpack_style,
            "bag_capacity" =>  $request->bag_capacity,
            "recommended_age" =>  $request->recommended_age,
            "gender" =>  $request->gender,
            "character" =>  $request->character,
            "no_of_compartment" =>  $request->no_of_compartment,
            "product_height" =>  $request->product_height,
            "product_breadth" =>  $request->product_breadth,
            "add_ons" =>  $request->add_ons,
            "body_material" =>  $request->body_material,
            "burner_material" =>  $request->burner_material,
            "no_of_burners" =>  $request->no_of_burners,
            "sole_material" =>  $request->sole_material,
            "fssai_license_number" =>  $request->fssai_license_number,
            "shelf_life" =>  $request->shelf_life,
            "veg_nonveg" =>  $request->veg_nonveg,
            "product_weight" =>  $request->product_weight,
            "weight_unit" =>  $request->weight_unit,
            "water_resistant" =>  $request->water_resistant,
            "laptop_capacity" =>  $request->laptop_capacity,
            "printer_details" =>  $request->printer_details,
            "stream" =>  $request->stream,
            "book_format" =>  $request->book_format,
            "youtube_url" =>  $request->youtube_url,
            "publish_year" =>  $request->publish_year,
            "author" =>  $request->author,
            "status" => $request->status
        );
        $res = $access->update($data);
        $subimgdata = [];
        $invimg = $request->file('image');
        if ($invimg) {
            $count = count($invimg);

            for ($i = 0; $i < $count; $i++) {
                if ($invimg[$i]) {
                    $invimage = $this->upload_image($invimg[$i], 'inventory_vendor/');
                } else {
                    $invimage = "";
                }

                $subimgdata = [
                    'image' => $invimage,
                    'status' => 1,
                    'alt' => "",
                    'created_at' => date('Y-m-d H:i:s'),
                    'item_id' => $request->id,
                    'size_id' => $request->size,
                ];

                $subresimg = InventoryVenImgModel::create($subimgdata);
            }
        }
        if ($res) {
            return redirect('view_inventory_form')->with('success', 'Updated successfully.');
        } else {
            return redirect()->back()->withErrors(['' => 'Somthing went wrong!']);
        }
    }
    
    // updatedpstatus
    public function updatedpstatus(Request $request)
    {
        $where=['vendor_id'=>$request->vendor_id,'item_id'=>$request->item_id];
        $getimagedata = InventoryVenImgModel::where($where)->update(['dp_status'=>0]);
        if($getimagedata){
            $data = InventoryVenImgModel::where('id', Request('image_id'));
            $updData=['dp_status'=>1];
            $res = $data->update($updData);
           if ($res) {
                $response['success'] = 1;
                $response['msg'] = 'Updated successfully!';
                $this->output($response);
            } else {
                $response['success'] = 0;
                $response['msg'] = 'Somthing went wrong!';
                $this->output($response);
            }
        }
    }
  

    // remove full inventory view images
    public function removevendorinvimg(Request $request)
    {
        $data = InventoryVenImgModel::where('id', Request('id'));
        $updData = array( 'del_status' => 1 );
        $res = $data->update($updData);
        if ($res) {
            $response['success'] = 1;
            $response['msg'] = 'Deleted successfully!';
            $this->output($response);
        } else {
            $response['success'] = 0;
            $response['msg'] = 'Somthing went wrong!';
            $this->output($response);
        }
    }

    // view_approved_inventory
    public function view_approved_inventory()
    {
        $array = array('status' => 1, 'del_status' => 0);
        $data = InventoryNewModel::orderBy('id', 'DESC')->where($array)->get();
        for ($i = 0; $i < count($data); $i++) {
            $vendor = VendorModel::where(['unique_id' => $data[$i]->vendor_id])->first();
            $data[$i]->vendor_info = $vendor;
        }
        
        return view('inventory_approved', ['pagedata' => $data]);
    }

    //update_net_quantity
    public function update_net_quantity(Request $request)
    {
        $access = InventoryformsModel::where("id", request('id'));
        $data = array("net_quantity" => $request->net_quantity);
        $res = $access->update($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //update_sale_rate
    public function update_sale_rate(Request $request)
    {
        $access = InventoryformsModel::where("id", request('id'));
        $data = array("sale_rate" => $request->sale_rate);
        $res = $access->update($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //delete inventory
    public function deleteform(Request $request)
    {
        $data = InventoryformsModel::where('id', Request('id'));
        $updData = array(  'del_status' => 1 );
        $res = $data->update($updData);
        if ($res) {
            return redirect()->back()->with('success', 'Deleted successfully.');
        } else {
            return redirect()->withErrors(['' => 'Somthing went wrong!']);
        }
    }

    public function inventorydetail(string $id)
    {
        $where = array('inventory_new.id' => $id,);
        $data = DB::table('inventory_new')
            ->leftJoin('master_taxes', 'master_taxes.id', '=', 'inventory_new.gst')
            ->leftJoin('master_classes', 'master_classes.id', '=', 'inventory_new.class')
            ->leftJoin('master_brand', 'master_brand.id', '=', 'inventory_new.brand')
            ->leftJoin('master_qty_unit', 'master_qty_unit.id', '=', 'inventory_new.qty_unit')
            ->leftJoin('master_category_sub_three', 'master_category_sub_three.id', '=', 'inventory_new.cat_id')
            ->select('master_category_sub_three.cat_id as inv_cat_one', 'master_category_sub_three.sub_cat_id as inv_cat_two', 'master_category_sub_three.sub_cat_id_two as inv_cat_three', 'master_category_sub_three.id as inv_cat_four', 'inventory_new.*',  'master_taxes.title as gst_title',  'master_classes.title as class_title',  'master_qty_unit.title as qty_unit_title',  'master_brand.title as brand_title')
            ->where($where)
            ->first();

        $cat_one = ManagecategoryModel::select('name')->where('id', $data->inv_cat_one)->first();
        $cat_two = managesubcategoryModel::select('name')->where('id', $data->inv_cat_two)->first();
        $cat_three = managesubcategorytwoModel::select('title')->where('id', $data->inv_cat_three)->first();
        $cat_four = managesubcategorythreeModel::select('title')->where('id', $data->inv_cat_four)->first();

        $imgwhere = array('item_id' => $data->id, 'del_status' => 0);
        $inv_images = InventoryImgModel::select('image', 'alt', 'folder')->where($imgwhere)->get();

        $cat_detail = array('cat_one' => $cat_one->name, 'cat_two' => $cat_two->name, 'cat_three' => $cat_three->title, 'cat_four' => $cat_four->title);
        $arraydata = array('inventory' => $data, 'cat_detail' => $cat_detail, 'inv_images' => $inv_images);

        return view('inventory_detail', $arraydata);
    }

    // edit_inventory_data
    public function edit_inventory_data(string $id)
    {
        $where = array('inventory_new.id' => $id,);
        $data = DB::table('inventory_new')
            ->leftJoin('master_category_sub_three', 'master_category_sub_three.id', '=', 'inventory_new.cat_id')
            ->select('master_category_sub_three.cat_id as inv_cat_one', 'master_category_sub_three.sub_cat_id as inv_cat_two', 'master_category_sub_three.sub_cat_id_two as inv_cat_three', 'master_category_sub_three.id as inv_cat_four', 'master_category_sub_three.form_id as form_id', 'master_category_sub_three.size as size', 'inventory_new.*')
            ->where($where)
            ->first();

        $cat_one = ManagecategoryModel::select('name')->where('id', $data->inv_cat_one)->first();
        $cat_two = managesubcategoryModel::select('name')->where('id', $data->inv_cat_two)->first();
        $cat_three = managesubcategorytwoModel::select('title')->where('id', $data->inv_cat_three)->first();
        $cat_four = managesubcategorythreeModel::select('title')->where('id', $data->inv_cat_four)->first();

        $imgwhere = array('item_id' => $data->id, 'del_status' => 0);
        $inv_images = InventoryImgModel::select('id', 'image', 'alt', 'folder','dp_status','item_id')->where($imgwhere)->get();
        $route = MasterformrouteModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $classes = managemasterclassModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $gst = managemastergstModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $qty = managemasterqtyModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $brand = managemasterbrandModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $colour = managemastercolourModel::orderBy('id', 'DESC')->where('del_status', 0)->get();
        $stream = managemasterstreamModel::orderBy('id', 'DESC')->where('del_status', 0)->get();

        $cat_detail = array('cat_one' => $cat_one->name, 'cat_two' => $cat_two->name, 'cat_three' => $cat_three->title, 'cat_four' => $cat_four->title);
        return view('inventory_form_edit', array('cat_detail' => $cat_detail, 'pagedata' => $data, 'route' => $route, 'inv_images' => $inv_images, 'classes' => $classes, 'gst' => $gst, 'qty' => $qty, 'brand' => $brand, 'colour' => $colour, 'stream' => $stream));
    }

    // view_empty_inventory
    public function view_empty_inventory()
    {
        $array = array('status' => 1, 'del_status' => 0);
        $data = InventoryNewModel::orderBy('id', 'DESC')->where($array)->where('qty_available', '<=', 0)->get();
        for ($i = 0; $i < count($data); $i++) {
            $vendor = VendorModel::where(['unique_id' => $data[$i]->vendor_id])->first();
            $data[$i]->vendor_info = $vendor;

            $cat_four = managesubcategorythreeModel::where(['id' => $data[$i]->cat_id])->first();
            $cat_two = managesubcategoryModel::where('id', $cat_four->sub_cat_id)->first();
            $cat_three = managesubcategorytwoModel::where(['id' => $cat_four->sub_cat_id_two])->first();
            $cat_one = ManagecategoryModel::where('id', $cat_four->cat_id)->first();

            $data[$i]->cat_one = $cat_one;
            $data[$i]->cat_two = $cat_two;
            $data[$i]->cat_three = $cat_three;
            $data[$i]->cat_four = $cat_four;
        }

        return view('view_empty_inventory', ['pagedata' => $data]);
    }

    // restock_qty_available
    public function restock_qty_available(Request $request)
    {
        $access = InventoryformsModel::where("id", request('id'));
        $data = array("qty_available" => $request->qty_available);
        $res = $access->update($data);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
}
