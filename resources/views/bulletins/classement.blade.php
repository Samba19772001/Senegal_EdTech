@extends('layouts.app')

@section('title', 'Classement — Senegal EdTech')
@section('page_label', 'RÉSULTATS')
@section('page_title', 'Classement par ordre de mérite')

@push('styles')
<style>
    .header-bleu {
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }
    .header-bleu * {
        box-sizing: border-box;
        max-width: 100%;
    }
    #tableau-wrapper {
        overflow-x: auto;
        overflow-y: visible;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior-x: contain;
        width: 100%;
        max-width: 100vw;
    }
</style>
@endpush

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-text-muted mb-6 flex-wrap">
        <a href="{{ route('bulletins.index') }}" class="hover:text-primary transition-colors">Bulletins</a>
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-text-dark font-medium">Classement {{ $composition->libelle }}</span>
    </div>

    {{-- Header bleu --}}
    <div class="header-bleu bg-primary rounded-2xl p-4 sm:p-6 mb-6 text-white">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div style="min-width:0;flex:1;overflow:hidden;">
                @php $libelle = strtoupper($composition->libelle); @endphp
                <h2 style="font-size:clamp(13px,4vw,20px);font-weight:700;line-height:1.4;word-break:break-word;overflow-wrap:break-word;">
                    BULLETIN —
                    @if(str_contains($libelle, 'T3')) 3e TRIMESTRE
                    @elseif(str_contains($libelle, 'T2')) 2e TRIMESTRE
                    @elseif(str_contains($libelle, 'T1')) 1er TRIMESTRE
                    @else {{ $libelle }}
                    @endif
                    — {{ $composition->classe->nom }}
                </h2>
                <p style="color:#bfdbfe;font-size:12px;margin-top:4px;line-height:1.5;">
                    {{ auth()->user()->annee_scolaire }} •
                    {{ $resultats->count() }} élèves •
                    Moy. : {{ number_format($moyenneClasse, 2) }}/10
                </p>
            </div>
            <a href="{{ route('bulletins.classement.pdf', $composition->id) }}"
                style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;background:white;color:#00288e;border-radius:12px;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap;flex-shrink:0;align-self:flex-start;">
                <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Télécharger PDF
            </a>
        </div>
    </div>

    {{-- Hint scroll mobile --}}
    <p style="font-size:11px;color:#6b7280;margin-bottom:8px;display:flex;align-items:center;gap:4px;" class="sm:hidden">
        ← Faites défiler pour voir toutes les matières
    </p>

    {{-- Tableau --}}
    <div style="background:white;border-radius:16px;border:1px solid #c4c5d5;box-shadow:0 1px 3px rgba(0,0,0,.06);overflow:hidden;">
        <div id="tableau-wrapper">
            <table style="width:max-content;min-width:100%;border-collapse:collapse;">

                <thead>
                    <tr style="background:#1e3a8a;">

                        {{-- Rang — PAS sticky --}}
                        <th style="text-align:left;padding:10px 12px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;background:#1e3a8a;min-width:52px;">
                            Rang
                        </th>

                        {{-- Élève — PAS sticky --}}
                        <th style="text-align:left;padding:10px 12px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;background:#1e3a8a;min-width:140px;">
                            Élève
                        </th>

                        {{-- Sexe --}}
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:48px;">
                            Sexe
                        </th>

                        {{-- Matières verticales --}}
                        @foreach($matieres as $matiere)
                        <th style="height:90px;vertical-align:bottom;text-align:center;padding:0 3px 6px;background:#1e3a8a;min-width:36px;">
                            <div style="writing-mode:vertical-rl;transform:rotate(180deg);font-size:9px;font-weight:600;color:white;text-transform:uppercase;letter-spacing:.04em;line-height:1.3;white-space:nowrap;">
                                {{ $matiere->nom }}<span style="color:#93c5fd;font-weight:400;"> /{{ $matiere->note_sur }}</span>
                            </div>
                        </th>
                        @endforeach

                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:52px;">Total</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:52px;">Moy/10</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:80px;">Mention</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($resultats as $resultat)
                    @php
                        $eleve      = $resultat['eleve'];
                        $initiales  = strtoupper(substr($eleve->prenom,0,1).substr($eleve->nom,0,1));
                        $couleurs   = ['blue','pink','orange','purple','green','red','indigo','amber'];
                        $couleur    = $couleurs[$eleve->id % count($couleurs)];
                        $mentionMap = [
                            'Très Bien'   => 'background:#dcfce7;color:#166534;',
                            'Bien'        => 'background:#dbeafe;color:#1e40af;',
                            'Assez Bien'  => 'background:#e0e7ff;color:#3730a3;',
                            'Passable'    => 'background:#fef3c7;color:#92400e;',
                            'Insuffisant' => 'background:#fee2e2;color:#991b1b;',
                        ];
                        $mentionStyle = $mentionMap[$resultat['mention']] ?? 'background:#f3f4f6;color:#374151;';
                        $rowBg = $resultat['rang']==1 ? '#fffbeb'
                               : ($resultat['rang']==2 ? '#f8fafc'
                               : ($resultat['rang']==3 ? '#fff7ed' : '#ffffff'));
                        $avatarMap = [
                            'blue'  =>'background:#dbeafe;color:#1d4ed8;',
                            'pink'  =>'background:#fce7f3;color:#9d174d;',
                            'orange'=>'background:#ffedd5;color:#c2410c;',
                            'purple'=>'background:#f3e8ff;color:#6b21a8;',
                            'green' =>'background:#d1fae5;color:#065f46;',
                            'red'   =>'background:#fee2e2;color:#991b1b;',
                            'indigo'=>'background:#e0e7ff;color:#3730a3;',
                            'amber' =>'background:#fef3c7;color:#92400e;',
                        ];
                        $avatarStyle = $avatarMap[$couleur] ?? 'background:#e5e7eb;color:#374151;';
                    @endphp
                    <tr style="background:{{ $rowBg }};border-bottom:1px solid #e2e8f0;">

                        {{-- Rang — PAS sticky --}}
                        <td style="padding:8px 12px;text-align:center;background:{{ $rowBg }};">
                            <span style="width:26px;height:26px;border-radius:50%;background:#dbeafe;color:#1e3a8a;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;">
                                {{ $resultat['rang'] }}
                            </span>
                        </td>

                        {{-- Élève — PAS sticky --}}
                        <td style="padding:8px 12px;background:{{ $rowBg }};">
                            <div style="display:flex;align-items:center;gap:7px;">
                                <div style="width:26px;height:26px;border-radius:50%;{{ $avatarStyle }}font-size:9px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    {{ $initiales }}
                                </div>
                                <span style="font-size:12px;font-weight:500;color:#1e293b;white-space:nowrap;">
                                    {{ $eleve->prenom }} {{ $eleve->nom }}
                                </span>
                            </div>
                        </td>

                        {{-- Sexe --}}
                        <td style="padding:8px;text-align:center;">
                            @if($eleve->sexe === 'M')
                                <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;background:#dbeafe;color:#1d4ed8;">M</span>
                            @else
                                <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;background:#fce7f3;color:#9d174d;">F</span>
                            @endif
                        </td>

                        {{-- Notes --}}
                        @foreach($matieres as $matiere)
                        @php $noteData = $resultat['notes'][$matiere->id] ?? null; @endphp
                        <td style="padding:8px 3px;text-align:center;font-size:11px;">
                            @if($noteData && $noteData['note'] !== null)
                                <span style="font-weight:600;color:#1e293b;">{{ $noteData['note'] }}</span>
                            @else
                                <span style="color:#d1d5db;">—</span>
                            @endif
                        </td>
                        @endforeach

                        <td style="padding:8px;text-align:center;">
                            <span style="font-weight:700;color:#1e293b;font-size:12px;">{{ number_format($resultat['totalPoints'],2) }}</span>
                        </td>
                        <td style="padding:8px;text-align:center;">
                            <span style="font-weight:700;color:#1e3a8a;font-size:12px;">{{ number_format($resultat['moyenne'],2) }}</span>
                        </td>
                        <td style="padding:8px;text-align:center;">
                            <span style="font-size:9px;font-weight:600;padding:2px 8px;border-radius:999px;white-space:nowrap;{{ $mentionStyle }}">{{ $resultat['mention'] }}</span>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr style="background:#eff6ff;border-top:2px solid #1e3a8a;">
                        {{-- PAS sticky --}}
                        <td colspan="3" style="padding:10px 12px;font-size:10px;font-weight:700;color:#1e293b;text-transform:uppercase;background:#eff6ff;white-space:nowrap;">
                            Moy. classe
                        </td>
                        @foreach($matieres as $matiere)
                        @php
                            $moyMat = $resultats->avg(function($r) use ($matiere) {
                                $n = $r['notes'][$matiere->id] ?? null;
                                return $n && $n['note'] !== null ? $n['note_ramenee'] : null;
                            });
                        @endphp
                        <td style="padding:10px 3px;text-align:center;font-size:10px;font-weight:600;color:#1e3a8a;">
                            {{ $moyMat ? number_format($moyMat,2) : '—' }}
                        </td>
                        @endforeach
                        <td style="padding:10px 8px;text-align:center;font-size:10px;font-weight:700;color:#1e293b;">—</td>
                        <td style="padding:10px 8px;text-align:center;font-size:12px;font-weight:700;color:#1e3a8a;">{{ number_format($moyenneClasse,2) }}/10</td>
                        <td></td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>

@endsection