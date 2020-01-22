<?php
/*
 * ============================================================
 * @package php-bitstorage-api
 * @link https://github.com/bitstorage-dev/php-bitstorage-api
 * ============================================================
 * @copyright 2020
 * @author Vitaliy Larin
 * @license MIT License
 * ============================================================
 * A curl HTTP REST wrapper for the BitStorage currency exchange
 */

namespace BitStorage;

class BitStorageApi
{
    protected $base = 'https://pub.bitstorage.finance/'; // REST url
    protected $wapi = 'https://bitstorage.finance/api/'; //REST url from private method
    protected $httpDebug = false; //  Enable/disable curl debugging information
    protected $curlUserDef = []; // User defined curl options
    protected $api_key; // API key that you created in the bitstorage website member area
    protected $api_secret; // API secret that was given to you when you created the api key

    /***
     * BitStorageApi constructor.
     * No arguments - use file setup
     * 1 argument - file to load config from
     * 2 arguments - api key and api secret
     */
	public function __construct()
    {
        $param = func_get_args();
        switch (count($param)) {
            case 0:
                $this->apiConfigFromFile();
                $this->userCurlConfigFromFile();
                break;
            case 1:
                $this->apiConfigFromFile($param[0]);
                $this->userCurlConfigFromFile($param[0]);
                break;
            case 2:
                $this->api_key = $param[0];
                $this->api_secret = $param[1];
                break;
            default:
                echo 'Please see readme here: https://github.com/bitstorage-dev/php-bitstorage-api';
        }
    }

    /***
     * magic get for private and protected members
     * @param string $member
     * @return string|null
     */
    public function __get(string $member)
    {
        if (property_exists($this, $member)) {
            return $this->$member;
        }
        return null;
    }

    /***
     * magic set for private and protected members
     * @param string $member
     * @param $value
     */
    public function __set(string  $member, $value)
    {
        $this->$member = $value;
    }

    /***
     * the function reads the keys from the configuration file if it is specified
     * or from config.json file if it is not specified
     * @param string|null $file
     */
	private function apiConfigFromFile(string $file = null)
    {
        $file = is_null($file) ? getenv("HOME") . "config.json" : $file;
        if (empty($this->api_key) === false || empty($this->api_secret) === false) {
            return;
        }
        if (file_exists($file) === false) {
            echo "Unable to load config from: " . $file . PHP_EOL;
            echo "API KEY or SECRET not found" . PHP_EOL;
            return;
        }
        $contents = json_decode(file_get_contents($file), true);
        $this->api_key = isset($contents['api-key']) ? $contents['api-key'] : "";
        $this->api_secret = isset($contents['api-secret']) ? $contents['api-secret'] : "";
    }

    /***
     * the function reads the keys from the configuration file if it is specified
     * or from config.json file if it is not specified
     * @param string|null $file
     */
    private function userCurlConfigFromFile(string $file = null)
    {
        $file = is_null($file) ? getenv("HOME") . "config.json" : $file;
        if (count($this->curlUserDef) > 0) {
            return;
        }
        if (file_exists($file) === false) {
            echo "Unable to load config from: " . $file . PHP_EOL;
            echo "No found user curl options" . PHP_EOL;
            return;
        }
        $contents = json_decode(file_get_contents($file), true);
        $this->curlUserDef = isset($contents['curlUserDef']) && is_array($contents['curlUserDef']) ? $contents['curlUserDef'] : [];
    }

    /***
     * The assets endpoint is to a detailed summary for each currency available on the exchange.
     *
     * $api = new BitStorageApi();
     * $api->assets();
     *
     * @return array|mixed
     * @throws Exception
     */
	public function assets()
    {
        return $this->httpRequest("v2/assets");
    }

    /***
     * The ticker endpoint is to a 24-hour pricing and volume summary for each market pair available on the exchange.
     *
     * $api = new BitStorageApi();
     * $api->ticker();
     *
     * @return array|mixed
     * @throws Exception
     */
    public function ticker()
    {
        return $this->httpRequest("v2/ticker");
    }

