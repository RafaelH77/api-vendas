<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    /**
     * Listar todos os vendedores
     *
     *  * @OA\Get(
     *     tags={"/seller"},
     *     path="/sellers",
     *     @OA\Response(response="200", description="Sucesso")
     *  )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new Response(
            DB::table('sellers')
                ->leftJoin('orders', 'sellers.id', '=', 'orders.seller_id')
                ->select('sellers.id', 'sellers.name', 'sellers.email', DB::raw('ROUND(SUM(orders.commission), 2) as commission'))
                ->groupBy('sellers.id')
                ->get(), 200
        );
    }

    /**
     * Criar vendedor
     *
     *  * @OA\Post(
     *     tags={"/seller"},
     *     path="/sellers",
     *     @OA\Parameter(
     *          name="name",
     *          in="query",
     *          @OA\Schema(type="string"),
     *          style="form",
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          @OA\Schema(type="string"),
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
        $seller = Seller::create($request->all());
        return new Response($seller, 200);
    }

    /**
     * Mostrar todas as vendas do vendedor
     *
     *   * @OA\Get(
     *     tags={"/seller"},
     *     path="/sellers/{seller}/orders",
     *     @OA\Parameter(
     *          name="seller",
     *          in="path",
     *          @OA\Schema(type="bigint"),
     *          style="form",
     *     ),
     *     @OA\Response(response="200", description="Sucesso")
     *   )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOrders($id)
    {
        return new Response(
            DB::table('sellers')
                ->join('orders', 'sellers.id', '=', 'orders.seller_id')
                ->select('orders.id', 'sellers.name', 'sellers.email', DB::raw('ROUND(orders.commission, 2) as commission'),
                    'orders.value', 'orders.created_at')
                ->where('sellers.id', '=', $id)
                ->get(), 200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
