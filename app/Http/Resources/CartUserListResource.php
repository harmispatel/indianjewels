<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartUserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $carts = isset($this->resource['carts']) ? $this->resource['carts'] : [];
        $total_qty = isset($this->resource['total_qty']) ? $this->resource['total_qty'] : 0;

        $main_array = [];
        $cart_array = [];
        foreach($carts as $cart)
        {
            $data['id'] = (isset($cart->id)) ? $cart->id : '';
            $data['design_id'] = (isset($cart->design_id)) ? $cart->design_id : '';
            $data['design_name'] = (isset($cart->design_name)) ? $cart->design_name : '';
            $data['quantity'] = (isset($cart->quantity)) ? $cart->quantity : '';
            $data['gold_type'] = (isset($cart->gold_type)) ? $cart->gold_type : '';
            $data['gold_color'] = (isset($cart->gold_color)) ? $cart->gold_color : '';
            $data['price'] = (isset($cart->designs->price)) ? $cart->designs->price : 0;
            $data['image'] = isset($cart->designs) ?  asset('public/images/uploads/item_images/'.$cart->designs->code.'/'.$cart->designs->image) : '' ;
            $data['gross_weight_22k'] = isset($cart->designs['gweight4']) ?  $cart->designs['gweight4'] : '' ;
            $data['gross_weight_20k'] = isset($cart->designs['gweight3']) ?  $cart->designs['gweight3'] : '' ;
            $data['gross_weight_18k'] = isset($cart->designs['gweight2']) ?  $cart->designs['gweight2'] : '' ;
            $data['gross_weight_14k'] = isset($cart->designs['gweight1']) ?  $cart->designs['gweight1'] : '' ;
            $data['total_price_14k'] = isset($cart->designs->total_price_14k) ? round($cart->designs->total_price_14k,2) : 0;
            $data['total_price_18k'] = isset($cart->designs->total_price_18k) ? round($cart->designs->total_price_18k,2) : 0;
            $data['total_price_20k'] = isset($cart->designs->total_price_20k) ? round($cart->designs->total_price_20k,2) : 0;
            $data['total_price_22k'] = isset($cart->designs->total_price_22k) ? round($cart->designs->total_price_22k,2) : 0;
            $cart_array[] = $data;
        }
        $main_array['cart_items'] = $cart_array;
        $main_array['total_quantity'] = $total_qty;

        return $main_array;
    }
}
