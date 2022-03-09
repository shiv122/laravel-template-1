<?php

use Illuminate\Support\Facades\Storage;

for ($i = 0; $i < 1000; $i++) {
    $coupon[] = substr(uniqid(), 6);
}
Storage::put('coupons.txt', implode(',', array_unique($coupon)));
