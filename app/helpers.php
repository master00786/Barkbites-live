<?php

if (!function_exists('currency')) {
    function currency()
    {
        return config('app.currency_symbol', '₹');
    }
}
