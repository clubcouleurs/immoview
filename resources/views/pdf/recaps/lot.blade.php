<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style>
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
            <td align="center" valign="middle">

            <img src="{{asset('storage/'. $produit->projet->entreprise->logo)}}" width="250">
            </td>

        </tr>
    </table>

    <table>
        <tr>                  
        </tr>
    </table>    



    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
        <tr class="top_rw">
           <td colspan="2">
              <h2 style="margin-bottom: 0px;"> Fiche produit </h2>
              <span style=""> Projet : {{$produit->projet->nom}} - {{$produit->projet->ville}}  </span>
           </td>
            <td  style="width:30%; margin-right: 10px;">
                Etat : <b>{{$produit->etiquette->label}}</b>
           </td>
        </tr>
        </table>                    
                    <table >
                        <tr class="top">
                            <td width="50%" class="top_rw">
Produit : <b>{{ucfirst($produit->constructible_type)}} N° {{$produit->constructible->num}} </b>
@isset($produit->constructible->num_cadastre)
    | N° cadastrale : <b>{{$produit->constructible->num_cadastre}} </b>     
@endisset
<br>
@isset($produit->constructible->titre_foncier)
    Titre foncier : <b>{{$produit->constructible->titre_foncier}} </b><br>     
@endisset  
</td>
<td class="top_rw">
    Tranche : <b>{{$produit->tranche}} </b><br>
</td>
<td class="top_rw">Etage : <b>{{$produit->etage}} </b><br></td>

</tr>
<tr>
<td class="top_rw">
Surface : <b>{{$produit->constructible->surface}} m² </b>
@isset($produit->constructible->surface_cadastre)
    | Surface cadastrale : <b>{{$produit->constructible->surface_cadastre}} m² </b>    
@endisset
</td>
<td colspan="2" class="top_rw">
Façades : <b>{{$produit->nombreFacade}}, de  {{$produit->descriptionVoies}} </b><br>
</td>



</tr>
<tr>

</tr>
<tr>

<td colspan="2" valign="middle" class="top_rw">
Prix total : <b>{{$produit->totalDefinitifFormat}} Dhs, <br>{{$produit->totalDefinitifLetter}}</b><br>  
</td>
<td class="top_rw">
Prix/ m² : <b>{{number_format($produit->prix, 2 , ',' , '.')}} Dhs </b><br>       
</td>
</tr>
<tr><td></td></tr>

                            
                       
                    </table>


            @isset($produit->dossier)
            <b>Vendu à : </b>
           
                    @foreach($produit->dossier->sanitizeClientInfos() as $txt)
                                 {!!$txt!!} 

                    @endforeach
            @endisset                    

                           
     @isset($paiements)
     <p><b>Historique des paiements : </b></p>
            <table cellspacing="0px" cellpadding="2px">
            <tr class="heading">
                <td style="width:5%;">
                    N°
                </td>
                <td style="width:15%; text-align:center;">
                    Montant
                </td>
                <td style="width:15%; text-align:right;">
                    Date
                </td>
                 <td style="width:15%; text-align:right;">
                   Type
                </td>
                 <td style="width:15%; text-align:right;">
                    N° Pièce
                </td>
                 <td style="width:10%; text-align:right;">
                   Banque
                </td>
                 <td style="width:15%; text-align:right;">
                   Etat
                </td>                
            </tr>
@foreach ($paiements as $paiement)
            <tr class="item">
               <td style="width:5%;">
{{$loop->iteration}}
                </td>
                <td style="width:15%; text-align:center;">
                    {{number_format($paiement->montant, 2 , ',' , '.')}}
                </td>
                <td style="width:15%; text-align:right;">
                    {{$paiement->date}}
                </td>
                 <td style="width:15%; text-align:right;">
                   {{$paiement->type}}
                </td>
                 <td style="width:15%; text-align:right;">
                    {{$paiement->num}}
                </td>
                 <td style="width:10%; text-align:right;">
                    {{isset($paiement->banque->abreviation) ? $paiement->banque->abreviation : ''}}
                </td>
                 <td style="width:10%; text-align:right;">
                    {{$paiement->etat}}
                </td>                
            </tr>
@endforeach            
            </table>
           <table cellpadding="0" cellspacing="0">
            <tr class="total">
                  <td colspan="3" align="right">
                    Total paiements encaissés :  <b> {{number_format($produit->dossier->totalPaiementsV)}} Dhs </b>
                    <b> {{$produit->dossier->totalPaiementsLettresV}} Dirhams </b>
                    <br>
                    Total paiements non-encaissés  :  <b> {{number_format($produit->dossier->totalPaiements - $produit->dossier->totalPaiementsV)}} Dhs </b>
                </td>
            </tr>            

        </table>
<table cellspacing="0px" cellpadding="2px">
                    <tr>
                        <td>
                        <b> Etat des avances : </b> <br>
Le(s) client(s) a/ont payé <b>
    <span style="font-size: 16px">{{$produit->dossier->tauxPaiementV}}% </span></b>
    du prix total du bien.
                        </td>
                        <td>
                            <br>

                            ...................................<br>
                         <b> Cachet & Signature de {{$produit->projet->entreprise->nom}}

                            
                        </td>
                    </tr>
                     <tr>

                    </tr>
                 </table>
                 <table cellspacing="0px" cellpadding="2px">
                     <tr>
                        <td>
                            
                            
                            <br>
                            <br>
                            <br>
                        </td>
                    </tr>
                 </table>                         
    </div>
 @endisset 
</body>
</html>
