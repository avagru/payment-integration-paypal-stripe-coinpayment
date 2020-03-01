<?php
    define('BASE_URL', 'http://localhost/payment-gateways');
    
    // database configure
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'payment_gateways');

    // paypal configure;
    define('PAYPAL_ID', '');
    define('PAYPAL_SANDBOX', TRUE);
    define('PAYPAL_SANDBOX_CLIENT_ID', 'AUiqv3B2CmIPcP5ptjEt0PurFip3QL1WjQHZqGnFVr9SE_Onoce5GlMw6ggt8PTFPAFT1nQi4iv_Ol6D');
    define('PAYPAL_PRODUCTION_CLIENT_ID', '');
    define('PAYPAL_CURRENCY', 'USD');
    
    // stripe configure;
    define('STRIPE_CLIENT_KEY', 'pk_test_qWA40rQLbO6ootjDeLuurOUW00g0wUPw15');
    define('STRIPE_SECRET_KEY', 'sk_test_oSKNuk09l19QJRjvpkbQOoUC00tZkobn6k');
    define('STRIPE_CURRENCY', 'USD');

    // coin configure;
    define('COIN_PUBLIC_KEY', '4f1cd6d59bf85cea6fc7199d261bcf1810dddd43b2056680c102c886662df497');
    define('COIN_PRIVATE_KEY', 'd9E50326f76E552E4a63E1D0Ffe964aa2689Ba11A16d9f391F9F5b26A8e2726b');
    define('COIN_MERCHANT_ID', '1245bd1244d36efe8b298b1d78c5422c');
?>