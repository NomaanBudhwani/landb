<?php

namespace Theme\Landb\Http\Controllers;

use App\Http\Controllers\Controller;
/*use Botble\Theme\Theme;*/

use App\Models\UserCart;
use App\Models\UserCartItem;
use App\Models\UserWishlist;
use App\Models\UserWishlistItems;
use BaseHelper;
use Botble\Ecommerce\Cart\CartItem;
use Botble\Ecommerce\Models\Customer;
use Botble\Ecommerce\Models\Order;
use Botble\Ecommerce\Models\OrderProduct;
use Botble\Ecommerce\Models\Product;
use Botble\Page\Models\Page;
use Botble\Page\Services\PageService;
use Botble\Theme\Events\RenderingSingleEvent;
use Botble\Theme\Events\RenderingHomePageEvent;
use Botble\Theme\Events\RenderingSiteMapEvent;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Theme\Landb\Repositories\ProductsRepository;
use Response;
use SeoHelper;
use SiteMapManager;
use SlugHelper;
use Theme;
use Cart;
use OrderHelper;
/*use Botble\Theme\Http\Controllers\PublicController;*/

class CartController extends Controller
{
  private $user;
  public function __construct() {
    $this->user = auth('customer')->user();
  }

  public function getIndex(){
    $cart = Order::where('id', $this->getUserCart())->with(['products' => function($query){
      $query->with(['product']);
    }])->first();
    $token = OrderHelper::getOrderSessionToken();
    return Theme::scope('cart', ['cart' => $cart])->render();
  }

  public function createCart(Request $request){
    $data = $request->all();
    $product = Product::find($data['product_id']);
    if($product){
      $cartItem = $this->createCartItem($data, $product);
      if($cartItem){
        return response()->json(['message' => 'Product added to cart successfully'], 200);
      }else{
        return response()->json(['message' => 'Server Error'], 500);
      }
    }else{
      return response()->json(['message' => 'Product not found'], 404);
    }
  }

  public function getUserCart(){
    $check = auth('customer')->user()->pendingOrder();
    $token = OrderHelper::getOrderSessionToken();
    if(!$check){
      $cart = Order::create([
          'user_id' => auth('customer')->user()->id,
          'amount' => 0,
          'sub_total' => 0,
          'is_finished' => 0,
          'token' => $token,
          'tax_amount' => 0,
          'discount_amount' => 0,
          'shipping_amount' => 0,
          'currency_id' => 1,
      ]);
      return $cart->id;
    }else{
      return auth('customer')->user()->pendingOrderId();
    }
  }

  public function createCartItem($data, $product){
    $cartId = $this->getUserCart();
    $checkCart = OrderProduct::where('order_id', $cartId)->where('product_id', $product->id)->first();
    if($checkCart){
     $update =  $checkCart->update(['qty' => $checkCart->qty+$data['quantity']]);
     if($update){
       $this->getOrderAndUpdateAmount();
       return true;
     }
    }else{
      $create = OrderProduct::create([
          'order_id' => $cartId,
          'product_id' => $product->id,
          'qty' => $data['quantity'],
          'price' => $product->price,
          'tax_amount' => 0,
          'product_name' => $product->name,
      ]);
      if($create){
        $this->getOrderAndUpdateAmount();
        return true;
      }
    }
    return false;
  }

  public function updateCartQuanity(Request $request){
    $data = $request->all();
    if(!empty($data['id'])){
      if($data['quantity'] == 0){
        $update = OrderProduct::where('id', $data['id'])->delete();
      }else{
        $update = OrderProduct::where('id', $data['id'])->update(['qty' => $data['quantity']]);
        $this->getOrderAndUpdateAmount();
      }
      if($update){
        return response()->json(['message' => 'Cart Updated successfully'], 200);
      }else{
        return response()->json(['message' => 'Server Error'], 500);
      }
    }else{
      return response()->json(['message' => 'Cart Item not found'], 404);
    }

  }

  public function getOrderAndUpdateAmount(){
    $orderId = $this->getUserCart();
    $products = OrderProduct::where('order_id', $orderId)->get();
    $amount = 0;

    foreach ($products as $product) {
      $amount = $amount + ($product->qty * $product->price);
    }
    Order::find($orderId)->update([
        'sub_total' => $amount,
        'amount' => $amount
    ]);
  }
}