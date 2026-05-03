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
            font-size: 15px;
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

        /* Container for rounded corners and shadow */
        .table-container {
            width: 650px;
            margin: 30px auto; /* Centers the container horizontally */
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e0e6ed;
            /* Basic shadow for web view, usually ignored in PDF */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .modern-table {
            width: 100%; /* Fills the 650px container */
            border-collapse: collapse;
            table-layout: fixed; /* Forces the table to stay exactly 650px */
        }

        .modern-table th,
        .modern-table td {
            padding: 12px 15px;
            word-wrap: break-word; /* Prevents long text from breaking the layout */
        }

        /* Ensure the words column is centered if requested */
        .amount-words {
            font-style: italic;
            color: #64748b;
            font-size: 13px;
            text-align: center;      /* Centering the text inside the cell */
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        /* Header Styling */
        .modern-table thead {
            background-color: #919191;
        }

        .modern-table th {
            padding: 16px 20px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #eeeeee;
            font-weight: 700;
            border-bottom: 2px solid #eef2f7;
        }

        /* Row & Cell Styling */
        .modern-table td {
            padding: 18px 20px;
            font-size: 14px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        /* Hover effect for rows */
        .modern-table tbody tr:hover {
            background-color: #fcfdfe;
            transition: background 0.2s ease;
        }

        /* Specific text treatments */
        .text-end { text-align: right; }
        .font-monospace { font-family: 'Courier New', monospace; letter-spacing: -0.5px; }
        .text-success { color: #2dce89 !important; }
        .text-danger { color: #f5365c !important; }
        .text-primary { color: #5e72e4 !important; }

        .amount-words {
            font-style: italic;
            color: #64748b;
            font-size: 13px;
            max-width: 250px;
        }

        /* Remove border from last row */
        .modern-table tbody tr:last-child td {
            border-bottom: none;
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
    ATTESTATION DE PRIME
</div>

<div class="content" style="text-indent: 50px;">
    <strong>L</strong>e Directeur Régional des Impôts de Marrakech soussigné, atteste que

    {{ $civility }}. <strong>{{ $employee->firstname }} {{ $employee->lastname }}</strong>, <strong>{{ $grade }}</strong>,
    CNIE N° {{ $employee->cin }}, PPR {{ $employee->ppr }}, est mis(e) à la disposition de la Direction Régionale des Impôts de Marrakech
    à compter du <strong>{{ \Carbon\Carbon::parse($employee->disposition_date)->translatedFormat('d/m/Y') }}</strong>, a perçu une prime d’un montant :
    <br><br>

    <div class="table-container">
        <table class="modern-table">
            <thead>
            <tr>
                <th style="width: 15%;">ANNEE</th>
                <th class="text-end" style="width: 20%;">BRUT (MAD)</th>
                <th class="text-end" style="width: 20%;">IR (MAD)</th>
                <th class="text-end" style="width: 20%;">NET (MAD)</th>
                <th>MONTANT EN LETTRES</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="fw-bold">{{ $year }}</td>
                <td class="text-end"> {{ number_format($gross, 2, ',', ' ') }}</td>
                <td class="text-end"> {{ number_format($ir, 2, ',', ' ') }}</td>
                <td class="text-end fw-bold"> {{ number_format($net, 2, ',', ' ') }}</td>
                <td class="amount-words">
                    {{ $words }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="closing-statement">
        <strong>L</strong>a présente attestation est délivrée à l’intéressé(e), sur sa demande, pour servir et valoir ce que de droit.
    </div>

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="width: 60%;">
            </td>
            <td style="text-align: right; vertical-align: top;">
                Fait Marrakech, le {{ \Carbon\Carbon::parse($employee->created_at)->locale('fr')->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>
</div>


<div id="footer">
    <img src="{{ public_path('images/footer.jpg') }}" class="footer-img">
</div>

</body>
</html>
