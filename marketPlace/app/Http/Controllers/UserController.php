<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use App\Http\Requests\UserEdit;
use App\Models\ProductOderLine;
use App\Models\CompleteOrderLine;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Http\FormRequest;

class UserController extends Controller
{
    public function profile()
    {
        return view('user.profile', ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function userProfile()
    {
        $user_id = Auth::user()->id;
        $userShop = Shop::where('user_id', '=', $user_id)->first();
        $shops = Shop::all();
        $categories = Category::all()->where('parent_id', '=', null);

        $completedOrderLines = $this->orderPlaced($user_id);
        $completedShopOrderLines = $this->salesMade($userShop);

        return view('user.userProfile', ['categories' =>  $categories],['shop' => $userShop, 'completedOrderLines' => $completedOrderLines, 'completedShopOrderLines' => $completedShopOrderLines]);
    }

    public function editProfile(UserEdit $request)
    {
        $request->validated();

        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        if ($request->file('profilePhoto') !== null) {
            $extension = $request->file('profilePhoto')->getClientOriginalExtension();
            $img = 'profileImg' . Auth::user()->id . '.' .  $extension;
            $request->file('profilePhoto')->storeAs('public/img/profile', $img);
            $user->path = $img;
        }

        if ($request->string('userName') !== null && $request->string('userName')->length() > 0) {
            $user->name = $request->string('userName');
        }

        if ($request->string('password') !== null && $request->string('password')->length() > 0) {
            if (!Hash::check($request->get('password'), $user->password)) {
                return back()->with('error', "La contraseña actual no es valida");
            } else {
                $user->password = Hash::make($request->string('newPassword'));
            }
        }

        $user->save();
        Log::info("Editado información de usuario:" . $user);
        return redirect()->route('user.userProfile', ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        setcookie("shoppingCartProductsId", "", time() - 3600);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
        Log::info("Cerrado sesión se usuario");
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

        return $completedOrderLines;
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
