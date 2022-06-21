<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        \Gate::authorize('view','orders');
        $orders = Order::latest()->paginate();
        return OrderResource::collection($orders);

    }
    public function show($id)
    {
        \Gate::authorize('view','orders');
        $order = Order::find($id);
        return  new OrderResource($order) ;

    }

    public function export()
    {
        \Gate::authorize('view','orders');
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=orders.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

         $orders = Order::latest()->get();
        $columns =  ['id','Name','email','Product_name','Price','Quantity'] ;
        $callback = function() use ($orders, $columns) {

            $file = fopen('php://output', 'w');
            fputcsv($file,$columns);
            foreach ($orders as $order) {
                $row['Id']  = $order->id;
                $row['Name']    = $order->first_name . ' '.$order->last_name;
                $row['email']= $order->email;
                $row['Product_name']    = '';
                $row['Price']  = '';
                $row['Quantity']  = '';

                fputcsv($file, array($row['Id'], $row['Name'],$row['email'], $row['Product_name'], $row['Price'], $row['Quantity']));
                foreach ($order->orderItems as $order_item) {

                    fputcsv($file, array('','', $order_item->product_name, $order_item->price, $order_item->quantity));

                }
            }

            fclose($file);
        };
        return response()->stream($callback , 200, $headers);
    }
}
