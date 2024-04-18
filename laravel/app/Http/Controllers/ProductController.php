<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(){
        try{
            $productsWithCategory = product::with('category')->get();
            return response()->json(['success'=>true,'product'=>$productsWithCategory],200);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
    public function create(ProductStoreRequest $request){
        try{
            $product = product::create($request->all());
            if($product){
                return response()->json(['success'=>true,"message"=>"Product is Created Successfully"],200);
            }
            else{
                return response()->json(['error'=> 'Product is not created Successfully'],400);
            }

        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
        
    }

    public function update(ProductUpdateRequest $request,$id) {   
        try{
            $product = product::find($id);

            if($product){
                $productUpdate=$product->update($request->all());
                return response()->json(['success'=>true,'message'=> 'Product is Updated Successfully'],200);
            }
            else{
                return response()->json(['error'=> 'There is No Product Which ID is'.$id.'.'],400);
            }
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
    public function delete($id) {
        try{
            $product = product::find($id);
            if($product){
                $productDelete=$product->delete();
                return response()->json(['success'=>true,'message'=> 'Product is Deleted Successfully'],200);
            }
            else{
                return response()->json(['error'=> 'There is No Product Which ID is'.$id.'.'],400);
            }
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
    public function view($id) {
        try{
            $product = product::with('category')->find($id);
            if($product){
                return response()->json(['success'=>true,"product"=>$product],200);
            }
            else{
                return response()->json(['error'=> 'There is No Product which ID is '.$id.'.'],400);
            }
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
}
