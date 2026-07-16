<!DOCTYPE html>
<html>
<head>
<style>
h3 { color: #2b2f90; }
.top_rw{ background-color:#f4f4f4; }
.top_cw{ background-color:#cccccc; }

    .td_w{ }
    button{ padding:5px 10px; font-size:14px;}
    .invoice-box {
        max-width: 890px;
        margin: auto;
        padding:10px;
        border: 2px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 14px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
        border-bottom: solid 2px #ccc;
    }
    .invoice-box table td {
        padding: 5px;
        vertical-align:middle;
    }
/*    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }*/
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 2px solid #ddd;
        font-weight: bold;
        font-size:12px;
    }
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    .invoice-box table tr.item td{
        border-bottom: 2px solid #eee;
    }
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    .rtl table {
        text-align: right;
    }
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>

            <img src="{{asset('storage/'.  $logo)}}" width="250">

            </td>
            <td align="right"><h1>CONTRAT DE RESERVATION</h1>
                <h3>{{ strtoupper($type) }}</h3></td>
        </tr>
    </table>
    
    <div class="invoice-box">

    @foreach ($data as $article)
    
    <h3>{{ $article->titre }}</h3>
    <p align="justify">{!! nl2br( $article->texte ) !!} </p>
    <hr>
    @endforeach

                 <table cellspacing="0px" cellpadding="2px">
                     <tr>
                        <td align="center" colspan="2">
                            
                            
                            <br>
                            <br>
                            <br>
                            FAIT ET PASSÉ À {{ strtoupper($article->contrat->projet->entreprise->ville) }}<br>
                            LE : {{dateOfToDay()}}
                        </td>
                    </tr>
                        <tr>
                        <td>
                            POUR LE RESERVATAIRE
                        </td>
                        <td align="right">
                            POUR LE RESERVANT<br>
                            En vertu des pouvoirs qui<br>
                            m’ont été conférés<br>
                        </td>                        
                        </tr>
                   
                 </table>   


    </div>
</body>
</html>
