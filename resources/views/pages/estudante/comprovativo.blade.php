<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ISPM</title>
    {{-- <link rel="stylesheet" href="{{asset('css/bilhete.css')}}"> --}}
    <style>
        .base{
            width: 100%;
            display: flex;
            justify-content: center;
            padding-top: 30px;
            padding-bottom: 30px;
            .bilhete{
                width: 40%;
                border: 1px solid dimgray;
                border-radius: 8px;
                .baseTop{
                    background: rgb(0, 17, 255);
                    color: rgb(228, 18, 18);
                    border-top-left-radius: 8px;
                    border-top-right-radius: 8px;
                    padding: 5px;
                    text-align: center
                    margin-bottom: 20px;
                    h5{
                        color: white;
                        margin-left: 10px;
                        margin-right: 10px;
                        font-size: 25px;
                        font-family: Arial, Helvetica, sans-serif;
                    }
                }
                .corpo{
                    width: 100%;
                    padding-left: 20px;
                    padding-right: 20px;
                    font-size: 16px;
                    font-weight: 400;
                    color: dimgray;
                    p{
                        font-size: 20px;
                    }
                    table{
                        width: 100%;
                        thead{
                            tr{
                                th{
                                    text-align: center;
                                }
                            }
                        }
                        tbody{
                            tr{
                                td{
                                    text-align: center;
                                }
                            }
                        }
                    }
                }
                .musaico{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 20px;
                    font-size: 40px;
                }
            }
        }
    </style>
</head>
<body>
    <div class="baseTo">
        <div class="container-fluid">
                <div class="head-body">
                    <div class="container-fluid base">
                        <div class="bilhete">
                            <div class="baseTop">
                                <i class="fa fa-bus"></i><h5 style="text-align: center;" >Bilhete Macon</h5><i class="fa fa-bus"></i>
                            </div>
                             <div class="corpo">
                               <p>Nome: <b>{{Auth::user()->candidato->name}}</b></p>
                               
                                <p>Caro Cliente a sua reserva tem duração de 24h.</p>
                                <p>Para efeito de pagamento dirija-se a uma agência mas próxima.</p>
                                <h2>Bilhete Reservado</h2>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
