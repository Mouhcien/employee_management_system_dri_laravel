<!DOCTYPE html>
<html lang="ar">
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

        .date-end {
            float: left;
            margin-top: 50px;
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
    المدير الجهوي للضرائب بمراكش <br>
    إلى <br>
    السيد رئيس الجماعة الحضرية لقلعة السراغنة<br>
</div>

<div class="content" style="text-indent: 50px;">
    <strong>L</strong>e soussigné atteste que,


</div>


<div id="footer">
    <img src="{{ public_path('images/footer.jpg') }}" class="footer-img">
</div>

</body>
</html>
