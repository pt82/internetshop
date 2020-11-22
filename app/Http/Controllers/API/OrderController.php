<?php

namespace App\Http\Controllers\API;
use App\Mail\OrderClientMail;
use App\Order;
use App\Order_tovar;
use App\Statusorder;
use App\Tovar;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderAdminMail;

class OrderController extends Controller
{
//    загружаем заказы, склеиваем таблицы
    public function orderall ()
    {
        return   DB::table('orders')
            ->Join('statusorders', 'orders.id_statusorders','=','statusorders.id')
            ->Join('receives', 'orders.id_receives','=','receives.id')
            ->select('orders.*', DB::raw("DATE_FORMAT(orders.created_at, '%d-%b-%Y') as data_order"), 'statusorders.status', 'receives.receive')
            ->orderBy('article', 'desc')
            ->get();

    }
//    в магазине оформление заказа
public function orderadd(Request $request)
{
    try {
        $n_order = Order::latest()->first()->article;
        $arr = $request->all();
        $order = $arr[0];
        unset($arr[0]);
        if ($order['fullorder'] === "1") {
            $ord = Order::create([
                'name' => $order['user'],
                'phone' => $order['phone'],
                'email' => $order['email'],
                'id_statusorders' => 1,
                'id_receives' => 1,
                'article' => sprintf("%06d", $n_order + 1),
                'receive' => $order['receive'],

            ]);
            foreach ($arr as $key => $value) {
                $ord->tovars()->attach($arr[$key]['id_tovars'], ['quantity' => $arr[$key]['quantity']]);
            }
        }
        if ($order['fullorder'] === "2") {
            $ord = Order::create([
                'name' => $order['user'],
                'phone' => $order['phone'],
                'email' => $order['email'],
                'id_statusorders' => 1,
                'id_receives' => 2,
                'article' => sprintf("%06d", $n_order + 1),
                'receive' => $order['receive'],
                'adress' => $order['adress'],
                'day_receive' => $order['day_receive'],
                'time_receiveon' => $order['time_receiveon'],
                'time_receiveoff' => $order['time_receiveoff'],
            ]);
            foreach ($arr as $key => $value) {
                $ord->tovars()->attach($arr[$key]['id_tovars'], ['quantity' => $arr[$key]['quantity']]);
            }
        }

        $data = ([
            'article' => $ord->article

        ]);
        $email=$ord->email;
        Mail::to($email)->send(new OrderClientMail($data));
        return response()->json([
            'success' => true,
            'article' => $ord->article
        ]);
    }
    catch (Exception $e) {
        return false;
    }
}
//в магазине добавление в один клик
    public function add_order_oneclick(Request $request)
    {
             $n_order = Order::latest()->first()->article;
            $orderone=new Order();
            $orderone->phone=$request->phone;
            $orderone->id_statusorders=1;
            $orderone->id_receives=1;
            $orderone->article=sprintf("%06d", $n_order + 1);
            $orderone->save();
            $product_in_order= new Order_tovar();
            $product_in_order->id_orders=$orderone->id;
            $product_in_order->id_tovars=$request->id_tovars;
            $product_in_order->quantity=$request->quantity;
            $product_in_order->save();

            if($orderone->save() &&  $product_in_order->save()){
                return response()->json([
                    'success' => true,
                    'article' => $orderone->article
                ]);
            }
    }

//    добавлянем заказ в админ панеле
    public function order_add_admin(Request $request)
    {
        $order= new Order();
        $n_order = Order::latest()->first()->article;
        $arr = $request->all();
        if($request->fullorder===1) {
            $order->article = sprintf("%06d", $n_order + 1);
            $order->id_statusorders = 1;
            $order->id_receives = 1;
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->adress = '';
            $order->receive = $request->receive;
            $order->day_receive = null;
            $order->time_receiveon = null;
            $order->time_receiveoff = null;
        }
        if($request->fullorder===2) {
            $order->article = sprintf("%06d", $n_order + 1);
            $order->id_statusorders = 1;
            $order->id_receives = 2;
            $order->name = $request->name;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->adress = $request->adress;
            $order->receive = $request->receive;
            $order->day_receive = $request->day_receive;
            $order->time_receiveon = $request->time_receiveon;
            $order->time_receiveoff = $request->time_receiveoff;
        }
        $order->save();
        if ($order->save()) {
            return response()->json([
                'success' => true,
                'id_order' => $order->id
            ]);
        }
    }


//обновляем данные в заказе
    public function orderup(Request $request)
    {
        $status_order = Statusorder::find($request->id_statusorders);
        $order = Order::find($request->id);
        if($order->id_receives===1) {
            $order->name = $request->name;
            $order->id_statusorders = $request->id_statusorders;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->article = $request->article;


        }
        if($order->id_receives===2) {
            $order->name = $request->name;
            $order->id_statusorders = $request->id_statusorders;
            $order->phone = $request->phone;
            $order->email = $request->email;

            $order->article = $request->article;
            $order->adress = $request->adress;
            $order->day_receive = $request->day_receive;
            $order->time_receiveon = $request->time_receiveon;
            $order->time_receiveoff = $request->time_receiveoff;
        }
        $order->save();
        $email = $request->get('email');

        $data = ([
            'Status_order' => $status_order->status,
            'article' => $request->article,
        ]);
        if ($request->id_statusorders===5) {

            $arr = Order_tovar::where('id_orders',$request->id)->get();


            foreach ($arr as $key){
              $product=Tovar::find($key->id_tovars);
              $e=$product->balance - $key->quantity;
              $product->balance=$e;
                $product->save();
            }

        }
        if ($request->send_mail){
            Mail::to($email)->send(new OrderAdminMail($data));
             }
        if ($order->save()) {
            return response()->json([

            ], 200);
        }
    }


//в админ панеле выводим заказ
    public function orderone ($id)
    {

        return Order::select('orders.*', DB::raw("DATE_FORMAT(orders.created_at, '%d.%m.%Yг.  %hч %mм') as data_order"))
             ->where('id', $id)
            ->with('tovars')
            ->get();
    }

//    удаляем товар из связаной таблицы
    public function deltovarinorder ($id)
    {
        DB::table('order_tovar')->where('id_tovars', $id)->take(1)->delete();
    }
//добаляем товар в заказ
    public function add_product_in_order (Request $request)
    {

       $product_in_order= new Order_tovar();
       $product_in_order->id_orders=$request->id_orders;
       $product_in_order->id_tovars=$request->id_tovars;
       $product_in_order->quantity=$request->quantity;
       $product_in_order->save();

    }

//    меняем кол-во товаров в заказе
    public function change_quantity (Request $request)
    {
        $product=Tovar::find($request->id_tovars);
        if($product->balance>=$request->quantity) {
            $product_in_order = Order_tovar::find($request->id);
            $product_in_order->quantity = $request->quantity;
            $product_in_order->save();
            return response()->json([
                'success' => true,
            ]);
        }
        else{
           return response()->json([
                'success' => false,
                'balance'=> $product->balance
            ]);
        }
    }


}
