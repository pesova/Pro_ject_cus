<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reciept</title>
</head>

<style>

@font-face {
    font-family: Gilroy;
    src: url("{{public_path()}}/backend/assets/fonts/Gilroy-Regular.ttf");
}

    *{
        margin: 0;
        -webkit-box-sizing: border-box;
        padding: 0;
        text-decoration: none;
        line-height: 1.5;
        box-sizing: border-box;
        font-family: 'Gilroy';
    }
    #logo-container{
        width: 25%;
        padding: 10px;
    }
    .logo{
        width: 100%;
    }
    #wrapper{
        /* margin-left: 5px; */
        width: 590px;
        margin: 5px auto;
        border: 1.2px solid #00098A;
        border-radius: 8px;
        background: #fafafa;
        background-image: url("{{public_path('backend/assets/images/Group_1400.png')}}");
        background-position: right bottom;
        background-size: 300px 300px;
        background-repeat: no-repeat;
        background-origin: padding-box;
     
       
    }

    #details{
        background: #fff;
        width: 80%;
        margin: 15px auto;
        padding-bottom: 20px;
    }

    #details h4{
        text-align: center;
        padding: 10px 15px;
        background: #00098A;
        color: #fff;
    }

    #details  .transaction-id{
        color: rgba(0, 0, 0, 0.521);
        font-weight: 100;
        margin-top: 15px;
        padding: 8px;
    }
    .detail-text{
        color: rgba(0, 0, 0, 0.521);
    }
    #details  .transaction-id span{
    
        display: inline-block;
        margin-left: 20px;
    }

    .title{
        padding: 15px 8px;
        color: #00098A;
        border-bottom: 1.2px solid #00098A;
        /* margin-bottom: 10px; */
    }

   #table-details{
        margin-top: 10px;
        display: inline-block;
        /* width: 100%; */
    }

   

    td{
        text-align: left;
    }



    .details-value{
        padding-left: 80px;
    }

    #table-container{
        width: 80%;
        margin: 8px auto;
        text-align: center;
    }

    #description{
        padding: 5px;
        color: #00098A;
        border-bottom: 1px solid rgb(0, 9, 138);
        border-top: 1px solid rgb(0, 9, 138);
        margin-bottom: 10px;
    }

    .description-text{
        width: 80%;
        margin: 8px auto;
        padding: 8px 10px;
        color: rgba(0, 0, 0, 0.521);
        margin-bottom: 15px;
    }

    #greeting{
        min-height: 100px;
        padding: 15px;
        color: #00098A;
    }

    #footer{
        /* padding: 10px 15px; */
        background: #00098A;
        color: #fff;
        position: relative;
        padding: 10px 5px;
        border-radius: 0 0 7px 7px;
    }

    .link{
      
      position: absolute;
      right: 20px;
      top: 10px;
    }

    .link a{
        color: white;
        display: inline-block;
        padding: 0px 10px;
    }

    .amount{
        color: #00e676;
    }

    .date{
        color: #00098A;
    }

    .owing{
        color: #d32f2f;
    }
</style>
<body>
    @php
          $format = strtotime($transaction['transaction_date']);
        $date = date("D d M Y h:i:sa", $format);
    @endphp 
    <div id="wrapper" >
        <div id="logo-container">
                <img src="{{public_path('backend/assets/images/fulllogo.png')}}" alt="" class="logo">
        </div>
        <div id="details">
            <h4>
                TRANSACTION RECIEPT
            </h4>

            <p class="transaction-id">
            Tranaction ID : <span>{{$transaction['transaction_id']}}</span>
            </p>

            <p class="title">
                Details of Transaction
            </p>
            <div id="table-container">
            <table id="table-details">
                            <tbody>
                            <tr class="details-table">
                                <td class="detail-text">
                                    Date Recorded  
                                </td>
                                <td class="details-value date">
                                    {{$date}}
                                </td>
                            </tr>
                            <tr class="details-table">
                                <td class="detail-text ">
                                    Amount Paid
                                </td>
                                <td class="details-value amount">
                                    {{$transaction['transaction_amount']}}
                                </td>
                            </tr>
                            {{-- <tr class="details-table">
                                <td class="detail-text">
                                    Amount Owing  
                                </td>
                                <td class="details-value owing">
                                    Amount Owing here
                                </td>
                            </tr>   --}}
                            </tbody>
                            
                        </table>
            </div>
            <p id="description">
                Description of Transaction
            </p>
            <p class="description-text">
                {{$transaction['transaction_description']}}
            </p>
        </div>


        <div id="greeting">
            <p>THANKS FOR YOUR PATRONAGE!</p>
        </div>

        <div id="footer">
            <p>CustomerPayMe</p>
            <p class="link"><a href="">www.customerpay.me</a></p>
        </div>
    </div>
    
</body>
</html>