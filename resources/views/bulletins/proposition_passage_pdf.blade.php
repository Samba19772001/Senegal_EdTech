<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Proposition de Passage</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #1E293B; padding: 15px; }

        .header { text-align: center; margin-bottom: 10px; }
        .header h1 { font-size: 13px; font-weight: bold; color: #00288e; text-transform: uppercase; }
        .header p { font-size: 9px; color: #444653; margin-top: 2px; }
        .ligne-sep { border-bottom: 2px solid #00288e; margin: 7px 0; }
        .titre { background: #00288e; color: white; text-align: center; padding: 6px; font-size: 11px; font-weight: bold; margin-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #00288e; color: white; }
        thead th { padding: 5px 4px; text-align: center; font-size: 8px; text-transform: uppercase; border: 1px solid #0039b3; }
        thead th.left { text-align: left; }
        tbody tr:nth-child(even) { background: #f8f9ff; }
        tbody tr.redouble { background: #fee2e2; }
        tbody td { padding: 4px; border: 1px solid #c4c5d5; font-size: 8.5px; text-align: center; }
        tbody td.left { text-align: left; }
        tfoot tr { background: #eff4ff; }
        tfoot td { padding: 5px 4px; border: 1px solid #c4c5d5; font-size: 8px; font-weight: bold; text-align: center; color: #00288e; }

        .admis    { color: #166534; font-weight: bold; }
        .redouble-text { color: #991b1b; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>IA : {{ auth()->user()->region }} — IEF : {{ auth()->user()->departement }}</h1>
        <h1 style="margin-top:3px;">{{ auth()->user()->nom_ecole }}</h1>
        <p>Année scolaire : {{ auth()->user()->annee_scolaire }}</p>
    </div>

    <div class="ligne-sep"></div>

    <div class="titre">
        TABLEAU DE PROPOSITION DE PASSAGE — CLASSE : {{ $composition->classe->nom }}
    </div>

    {{-- Stats --}}
    <table style="margin-bottom: 10px;">
        <tr style="background: #eff4ff;">
            <td style="padding:4px 8px; border:1px solid #c4c5d5; text-align:center; font-size:8px;">
                <strong>Effectif :</strong> {{ $resultats->count() }}
            </td>
            <td style="padding:4px 8px; border:1px solid #c4c5d5; text-align:center; font-size:8px; color:#166534;">
                <strong>Admis :</strong> {{ $resultats->where('decision', 'Passe en classe supérieure')->count() }}
            </td>
            <td style="padding:4px 8px; border:1px solid #c4c5d5; text-align:center; font-size:8px; color:#991b1b;">
                <strong>Redoublants :</strong> {{ $resultats->where('decision', 'Redouble')->count() }}
            </td>
            <td style="padding:4px 8px; border:1px solid #c4c5d5; text-align:center; font-size:8px; color:#00288e;">
                <strong>Moy. annuelle :</strong>
                {{ $resultats->whereNotNull('moyAnnuelle')->avg('moyAnnuelle')
                    ? number_format($resultats->whereNotNull('moyAnnuelle')->avg('moyAnnuelle'), 2)
                    : '—' }}/10
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width:25px;">Rang</th>
                <th class="left" style="width:110px;">Prénom & Nom</th>
                <th style="width:22px;">Sexe</th>
                <th style="width:40px;">Moy. T1</th>
                <th style="width:40px;">Moy. T2</th>
                <th style="width:40px;">Moy. T3</th>
                <th style="width:45px;">Moy. Ann.</th>
                <th style="width:80px;">Observation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resultats as $r)
            @php
                $estAdmis = $r['decision'] == 'Passe en classe supérieure';
                $rowClass = !$estAdmis ? 'redouble' : '';
            @endphp
            <tr class="{{ $rowClass }}">
                <td><strong>{{ $r['rang'] }}</strong></td>
                <td class="left">{{ $r['eleve']->prenom }} {{ $r['eleve']->nom }}</td>
                <td>{{ $r['eleve']->sexe }}</td>
                @foreach([1,2,3] as $t)
                <td>{{ $r['moyennes'][$t] !== null ? number_format($r['moyennes'][$t], 2) : '—' }}</td>
                @endforeach
                <td><strong>{{ $r['moyAnnuelle'] !== null ? number_format($r['moyAnnuelle'], 2) : '—' }}/10</strong></td>
                <td class="{{ $estAdmis ? 'admis' : 'redouble-text' }}">
                    {{ $estAdmis ? 'Passe en classe sup.' : 'Redouble' }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align:left; padding-left:4px;">Moyenne annuelle de la classe</td>
                <td>
                    {{ $resultats->whereNotNull('moyAnnuelle')->avg('moyAnnuelle')
                        ? number_format($resultats->whereNotNull('moyAnnuelle')->avg('moyAnnuelle'), 2)
                        : '—' }}/10
                </td>
                <td>—</td>
            </tr>
        </tfoot>
    </table>

    <p style="margin-top: 10px; font-size: 8px; color: #94a3b8; text-align: right;">
        Généré le {{ now()->format('d/m/Y à H:i') }} — Senegal EdTech
    </p>

</body>
</html>