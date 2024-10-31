<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function shop()
    {
        $products = Product::all();
        return view('cart.shop', compact('products'));
    }

    public function addToCart($id, Cart $cart)
    {
        $product = Product::findOrFail($id);
        // Cart::add(array(
        //     'id' => $id,
        //     'name' => $product->name,
        //     'price' => $product->price,
        //     'quantity' => 1,
        //     'attributes' => array('image' => $product->image)
        // ));
        // return redirect()->route('shop.cart');
        $cart->add([
            'id' => $product->id,
            'name' => $product->name, 
            'qty' => 1, 
            'price' => $product->price, 
            'options' => [
                'image' => $product->image,
                ]
            ]);
        return redirect()->back()->with('success','Item is Added to Cart Successfully !');
    }

    public function cart(Cart $cart)
    {
        // return view('cart.cart');
        // dd($cart->content());
        // dd(app(Cart::class)->content());
        return view('cart.cart');
        
        
    }
    public function qtyIncrement($rowId, Cart $cart)
    {
        $product =$cart->get($rowId);
        $updateQty = $product->qty + 1;

        $cart->update($rowId, ['qty'=> $updateQty]);
        return redirect()->back()->with('success','Item has been increased from Cart !');
        
    }
    public function qtydecrement($rowId, Cart $cart)
    {
        $product =$cart->get($rowId);
        $updateQty = $product->qty - 1;

        if ($updateQty > 0) {
            $cart->update($rowId, ['qty'=> $updateQty]);
        }

        return redirect()->back()->with('success','Item has been decreased from Cart !');

    }

    public function removeProduct($rowId,Cart $cart)
    {
        // $cart->destroy();
        $cart->remove($rowId);
        return redirect()->back()->with('success','Item has been removed from Cart !');
    }

}
