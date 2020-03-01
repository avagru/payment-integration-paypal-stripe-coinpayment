<?php
    include_once 'vendor/autoload.php';
    include_once 'config.php';
    include_once 'db.php';
    $sql = "SELECT * FROM transactions";
    $transactions = $db->query($sql);
    $cps_api = new CoinpaymentsAPI(COIN_PRIVATE_KEY, COIN_PUBLIC_KEY, 'json');
    $coins = $cps_api->GetShortRatesWithAccepted();
    $replaces = [
        'USDT.ERC20' => 'USDT',
        'BTC.LN' => 'BTC',
        'sBTC' => 'blank'
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL . '/assets/css/loading.min.css';?>"/>
    <style>
        .StripeElement {
            border: 1px solid #ced4da;
            padding: 10px;
            border-radius: 5px;
        }
        .StripeElement.is-focused {
            border-color: #80bdff;
            outline:0;
            box-shadow: 0 0 0 0.2rem #007bff40;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        .radius-5 {
            border-radius:20px;
            padding-left: 90px;
            padding-right: 90px;
        }
        #coin_payment_btn {
            background-image: url('./assets/img/buynow-grey.png');
            width: 200px;
            height: 40px;
            background-position: center;
            background-size: 140px 45px;
            background-repeat: no-repeat;
        }
        .coin {
            padding: 5px 15px;
            border-radius: 5px;
            border: 1px solid #cccccc;
            margin-bottom: 15px;
        }
        .coin img {
            margin-right: 15px;
        }
        .btn-block {
            display: flex;
            align-items: center;
            justify-content: space-around;
        }
        .coins-container {
            max-height: 450px;
            overflow: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="<?= BASE_URL . '/assets/js/jquery.loading.min.js';?>"></script>
    <script>
        var BASE_URL = "<?= BASE_URL;?>";
        var PAYPAL_SANDBOX = <?= PAYPAL_SANDBOX; ?>;
        var PAYPAL_SANDBOX_CLIENT_ID = "<?= PAYPAL_SANDBOX_CLIENT_ID; ?>";
        var PAYPAL_PRODUCTION_CLIENT_ID = "<?= PAYPAL_PRODUCTION_CLIENT_ID; ?>";
        var PAYPAL_CURRENCY = "<?= PAYPAL_CURRENCY;?>";
        var STRIPE_CLIENT_KEY = "<?= STRIPE_CLIENT_KEY;?>";
        var STRIPE_CURRENCY = "<?= STRIPE_CURRENCY;?>";
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="checkout-form my-5">
                    <div class="form-group">
                        <label for="type">Type:</label>
                        <div class="payment_type_container">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="type" value="paypal" checked/>PayPal
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="type" value="stripe"/>Stripe
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="type" value="bitcoin"/>Coins
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="paypal-section d-block">
                        <div class="form-group">
                            <label for="paypal_amount">Amount:</label>
                            <input type="number" id="paypal_amount" class="form-control"/>
                        </div>
                        <div id="paypal-button" class="text-right"></div>
                    </div>
                    <div class="stripe-section d-none">
                        <div class="form-group">
                            <label for="stripe_amount">Amount:</label>
                            <input type="number" id="stripe_amount" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Card Info:</label>
                            <div id="card-element"></div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success radius-5" id="stripe_payment_btn">Pay Now</button>
                        </div>
                    </div>
                    <div class="bitcoin-section d-none">
                    <form action="./payment_success.php" method="POST">
                        <input type="hidden" name="type" value="coin"/>
                        <input type="hidden" name="merchant" value="<?= COIN_MERCHANT_ID;?>">
                        <input type="hidden" name="currency1" value="USD">
                        <input type="hidden" name="currency2" value="BTC">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control" name="amount" value="10.00" placeholder="USD">
                        </div>
                        <div class="form-group">
                            <div class="coins-container">
                                <div class="row">
                                    <?php 
                                        foreach($coins['result'] as $key => $val):
                                            if ($val['accepted'] == 1):                                    
                                    ?>
                                                <div class="col-md-4 px-2">
                                                    <button type="button" class="btn btn-outline-success btn-block mb-3 coin_btn <?= $key == 'BTC' ? 'active' : '';?>">
                                                        <img width="30" height="30" src="<?= BASE_URL . '/assets/img/coins/' . str_replace(array_keys($replaces), array_values($replaces), $key) . '.png';?>"><?= $key;?>
                                                    </button>
                                                </div>
                                    <?php
                                            endif;
                                        endforeach;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Buyer Name</label>
                                    <input type="text" placeholder="Name..." class="form-control" name="name" value=""/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Buyer Email</label>
                                    <input type="email" placeholder="Email..." class="form-control" name="email" value=""/>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-warning" id="coin_payment_btn"></button>
                        </div>
                    </form>
                    </div>
                </div>  
            </div>
        </div>
        <hr/>
        <h2>Transaction Details</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Transaction Id</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Currency</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $idx = 0;
                    foreach ($transactions as $transaction):
                        $idx++;
                ?>
                        <tr>
                            <td><?= $idx;?></td>
                            <td><?= $transaction['transaction_id'];?></td>
                            <td><?= $transaction['transaction_type'];?></td>
                            <td><?= $transaction['transaction_amount'];?></td>
                            <td><?= $transaction['currency'];?></td>
                        </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(async function() {
            var amount = 0;

            $(".payment_type_container").on("change", "input", function() {
                let type = $(this).val();
                switch(type) {
                    case 'paypal':
                        $(".paypal-section").removeClass("d-none").addClass("d-block");
                        $(".stripe-section, .bitcoin-section").removeClass("d-block").addClass("d-none");
                        break;
                    case 'stripe':
                        $(".stripe-section").removeClass("d-none").addClass("d-block");
                        $(".paypal-section, .bitcoin-section").removeClass("d-block").addClass("d-none");
                        break;
                    case 'bitcoin':
                        $(".bitcoin-section").removeClass("d-none").addClass("d-block");
                        $(".paypal-section, .stripe-section").removeClass("d-block").addClass("d-none");
                        break;
                    default:
                        $(".paypal-section").removeClass("d-none").addClass("d-block");
                        $(".stripe-section, .bitcoin-section").removeClass("d-block").addClass("d-none");
                        break;
                }
            })
            /***************** start paypal payment ****************/
            paypal.Button.render({
                env: PAYPAL_SANDBOX ? 'sandbox' : 'production',
                client: {
                    sandbox: PAYPAL_SANDBOX_CLIENT_ID,
                    production: PAYPAL_PRODUCTION_CLIENT_ID
                },
                style: {
                    label: 'paypal',
                    size: 'medium',
                    color: 'gold',
                    shape: 'pill',
                    tagline: false
                },
                commit: true,
                payment: function(data, actions) {
                    amount = $("#paypal_amount").val();
                    return actions.payment.create({
                        payment: {
                            transactions: [{
                                amount: {total: amount, currency: PAYPAL_CURRENCY}
                            }],
                            redirect_urls: {
                                return_url: BASE_URL + '/index.php',
                                cancel_url: BASE_URL + '/cancel.php'
                            }
                        }
                    })
                },
                onAuthorize: function(data, actions) {
                    return actions.payment.execute().then(function() {
                        $.post(BASE_URL + '/payment_success.php', {
                            type: 'paypal',
                            transaction_id: data.paymentID,
                            amount: amount,
                            currency: PAYPAL_CURRENCY
                        }).then(function(res) {
                            if (res.error) {
                                alert(res.error);
                            } else {
                                // console.log("Success", res);
                                actions.redirect();
                            }
                        })
                    })
                },
                onCancel: function(data, actions) {
                    console.log("Cancel");
                    actions.redirect();
                },
                onError: function(err) {
                    console.log("Error", err)
                }
            },"#paypal-button");
            /***************** end paypal payment ******************/

            /***************** start stripe payment ****************/
            var stripe = Stripe(STRIPE_CLIENT_KEY);
            var elements = stripe.elements();
            var card = elements.create("card", {
                iconStyle: "solid",
                style: {
                    base: {
                        iconColor: "#000000",
                        color: "#222222",
                        fontWeight: 300,
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSize: "14px",
                        backgroundColor: "#fafafa",
                        "::placeholder": {
                            color: "#777777"
                        },
                        ":-webkit-autofill": {
                            color: "#222222"
                        }
                    },
                    invalid: {
                        iconColor: "#FFC7EE",
                        color: "#FFC7EE"
                    }
                },
                classes: {
                    focus: 'is-focused',
                    empty: 'is-empty'
                }
            });
            card.currency = STRIPE_CURRENCY;
            card.mount("#card-element");

            $(".checkout-form").on("click", "#stripe_payment_btn", async function() {
                let response1 = await stripe.createToken(card);
                amount = $("#stripe_amount").val();
                let data = {
                    type: 'stripe',
                    token: response1.token.id,
                    amount: amount,
                    currency: STRIPE_CURRENCY
                }
                $.showLoading({name: 'line-scale'}); 
                $.post(BASE_URL + '/payment_success.php', data).then(function(res) {
                    if (res.error) {
                        alert(res.error);
                    } else {
                        $.hideLoading();
                        location.href = BASE_URL + '/index.php';
                    }
                })
            })
            /**************** end stripe payment *****************/

            /**************** start coin payment ****************/
                $(".coins-container").on("click", ".coin_btn", function() {
                    let coin = $(this).text().trim();
                    $(".coins-container .coin_btn").removeClass("active");
                    $(this).addClass("active");
                    $("[name='currency2']").val(coin);
                })
            /**************** end coin payment ******************/
        });
    </script>
</body>
</html>