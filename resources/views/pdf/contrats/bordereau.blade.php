<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Autorisation de Versement - JNAN LKHIR</title>
    <style>
        @page {
            margin: 20pt; /* Marges de la page PDF */
        }
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.3;
        }
        
        /* Utilitaires */
        .text-blue { color: #000000; font-weight: bold;}
        .text-bold { font-weight: bold; }
        .text-center { text-align: center; }
        
        /* Structure de base en tableaux */
        table.main-layout {
            width: 100%;
            border-collapse: collapse;
        }
        
        /* --- EN-TÊTE --- */
        .header-table {
            width: 100%;
            margin-bottom: 20pt;
        }
        .logo-section {
            width: 25%;
            text-align: left;
        }
        .logo-placeholder {
            /* Simule le logo DAR SUD */
            width: 80pt;
            height: 60pt;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            font-size: 14pt;
        }
        .title-section {
            width: 75%;
            text-align: center;
            padding-right: 50pt;
        }
        .main-title {
            font-size: 20pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 0;
        }
        .sub-title {
            font-size: 12pt;
            margin-top: 5pt;
        }
        
        /* --- CADRES ARRONDIS (fieldset style) --- */
        .framed-box {
            border: 1pt solid #999;
            border-radius: 10pt;
            padding: 10pt;
            margin-bottom: 10pt;
            position: relative;
        }
        .framed-box-title {
            position: absolute;
            top: -8pt;
            left: 20pt;
            background-color: white;
            padding: 0 5pt;
            font-weight: bold;
            font-size: 11pt;
            text-transform: uppercase;
        }
        
        /* --- SECTION PRODUIT --- */
        table.produit-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5pt;
        }
        table.produit-table td {
            text-align: center;
            padding: 2pt;
        }
        .label {
            font-weight: bold;
            display: block;
            margin-bottom: 3pt;
        }
        .input-sim {
            display: inline-block;
            border: 1pt solid #ccc;
            border-radius: 5pt;
            padding: 4pt 15pt;
            min-width: 30pt;
            text-align: center;
        }
        
        /* --- SECTION BANQUE (Col Droite) --- */
        .banque-box {
            border: 1pt solid #999;
            border-radius: 10pt;
            padding: 10pt;
            padding-bottom: 100pt;
            font-size: 9pt;
        }
        .banque-header {
            font-weight: bold;
            text-align: center;
            margin-bottom: 5pt;
        }
        .banc-cadre-reserve {
            text-align: center;
            margin-top: 15pt;
            margin-bottom: 15pt;
        }
        .line-spacer {
            margin-bottom: 12pt;
        }
        .checkbox-sim {
            display: inline-block;
            width: 15pt;
            height: 15pt;
            border: 1pt solid #ccc;
            border-radius: 4pt;
            vertical-align: middle;
            margin-left: 5pt;
            margin-right: 10pt;
        }
        .dot-line {
            border-bottom: 1pt dotted #333;
            display: inline-block;
            width: 150pt;
            height: 1pt;
            vertical-align: bottom;
        }
        .cachet-section {
            margin-top: 60pt;
            text-align: center;
            font-weight: bold;
        }
        
        /* --- FOOTER IMPORTANT --- */
        .important-footer {
            margin-top: 15pt;
            font-size: 7.5pt;
            color: #555;
        }
        .important-title {
            font-weight: bold;
            color: #333;
        }
        ul.important-list {
            margin: 2pt 0 0 15pt;
            padding: 0;
            list-style-type: decimal;
        }
        ul.important-list li {
            margin-bottom: 1pt;
        }

    </style>
