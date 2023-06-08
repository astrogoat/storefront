<?php

namespace Astrogoat\Storefront\Http\Controllers;

use Astrogoat\Paystack\Settings\PaystackSettings;
use Astrogoat\Storefront\Models\StoreOrder;
use Astrogoat\Storefront\Settings\StorefrontSettings;
use Astrogoat\Storefront\Storefront;
use Helix\Lego\Settings\ContactInformationSettings;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;

class StorefrontOrderController
{
    public function invoice(StoreOrder $storeOrder)
    {
        $client = new Party([
            'name' => tenant()->name,
            'phone' => app(ContactInformationSettings::class)->contact_phone_number,
            'custom_fields' => [
                'email' => app(ContactInformationSettings::class)->contact_email,
                'address' => app(ContactInformationSettings::class)->address,
            ],
        ]);

        $customer = new Party([
            'name' => $storeOrder->customer_name,
            'phone' => $storeOrder->customer_phone,
            'custom_fields' => [
                'email' => $storeOrder->customer_email,
                'order number' => $storeOrder->reference,
                'address' => $storeOrder->customer_street . ', ' . $storeOrder->customer_city . ', ' . $storeOrder->customer_state . ', ' . $storeOrder->customer_country,
            ],
        ]);

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('receipt')
            ->series($storeOrder->reference)
            // ability to include translated invoice status
            // in case it was paid
            ->status(__('invoices::invoice.paid'))
//            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
//            ->payUntilDays(14)
            ->currencySymbol(settings(StorefrontSettings::class, 'currency'))
            ->currencyCode(settings(StorefrontSettings::class, 'currency'))
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($client->name . ' ' . $customer->name)
            ->notes($notes);
        //            ->logo(public_path('vendor/invoices/sample-logo.png'))
        // You can additionally save generated invoice to configured disk
        //            ->save('public');

        foreach ($storeOrder->orderedProducts as $orderedProduct) {
            $item = (new InvoiceItem())
                ->title($orderedProduct->product->title)
//                ->description('Your product or service description')
                ->pricePerUnit($orderedProduct->product->price)
                ->quantity(1);
            //                [
            //                (new InvoiceItem())
            //                    ->title('Service 1')
            //                    ->description('Your product or service description')
            //                    ->pricePerUnit(47.79)
            //                    ->quantity(1),
            //            (new InvoiceItem())->title('Service 2')->pricePerUnit(71.96)->quantity(2),
            //            (new InvoiceItem())->title('Service 4')->pricePerUnit(87.51)->quantity(7)->discount(4)->units('kg'),
            //            (new InvoiceItem())->title('Service 5')->pricePerUnit(71.09)->quantity(7)->discountByPercent(9),
            //            (new InvoiceItem())->title('Service 9')->pricePerUnit(33.24)->quantity(6)->units('m2'),
            //            (new InvoiceItem())->title('Service 14')->pricePerUnit(160)->units('hours'),
            //            (new InvoiceItem())->title('Service 20')->pricePerUnit(55.80),
            //            ];

            $invoice->addItem($item);
        }

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }

    public function track($reference)
    {

    }
}
