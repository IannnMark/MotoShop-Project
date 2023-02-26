<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Redirect;
use Auth;
use App\DataTables\ProductDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $input = $request->validate([

            'description' => 'required|max:255',
            'sell_price' => 'required|min:2',
            'product_img' => 'mimes:png,jpg,gif,svg',
        ]);

        if($file = $request->hasFile('product_img')) {
            $file = $request->file('product_img') ;
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path().'/img_path' ;
            $input['product_img'] = 'img_path/'.$fileName;

            $products = Product::create($input);
            $file->move($destinationPath,$fileName);
           }

         return redirect()->route('getProduct')->with('Success!', 'New Product has been Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $products = Product::findOrFail($id);
        return view('product.edit', compact('products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $products, $id)
    {
         $products = Product::find($id);

        $input = $request->all();

         $request->validate([

            'description' => 'required|max:255',
            'sell_price' => 'required|min:2',
            'product_img' => 'mimes:png,jpg,gif,svg',
            
        ]);

        if($file = $request->hasFile('product_img')) {
            $file = $request->file('product_img');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path().'/img_path' ;
            $input['product_img'] = 'img_path/'.$fileName;
            $file->move($destinationPath, $fileName);
        }

            $products->description = $request->description;
            $products->sell_price = $request->sell_price;
            $products->product_img = $request->$fileName;

            $products->update($input);
            return redirect()->route('getProduct')->with('Success', 'Product Record Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::find($id)->delete();

        return redirect()->route('products.index')->with('Product Successfully Removed');
    }

     public function getProduct(ProductDataTable $dataTable){


        $products = Product::with([])->get();
        return $dataTable->render('product.products');   }
}
