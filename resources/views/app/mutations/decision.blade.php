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
            font-size: 14px;
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
            <span style="font-size: 12px; margin-left: 55px"> N° ......./SRRSI/MAR/{{ date('Y') }} </span>
        </td>
        <td style="text-align: right; vertical-align: top;">
            Marrakech, le {{ \Carbon\Carbon::parse(now())->locale('fr')->translatedFormat('d F Y') }}
        </td>
    </tr>
</table>

<div class="title">
    LE DIRECTEUR REGIONAL DES IMPOTS <br><br>
    DE MARRAKECH <br><br>
    A <br><br>
    <strong>
    {{ $mutation->employee->gender == 'F' ? 'Mme' : 'M' }}
    {{ strtoupper($mutation->employee->lastname) }} {{ $mutation->employee->firstname }}
    </strong>, <br><br>
    {{ $mutation->employee->competences->whereNull('finished_date')->first()->grade->title }}, <br><br>
    @if (!is_null($mutation->fromAffectation->section))
        {{ $mutation->fromAffectation->section->title }} <br><br>
    @endif
    @if (!is_null($mutation->fromAffectation->sector))
        {{ $mutation->fromAffectation->sector->title }} <br><br>
    @endif
    @if (!is_null($mutation->fromAffectation->entity))
        {{ $mutation->fromAffectation->entity->title }} <br><br>
    @endif
    @if (!is_null($mutation->fromAffectation->service))
        {{ $mutation->fromAffectation->service->title }} <br><br>
    @endif
    @if (!is_null($mutation->employee->local))
        {{ $mutation->employee->local->city->title }} <br><br>
    @endif


</div>

<div class="content">
    <u>Objet</u> : Mutation <br>

    @if (!is_null($mutation->demand))
        <u>REF</u>  : votre demande de mutation du {{ \Carbon\Carbon::parse($mutation->demand->demand_date)->locale('fr')->translatedFormat('d/m/Y') }}. <br><br>
    @endif

    @if (!is_null($mutation->demand))
        Suite à votre demande,
    @else
        Pour nécessité de service,
    @endif
    j’ai l'honneur de vous informer, que vous êtes muté(e), au
    @if (!is_null($mutation->toAffectation))
            @if (!is_null($mutation->toAffectation->section))
                {{ $mutation->toAffectation->section->title }} de
            @endif
            @if (!is_null($mutation->toAffectation->sector))
                {{ $mutation->toAffectation->sector->title }} de
            @endif
            @if (!is_null($mutation->toAffectation->entity))
                {{ $mutation->toAffectation->entity->title }} relevant
            @endif
            @if (!is_null($mutation->toAffectation->service))
                {{ $mutation->toAffectation->service->title }}
            @endif
    @else
        @if (!is_null($mutation->entity_name))
            {{ $mutation->entity_name ?? 'N/A' }} de
        @endif
        @if (!is_null($mutation->direction_name))
                {{ $mutation->direction_name ?? 'N/A' }}
        @endif
        @if ( !is_null($mutation->city_name))
                {{ $mutation->city_name ?? 'N/A' }}
        @endif
    @endif
    et ce à compter du <strong>{{ \Carbon\Carbon::parse($mutation->starting_date)->locale('fr')->translatedFormat('d F Y') }}</strong>.

    <div id="footer">
        <img src="{{ public_path('images/footer.jpg') }}" class="footer-img">
    </div>

</div>

</body>
</html>
