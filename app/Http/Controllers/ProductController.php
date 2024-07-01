<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return view('product.index');
    }
    public function fetchProducts(Request $request){
        $shopifyA = new ShopifyController('A');
        $products = $shopifyA->listProducts($request);
        return json_encode($products);
    }
    public function importProduct(Request $request){
        $request_data['product'] = $request->data;
//        unset($request_data['product']['id']);
        $shopifyB = new ShopifyController('B');
        $check =  $shopifyB->createProduct($request_data);
        return json_encode($check);
    }
}