    /***
     * The order book endpoint is to a complete level 2 order book (arranged by best asks/bids) with full depth returned
     * for a given market pair.
     *
     * -market_pair : A pair such as “LTC_BTC”
     * -depth : Orders depth quantity:[0,5,10,20,50,100,500] Not defined or 0 = full order book
     * -level : Level 1 – Only the best bid and ask. Level 2 – Arranged by best bids and asks. Level 3 – Complete order book, no aggregation.
     *
     * $market_pair = 'LTC_BTC';
     * $depth = 5;
     * $level = 1;
     * $api = new BitStorageApi();
     * $api->orderBook($market_pair, $depth, $level)
     *
     * @param string $market_pair
     * @param int $depth
     * @param int $level
     * @return array|mixed
     * @throws Exception
     */
	public function orderBook(string $market_pair, int $depth = 0, int $level = 3)
    {
        $string = "v2/orderbook/${market_pair}/${depth}/${level}";
		return $this->httpRequest($string);
    }

    /***
     * The trades endpoint to return data on all recently completed trades for a given market pair.
     *
     * -market_pair : A pair such as “LTC_BTC”
     *
     * $market_pair = 'LTC_BTC';
     * $api = new BitStorageApi();
     * $api->trades($market_pair)
     *
     * @param string $market_pair
     * @return array|mixed
     * @throws Exception
     */
	public function trades(string $market_pair)
    {
        $string = "v2/trades/${market_pair}";
		return $this->httpRequest($string);
    }

    /***
     * Obtain the account's balances and fee levels
     *
     * $api = new BitStorageApi();
     * $api->balancesAndInfo();
     *
     * @return array|mixed
     * @throws Exception
     */
    public function balancesAndInfo()
    {
        return $this->httpRequest("balances-and-info","POST",["wapi" => true],true);
    }

    /***
     * Get the account's current open orders, grouped by order side (bid or ask).
     *
     * -currency : Symbol Base currency, 'DOGE'
     * -market : Symbol quote currency, 'BTC'
     *
     * $currency = 'BTC';
     * $market = 'DOGE';
     * $api = new BitStorageApi();
     * $api->openOrders($currency, $market);
     *
     * @param string $currency
     * @param string $market
     * @return array|mixed
     * @throws Exception
     */
    public function openOrders(string $currency, string $market)
    {
        $params = [
            'wapi' => true,
            'currency' => $currency,
            'market' => $market
        ];
        return $this->httpRequest('open-orders',"POST",$params,true);
    }

    /***
     * Get a list of the account's transactions, ordered by date, in descending order.
     *
     * -currency : Symbol Base currency, 'DOGE'
     * -market : Symbol quote currency, 'BTC'
     * -limit : The amount of transactions to return
     * -side : Filters transactions by type ("buy" or "sell").
     *
     * $currency = 'BTC';
     * $market = 'DOGE';
     * $limit = 10;
     * $side = 'buy'
     * $api = new BitStorageApi();
     * $api->userTransactions(string $currency, $market, $limit, $side);
     *
     * @param string $currency
     * @param string $market
     * @param int $limit
     * @param string $side
     * @return array|mixed
     * @throws Exception
     */
    public function userTransactions(string $currency, string $market, int $limit, string $side)
    {
        $params = [
            'wapi' => true,
            'currency' => $currency,
            'market' => $market,
            'limit' => $limit,
            'side' => $side
        ];
        return $this->httpRequest('user-transactions',"POST",$params,true);
    }

