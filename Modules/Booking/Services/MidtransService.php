<?php

namespace Modules\Booking\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        $this->configure();
    }

    public function configure()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    public function getSnapToken($params)
    {
        return Snap::getSnapToken($params);
    }
    
    public function createTransaction($params)
    {
        return Snap::createTransaction($params);
    }
    
    public function charge($params)
    {
        return \Midtrans\CoreApi::charge($params);
    }
    
    public function getTransactionStatus($orderId)
    {
        return \Midtrans\Transaction::status($orderId);
    }
}