</head>
<body>

    <!-- Tableau de mise en page principal (2 Colonnes) -->
    <table class="main-layout">
        <tr>
            <!-- COLONNE GAUCHE (70%) -->
            <td style="width: 70%; vertical-align: top; padding-right: 15pt;">
                
                <!-- EN-TÊTE GAUCHE -->
                <table class="header-table">
                    <tr>
                        <td class="logo-section">
                            <!-- Remplacer par <img src="chemin/vers/logo.png"> pour le PDF -->
                            <div class="logo-placeholder">
                                <img src="{{asset('storage/'. $logo)}}" width="100%">
                            </div>
                        </td>
                        <td class="title-section">
                            <h1 class="main-title">AUTORISATION DE VERSEMENT</h1>
                            <p class="sub-title text-bold">
                                PROJET : {{$dossier->produit->projet->nom}}</p>
                        </td>
                    </tr>
                </table>

                <!-- SECTION PRODUIT -->
                <div class="framed-box">
                    <span class="framed-box-title">PRODUIT</span>
                    <table class="produit-table">
                        <tr>
                            <td>
                                <span class="label">Tranche</span>
                                <span class="input-sim text-blue">
                                    {{$dossier->produit->tranche}}
                                </span>
                            </td>
                            <td>
                                <span class="label">Immeuble</span>
                                <span class="input-sim text-blue">
                                    {{$dossier->produit->immeuble}}
                                </span>
                            </td>
                            <td>
                                <span class="label">Etage</span>
                                <span class="input-sim text-blue">
                                    {{$dossier->produit->etage}}
                                </span>
                            </td>
                            <td>
                                <span class="label">N°</span>
                                <span class="input-sim text-blue">
                                    {{$dossier->produit->constructible->num}}
                                </span>
                            </td>
                            <td>
                                <span class="label">Surface (m²)</span>
                                <span class="input-sim text-blue">
                                    {{$dossier->produit->constructible->surface}}
                                </span>
                            </td>
                        </tr>
                    </table>
                    <p style="margin-top: 10pt; margin-left: 5pt;">
                        <span class="text-bold">Commercial :</span>
                        <span class="text-blue">{{$dossier->user->name}}</span>
                    </</p>
                </div>

                <!-- SECTION CLIENT -->
                <div class="framed-box">
                    <span class="framed-box-title">CLIENT (s)</span>
                    <div class="text-blue" style="margin-top: 5pt; padding-left: 5pt;">
                        @foreach ($dossier->clients as $client)
                        <p style="margin: 0 0 5pt 0;">
                        Monsieur/Madame : {{ucfirst($client->nom)}} {{ucfirst($client->prenom)}}
                        - Mobile : {{$client->mobile}}</p>
                        <p style="margin: 0 0 5pt 0;">
                        Demeurant à : {{$client->adresse}}</p>
                        <p style="margin: 0 0 5pt 0;">
                        Titulaire de la carte d'identité nationale N° : {{$client->cin}}</p>
                        ---
                        @endforeach
                    </div>
                </div>

                <!-- SECTION ÉMISSION / MONTANT -->
                <div class="framed-box">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 2pt 5pt;">
                                <span class="text-bold">Emission le :</span> <span class="text-blue">
                                    {{date("j/n/Y")}}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 2pt 5pt;">
                                <span class="text-bold">Montant à verser en chiffres :</span>
                                <div class="text-blue text-bold" style="margin-top: 2pt;">
                                    {{number_format($bordereau->montant)}} Dirhams.
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10pt 5pt 2pt 5pt;">
                                <span class="text-bold">Montant à verser en lettres (Dh):</span>
                                <div class="text-blue text-bold" style="margin-top: 2pt;">
                                    {{$montantEnLetters}} Dirhams.
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

            </td>

            <!-- COLONNE DROITE (30% - SECTION BANQUE) -->
            <td style="width: 30%; vertical-align: top; padding-bottom: 20px;">
                <div class="banque-box">
                    <div class="banque-header text-blue">
                        A REMETTRE A LA BANQUE
                    </div>
                    <div class="text-blue text-center" style="margin-top: 5pt;">
                        Banque {{strtoupper($bordereau->banque->abreviation)}} 
                        COMPTE N° :<br>  {{$bordereau->banque->num}}
                    </div>
                    
                    <div class="banc-cadre-reserve">
                        <span class="text-bold" style="border-bottom: 1pt solid #333; padding-bottom: 2pt;">
                            Cadre réservé à la banque
                        </span>
                    </div>

                    <div class="line-spacer text-bold">Montant :</div>
                    <div class="line-spacer text-bold">Réglé le :</div>
                    
                    <div class="line-spacer">
                        <span class="checkbox-sim"></span><span class="text-bold">Par chèque :</span> <br>
                        <span class="checkbox-sim"></span><span class="text-bold">En Espèce :</span> 
                    </div>

                    <div class="line-spacer text-bold">Numéro :</div>
                    <div class="line-spacer text-bold">Banque :</div>
                    <div class="line-spacer text-bold">Quittance n°:</div>
                    
                    <div style="margin-top: 10pt; text-align: center;">
                        <span class="dot-line"></span>
                    </div>

                    <div class="cachet-section">Cachet</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- ZONE IMPORTANT FOOTER -->
    <div class="important-footer">
        <span class="important-title">Important :</span>
        <ul class="important-list">
            <li>Le réservataire ci-dessus désigné est tenu de s'acquiter du versement dont le montant est fixé ci-dessus,</li>
            <li>Le réservataire remettra une photocopie de la déclaration de paiement remise par la banque au bureau commercial de {{$dossier->produit->projet->nom}},</li>
            <li>Le numéro de l'autorisation du versement doit être mentionné sur l'avis de crédit,</li>
            <li>Délai de délivrance de l'acte de réservation : immédiatement après versement en espèces et 72h pour les chèques et les effets,</li>
            <li>L'acte de réservation ne sera délivré qu'après le versement intégral de 30% du montant.</li>
        </ul>
    </div>

</body>
</html>