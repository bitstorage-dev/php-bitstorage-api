# PHP BitStorage API

This project will allow you to create your own projects for interaction with the exchange [BitStorage](https://bitstorage.finance/api-docs).

#### Installation
```
git clone https://github.com/bitstorage-dev/php-bitstorage-api.git .
composer update
```

<details>
 <summary>Click for help with installation</summary>

## Install Composer
If the above step didn't work, install composer and try again.
#### Debian / Ubuntu
```
sudo apt-get install curl php-curl
curl -s http://getcomposer.org/installer | php
php composer.phar install
```
Composer not found? Use this command instead:
```
php composer.phar update
```

#### Windows:
[Download installer for Windows](https://github.com/bitstorage-dev/php-bitstorage-api/#installing-on-windows)

</details>

#### Getting started
```php
require 'vendor/autoload.php';
// 1. config in home directory
$api = new BitStorage\BitStorageApi();
// 2. config in specified file
$api = new BitStorage\BitStorageApi( "somefile.json" );
// 3. config by specifying api key and secret
$api = new BitStorage\BitStorageApi("<api key>","<secret>");
```

#### Info About all currency exchange
```php
$assets = $api->assets();
print_r($assets);
```
<details>
 <summary>View Response</summary>

```
Array
(
    [BTC] => Array
        (
            [name] => bitcoin
            [unified_cryptoasset_id] => 1
            [can_withdraw] => 1
            [can_deposit] => 1
            [min_withdraw] => 0.0011
            [max_withdraw] => 100
            [maker_fee] => 0.25
            [taker_fee] => 0.25
        )

    [NXB] => Array
        (
            [name] => nxboost
            [unified_cryptoasset_id] => 0
            [can_withdraw] => 1
            [can_deposit] => 1
            [min_withdraw] => 50
            [max_withdraw] => 1000000
            [maker_fee] => 0.25
            [taker_fee] => 0.25
        )

    [DOGE] => Array
        (
            [name] => dogecoin
            [unified_cryptoasset_id] => 74
            [can_withdraw] => 1
            [can_deposit] => 1
            [min_withdraw] => 200
            [max_withdraw] => 1000000
            [maker_fee] => 0.25
            [taker_fee] => 0.25
        )

)
```
</details>

#### All info about trading pairs
```php
$ticker = $api->ticker();
print_r($ticker);
```
<details>
 <summary>View Response</summary>

```
Array
(
    [NXB_BTC] => Array
        (
            [base_id] => 0
            [quote_id] => 1
            [last_price] => 1.0E-7
            [quote_volume] => 0
            [base_volume] => 0
            [isFrozen] => 1
        )

    [SICC_BTC] => Array
        (
            [base_id] => 0
            [quote_id] => 1
            [last_price] => 1.0E-8
            [quote_volume] => 0
            [base_volume] => 0
            [isFrozen] => 1
        )

    [DOGE_BTC] => Array
        (
            [base_id] => 74
            [quote_id] => 1
            [last_price] => 2.9E-7
            [quote_volume] => 0
            [base_volume] => 0
            [isFrozen] => 1
        )

)
```
</details>

#### Order book public method
```php
$market_pair = 'LTC_BTC';
$orderBook = $api->orderBook($market_pair);
print_r($orderBook);
```
<details>
 <summary>View Response</summary>

```
Array
(
    [timestamp] => 1579251863
    [asks] => Array
        (
            [0] => Array
                (
                    [0] => 0.00678720
                    [1] => 1.93488405
                )

            [1] => Array
                (
                    [0] => 0.00690000
                    [1] => 0.00545601
                )

            [2] => Array
                (
                    [0] => 0.00705600
                    [1] => 0.76735301
                )

            [3] => Array
                (
                    [0] => 0.00739200
                    [1] => 1.38252528
                )

            [4] => Array
                (
                    [0] => 0.00752640
                    [1] => 0.96025874
                )

            [5] => Array
                (
                    [0] => 0.00772800
                    [1] => 4.95497893
                )

        )

    [bids] => Array
        (
            [0] => Array
                (
                    [0] => 0.00665280
                    [1] => 11.21001407
                )

            [1] => Array
                (
                    [0] => 0.00638400
                    [1] => 13.02311477
                )

            [2] => Array
                (
                    [0] => 0.00604800
                    [1] => 12.95552647
                )

            [3] => Array
                (
                    [0] => 0.00591360
                    [1] => 2.07205313
                )

            [4] => Array
                (
                    [0] => 0.00571200
                    [1] => 26.55359529
                )

        )

)
```
</details>

#### Trade history public method
```php
$market_pair = 'LTC_BTC';
$trades = $api->trades($market_pair);
print_r($trades);
```
<details>
 <summary>View Response</summary>

```
Array
(
    [0] => Array
        (
            [tradeID] => 802315
            [price] => 0.00677811
            [base_volume] => 0.30793017
            [quote_volume] => 0.00208718
            [trade_timestamp] => 1579251738
            [type] => Buy
        )

    [1] => Array
        (
            [tradeID] => 802310
            [price] => 0.00664587
            [base_volume] => 3.23427144
            [quote_volume] => 0.02149455
            [trade_timestamp] => 1579251588
            [type] => Sell
        )

    [2] => Array
        (
            [tradeID] => 802300
            [price] => 0.00664389
            [base_volume] => 1.05470960
            [quote_volume] => 0.00700737
            [trade_timestamp] => 1579251113
            [type] => Sell
        )

    [3] => Array
        (
            [tradeID] => 802299
            [price] => 0.00664389
            [base_volume] => 2.09450760
            [quote_volume] => 0.01391568
            [trade_timestamp] => 1579251088
            [type] => Sell
        )

    [4] => Array
        (
            [tradeID] => 802296
            [price] => 0.00677811
            [base_volume] => 1.07343406
            [quote_volume] => 0.00727585
            [trade_timestamp] => 1579250788
            [type] => Buy
        )

    [5] => Array
        (
            [tradeID] => 802274
            [price] => 0.00677508
            [base_volume] => 0.77804842
            [quote_volume] => 0.00527134
            [trade_timestamp] => 1579249713
            [type] => Buy
        )

    [6] => Array
        (
            [tradeID] => 802269
            [price] => 0.00664983
            [base_volume] => 5.00015726
            [quote_volume] => 0.03325020
            [trade_timestamp] => 1579249388
            [type] => Sell
        )

    [7] => Array
        (
            [tradeID] => 802259
            [price] => 0.00665082
            [base_volume] => 3.83740187
            [quote_volume] => 0.02552187
            [trade_timestamp] => 1579249013
            [type] => Sell
        )

    [8] => Array
        (
            [tradeID] => 802245
            [price] => 0.00664983
            [base_volume] => 9.60615537
            [quote_volume] => 0.06387930
            [trade_timestamp] => 1579248288
            [type] => Sell
        )

    [9] => Array
        (
            [tradeID] => 802243
            [price] => 0.00678013
            [base_volume] => 0.21816053
            [quote_volume] => 0.00147916
            [trade_timestamp] => 1579248163
            [type] => Buy
        )

    [10] => Array
        (
            [tradeID] => 802224
            [price] => 0.00677912
            [base_volume] => 0.97455249
            [quote_volume] => 0.00660661
            [trade_timestamp] => 1579247038
            [type] => Buy
        )

    [11] => Array
        (
            [tradeID] => 802197
            [price] => 0.00672256
            [base_volume] => 0.01945822
            [quote_volume] => 0.00013081
            [trade_timestamp] => 1579245763
            [type] => Buy
        )

    [12] => Array
        (
            [tradeID] => 802183
            [price] => 0.00655281
            [base_volume] => 1.66794631
            [quote_volume] => 0.01092974
            [trade_timestamp] => 1579244838
            [type] => Sell
        )

    [13] => Array
        (
            [tradeID] => 802180
            [price] => 0.00670539
            [base_volume] => 0.91358394
            [quote_volume] => 0.00612594
            [trade_timestamp] => 1579244638
            [type] => Buy
        )

    [14] => Array
        (
            [tradeID] => 802158
            [price] => 0.00670640
            [base_volume] => 0.97267599
            [quote_volume] => 0.00652315
            [trade_timestamp] => 1579243438
            [type] => Buy
        )

    [15] => Array
        (
            [tradeID] => 802137
            [price] => 0.00660132
            [base_volume] => 0.57672635
            [quote_volume] => 0.00380716
            [trade_timestamp] => 1579242688
            [type] => Sell
        )

    [16] => Array
        (
            [tradeID] => 802122
            [price] => 0.00675993
            [base_volume] => 0.81600441
            [quote_volume] => 0.00551613
            [trade_timestamp] => 1579241988
            [type] => Buy
        )

    [17] => Array
        (
            [tradeID] => 802103
            [price] => 0.00676094
            [base_volume] => 0.95788900
            [quote_volume] => 0.00647623
            [trade_timestamp] => 1579241238
            [type] => Buy
        )

    [18] => Array
        (
            [tradeID] => 802062
            [price] => 0.00667755
            [base_volume] => 12.96798589
            [quote_volume] => 0.08659437
            [trade_timestamp] => 1579238838
            [type] => Sell
        )

    [19] => Array
        (
            [tradeID] => 802055
            [price] => 0.00664290
            [base_volume] => 10.96511182
            [quote_volume] => 0.07284014
            [trade_timestamp] => 1579238387
            [type] => Sell
        )
)
```
</details>

#### Balance and Info methods
```php
$market_pair = 'LTC_BTC';
$balance = $api->balancesAndInfo();
print_r($balance);
```
<details>
 <summary>View Response</summary>

```
Array
(
    [balances-and-info] => Array
        (
            [on_hold] => Array
                (
                    [BTC] => Array
                        (
                            [withdrawal] => 0
                            [total] => 2.531E-5
                            [order] => 2.531E-5
                        )

                    [DOGE] => Array
                        (
                            [withdrawal] => 0
                            [total] => 15600.9022
                            [order] => 15600.9022
                        )

                    [NXB] => Array
                        (
                            [withdrawal] => 0
                            [total] => 19000
                            [order] => 19000
                        )

                )

            [available] => Array
                (
                    [DOGE] => 2
                    [ETH] => 0.008959
                    [LTC] => 0.00226908
                    [NXB] => 4590.52747053
                )

            [usd_volume] => 0
            [fee_bracket] => Array
                (
                    [maker] => 0.25
                    [taker] => 0.25
                )

            [exchange_npc_volume] => 0
        )

)
```
</details>


#### Open Orders
```php
$currency = 'BTC';
$market = 'DOGE';
$openOrder = $api->openOrders($currency, $market);
print_r($openOrder);
```
<details>
 <summary>View Response</summary>

```
Array
(
    [open-orders] => Array
        (
            [market] => DOGE
            [currency] => BTC
            [bid] => Array
                (
                    [0] => Array
                        (
                            [id] => 2789460
                            [side] => buy
                            [type] => limit
                            [amount] => 25
                            [amount_remaining] => 25
                            [price] => 2.1E-7
                            [avg_price_executed] => 0
                            [stop_price] => 0
                            [currency] => 
                            [market] => DOGE
                            [status] => ACTIVE
                            [replaced] => 2773980
                            [replaced_by] => 0
                            [timestamp] => 1575961985
                        )

                    [1] => Array
                        (
                            [id] => 2764712
                            [side] => buy
                            [type] => limit
                            [amount] => 100
                            [amount_remaining] => 100
                            [price] => 2.0E-7
                            [avg_price_executed] => 0
                            [stop_price] => 0
                            [currency] => 
                            [market] => DOGE
                            [status] => ACTIVE
                            [replaced] => 0
                            [replaced_by] => 0
                            [timestamp] => 1575958202
                        )

                )

            [ask] => Array
                (
                    [0] => Array
                        (
                            [id] => 13947471
                            [side] => sell
                            [type] => limit
                            [amount] => 4998
                            [amount_remaining] => 4998
                            [price] => 2.9E-7
                            [avg_price_executed] => 0
                            [stop_price] => 0
                            [currency] => 
                            [market] => DOGE
                            [status] => ACTIVE
                            [replaced] => 0
                            [replaced_by] => 0
                            [timestamp] => 1578392765
                        )

                    [1] => Array
                        (
                            [id] => 13858558
                            [side] => sell
                            [type] => limit
                            [amount] => 5000
                            [amount_remaining] => 0
                            [price] => 2.9E-7
                            [avg_price_executed] => 
                            [stop_price] => 0
                            [currency] => 
                            [market] => DOGE
                            [status] => ACTIVE
                            [replaced] => 0
                            [replaced_by] => 0
                            [timestamp] => 1578383470
                        )

                    [2] => Array
                        (
                            [id] => 13859016
                            [side] => sell
                            [type] => limit
                            [amount] => 2536
                            [amount_remaining] => 2536
                            [price] => 3.0E-7
                            [avg_price_executed] => 0
                            [stop_price] => 0
                            [currency] => 
                            [market] => DOGE
                            [status] => ACTIVE
                            [replaced] => 0
                            [replaced_by] => 0
                            [timestamp] => 1578383489
                        )

                    [3] => Array
                        (
                            [id] => 13859207
                            [side] => sell
                            [type] => limit
                            [amount] => 3287
                            [amount_remaining] => 3287
                            [price] => 3.1E-7
                            [avg_price_executed] => 0
                            [stop_price] => 0
                            [currency] => 
                            [market] => DOGE
                            [status] => ACTIVE
                            [replaced] => 0
                            [replaced_by] => 0
                            [timestamp] => 1578383500
                        )

                    [4] => Array
                        (
                            [id] => 13859303
                            [side] => sell
                            [type] => limit
                            [amount] => 1852
                            [amount_remaining] => 1852
                            [price] => 3.2E-7
                            [avg_price_executed] => 0
                            [stop_price] => 0
                            [currency] => 
                            [market] => DOGE
                            [status] => ACTIVE
                            [replaced] => 0
                            [replaced_by] => 0
                            [timestamp] => 1578383509
                        )

                    [5] => Array
                        (
                            [id] => 13859399
                            [side] => sell
                            [type] => limit
                            [amount] => 2827.9022
                            [amount_remaining] => 2827.9022
                            [price] => 3.3E-7
                            [avg_price_executed] => 0
                            [stop_price] => 0
                            [currency] => 
                            [market] => DOGE
                            [status] => ACTIVE
                            [replaced] => 0
                            [replaced_by] => 0
                            [timestamp] => 1578383518
                        )

                    [6] => Array
                        (
                            [id] => 2764710
                            [side] => sell
                            [type] => limit
                            [amount] => 100
                            [amount_remaining] => 100
                            [price] => 3.7E-7
                            [avg_price_executed] => 0
                            [stop_price] => 0
                            [currency] => 
                            [market] => DOGE
                            [status] => ACTIVE
                            [replaced] => 0
                            [replaced_by] => 0
                            [timestamp] => 1575958192
                        )

                )

        )

)

```
</details>

#### User trade history
```php
$currency = 'BTC';
$market = 'DOGE';
$limit = 10;
$side = 'buy';
$history = $api->userTransactions(string $currency, $market, $limit, $side);
print_r($history);
```
<details>
 <summary>View Response</summary>

```
Array
(
    [user-transactions] => Array
        (
            [market] => DOGE
            [currency] => BTC
            [data] => Array
                (
                    [0] => Array
                        (
                            [id] => 785304
                            [date] => 2020-01-07 09:50:23
                            [timestamp] => 1578383423
                            [btc] => 13302.9022
                            [side] => sell
                            [price] => 2.9E-7
                            [amount] => 0
                            [fee] => 0
                            [currency] => 
                        )

                    [1] => Array
                        (
                            [id] => 780329
                            [date] => 2020-01-04 08:13:55
                            [timestamp] => 1578118435
                            [btc] => 694.1492
                            [side] => sell
                            [price] => 3.6E-7
                            [amount] => 0
                            [fee] => 0
                            [currency] => 
                        )

                    [2] => Array
                        (
                            [id] => 739163
                            [date] => 2019-12-22 12:58:19
                            [timestamp] => 1577012299
                            [btc] => 35.7
                            [side] => sell
                            [price] => 2.9E-7
                            [amount] => 0
                            [fee] => 0
                            [currency] => 
                        )

                    [3] => Array
                        (
                            [id] => 739151
                            [date] => 2019-12-22 12:56:24
                            [timestamp] => 1577012184
                            [btc] => 202.3
                            [side] => sell
                            [price] => 2.9E-7
                            [amount] => 0
                            [fee] => 0
                            [currency] => 
                        )

                    [4] => Array
                        (
                            [id] => 739150
                            [date] => 2019-12-22 12:56:14
                            [timestamp] => 1577012174
                            [btc] => 5712
                            [side] => sell
                            [price] => 2.9E-7
                            [amount] => 0
                            [fee] => 0
                            [currency] => 
                        )

                    [5] => Array
                        (
                            [id] => 680952
                            [date] => 2019-12-10 08:09:31
                            [timestamp] => 1575958171
                            [btc] => 100
                            [side] => sell
                            [price] => 3.4E-7
                            [amount] => 0
                            [fee] => 0
                            [currency] => 
                        )

                    [6] => Array
                        (
                            [id] => 616935
                            [date] => 2019-11-23 09:29:30
                            [timestamp] => 1574494170
                            [btc] => 1898.39530592
                            [side] => sell
                            [price] => 0
                            [amount] => 0
                            [fee] => 0
                            [currency] => 
                        )

                    [7] => Array
                        (
                            [id] => 616924
                            [date] => 2019-11-23 09:22:09
                            [timestamp] => 1574493729
                            [btc] => 1302.07371353
                            [side] => sell
                            [price] => 0
                            [amount] => 0
                            [fee] => 0
                            [currency] => 
                        )

                    [8] => Array
                        (
                            [id] => 616907
                            [date] => 2019-11-23 09:08:10
                            [timestamp] => 1574492890
                            [btc] => 4258.39561935
                            [side] => sell
                            [price] => 0
                            [amount] => 0
                            [fee] => 0
                            [currency] => 
                        )

                    [9] => Array
                        (
                            [id] => 616900
                            [date] => 2019-11-23 09:00:52
                            [timestamp] => 1574492452
                            [btc] => 4599.22073763
                            [side] => sell
                            [price] => 0
                            [amount] => 0
                            [fee] => 0
                            [currency] => 
                        )

                )

        )

)
```
</details>


#### Place One (or Many) New Orders
```php
$side = 'buy';
$type = 'limit';
$currency = 'BTC';
$market = 'DOGE';
$amount = 15;
$stop_price = 0;
$limit_price = 0.00000027;
$orderNew = $api->ordersNew($side, $type, $currency, $market, $limit_price, $stop_price, $amount);
print_r($orderNew);
```
<details>
 <summary>View Response</summary>
 
```
Array
(
    [orders-new] => Array
        (
            [0] => Array
                (
                    [transactions] => 0
                    [new_order] => 1
                    [order_info] => Array
                        (
                            [id] => 6316659
                            [side] => buy
                            [type] => limit
                            [amount] => 15
                            [amount_remaining] => 15
                            [price] => 2.7E-7
                            [avg_price_executed] => 0
                            [stop_price] => 0
                            [market] => DOGE
                            [currency] => BTC
                            [status] => ACTIVE
                        )

                )

        )

)
```
</details>

#### Edit One (or Many) Orders
```php
$id = 6316659;
$type = 'limit';
$amount = 15;
$stop_price = 0;
$limit_price = 0.00000027;
$orderEdit = $api->ordersEdit( $id, $type, $limit_price, $stop_price, $amount)
print_r($orderEdit);
```
<details>
 <summary>View Response</summary>

```
Array
(
    [orders-edit] => Array
        (
            [0] => Array
                (
                    [transactions] => 0
                    [edit_order] => 1
                    [order_info] => Array
                        (
                            [id] => 6316660
                            [side] => buy
                            [type] => limit
                            [amount] => 150
                            [amount_remaining] => 150
                            [price] => 2.7E-7
                            [avg_price_executed] => 0
                            [stop_price] => 0
                            [market] => DOGE
                            [currency] => BTC
                            [status] => ACTIVE
                            [replaced] => 6316659
                        )

                )

        )

)
```
</details>


#### Existing Crypto Deposit Addresses
```php
$market = 'BTC';
$limit = 1;
$getAddress = $api->getDepositAddress( $market, $limit);
print_r($getAddress);
```
<details>
 <summary>View Response</summary>

```
Array
(
    [btc-deposit-address-get] => Array
        (
            [0] => Array
                (
                    [id] => 3444
                    [address] => 37ZYbijrwiHPLVtVL8M79RSsFm6NdawVkP
                    [cryptonot_address] => 
                    [site_user] => 1233
                    [date] => 2019-11-24 14:44:47
                    [system_address] => N
                    [hot_wallet] => N
                    [warm_wallet] => N
                    [c_currency] => 28
                    [merch_address] => N
                    [merch_site] => 
                    [merch_user] => 
                )

        )

)

```
</details>

#### Get New Crypto Deposit Addresses
```php
$market = 'BTC';
$limit = 1;
$newAddress = $api->newDepositAddress($market);
print_r($newAddress);
```
<details>
 <summary>View Response</summary>

```
Array
(
    [crypto-deposit-address-new] => Array
        (
            [address] => 3FuVGvCAs3QNQQBa8zjXYqFoqDYBQD3whZ
        )

)
```
</details>

#### Make a Withdrawal
```php
$currency = 'NXB';
$amount = 100;
$address = 'NF8wC43ZxmpWjCeaAvtpr9FiK8pd83Xvd6';
$newWithdrawals = $api->newWithdrawals($currency, $amount, $address);
print_r($newWithdrawals);
```
<details>
 <summary>View Response</summary>

```
Array
(
)
```
</details>


#### Installing on Windows
Download and install composer:
1. https://getcomposer.org/download/
2. Create a folder on your drive like C:\BitStorage
3. Run command prompt and type `cd C:\BitStorage`
4. ```
   git clone https://github.com/bitstorage-dev/php-bitstorage-api .
   composer update
   ```
5. Once complete copy the vendor folder into your project.