    /***
     * Place one or many new orders from your account.
     *
     * -side : Can be "buy" or "sell".
     * -type : Can be "market", "limit" or "stop".
     * -currency : letter currency code, e.g. 'BTC'
     * -market : letter currency code, e.g. 'DOGE'
     * -limit_price : The limit price for the order, in the order currency
     * -stop_price : The stop price for the order, in the order currency.
     * -amount : The amount of base currency to buy or sell.
     * -orders : This parameter is used only if you intend to place multiple orders in one API request
     *
     * -orders : is array [['side'=> '','type'=> '','currency' => '','market' => '', 'limit_price' => '', 'stop_price' => '', 'amount' => ''],[...],...]
     *
     * $orders = null;
     * $side = 'buy';
     * $type = 'limit';
     * $currency = 'BTC';
     * $market = 'DOGE';
     * $amount = 15;
     * $stop_price = 0;
     * $limit_price = 0.00000027;
     * $api = new BitStorageApi();
     * $api->ordersNew($orders,$side, $type, $currency, $market, $limit_price, $stop_price, $amount);
     *
     * @param array $orders
     * @param string $side
     * @param string $type
     * @param string $currency
     * @param string $market
     * @param float $limit_price
     * @param float $stop_price
     * @param float $amount
     * @return array|mixed
     * @throws Exception
     */
    public function ordersNew(array $orders = null, string $side = null, string $type = null, string $currency = null, string $market = null, float $limit_price = null, float  $stop_price = null, float $amount = null)
    {
        if(is_null($orders)) {
            $params = [
                'wapi' => true,
                'side' => $side,
                'type' => $type,
                'currency' => $currency,
                'market' => $market,
                'limit_price' => $limit_price,
                'stop_price' => $stop_price,
                'amount' => $amount
            ];
        } else {
            $params = [
                'wapi' => true,
                'orders' => json_encode($orders)
            ];
        }
        return $this->httpRequest('orders/new',"POST",$params,true);
    }

    /***
     * Edit one or many of the orders that you have placed.
     *
     * -id : The unique identifier of the order that you wish to edit
     * -type : Can be "market", "limit" or "stop".
     * -limit_price : The limit price for the order, in the order currency.
     * -stop_price : The stop price for the order, in the order currency
     * -amount : The amount of base currency to buy or sell
     * -orders : This parameter is used only if you intend to edit multiple orders in one API request
     *
     * -orders : is array [['id'=> '', 'type' => '', 'amount' => '', 'stop_price' => '', 'limit_price' => ''],[...],...]
     *
     * $orders = null;
     * $id = 642741;
     * $type = 'limit';
     * $amount = 15;
     * $stop_price = 0;
     * $limit_price = 0.00000027;
     * $api = new BitStorageApi();
     * $api->ordersEdit($orders, $id, $type, $limit_price, $stop_price, $amount)
     *
     * @param array $orders
     * @param int $id
     * @param string $type
     * @param float $limit_price
     * @param float $stop_price
     * @param float $amount
     * @return array|mixed
     * @throws Exception
     */
    public function ordersEdit(array $orders = null, int $id = null, string $type = null, float $limit_price = null, float $stop_price = null, float $amount = null)
    {
        if(is_null($orders)) {
            $params = [
                'wapi' => true,
                'id' => $id,
                'type' => $type,
                'limit_price' => $limit_price,
                'stop_price' => $stop_price,
                'amount' => $amount
            ];
        } else {
            $params = [
                'wapi' => true,
                'orders' => json_encode($orders)
            ];
        }

        return $this->httpRequest('orders/edit',"POST",$params,true);
    }
    /***
     * Get a list of the account's existing addresses for receiving Crypto currency.
     *
     * -market : The currency (BTC or other) of addresses to return
     * -limit : The amount of addresses to return
     *
     * $market = 'BTC';
     * $limit = 1;
     * $api = new BitStorageApi();
     * $api->getDepositAddress( $market, $limit);
     *
     * @param string $market
     * @param int $limit
     * @return array|mixed
     * @throws Exception
     */
    public function getDepositAddress( string $market, int $limit)
    {
        $params = [
            'wapi' => true,
            'market' => $market,
            'limit' => $limit
        ];
        return $this->httpRequest('btc-deposit-address/get',"POST",$params,true);
    }

