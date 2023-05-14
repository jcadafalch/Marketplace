<?php

namespace App\Http\Controllers;

session_start();


use Dompdf\Dompdf;
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

        return view('order.orderSummary', ['categories' => Category::all()], ['producte' => $products, 'shops' => $shops, 'orderDate' => $orderDate, 'order' => $order]);
    }

    public function pdf($id)
    {

        $order = Order::find($id);
        $orderDate = date('d-m-Y', strtotime($order->closed_at));

        $products = $order->getOrderProducts($order->id);
        $products = $products->sortBy('shop_id');

        $shops = Shop::whereIn('id', function($query) use ($order) {
            $query->select('shop_id')
            ->from('order_lines')
            ->where('order_id', '=', $order->id);
        })->get();

        $data = ['orderDate' => $orderDate, 'producte' => $products, 'shops' => $shops, 'order' => $order,]; // optional data array to pass to the vie
        $html = view('order.orderSummaryPdf', $data)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("document.pdf", array("Attachment" => false)); // muestra el pdf en la pagina
        
        // Descargue el archivo PDF generado automáticamente
        //$dompdf->stream("pedido.pdf", array("Attachment" => true, 'Content-Type' => 'application/pdf')); // Descarga el pdf directamente
    }

    public function selled(/*$id*/) {
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            $producte = [];
        } else {
            $producte = Product::getInfoFromId($_COOKIE['shoppingCartProductsId']);
        }
        $categories = Category::all();
    return view('order.selled', ['categories' => $categories], ['producte' => $producte, 'shops' => Shop::all(), /*'order' => Order::findOrFile($id)*/]);
    }
}
