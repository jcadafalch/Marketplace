<?php

namespace App\Http\Controllers;

session_start();


use Carbon\Carbon;
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

    /**
     * La función recupera y muestra el resumen de un pedido, incluidos sus productos y tiendas
     * asociadas, y redirige a una página de error si es necesario.
     * 
     * @param id El parámetro `` es el ID del pedido que debe mostrarse en el resumen del pedido. Se
     * utiliza para recuperar los detalles del pedido de la base de datos.
     * 
     * @return view llamada 'order.orderSummary' con una serie de datos que incluyen todas las
     * categorías, los productos en el pedido, las tiendas donde se compraron los productos, la fecha
     * del pedido y el pedido en sí. Si el pedido o los productos son nulos, o si el usuario
     * autenticado no es el propietario del pedido, la función redirige a una página de error genérica.
    */
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

    /**
     * La función genera un resumen en PDF de un pedido con sus productos y tiendas.
     * 
     * @param id El parámetro "id" es el identificador del pedido que se está utilizando para generar
     * un resumen en PDF.
    */
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

        $this->showPdf($html, "pedido".$order->id.".pdf");
    }

    /**
     * Esta función recupera y muestra un resumen de una línea de pedido, incluido el pedido asociado,
     * los productos y la fecha del pedido, al mismo tiempo que verifica la autenticación y el manejo
     * de errores.
     * 
     * @param id El parámetro "id" es el identificador de una línea de pedido que se utiliza para
     * recuperar información sobre esa línea de pedido específica.
     * 
     * @return una vista llamada 'order.orderLineSummary' con una matriz de datos que incluye todas las
     * categorías, los productos en el pedido, la fecha del pedido, el pedido en sí y la línea
     * específica del pedido que se resume. Si falta alguno de los datos necesarios o el usuario no
     * está autorizado, la función redirige a una página de error genérica.
    */
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

    /**
     * Esta función genera un resumen en PDF de una línea de pedido con su pedido asociado y la
     * información de la tienda.
     * 
     * @param id El parámetro "id" es el identificador de la línea de pedido específica que debe
     * generarse como PDF.
    */
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

        $this->showPdf($html, "pedido".$order->id.".pdf");
    }

    /**
     * Esta función genera un archivo PDF para una línea de pedido específica con información sobre el
     * pedido, los productos y el usuario.
     * 
     * @param id El parámetro "id" es el identificador de una línea de pedido, que se utiliza para
     * recuperar información sobre el pedido, los productos y el usuario asociado con esa línea de
     * pedido. Esta información luego se utiliza para generar un documento PDF que contiene detalles
     * sobre la línea de pedido.
    */
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
            'user' => $user];
        $html = view('order.selledPdf', $data)->render();

        $this->showPdf($html, "lineaPedido".$orderLine->id.".pdf");

    }

    /**
     * Esta función recupera información sobre un pedido de producto vendido y la muestra en una vista.
     * 
     * @param id El parámetro "id" es el identificador de la línea de pedido que debe recuperarse y
     * mostrarse.
     * 
     * @return view denominada "order.selled" con una matriz de datos que incluye todas las
     * categorías, los productos de una línea de pedido, la fecha del pedido, el pedido en sí y la
     * línea del pedido.
    */
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

    /**
     * Esta función recupera los pedidos y las líneas de pedido completadas para un usuario específico
     * y los devuelve a la vista junto con todas las categorías.
     * 
     * @return view llamada 'order.orderList' con una matriz de datos que incluye todas las
     * categorías, los pedidos realizados por el usuario autenticado y las líneas de pedido
     * completadas.
    */
    public function orderList()
    {

        $userId = Auth::user()->id;

        [$orders, $completedOrderLines] = $this->orderPlaced($userId);

        
        return view('order.orderList', ['categories' => Category::all()], ['orders' => $orders, 'completedOrderLines' => $completedOrderLines]);
    }

    /**
     * Esta función recupera una lista de líneas de pedido de tienda completadas para la tienda del
     * usuario autenticado.
     * 
     * @return view denominada `selledList` con una matriz de
     * datos que incluye todas las categorías, las líneas de pedido de la tienda completadas y la
     * tienda del usuario.
    */
    public function selledList()
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
               
               $shop = Shop::find($orderLine->shop_id);
               
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
     * Esta función genera y muestra o descarga un archivo PDF desde HTML utilizando la biblioteca
     * Dompdf en PHP.
     * 
     * @param html El contenido HTML que debe convertirse en un archivo PDF.
     * @param fileName El nombre del archivo PDF que se generará y descargará o mostrará.
    */
    private function showPdf($html, $fileName)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $downloadAutomatically = env('DOWNLOAD_PDF_AUTOMATICALLY', true);

        if($downloadAutomatically)
        {
            // Descarga el archivo PDF generado automáticamente
            $dompdf->stream($fileName, array("Attachment" => true, 'Content-Type' => 'application/pdf'));
        }else{
            // muestra el pdf en la pagina
            $dompdf->stream($fileName, array("Attachment" => false)); 
        }
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

        $orderLine = $this->checkOrderLineStatus($orderLine);

        if($orderLine->pendingToPay && is_null($orderLine->paid_at)){
            $status = "Pendiente de pago";
        }elseif($orderLine->paid_at != null && is_null($orderLine->send_at)){
                $status = "Pendiente de envio";
        } elseif($orderLine->send_at != null && is_null($orderLine->recieved_at)){
                $status = "Pendiente de entrega";
        }elseif(!is_null($orderLine->recieved_at)){
                $status = "Entregado";
        }
        

        $status = $status ?: "Estado desconocido";

        return $status;
    }

    /**
     * La función verifica el estado de una línea de pedido y la actualiza según ciertas condiciones.
     * 
     * @param orderLine El objeto de línea de pedido que debe verificarse y actualizarse si es
     * necesario.
     * 
     * @return orderLine actualizado después de verificar y actualizar su estado según
     * ciertas condiciones.
    */
    private function checkOrderLineStatus($orderLine){
        $order = Order::find($orderLine->shop_id);

        $orderDate = Carbon::createFromFormat('Y-m-d H:i:s', $order->closed_at);

        if($orderLine->pendingToPay && $orderDate->addWeek()->isPast())
        {
            $orderLine->pendingToPay = 0;
            $orderLine->paid_at = now();
            $orderLine->save();
            Log::info("La linea de pedido con id: \"".$orderLine->id."\" se ha marcado como pagada, después de estar más de 1 semana con el estado \"Pendiente de pago\"");
        }

        if($orderLine->paid_at != null &&  $orderLine->send_at == null){
            $orderLinePaidAtDate = Carbon::createFromFormat('Y-m-d H:i:s', $orderLine->paid_at);

            if($orderLinePaidAtDate->addWeek()->isPast()){
                $orderLine->send_at = now();
                $orderLine->save();
                Log::info("La linea de pedido con id: \"".$orderLine->id."\" se ha marcado como enviado, después de estar más de 1 semana con el estado \"Pendiente de envio\"");
            }
        }

        if($orderLine->send_at != null && $orderLine->recieved_at == null){
            $orderLineSentAtDate = Carbon::createFromFormat('Y-m-d H:i:s', $orderLine->send_at);
            if($orderLineSentAtDate->addWeek()->isPast()){
                $orderLine->recieved_at = now();
                $orderLine->save();
                Log::info("La linea de pedido con id: \"".$orderLine->id."\" se ha marcado como entregado, después de estar más de 1 semana con el estado \"Pendiente de entrega\"");
            }
        }

        return $orderLine;
    }
}
