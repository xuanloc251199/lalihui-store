<?php
    if (!function_exists('formatVND')) {
        function formatVND($amount)
        {
            return number_format($amount, 0, ',', '.') . ' VND';
        }
    }
?>