<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Classement {{ $composition->libelle }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #1E293B; padding: 15px; }

        .header { text-align: center; margin-bottom: 12px; }
        .header h1 { font-size: 13px; font-weight: bold; color: #00288e; text-transform: uppercase; }
        .header p { font-size: 9px; color: #444653; margin-top: 3px; }
        .ligne-sep { border-bottom: 2px solid #00288e; margin: 8px 0; }

        .titre { background: #00288e; color: white; text-align: center; padding: 6px; font-size: 11px; font-weight: bold; margin-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #00288e; color: white; }
        thead th { padding: 5px 4px; text-align: center; font-size: 8px; text-transform: uppercase; border: 1px solid #0039b3; }
        thead th.left { text-align: left; }
        tbody tr:nth-child(even) { background: #f8f9ff; }
        tbody tr.top1 { background: #fef3c7; }
        tbody tr.top2 { background: #f1f5f9; }
        tbody tr.top3 { background: #fff7ed; }
        tbody td { padding: 4px; border: 1px solid #c4c5d5; font-size: 8px; text-align: center; }
        tbody td.left { text-align: left; }
        tfoot tr { background: #eff4ff; }
        tfoot td { padding: 5px 4px; border: 1px solid #c4c5d5; font-size: 8px; font-weight: bold; text-align: center; color: #00288e; }

        .mention-tb { color: #166534; font-weight: bold; }
        .mention-b  { color: #1e40af; font-weight: bold; }
        .mention-ab { color: #3730a3; font-weight: bold; }
        .mention-p  { color: #92400e; font-weight: bold; }
        .mention-i  { color: #991b1b; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ auth()->user()->nom_ecole }}</h1>
        <p>{{ auth()->user()->region }} — Année scolaire : {{ auth()->user()->annee_scolaire }}</p>
    </div>

    <div class="ligne-sep"></div>

    @php
        $libelle = strtoupper($composition->libelle);
    @endphp

    <div class="titre">
        CLASSEMENT PAR ORDRE DE MÉRITE — 
        @if(str_contains($libelle, 'T3'))
            3em TRIMESTRE
        @elseif(str_contains($libelle, 'T2'))
            2em TRIMESTRE
        @elseif(str_contains($libelle, 'T1'))
            1er TRIMESTRE
        @else
            {{ $libelle }}
        @endif
        — CLASSE : {{ $composition->classe->nom }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">Rang</th>
                <th class="left" style="width: 120px;">Élève</th>
                @foreach($matieres as $matiere)
                <th style="width: 35px;">{{ Str::limit($matiere->nom, 6) }}<br>/{{ $matiere->note_sur }}</th>
                @endforeach
                <th style="width: 35px;">Total</th>
                <th style="width: 35px;">Moy/10</th>
                <th style="width: 50px;">Mention</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resultats as $resultat)
            @php
                $rowClass = $resultat['rang'] == 1 ? 'top1' : ($resultat['rang'] == 2 ? 'top2' : ($resultat['rang'] == 3 ? 'top3' : ''));
                $mentionClass = match($resultat['mention']) {
                    'Très Bien'  => 'mention-tb',
                    'Bien'       => 'mention-b',
                    'Assez Bien' => 'mention-ab',
                    'Passable'   => 'mention-p',
                    default      => 'mention-i',
                };
            @endphp
            <tr class="{{ $rowClass }}">
                <td><strong>{{ $resultat['rang'] }}</strong></td>
                <td class="left">{{ $resultat['eleve']->prenom }} {{ $resultat['eleve']->nom }}</td>
                @foreach($matieres as $matiere)
                @php $nd = $resultat['notes'][$matiere->id] ?? null; @endphp
                <td>{{ $nd && $nd['note'] !== null ? $nd['note'] : '—' }}</td>
                @endforeach
                <td><strong>{{ number_format($resultat['totalPoints'], 2) }}</strong></td>
                <td><strong>{{ number_format($resultat['moyenne'], 2) }}</strong></td>
                <td class="{{ $mentionClass }}">{{ $resultat['mention'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: left; padding-left: 4px;">Moyenne de la classe</td>
                @foreach($matieres as $matiere)
                @php
                    $moyMat = $resultats->avg(function($r) use ($matiere) {
                        $n = $r['notes'][$matiere->id] ?? null;
                        return $n && $n['note'] !== null ? $n['note_ramenee'] : null;
                    });
                @endphp
                <td>{{ $moyMat ? number_format($moyMat, 2) : '—' }}</td>
                @endforeach
                <td>—</td>
                <td>{{ number_format($moyenneClasse, 2) }}/10</td>
                <td>—</td>
            </tr>
        </tfoot>
    </table>

    <p style="margin-top: 10px; font-size: 8px; color: #94a3b8; text-align: right;">
        Généré le {{ now()->format('d/m/Y à H:i') }} — Senegal EdTech
    </p>

</body>
</html>