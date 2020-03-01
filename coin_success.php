<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center" style="height: 100vh">
        <div class="success-confirm" style="word-break: break-all; flex-basis: 550px; padding: 20px; border: 1px solid #cccccc; background-color: #f9f9f9; border-radius: 4px;">
            <div class="row form-group">
                <div class="col-md-4">Transaction Id:</div>
                <div class="col-md-8"><?= $transaction_response['result']['txn_id'];?></div>
            </div>
            <div class="row form-group">
                <div class="col-md-4">Amount:</div>
                <div class="col-md-8"><?= $transaction_response['result']['amount'];?></div>
            </div>
            <div class="row form-group">
                <div class="col-md-4">Address:</div>
                <div class="col-md-8"><?= $transaction_response['result']['address'];?></div>
            </div>
            <div class="row form-group">
                <div class="col-md-4">Checkout Url:</div>
                <div class="col-md-8"><?= $transaction_response['result']['checkout_url'];?></div>
            </div>
            <div class="text-right">
                <a class="btn btn-success" href="<?= BASE_URL . '/index.php';?>">Confirmed</a>
            </div>
        </div>
    </div>    
</body>
</html>