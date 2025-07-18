<?php

use Illuminate\Support\Facades\App;

if (!function_exists('format_currency')) {
    function format_currency($amount)
    {
        $locale = App::currentLocale();
        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        
        if ($locale === 'hi') {
            return $formatter->formatCurrency($amount, 'INR');
        }
        
        return $formatter->formatCurrency($amount, 'USD');
    }
}