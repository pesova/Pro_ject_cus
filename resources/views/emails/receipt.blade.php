<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Receipt</title>
</head>
<body>
    <div>
        <h4>
            Payment Receipt
        </h4>
        <p>
            Hello {{$data['name']}}, thanks for making payment of your debt. 
        </p>
         <p>Please the attached document is the receipt to your payment.
        </p> 
        <p>Thanks, for your Patronage</p>
        <p>Signed Admin {{$data['store_name']}}</p>
    </div>
</body>
</html>