<?php

namespace App\Config;

class Exchange
{

    /**
     * Api para obtener el precio de las criptomonedas
     */
    private static $api_crypto = 'https://production.api.coindesk.com/v2/tb/price/ticker?assets=';

    /**
     * Api para comvertir un valor en USD a btc
     */
    private static $api_exchange = 'https://blockchain.info/tobtc?currency=USD&value=';

    private static string $prices = '';
    /**
     * Calcular las comisiones de una transacción en paypal
     */
    final public static function Paypal(string | int | float $input, float $percent = 1.054, float $extra = 0.35): float
    {
        return $input * $percent + $extra;
    }

    /**
     * Obtener el precio de una criptomoneda
     */
    final public static function Crpyto(string $crypto): array
    {
        $crypto = strtoupper($crypto);
        $data = json_decode(file_get_contents(self::$api_crypto . $crypto), true);

        if ($data['statusCode'] != 200) {
            # Invalid crpyto
            return [
                'ok' => false,
                'msg' => 'Invalid crypto currency',
            ];
        } else {
            $data = $data['data'][$crypto];
            return [
                'ok' => true,
                'name' => $data['name'],
                'price' => round($data['ohlc']['c'], 3),
                'change' => round($data['change']['percent'], 3),
            ];
        }

    }

    /**
     * Cambiar un valor dado en USD a BTC
     */
    final public static function Change(float | int $amount): string
    {
        return file_get_contents(self::$api_exchange . $amount);
    }

    /**
     * Obtener los precios del bot
     */
    final public static function Prices(array $credits): string
    {
        if (self::$prices != '') {
            return self::$prices;
        }
        $txt = "💸 <b><u>About premium access</u></b> 💸\n\n<i>  - Antispam: 45's\n  - Access for more gates(charge, auth, mass, etc) and tools\n  - Use in private chat\n  - No more antiflood</i>\n\n<b><u>Prices in %s:</u></b> \n  <i><b>For users:</b>\n    1 month - %s$\n    2 weeks  - %s$\n    1 week    - %s$\n  <b>For groups:</b>\n    <u>Premium</u>: %s$ (Subject to evaluation)\n    <u>Free</u>: %s$ per month\n  <b>Credits:</b>\n%s\n<b><u>Payment methods</u> (1 month membership for users)</b>\n  Btc: <b>%s</b> ₿\n  Ltc: <b>%s</b> Ł\n  Eth: <b>%s</b> Ξ\n  Paypal(%s) %s$\n  Others: <b>Binance, Gift card, Airtm, Payeer</b></i>";
        $pp = ($_ENV['USER_PAYPAL']) ? '<b>✅ON</b>' : '<b>❌OFF</b>';
        $paypal = self::Paypal($_ENV['USER_MONTH']);
        $btc = round(self::Change($_ENV['USER_MONTH']), 7);
        $ltc = round($_ENV['USER_MONTH'] / self::Crpyto('LTC')['price'], 7);
        $eth = round($_ENV['USER_MONTH'] / self::Crpyto('ETH')['price'], 7);
        $credit = '';
        foreach ($credits as $key => $value) {
            $credit .= '    ' . $key . ': ' . $value . "$\n";
        }
        self::$prices = sprintf($txt, $_ENV['CURRENCY'], $_ENV['USER_MONTH'], $_ENV['USER_2WEEKS'], $_ENV['USER_WEEK'], $_ENV['GROUP_P'], $_ENV['GROUP_F'], $credit, $btc, $ltc, $eth, $pp, $paypal);
        return self::$prices;
    }
}
