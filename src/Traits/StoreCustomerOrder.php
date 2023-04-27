<?php

namespace Astrogoat\Storefront\Traits;

use Astrogoat\Storefront\Models\StoreOrder;
use Astrogoat\Storefront\Models\StoreOrderStoreProduct;
use Astrogoat\Storefront\Models\StorePayment;

trait StoreCustomerOrder
{
    public $customer;
    public $address;

    protected $rules = [
        'customer.name' => 'required|min:6',
        'customer.email' => 'required|email',
        'customer.phone' => 'required',
        'address.street' => 'required|min:3',
        'address.city' => 'required|min:3',
        'address.state' => 'required|min:3',
        'address.country' => 'required',
    ];

    public function updatePayment($reference, $status, $channel, $bank, $currency, $gateway_response): bool
    {
        $payment = StorePayment::where('reference', $reference)->first();

        if(! is_null($payment)) {
            $payment->status = $status;
            $payment->method = $channel;
            $payment->bank = $bank;
            $payment->currency = $currency;
            $payment->gateway_response = $gateway_response;
            $payment->save();

            return true;
        }

        return false;
    }

    public function storeOrder($transactionReference): void
    {
        // save order
        $order = StoreOrder::create([
            'customer_name' => $this->customer['name'],
            'customer_email' => $this->customer['email'],
            'customer_phone' => $this->customer['phone'],
            'customer_street' => $this->address['street'],
            'customer_city' => $this->address['city'],
            'customer_state' => $this->address['state'],
            'customer_country' => $this->address['country'],
            'reference' => $transactionReference,
        ]);

        // save payment
        $payment = StorePayment::create([
            'order_id' => $order->id,
            'status' => 'pending',
            'amount' => $this->getTotal() * 100,
            'method' => 'momo',
            'reference' => $transactionReference,
        ]);

        // save order_products
        foreach ($this->getItems() as $item) {
            StoreOrderStoreProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => 1,
            ]);
        }
    }
}
