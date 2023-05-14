<?php

namespace App\Http\Controllers;

session_start();

use App\Models\Shop;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function show($id)
    {
        $order = Order::find($id);

        if($order == null)
        {
            return redirect()->route('error.genericError');
        }

        if(Auth::id() != $order->user_id){
            return redirect()->route('error.genericError');
        }

        $products = $order->getOrderProducts($order->id);

        if($products == null){
            return redirect()->route('error.genericError');
        }

        $products = $products->sortBy('shop_id');

        $shops = Shop::whereIn('id', function($query) use ($order) {
            $query->select('shop_id')
            ->from('order_lines')
            ->where('order_id', '=', $order->id);
        })->get();

        $orderDate = date('d-m-Y', strtotime($order->closed_at));

        return view('order.orderSummary', ['categories' => Category::all()], ['producte' => $products, 'shops' => $shops, 'orderDate' => $orderDate]);
    }
}
