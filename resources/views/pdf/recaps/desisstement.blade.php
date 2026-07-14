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

            <td align="center"><h1>DEMANDE DE DESISTEMENT</h1></td>
        </tr>
    </table>
    
    <div class="invoice-box">
                 <table cellspacing="0px" cellpadding="2px" width="70%">
                     <tr>
                        <td align="justify" colspan="2">
                            <p>
                            @if (count($dossier->clients) > 1)
                            Nous soussignés Mr/Mme
                            @else
                            Je soussigné Mr/Mme
                            @endif
                            @foreach ($dossier->clients as $client)
                            <b>{{$client->nom}} {{$client->prenom}}</b>, portant la <b>CIN N° : {{$client->cin}}</b>
                            @endforeach
                            attributaire du produit <b>N° : {{$dossier->produit->constructible->num}}</b>,
                            qui est du type <b>{{$dossier->produit->constructible_type}}</b>, dans le cadre du projet immobilier <b>{{$dossier->produit->projet->nom}}</b>, appartenant à la société <b>{{$dossier->produit->projet->entreprise->nom}}.</b></b></p>
                            <p>
                            Sur lequel j'ai effectué un total de versement d'un montant de
                            <b>{{number_format($dossier->TotalPaiementsV)}} Dhs.</b></p>
                            <p>
                            Je vous demande de me restituer l'intégralité des sommes versées sur ledit bien, déduction faite de l'indemnité de désistement d'un montant de <b>{{number_format($indemnite)}} Dhs ({{$tauxIndemnite}}%)</b>.
                            Je libère ainsi ledit bien de toute réserve afin que la société<b> {{$dossier->produit->projet->entreprise->nom}}</b> puisse en disposer librement.</p>
                            <br>
                            <br>
                            <br>
                            FAIT ET PASSÉ À {{ strtoupper($dossier->produit->projet->entreprise->ville) }}<br>
                            LE : {{dateOfToDay()}}
                        </td>
                    </tr>
                        <tr>
                        <td>
                            Signature légalisée du RESERVATAIRE
                        </td>                      
                        </tr>
                   
                 </table>   


    </div>
</body>
</html>
