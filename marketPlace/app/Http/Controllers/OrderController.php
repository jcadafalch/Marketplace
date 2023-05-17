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
use App\Models\CompleteOrderLine;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function orderSummary($id)
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

        $data = [
            'orderDate' => $orderDate, 
            'producte' => $products, 
            'shops' => $shops, 
            'order' => $order,
        ]; 
        $html = view('order.orderSummaryPdf', $data)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $downloadAutomatically = env('DOWNLOAD_PDF_AUTOMATICALLY', true);

        if($downloadAutomatically == "true" || $downloadAutomatically)
        {
            // Descarga el archivo PDF generado automáticamente
            $dompdf->stream("pedido".$order->id.".pdf", array("Attachment" => true, 'Content-Type' => 'application/pdf'));
        }else{
            // muestra el pdf en la pagina
            $dompdf->stream("pedido".$order->id.".pdf", array("Attachment" => false)); 
        }
    }

    public function orderLineSummary($id)
    {
        $orderLine = OrderLine::find($id);

        if($orderLine == null)
        {
            return redirect()->route('error.genericError');
        }

        $order = Order::find($orderLine->order_id);
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

        $orderDate = date('d-m-Y', strtotime($order->closed_at));

        return view('order.orderLineSummary', ['categories' => Category::all()], ['producte' => $products, 'orderDate' => $orderDate, 'order' => $order, 'orderLine' => $orderLine]);
    }

    public function orderLinePdf($id)
    {
        $orderLine = OrderLine::find($id);
        $order = Order::find($orderLine->order_id);
        $orderDate = date('d-m-Y', strtotime($order->closed_at));

        $products = $order->getOrderProducts($order->id);
        $products = $products->sortBy('shop_id');

        $shop = Shop::find($orderLine->shop_id);

        $data = [
            'orderDate' => $orderDate, 
            'producte' => $products, 
            'order' => $order, 
            'orderLine' => $orderLine, 
            'shop' => $shop,
        ]; 
        $html = view('order.orderLineSummaryPdf', $data)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $downloadAutomatically = env('DOWNLOAD_PDF_AUTOMATICALLY', true);

        if($downloadAutomatically == "true" || $downloadAutomatically)
        {
            // Descarga el archivo PDF generado automáticamente
            $dompdf->stream("pedido".$order->id.".pdf", array("Attachment" => true, 'Content-Type' => 'application/pdf'));
        }else{
            // muestra el pdf en la pagina
            $dompdf->stream("pedido".$order->id.".pdf", array("Attachment" => false)); 
        }
    }

    public function selledPdf($id){
        $orderLine = OrderLine::find($id);
        $order = Order::find($orderLine->order_id);
        $orderDate = date('d-m-Y', strtotime($order->closed_at));
        $products = ProductOderLine::getProductOfOrderLine($id);

        $user = User::find($order->user_id);

        $data = [
            'orderDate' => $orderDate,
            'producte' => $products, 
            'order' => $order, 
            'orderLine' => $orderLine, 
            'user' => $user]; // optional data array to pass to the vie
        $html = view('order.selledPdf', $data)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $downloadAutomatically = env('DOWNLOAD_PDF_AUTOMATICALLY', true);

        if($downloadAutomatically)
        {
            // Descarga el archivo PDF generado automáticamente
            $dompdf->stream("lineaPedido".$orderLine->id.".pdf", array("Attachment" => true, 'Content-Type' => 'application/pdf'));
        }else{
            // muestra el pdf en la pagina
            $dompdf->stream("lineaPedido".$orderLine->id.".pdf", array("Attachment" => false)); 
        }

    }

    public function selled($id) {

        $orderLine = OrderLine::find($id);

        if($orderLine == null)
        {
            Log::error("No se ha encontrado la linea de producto con id".$id);
            return redirect()->route('error.genericError');
        }

        $order = Order::find($orderLine->order_id);

        $products = ProductOderLine::getProductOfOrderLine($orderLine->order_id);
        if($products == null){
            Log::error("No se han encontrado los productos de la linea de producto con id".$id);
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

        $userId = Auth::user()->id;

        [$orders, $completedOrderLines] = $this->orderPlaced($userId);

        
        return view('order.orderList', ['categories' => Category::all()], ['orders' => $orders, 'completedOrderLines' => $completedOrderLines]);
    }

    
    public function selledList(/*$id*/)
    {
        $user_id = Auth::user()->id;
        $userShop = Shop::where('user_id', '=', $user_id)->first();
        $shops = Shop::all();

        $completedShopOrderLines = $this->salesMade($userShop);

        return view('order.selledList', ['categories' => Category::all()], ['completedShopOrderLines' => $completedShopOrderLines, 'shop' => $userShop]);

    }

    /**
    * La función recupera las líneas de pedido completadas para un ID de usuario dado.
    * 
    * @param userId El ID del usuario para el que se obtienen las líneas de pedido completadas.
    * 
    * @return array de objetos `CompleteOrderLine` que representan líneas de pedido completadas
    * para un usuario determinado. Si no hay líneas de pedido completas, se devuelve una matriz vacía.
    */
   private function orderPlaced($userId)
   {
       $completedOrderLines = [];

       $orders = Order::where('user_id', $userId)->where('in_process', 0)->get();

       if($orders->count() < 0){
           return $completedOrderLines;
       }

       foreach ($orders as $order ) {
           
           $orderLines = OrderLine::where('order_id', $order->id)->get();

           foreach ($orderLines as $orderLine) {
               
               $shop = Shop::find($orderLine->id);
               $products = ProductOderLine::getProductOfOrderLine($orderLine->id);

               $completeOrderLine = new CompleteOrderLine();
               $completeOrderLine->orderDate = $orderDate = strval(date('d-m-Y', strtotime($order->closed_at)));
               $completeOrderLine->orderId = $order->id;
               $completeOrderLine->orderLineId = $orderLine->id;
               $completeOrderLine->orderLineStatus = $this->getOrderLineStatus($orderLine);
               $completeOrderLine->shopName = $shop->name;
               $completeOrderLine->shopLogoUrl = $shop->getLogo()->url;
               $completeOrderLine->price = round($products->sum('price') / 100, 2);
               $completeOrderLine->productsName = implode(", ", $products->pluck('name')->toArray());

               array_push($completedOrderLines, $completeOrderLine);
           }
       }

       return [$orders, $completedOrderLines];
   }

   /**
     * La función recupera líneas de pedido completadas para una tienda determinada y las devuelve como
     * una matriz de objetos CompleteOrderLine.
     * 
     * @param shop El parámetro  es una instancia del modelo Shop, que representa una tienda en la
     * aplicación. Se utiliza para filtrar los registros de OrderLine para incluir solo aquellos que
     * pertenecen a la tienda especificada.
     * 
     * @return array de objetos CompleteOrderLine, que contienen información sobre las líneas de
     * pedido completadas para una tienda determinada.
     */
    private function salesMade($shop)
    {
        $completedOrderLines = [];

        $orderLines = OrderLine::where('shop_id', $shop->id)->get();

        foreach ($orderLines as $orderLine) {
                $order = Order::find($orderLine->order_id);
                $products = ProductOderLine::getProductOfOrderLine($orderLine->id);

                $completeOrderLine = new CompleteOrderLine();
                $completeOrderLine->orderDate = $orderDate = strval(date('d-m-Y', strtotime($order->closed_at)));
                $completeOrderLine->orderId = $order->id;
                $completeOrderLine->orderLineId = $orderLine->id;
                $completeOrderLine->orderLineStatus = $this->getOrderLineStatus($orderLine);
                $completeOrderLine->shopName = $shop->name;
                $completeOrderLine->shopLogoUrl = $shop->getLogo()->url;
                $completeOrderLine->price = round($products->sum('price') / 100, 2);
                $completeOrderLine->productsName = implode(", ", $products->pluck('name')->toArray());

                array_push($completedOrderLines, $completeOrderLine);
        }

        return $completedOrderLines;
    }


   /**
     * La función determina el estado de una línea de pedido en función de su estado de pago y entrega.
     * 
     * @param orderLine  es un objeto que representa un elemento de línea en un pedido.
     * Contiene información como si el artículo está pendiente de pago, si ha sido pagado, enviado,
     * recibido, etc. La función getOrderLineStatus toma este objeto como parámetro y devuelve una
     * cadena que representa el estado del pedido.
     * 
     * @return string que representa el estado de una línea de pedido. Los valores posibles son 
     * "Pendiente de pago", "Pendiente de envio", "Pendiente de entrega", "Entregado", o "Estado desconocido".
     */
    private function getOrderLineStatus($orderLine)
    {
        $status = '';

        if($orderLine->pendingToPay && is_null($orderLine->paid_at) && is_null($orderLine->send_at) && is_null($orderLine->recieved_at)){
            $status = "Pendiente de pago";
        }elseif(!$orderLine->pendingToPay && !is_null($orderLine->paid_at)){
            if(is_null($orderLine->send_at) && is_null($orderLine->recieved_at)){
                $status = "Pendiente de envio";
            } elseif(!is_null($orderLine->send_at) && is_null($orderLine->received_at)){
                $status = "Pendiente de entrega";
            }elseif(!is_null($orderLine->send_at) && !is_null($orderLine->received_at)){
                $status = "Entregado";
            }
        }

        $status = $status ?: "Estado desconocido";

        return $status;
    }
}
