<x-layout>
    <div class="row col-12">
        <div class="col-4">
            <div class="form-container">
                <h4 class="mb-4 fw-bold text-primary border-bottom pb-2">Détails de la Prime</h4>

                <form action="{{ route('categories.load', $employee) }}" method="POST" class="row g-3">
                    @csrf
                    <!-- Année -->
                    <div class="col-md-4">
                        <label for="txt_year" class="form-label fw-semibold text-secondary">Année</label>
                        <input type="number" class="form-control shadow-sm" id="txt_year" name="txt_year" value="2026">
                    </div>

                    <!-- Montant BRUT -->
                    <div class="col-md-8">
                        <label for="txt_gross" class="form-label fw-semibold text-secondary">Montant BRUT (MAD)</label>
                        <div class="input-group">
                            <input type="number" class="form-control shadow-sm calc-trigger" id="txt_gross" name="txt_gross" placeholder="0.00" step="0.01">
                            <span class="input-group-text bg-white">MAD</span>
                        </div>
                    </div>

                    <!-- IR (MAD) -->
                    <div class="col-md-6">
                        <label for="txt_ir" class="form-label fw-semibold text-secondary">Impôt sur le Revenu (IR)</label>
                        <div class="input-group">
                            <input type="number" class="form-control shadow-sm calc-trigger" id="txt_ir" name="txt_ir" placeholder="0.00" step="0.01">
                            <span class="input-group-text bg-white text-danger">MAD</span>
                        </div>
                    </div>

                    <!-- Montant NET (Readonly) -->
                    <div class="col-md-6">
                        <label for="txt_net" class="form-label fw-semibold text-success">Montant NET (Automatique)</label>
                        <div class="input-group">
                            <input type="number" class="form-control shadow-sm bg-light" id="txt_net" name="txt_net" readonly placeholder="0.00">
                            <span class="input-group-text bg-light">MAD</span>
                        </div>
                    </div>

                    <!-- MONTANT EN LETTRES -->
                    <div class="col-12">
                        <label for="txt_words" class="form-label fw-semibold text-secondary">Montant en Lettres (NET)</label>
                        <textarea class="form-control shadow-sm bg-light" id="txt_words" rows="2" name="txt_words" readonly placeholder="Le montant s'affichera ici..."></textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Valider le Formulaire</button>
                    </div>
                </form>
            </div>

        </div>
        <div class="col-8">
            <style>

                /* The blue outer border */
                #border {
                    position: fixed;
                    top: 30px;
                    left: 30px;
                    bottom: 70px;
                    right: 30px;
                    border: 1px solid #1e5a91;
                    z-index: -1;
                }

                /* Header & Footer adjustments */
                .banner-img { width: 100%; height: auto; margin-top: 20px; }
                #footer {
                    position: fixed;
                    bottom: 0.6cm;
                    right: 2cm;
                    width: 100px;
                }

                /* Title styling */
                .page-title {
                    font-size: 24px;
                    font-weight: 800;
                    margin: 60px 0;
                    text-align: center;
                    letter-spacing: 2px;
                }

                /* Document content styling */
                .content-body {
                    line-height: 2;
                    text-align: justify;
                    padding: 0 40px;
                    font-size: 15px;
                }

                /* Custom Table Style to match your design in Bootstrap */
                .table-custom-header {
                    background-color: #919191 !important;
                    color: white !important;
                    font-size: 11px;
                    letter-spacing: 1px;
                }

                .amount-text {
                    font-style: italic;
                    color: #6c757d;
                    font-size: 13px;
                }
            </style>
            </head>
            <body>

            <div id="border"></div>

            <!-- Administrative Header -->
            <div class="container-fluid px-5">
                <div class="row">
                    <div class="col-8">
                        <p class="mb-0 fw-bold">DIRECTION REGIONALE DES IMPOTS</p>
                        <p class="mb-0 ps-5 ms-3">DE MARRAKECH</p>
                        <small class="text-muted ps-5 ms-2">(N° {{ $employee->reference ?? '......./SRR/BRH-Mar' }})</small>
                    </div>
                    <div class="col-4 text-end">
                        <!-- Optional placeholder for QR or extra info -->
                    </div>
                </div>
            </div>

            <!-- Document Title -->
            <h1 class="page-title text-primary">ATTESTATION DE PRIME</h1>

            <!-- Content -->
            <div class="content-body">
                <p>
                    <span class="fw-bold fs-4">L</span>e Directeur Régional des Impôts de Marrakech soussigné, atteste que
                    {{ $civility }}. <strong class="text-uppercase">{{ $employee->firstname }} {{ $employee->lastname }}</strong>,
                    <span class="text-muted">{{ $grade }}</span>,
                    CNIE N° <strong>{{ $employee->cin }}</strong>, PPR <strong>{{ $employee->ppr }}</strong>,
                    est mis(e) à la disposition de la Direction Régionale des Impôts de Marrakech à compter du
                    <strong>{{ \Carbon\Carbon::parse($employee->disposition_date)->translatedFormat('d/m/Y') }}</strong>,
                    a perçu une prime d’un montant :
                </p>

                <!-- Bootstrap 5 Table Container -->
                <div class="table-responsive my-4 shadow-sm rounded-3 overflow-hidden border">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-custom-header">
                        <tr>
                            <th class="ps-4">ANNÉE</th>
                            <th class="text-end">BRUT (MAD)</th>
                            <th class="text-end">IR (MAD)</th>
                            <th class="text-end">NET (MAD)</th>
                            <th class="text-center">MONTANT EN LETTRES</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <tr>
                            <td class="ps-4 fw-bold"><p id="sl_year">----------</p></td>
                            <td class="text-end font-monospace"><p id="sl_brut">----------</p></td>
                            <td class="text-end text-danger font-monospace"><p id="sl_ir">----------</p></td>
                            <td class="text-end fw-bold text-success font-monospace"><p id="sl_net">----------</p></td>
                            <td class="text-center">
                            <span class="amount-text">
                                <p id="sl_letter">----------</p>
                            </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <p class="mt-5">
                    <strong>L</strong>a présente attestation est délivrée à l’intéressé(e), sur sa demande, pour servir et valoir ce que de droit.
                </p>

                <!-- Signature Date -->
                <div class="row mt-5">
                    <div class="col-6"></div>
                    <div class="col-6 text-end pe-5">
                        <p>Fait à Marrakech, le {{ \Carbon\Carbon::parse($employee->created_at)->locale('fr')->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>

    <script>
        // Form Inputs
        const yearInput = document.getElementById('txt_year');
        const grossInput = document.getElementById('txt_gross');
        const irInput = document.getElementById('txt_ir');
        const netInput = document.getElementById('txt_net');
        const wordsInput = document.getElementById('txt_words');

        // Document Preview Elements (The <p> tags)
        const slYear = document.getElementById('sl_year');
        const slBrut = document.getElementById('sl_brut');
        const slIr = document.getElementById('sl_ir');
        const slNet = document.getElementById('sl_net');
        const slLetter = document.getElementById('sl_letter');

        function updateCalculations() {
            // 1. Get Values
            const year = yearInput.value || '----------';
            const gross = parseFloat(grossInput.value) || 0;
            const ir = parseFloat(irInput.value) || 0;
            const net = Math.max(0, gross - ir);

            // 2. Update Form Fields
            netInput.value = net.toFixed(2);
            const letterValue = net > 0 ? numberToFrenchWords(net) + " DIRHAMS" : "";
            wordsInput.value = letterValue;

            // 3. Update Document Preview (<p> tags)
            slYear.innerText = year;
            slBrut.innerText = gross > 0 ? gross.toLocaleString('fr-FR', { minimumFractionDigits: 2 }) : '----------';
            slIr.innerText = ir > 0 ? ir.toLocaleString('fr-FR', { minimumFractionDigits: 2 }) : '----------';
            slNet.innerText = net > 0 ? net.toLocaleString('fr-FR', { minimumFractionDigits: 2 }) : '----------';
            slLetter.innerText = letterValue || '----------';
        }

        // Add event listeners to all inputs
        [yearInput, grossInput, irInput].forEach(input => {
            input.addEventListener('input', updateCalculations);
        });

        // French Number to Words Converter
        function numberToFrenchWords(n) {
            const amount = Math.floor(n);
            const cents = Math.round((n - amount) * 100);

            const units = ['', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf'];
            const tens = ['', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt', 'quatre-vingt-dix'];

            function convert(num) {
                if (num < 10) return units[num];
                if (num < 20) {
                    const specials = ['dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize'];
                    return num < 17 ? specials[num - 10] : 'dix-' + units[num % 10];
                }
                if (num < 100) {
                    const t = Math.floor(num / 10);
                    const u = num % 10;
                    if (u === 0) return tens[t];
                    if (u === 1 && t < 8) return tens[t] + '-et-un';
                    return tens[t] + '-' + (t === 7 || t === 9 ? convert(num % 10 + 10) : units[u]);
                }
                if (num < 1000) {
                    const c = Math.floor(num / 100);
                    const rest = num % 100;
                    let s = c === 1 ? 'cent' : units[c] + ' cent';
                    if (rest === 0) return s + (c > 1 ? 's' : '');
                    return s + ' ' + convert(rest);
                }
                if (num < 1000000) {
                    const m = Math.floor(num / 1000);
                    const rest = num % 1000;
                    let s = m === 1 ? 'mille' : convert(m) + ' mille';
                    if (rest === 0) return s;
                    return s + ' ' + convert(rest);
                }
                return num.toString();
            }

            let result = convert(amount).toUpperCase();
            if (cents > 0) {
                result += " ET " + convert(cents).toUpperCase() + " CENTIMES";
            }
            return result;
        }

        // Initialize display on load
        updateCalculations();
    </script>
</x-layout>