    /***
     * Get a new Crypto deposit address for the account
     *
     * -market : The currency (BTC or other) of addresses to return
     *
     * $market = 'BTC';
     * $api = new BitStorageApi();
     * $api->newDepositAddress($market);
     *
     * @param string $market
     * @return array|mixed
     * @throws Exception
     */
    public function newDepositAddress( string $market)
    {
        $params = [
            'wapi' => true,
            'market' => $market
        ];
        return $this->httpRequest('btc-deposit-address/new',"POST",$params,true);
    }

    /***
     * To make a withdrawal from your account to an existing crypto address.
     *
     * -currency : The currency (BTC or other) that you wish to withdraw
     * -amount : The amount that you wish to withdraw, in the above currency.
     * -address : For Crypto withdrawals, the Crypto address to which you wish to withdraw
     *
     * $currency = 'NXB';
     * $amount = 100;
     * $address = 'NF8wC43ZxmpWjCeaAvtpr9FiK8pd83Xvd6';
     * $api = new BitStorageApi();
     * $api->newWithdrawals($currency, $amount, $address);
     *
     * @param string $currency
     * @param float $amount
     * @param string $address
     * @return array|mixed
     * @throws Exception
     */
    public function newWithdrawals( string $currency, float $amount, string $address)
    {
        $params = [
            'wapi' => true,
            'currency' => $currency,
            'amount' => $amount,
            'address' => $address
        ];
        return $this->httpRequest('withdrawals/new',"POST",$params,true);
    }

    /***
     * Http request curl
     * You can't call this function directly, use the helper functions
     *
     * @see ticker()
     * @see assets()
     * and other..
     *
     * @param string $url
     * @param string $method
     * @param array $params
     * @param bool $signed
     * @return array|mixed|string
     * @throws Exception
     */
    private function httpRequest(string $url, string $method = "GET", array $params = [],  bool $signed = false)
    {
        if (function_exists('curl_init') === false) {
            throw new \Exception("cURL is not installed!");
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, $this->httpDebug);
        // signed request
        if ($signed === true) {
            if (empty($this->api_key)) {
                throw new \Exception("signedRequest error: API Key not found!");
            }
            if (empty($this->api_secret)) {
                throw new \Exception("signedRequest error: API Secret not found!");
            }
            if (isset($params['wapi'])) {
                unset($params['wapi']);
                $base = $this->wapi;
            } else {
                $base = $this->base;
            }
            $nonce = time();
            $params['api_key'] = $this->api_key;
            $params['nonce'] = $nonce;
            $param = base64_encode(json_encode($params));
            $signature = hash_hmac('sha256', $param, $this->api_secret);
            $params['signature'] = $signature;
            curl_setopt_array($curl, [
                CURLOPT_URL => $base . $url,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $params
            ]);
        }
        // public request with params
        else if (count($params) > 0) {
            $query = http_build_query($params, '', '&');
            curl_setopt($curl, CURLOPT_URL, $this->base . $url . '?' . $query);
        }
        // base url, no params
        else {
            curl_setopt($curl, CURLOPT_URL, $this->base . $url);
        }
        curl_setopt($curl, CURLOPT_USERAGENT, "Codular Sample cURL Request");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        // set user defined curl options
        foreach ($this->curlUserDef as $key => $value) {
            curl_setopt($curl, constant($key), $value);
        }
        $output = curl_exec($curl);
        // Check error
        if (curl_errno($curl) > 0) {
            echo 'Curl error: ' . curl_error($curl) . "\n";
            return [];
        }
        curl_close($curl);
        $json = json_decode($output, true);
        if (isset($json['errors'][0]['message'])) {
            // should always output error
            return "signedRequest error: {$json['errors'][0]['message']}" . PHP_EOL;
        } else
        return $json;
    }
}
