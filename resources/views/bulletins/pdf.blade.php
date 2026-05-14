<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin — {{ $eleve->prenom }} {{ $eleve->nom }}</title>
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1E293B; padding: 20px; }

    /* EN-TETE */
    .entete { width: 100%; margin-bottom: 12px; }
    .entete td { vertical-align: top; padding: 0 8px; border: none; }
    .republique { font-size: 10px; font-weight: bold; text-transform: uppercase; color: #1E293B; text-align: center; }
    .devise { font-size: 9px; color: #444653; text-align: center; margin-top: 3px; }
    .drapeau { margin: 8px auto; width: 50px; height: 32px; border: 0.5px solid #ccc; overflow: hidden; }
    .drapeau-vert  { background: #00853F; width: 33.33%; height: 100%; float: left; }
    .drapeau-jaune { background: #FDEF42; width: 33.33%; height: 100%; float: left; position: relative; }
    .drapeau-rouge { background: #E31B23; width: 33.33%; height: 100%; float: left; }
    .etoile { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #00853F; font-size: 12px; font-weight: bold; }
    .annee-classe { font-size: 9.5px; color: #1E293B; text-align: center; margin-top: 4px; }
    .annee-classe strong { color: #00288e; }
    .ecole-nom { font-size: 15px; font-weight: bold; color: #00288e; text-transform: uppercase; text-align: center; }
    .ecole-info { font-size: 9.5px; color: #444653; text-align: center; margin-top: 3px; }
    .ministere { font-size: 9.5px; font-weight: bold; text-transform: uppercase; color: #1E293B; text-align: center; }
    .trimestre-badge { display: inline-block; background: #00288e; color: white; font-size: 10px; font-weight: bold; padding: 4px 12px; border-radius: 10px; margin-top: 6px; }
    .ligne-separation { border-bottom: 2.5px solid #00288e; margin: 10px 0; }

    /* TITRE BULLETIN */
    .titre-bulletin { background: #00288e; color: white; text-align: center; padding: 9px; font-size: 13px; font-weight: bold; margin-bottom: 12px; letter-spacing: 0.5px; }

    /* INFOS ÉLÈVE */
    .infos-eleve { width: 100%; border: 1.5px solid #00288e; border-radius: 4px; margin-bottom: 12px; border-collapse: collapse; }
    .infos-eleve td { padding: 6px 12px; font-size: 10px; border: 0.5px solid #c4c5d5; }
    .infos-row { background: #eff4ff; }
    .infos-eleve .label { color: #444653; }
    .infos-eleve strong { color: #1E293B; }

    /* TABLEAU NOTES */
    .table-notes { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
    .table-notes thead tr { background: #00288e; color: white; }
    .table-notes thead th { padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.3px; border: 1px solid #0039b3; }
    .table-notes tbody tr:nth-child(even) { background: #f8f9ff; }
    .table-notes tbody td { padding: 7px 10px; border: 1px solid #c4c5d5; font-size: 10px; }
    .note-val { color: #00288e; font-weight: bold; text-align: center; }
    .appreciation { font-weight: bold; text-align: center; font-size: 9.5px; }
    .app-excellent   { color: #14532d; }
    .app-tres-bien   { color: #1e40af; }
    .app-bien        { color: #065f46; }
    .app-assez-bien  { color: #3730a3; }
    .app-passable    { color: #92400e; }
    .app-insuffisant { color: #991b1b; }
    .totaux-row { background: #eff4ff !important; }
    .totaux-row td { padding: 7px 10px; border: 1px solid #c4c5d5; font-size: 10px; font-weight: bold; }

    /* RÉSULTATS FINAUX */
    .resultat { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .resultat .titre-col { background: #00288e; color: white; font-weight: bold; font-size: 10px; padding: 8px 10px; text-align: center; border: 1px solid #0039b3; }
    .resultat .val-col { background: #f8f9ff; font-weight: bold; color: #00288e; font-size: 13px; padding: 10px; text-align: center; border: 1px solid #c4c5d5; }
    .mention-val { display: inline-block; padding: 3px 14px; border-radius: 12px; font-size: 11px; font-weight: bold; }
    .mention-tb  { background: #dcfce7; color: #166534; }
    .mention-b   { background: #dbeafe; color: #1e40af; }
    .mention-ab  { background: #e0e7ff; color: #3730a3; }
    .mention-p   { background: #fef3c7; color: #92400e; }
    .mention-i   { background: #fee2e2; color: #991b1b; }
    .mention-e   { background: #f0fdf4; color: #14532d; }

    /* SIGNATURES */
    .signatures { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .signatures td { width: 33%; text-align: center; padding: 8px 10px; border: none; }
    .sig-box { border: 1px solid #c4c5d5; border-radius: 4px; padding: 6px; background: #f8f9ff; }
    .sig-title { font-size: 10px; font-weight: bold; color: #00288e; margin-bottom: 35px; }
    .sig-line { border-top: 1px dashed #c4c5d5; padding-top: 4px; font-size: 8.5px; color: #94a3b8; }
</style>
</head>
<body>

    {{-- ═══════════════ EN-TÊTE ═══════════════ --}}
    <table class="entete">
        <tr>
            {{-- Gauche : République --}}
            <td style="width: 30%;">
                <p class="republique">République du Sénégal</p>
                <p class="devise">Un Peuple — Un But — Une Foi</p>

                {{-- Drapeau --}}
                <div class="drapeau">
                    <div class="drapeau-vert"></div>
                    <div class="drapeau-jaune">
                        <span class="etoile">★</span>
                    </div>
                    <div class="drapeau-rouge"></div>
                </div>

                <p class="annee-classe">Année : <strong>{{ $eleve->user->annee_scolaire }}</strong></p>
                <p class="annee-classe">Classe : <strong>{{ $composition->classe->nom }}</strong></p>
                <p class="annee-classe">Effectif : <strong>{{ $composition->classe->eleves->count() }} élèves</strong></p>
            </td>

            {{-- Centre : École --}}
            <td style="width: 40%; text-align: center;">
                <p class="ecole-nom">{{ $eleve->user->nom_ecole }}</p>
                <p class="ecole-info">{{ $eleve->user->region }} — {{ $eleve->user->departement }} — {{ $eleve->user->commune }}</p>
                <p class="ecole-info" style="margin-top: 3px;">
                    {{ $eleve->user->type_ecole == 'publique' ? 'École Publique' : 'École Privée' }}
                </p>
            </td>

            {{-- Droite : Ministère --}}
            <td style="width: 30%; text-align: right;">
                <p class="ministere">Ministère de<br/>l'Éducation Nationale</p>
                <div style="text-align: right; margin-top: 5px;">
                    <span class="trimestre-badge">Trimestre {{ $composition->trimestre }}</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="ligne-separation"></div>

    {{-- ═══════════════ TITRE ═══════════════ --}}
    <div class="titre-bulletin">
        BULLETIN DE COMPOSITION — {{ strtoupper($composition->libelle) }}
    </div>

    {{-- ═══════════════ INFOS ÉLÈVE ═══════════════ --}}
    <table class="infos-eleve">
        <tr class="infos-row">
            <td style="width: 50%;">
                <span class="label">Prénom & Nom : </span>
                <strong>{{ $eleve->prenom }} {{ strtoupper($eleve->nom) }} </strong>
            </td>
            <td style="width: 25%;">
                <span class="label">Matricule : </span>
                <strong>{{ $eleve->matricule ?? '—' }}</strong>
            </td>
            <td style="width: 25%;">
                <span class="label">Sexe : </span>
                <strong>{{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}</strong>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">Date de naissance : </span>
                <strong>
                    {{ $eleve->date_naissance
                        ? \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y')
                        : '—' }}
                </strong>
            </td>
            <td colspan="2">
                <span class="label">Instituteur(trice) : </span>
                <strong>{{ $eleve->user->prenom }} {{ $eleve->user->nom }}</strong>
            </td>
        </tr>
    </table>

    {{-- ═══════════════ TABLEAU DES NOTES ═══════════════ --}}
    @php
        $totalPoints = 0;
        $totalSur    = 0;
    @endphp

    <table class="table-notes">
        <thead>
            <tr>
                <th style="width: 35%;">Matière</th>
                <th style="width: 20%; text-align: center;">Note obtenue</th>
                <th style="width: 15%; text-align: center;">Sur</th>
                <th style="width: 15%; text-align: center;">Note / 10</th>
                <th style="width: 15%; text-align: center;">Appréciation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
            @php
                $noteRamenee = $note->note * 10 / $note->matiere->note_sur;
                $totalPoints += $note->note;
                $totalSur    += $note->matiere->note_sur;

                if ($noteRamenee >= 9.5)     { $appClass = 'app-excellent';   $appText = 'Excellent'; }
                elseif ($noteRamenee >= 8)   { $appClass = 'app-tres-bien';   $appText = 'Très Bien'; }
                elseif ($noteRamenee >= 7)   { $appClass = 'app-bien';        $appText = 'Bien'; }
                elseif ($noteRamenee >= 6)   { $appClass = 'app-assez-bien';  $appText = 'Assez Bien'; }
                elseif ($noteRamenee >= 5)   { $appClass = 'app-passable';    $appText = 'Passable'; }
                else                         { $appClass = 'app-insuffisant'; $appText = 'Insuffisant'; }
            @endphp
            <tr>
                <td>{{ $note->matiere->nom }}</td>
                <td class="note-val">{{ number_format($note->note, 2) }}</td>
                <td style="text-align: center;">{{ $note->matiere->note_sur }}</td>
                <td class="note-val">{{ number_format($noteRamenee, 2) }}</td>
                <td class="appreciation {{ $appClass }}">{{ $appText }}</td>
            </tr>
            @endforeach
        </tbody>
        <tr class="totaux-row">
            <td><strong>TOTAL</strong></td>
            <td class="note-val">{{ number_format($totalPoints, 2) }}</td>
            <td style="text-align: center;">{{ number_format($totalSur, 2) }}</td>
            <td class="note-val">{{ number_format($moyenne, 2) }}</td>
            <td></td>
        </tr>
    </table>

    {{-- ═══════════════ RÉSULTATS FINAUX ═══════════════ --}}
    @php
        $moyenneClasse = \App\Models\Bulletin::where('composition_id', $composition->id)->avg('moyenne_generale');
    @endphp

    <table class="resultat">
        <tr>
            <td class="titre-col">Moyenne obtenue</td>
            <td class="titre-col">Rang</td>
            <td class="titre-col">Moyenne de la classe</td>
            <td class="titre-col">Mention</td>
        </tr>
        <tr>
            <td class="val-col">{{ number_format($moyenne, 2) }} / 10</td>
            <td class="val-col">{{ $rang }}<sup>{{ $rang == 1 ? 'er' : 'ème' }}</sup></td>
            <td class="val-col">{{ number_format($moyenneClasse, 2) }} / 10</td>
            <td class="val-col">
                @php
                $mentionClass = match($mention) {
                    'Très Bien'  => 'mention-tb',
                    'Bien'       => 'mention-b',
                    'Assez Bien' => 'mention-ab',
                    'Passable'   => 'mention-p',
                    'Insuffisant'=> 'mention-i',
                    default      => 'mention-e',
                };
                @endphp
                <span class="mention-val {{ $mentionClass }}">{{ $mention }}</span>
            </td>
        </tr>
    </table>

    {{-- ═══════════════ SIGNATURES ═══════════════ --}}
    <table class="signatures">
        <tr>
            <td><div class="sig-line">Le Directeur</div></td>
            <td><div class="sig-line">L'Instituteur(trice)</div></td>
            <td><div class="sig-line">Parent / Tuteur</div></td>
        </tr>
    </table>

</body>
</html>