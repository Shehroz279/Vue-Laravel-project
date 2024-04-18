<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategory;
use App\Http\Requests\Category\UpdateCategory;
use App\Mail\SampleMail;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index() {
        try{

            // Storage::disk('local')->put('example.txt', 'Contents');
            // $categories = Category::with('products')->get();
            $categories = Category::all();

            if($categories){
                return response()->json(['success'=>true,"category"=>$categories],200);
            }
            else{
                return response()->json(["error"=> "Not find Category Table"],400);
            }
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
    public function create(StoreCategory $request) {
        try{
            $category = Category::create($request->all());
            if($category){
                return response()->json(['success'=>true,'message'=> 'Category is Created Successfully'],200);
            }
            else{
                return response()->json(['error'=> 'Category is Not created'],400);
            }
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
    public function update(UpdateCategory $request,$id) {   
        try{
            // $path = $request->file('avatar')->storeAs('public','myfile.png');
            // // dd($path);
            $category = Category::find($id);
            
            if($category){
                $categoryUpdate=$category->update($request->all());
                return response()->json(['success'=>true,'message'=> 'Category is Updated Successfully'],200);
            }
            else{
                return response()->json(['error'=> 'There is No Category which ID is '.$id.'.'],400);
            }
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
    public function delete($id) {
        try{
            $category = Category::find($id);
            if($category){
                $categoryDelete=$category->delete();
                return response()->json(['success'=>true,'message'=> 'Category is Deleted Successfully'],200);
            }
            else{
                return response()->json(['error'=> 'There is No Category which ID is '.$id.'.'],400);
            }
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
    public function view($id) {
        try{
            $categoryWithProduct = Category::with('products')->find($id);
            if($categoryWithProduct){
                return response()->json(['success'=>true,'category'=> $categoryWithProduct],200);
            }
            else{
                return response()->json(['error'=> 'There is No Category which ID is '.$id.'.'],400);
            }
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
    public function count($id) {
        try{

            $categoryCheck = Category::find($id);
            
            if($categoryCheck){
                $categoryProductCount=$categoryCheck->products->count();
                return response()->json(['success'=>true,'count'=> $categoryProductCount],200);
            }
            else{
                return response()->json(['error'=> 'Category Not Found'],400);
            }
        }
        catch(\Exception $e){   
            return response()->json(['error'=>$e->getMessage()],400);
        }
    }
}
