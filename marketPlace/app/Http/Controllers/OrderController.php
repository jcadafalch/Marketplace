<?php

namespace App\Http\Controllers;

session_start();


use Dompdf\Dompdf;
use App\Models\Shop;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use App\Models\ProductOderLine;
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

    public function orderPdf($id)
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

        $dompdf->stream("pedido".$order->id.".pdf", array("Attachment" => false)); // muestra el pdf en la pagina
        
        // Descargue el archivo PDF generado automáticamente
        //$dompdf->stream("pedido".$order->id.".pdf", array("Attachment" => true, 'Content-Type' => 'application/pdf')); // Descarga el pdf directamente
    }

    public function selledPdf($id){
        $orderLine = OrderLine::find($id);
        $order = Order::find($orderLine->order_id);
        $orderDate = date('d-m-Y', strtotime($order->closed_at));
        $products = ProductOderLine::getProductOfOrderLine($id);

        $user = User::find($order->user_id);

        $data = ['orderDate' => $orderDate, 'producte' => $products, 'order' => $order, 'orderLine' => $orderLine, 'user' => $user]; // optional data array to pass to the vie
        $html = view('order.selledPdf', $data)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("lineaPedido".$orderLine->id.".pdf", array("Attachment" => false)); // muestra el pdf en la pagina
        
        // Descargue el archivo PDF generado automáticamente
        //$dompdf->stream("pedido".$order->id.".pdf", array("Attachment" => true, 'Content-Type' => 'application/pdf')); // Descarga el pdf directamente

    }

    public function selled($id) {

        $orderLine = OrderLine::find($id);

        if($orderLine == null)
        {
            return redirect()->route('error.genericError');
        }

        $order = Order::find($orderLine->order_id);

        $products = ProductOderLine::getProductOfOrderLine($orderLine->order_id);
        if($products == null){
            return redirect()->route('error.genericError');
        }

        $orderDate = date('d-m-Y', strtotime($order->closed_at));

        return view('order.selled', ['categories' => Category::all()], ['producte' => $products, 'orderDate' => $orderDate, 'order' => $order, 'orderLine' => $orderLine]);
    }

    /**
     * La función establece una línea de pedido como pagada y actualiza sus atributosPENDIENDTOPAY y
     * Paid_at.
     * 
     * @param id El parámetro "id" es un número entero que representa el ID de la línea de pedido que
     * debe marcarse como pagada.
     */
    public function setPaid($id){
        $orderLine = OrderLine::find($id);

        if($orderLine == null){
            return;
        }

        $orderLine->pendingToPay = 0;
        $orderLine->paid_at = now();
        $orderLine->save();
    }

    
    /**
     * Esta función de PHP establece el atributo "send_at" de un objeto OrderLine en la hora actual.
     * 
     * @param id El parámetro "id" es un número entero que representa el identificador único de una
     * línea de pedido que debe actualizarse con la marca de tiempo actual que indica que se ha
     * enviado.
     */
    public function setSent($id){
        $orderLine = OrderLine::find($id);

        if($orderLine == null){
            return;
        }

        $orderLine->send_at = now();
        $orderLine->save();
    }

     public function orderList()
    {
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            $producte = [];
        } else {
            $producte = Product::getInfoFromId($_COOKIE['shoppingCartProductsId']);
        }
        $categories = Category::all();
        return view('order.orderList', ['categories' => $categories], ['producte' => $producte, 'shops' => Shop::all(), /*'order' => Order::findOrFile($id)*/]);
    }

    public function selledList(/*$id*/)
    {
        $user_id = Auth::user()->id;
        $userShop = Shop::where('user_id', '=', $user_id)->first();
        $shops = Shop::all();
        $categories = Category::all()->where('parent_id', '=', null);
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            $producte = [];
        } else {
            $producte = Product::getInfoFromId($_COOKIE['shoppingCartProductsId']);
        }
        $categories = Category::all();
        return view('order.selledList', ['categories' => $categories], ['producte' => $producte, 'shops' => Shop::all(), /*'order' => Order::findOrFile($id)*/ 'shop' => $userShop]);

    }
}
