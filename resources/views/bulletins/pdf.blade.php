<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin — {{ $eleve->prenom }} {{ $eleve->nom }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1E293B; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #00288e; padding-bottom: 12px; margin-bottom: 16px; }
        .header h1 { font-size: 13px; color: #00288e; font-weight: bold; text-transform: uppercase; }
        .header p { font-size: 10px; color: #444653; margin-top: 2px; }
        .titre-bulletin { background: #00288e; color: white; text-align: center; padding: 8px; font-size: 13px; font-weight: bold; margin-bottom: 14px; }
        .infos-eleve { display: flex; justify-content: space-between; background: #eff4ff; padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; }
        .infos-eleve p { font-size: 10px; color: #444653; }
        .infos-eleve strong { color: #1E293B; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        thead tr { background: #00288e; color: white; }
        thead th { padding: 7px 10px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        tbody tr:nth-child(even) { background: #f8f9ff; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #c4c5d5; font-size: 10px; }
        .note-ramene { color: #00288e; font-weight: bold; }
        .total-row { background: #00288e !important; color: white; }
        .total-row td { padding: 8px 10px; font-weight: bold; font-size: 11px; }
        .mention { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: bold; }
        .mention-tb { background: #dcfce7; color: #166534; }
        .mention-b  { background: #dbeafe; color: #1e40af; }
        .mention-ab { background: #e0e7ff; color: #3730a3; }
        .mention-p  { background: #fef3c7; color: #92400e; }
        .mention-i  { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 20px; display: flex; justify-content: space-between; }
        .signature-box { border-top: 1px solid #c4c5d5; width: 160px; text-align: center; padding-top: 6px; font-size: 10px; color: #444653; }
    </style>
</head>
<body>

    {{-- En-tête --}}
    <div class="header">
        <h1>{{ $eleve->user->nom_ecole }}</h1>
        <p>Région : {{ $eleve->user->region }} — {{ $eleve->user->commune }}</p>
        <p>Année scolaire : {{ $eleve->user->annee_scolaire }}</p>
    </div>

    {{-- Titre --}}
    <div class="titre-bulletin">
        BULLETIN DE COMPOSITION — {{ strtoupper($composition->libelle) }} — CLASSE : {{ $composition->classe->nom }}
    </div>

    {{-- Infos élève --}}
    <div class="infos-eleve">
        <p>Élève : <strong>{{ $eleve->prenom }} {{ $eleve->nom }}</strong></p>
        <p>Matricule : <strong>{{ $eleve->matricule ?? '—' }}</strong></p>
        <p>Sexe : <strong>{{ $eleve->sexe == 'M' ? 'Garçon' : 'Fille' }}</strong></p>
        <p>Trimestre : <strong>{{ $composition->trimestre }}</strong></p>
    </div>

    {{-- Tableau des notes --}}
    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Note obtenue</th>
                <th>Sur</th>
                <th>Note / 10</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
            <tr>
                <td>{{ $note->matiere->nom }}</td>
                <td>{{ $note->note }}</td>
                <td>{{ $note->matiere->note_sur }}</td>
                <td class="note-ramene">{{ number_format($note->note * 10 / $note->matiere->note_sur, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tr class="total-row">
            <td colspan="3">Moyenne Générale — Rang : {{ $rang }}<sup>ème</sup></td>
            <td>{{ number_format($moyenne, 2) }} / 10</td>
        </tr>
    </table>

    {{-- Mention --}}
    <p style="text-align:center; margin-bottom: 20px;">
        Mention :
        @php
        $cls = match($mention) {
            'Très Bien'  => 'mention-tb',
            'Bien'       => 'mention-b',
            'Assez Bien' => 'mention-ab',
            'Passable'   => 'mention-p',
            default      => 'mention-i',
        };
        @endphp
        <span class="mention {{ $cls }}">{{ $mention }}</span>
    </p>

    {{-- Signatures --}}
    <div class="footer">
        <div class="signature-box">Le Directeur</div>
        <div class="signature-box">L'Enseignant(e)</div>
        <div class="signature-box">Parent / Tuteur</div>
    </div>

</body>
</html>