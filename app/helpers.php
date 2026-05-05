<?php

if (! function_exists('money_fdj')) {
    /**
     * Formate un montant déjà exprimé en francs djiboutiens (Fdj).
     *
     * @param  float|string|null  $amountFdj
     */
    function money_fdj($amountFdj, int $decimals = 0): string
    {
        $fdj = round((float) ($amountFdj ?? 0), $decimals);
        $suffix = config('nexshop.currency_suffix', 'Fdj');

        return number_format($fdj, $decimals, ',', ' ').' '.$suffix;
    }
}

if (! function_exists('euros_to_fdj')) {
    /**
     * Montant numérique en Fdj (sans formatage). Les valeurs en base sont en Fdj : pas de conversion.
     *
     * @param  float|string|null  $amountFdj
     */
    function euros_to_fdj($amountFdj, int $decimals = 2): float
    {
        return round((float) ($amountFdj ?? 0), $decimals);
    }
}
