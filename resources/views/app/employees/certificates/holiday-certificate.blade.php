<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 13px; margin: 20px; padding-top: 50px }
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .header-table td { vertical-align: top; width: 33%; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        /* Remove body margins if you want the logo to go edge-to-edge */
        @page {
            margin: 0cm;
        }

        body {
            margin: 1.5cm; /* Re-apply margin to body text instead of the whole page */
            font-family: 'Tahoma', sans-serif;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            /* Pull the table up to the top if page margin is 0 */
            margin-top: -1.5cm;
        }

        .header-table td {
            padding: 0;
            text-align: center;
        }

        .banner-img {
            width: 100%;      /* Forces image to span full width of the table */
            height: auto;     /* Maintains aspect ratio */
            display: block;   /* Removes tiny gap at the bottom of images */
            margin-top: 20px;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin: 50px 0;
        }

        .content {
            line-height: 1.8;
            text-align: justify;
            margin: 0 40px;
            font-size: 12px;
        }

        #border {
            position: fixed;
            top: 30px;
            left: 30px;
            bottom: 70px;
            right: 30px;
            border: 1px solid #1e5a91; /* Adjust thickness as needed */
            z-index: -1;
        }

        #footer {
            position: fixed;
            bottom: 0.6cm; /* Distance from the bottom border */
            right: 2cm;  /* Distance from the right border */
            width: 100px;  /* Adjust based on your image size */
            text-align: right;
        }

        .footer-img {
            width: 100%;
            height: auto;
        }

        .decide-title {
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 3px;
            text-decoration: underline;
            margin-bottom: 20px;
            width: 100%; /* Ensures it takes full width to find the center */
        }

        .simple-border {
            border: 2px solid #1e5a91; /* Thickness, Style, Color */
            padding: 20px;
            border-radius: 8px; /* Optional: rounds the corners */
        }

    </style>
</head>
<body>

<div id="border"></div>

<table class="header-table">
    <tr>
        <td>
            <img src="{{ public_path('images/bannerdgi.jpg') }}" class="banner-img">
        </td>
    </tr>
</table>

<table style="width: 100%; margin-top: 20px;">
    <tr>
        <td style="width: 60%;">
            <p style="">DIRECTION REGIONALE DES IMPOTS</p>
            <p style="margin-left: 65px">DE MARRAKECH</p>
            <span style="font-size: 12px; margin-left: 55px">(N° {{ $employee->reference ?? '......./SRR/BRH-Mar' }}) </span>
        </td>
        <td style="text-align: right; vertical-align: top;">

        </td>
    </tr>
</table>

<div class="title">
    DÉCISION DE CONGÉ
</div>

<div class="content" >

    Le Ministre de l’Economie et des Finances:

    <div class="simple-border">
        <strong>V</strong>u la  réglementation sur les congés du personnel des Administrations Publiques.<br>
        <strong>V</strong>u la demande de congé présentée  par {{ $civility }}. <strong>{{ $employee->firstname }} {{ $employee->lastname }}</strong>, <strong>{{ $grade }}</strong>.<br>
        <ul>
            <li><strong> C.N.I. N°: {{ $employee->cin }}  </strong> </li>
            <li><strong> P.P.R  N°: {{ $employee->ppr }} </strong> </li>
        </ul>

        <strong>V</strong>u l’état des congés de l’année en cours ; <br>
        <strong>V</strong>u l’avis favorable du chef immédiat de l’intéressé(e).

        <h4 class="decide-title">DECIDE</h4>
        <table style="width: 100%">
            <tr>
                <td style="width: 20%"> <h5>ARTICLE 1 </h5> </td>
                <td>
                    : Un congé rémunéré d’une durée de <strong> {{ is_null($employee->holidays->last()) ? 'N/A' : $employee->holidays->last()->demand }} Jours ouvrables </strong> est accordé à <strong>{{ $employee->firstname }} {{ $employee->lastname }}</strong>
                    à compter du <strong>{{ is_null($employee->holidays->last()) ? 'N/A' : \Carbon\Carbon::parse($employee->holidays->last()->starting_date)->locale('fr')->translatedFormat('d F Y') }}.</strong>
                </td>
            </tr>
            <tr>
                <td> <h5>ARTICLE 2</h5> </td>
                <td>
                    : L’intéressé(e) déclare vouloir bénéficier de son congé à l’étranger.
                </td>
            </tr>
        </table>

    </div>

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="width: 40%;">
            </td>
            <td style="text-align: right; vertical-align: top;">
                Marrakech, le {{ \Carbon\Carbon::parse(now())->locale('fr')->translatedFormat('d F Y') }} <br>
                <b>Pour le Ministre de l’Economie et des Finances</b>
            </td>
        </tr>
    </table>
</div>


<div id="footer">
    <img src="{{ public_path('images/footer.jpg') }}" class="footer-img">
</div>

</body>
</html>
