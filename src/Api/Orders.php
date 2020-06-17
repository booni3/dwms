<?php

namespace Booni3\Dwms\Api;

class Orders extends Api
{
    public function getOrder($orderId)
    {
        return $this->_get('get-order/' . $orderId);
    }

    public function getOpenOrders()
    {

    }

    public function getOrderByReference(string $orderRef)
    {
        return $this->_get('get-order-by-ref',[
            'order_ref' => $orderRef
        ]);
    }

    public function createOrder(
        $unique_id,
        $store_code,
        $order_ref,
        $shipping_method,
        $requested_ship_date,
        $dispatch_by_date,
        $insured_value,
        $signature_required,
        $shipping_note,
        $full_name,
        $email,
        $telephone,
        $company,
        $address1,
        $address2,
        $city,
        $region,
        $postcode,
        $country_code,
        array $items_array
    ) {
        return $this->_post('create-order',[
            'unique_id' => $unique_id,
            'store_code' => $store_code,
            'order_ref' => $order_ref,
            'shipping_method' => $shipping_method,
            'requested_ship_date' => $requested_ship_date,
            'dispatch_by_date' => $dispatch_by_date,
            'insured_value' => $insured_value,
            'signature_required' => $signature_required,
            'shipping_note' => $shipping_note,
            'full_name' => $full_name,
            'email' => $email,
            'telephone' => $telephone,
            'company_name' => $company,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'region' => $region,
            'postcode' => $postcode,
            'country_code' => $country_code,
            'items' => json_encode($items_array),
        ]);
    }

    public function cancel(int $orderId)
    {
        return $this->_post('cancel-order', ['id' => $orderId]);
    }

    public function cancelBackOrders(int $orderId)
    {
        return $this->_post('cancel-open-backorders', ['id' => $orderId]);
    }

    public function hold(int $orderId)
    {
        return $this->_post('hold-order', ['id' => $orderId]);
    }

    public function unHold(int $orderId)
    {
        return $this->_post('hold-order', ['id' => $orderId]);
    }

}
