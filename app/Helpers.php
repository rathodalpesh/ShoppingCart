<?php
use Illuminate\Support\Facades\Auth;

//user active website display
function getPriceSymbol()
{
    if (Auth::check()) {
        $user = Auth::user();
        if ($user['currency_symbols'] !== "" ) {
            return $user['currency_symbols'];
        }
    }
    return "";
}

?>
