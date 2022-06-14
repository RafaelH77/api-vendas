<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Criar venda
     *
     *  * @OA\Post(
     *     tags={"/order"},
     *     path="/orders",
     *     @OA\Parameter(
     *          name="seller_id",
     *          in="query",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *     @OA\Parameter(
     *          name="value",
     *          in="query",
     *          @OA\Schema(type="float"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::create(array_merge($request->all(), ['commission' => round($request['value']*0.085, 2)]));
        $seller = Seller::find($order->seller_id);
        $responseObject = [
          'id' => $order->id,
          'name' => $seller->name,
          'email' => $seller->email,
          'comission' => $order->commission,
          'value' => $order->value,
          'created_at' => $order->created_at,
        ];
        return new Response($responseObject, 200);
    }

    /**
     * Mostrar o total de vendas do dia
     *
     *   * @OA\Get(
     *     tags={"/order"},
     *     path="/orders/total/{date}",
     *     @OA\Parameter(
     *          name="date",
     *          in="path",
     *          example="13-06-2022",
     *          @OA\Schema(type="string"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *   )
     *
     * @param  string  $date
     * @return \Illuminate\Http\Response
     */
    public function showTotalOrders($date)
    {
        return new Response(
            DB::table('orders')
                ->select(DB::raw('SUM(orders.value) as total'))
                ->whereBetween('orders.created_at', [date("Y-m-d H:i:s", strtotime($date)), date("Y-m-d H:i:s", strtotime($date . ' 23:59:59'))])
                ->get(), 200
        );
    }
}
