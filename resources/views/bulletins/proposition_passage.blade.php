@extends('layouts.app')

@section('title', 'Proposition de Passage — Senegal EdTech')
@section('page_label', 'RÉSULTATS')
@section('page_title', 'Proposition de passage')

@push('styles')
<style>
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
    <div class="flex items-center gap-2 text-sm text-text-muted mb-4 flex-wrap">
        <a href="{{ route('bulletins.index') }}" class="hover:text-primary">Bulletins</a>
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-text-dark font-medium">Proposition de passage</span>
    </div>

    {{-- Header --}}
    <div style="box-sizing:border-box;width:100%;overflow:hidden;"
        class="bg-primary rounded-2xl p-4 mb-4 text-white">
        <div style="min-width:0;flex:1;overflow:hidden;" class="mb-3">
            <h2 style="font-size:clamp(13px,4vw,18px);font-weight:700;line-height:1.4;word-break:break-word;">
                Proposition de passage — {{ $composition->classe->nom }}
            </h2>
            <p style="color:#bfdbfe;font-size:12px;margin-top:4px;line-height:1.5;">
                {{ auth()->user()->annee_scolaire }} •
                {{ $resultats->count() }} élèves •
                {{ $resultats->where('decision', 'Passe en classe supérieure')->count() }} admis •
                {{ $resultats->where('decision', 'Redouble')->count() }} redoublants
            </p>
        </div>
        <a href="{{ route('bulletins.proposition.pdf', $composition->id) }}"
            style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;background:white;color:#00288e;border-radius:12px;font-size:13px;font-weight:600;text-decoration:none;white-space:nowrap;">
            <svg style="width:16px;height:16px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Télécharger PDF
        </a>
    </div>

    {{-- Stats 2x2 --}}
    @php $moyClasse = $resultats->whereNotNull('moyAnnuelle')->avg('moyAnnuelle'); @endphp
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:16px;">
        <div style="background:white;border:1px solid #c4c5d5;border-radius:16px;padding:12px;text-align:center;">
            <p style="font-size:24px;font-weight:700;color:#121c2a;">{{ $resultats->count() }}</p>
            <p style="font-size:11px;color:#444653;margin-top:2px;">Total élèves</p>
        </div>
        <div style="background:white;border:1px solid #c4c5d5;border-radius:16px;padding:12px;text-align:center;">
            <p style="font-size:24px;font-weight:700;color:#16a34a;">{{ $resultats->where('decision', 'Passe en classe supérieure')->count() }}</p>
            <p style="font-size:11px;color:#444653;margin-top:2px;">Admis</p>
        </div>
        <div style="background:white;border:1px solid #c4c5d5;border-radius:16px;padding:12px;text-align:center;">
            <p style="font-size:24px;font-weight:700;color:#dc2626;">{{ $resultats->where('decision', 'Redouble')->count() }}</p>
            <p style="font-size:11px;color:#444653;margin-top:2px;">Redoublants</p>
        </div>
        <div style="background:white;border:1px solid #c4c5d5;border-radius:16px;padding:12px;text-align:center;">
            <p style="font-size:24px;font-weight:700;color:#00288e;">{{ $moyClasse ? number_format($moyClasse, 2) : '—' }}/10</p>
            <p style="font-size:11px;color:#444653;margin-top:2px;">Moy. annuelle</p>
        </div>
    </div>

    {{-- Hint scroll --}}
    <p style="font-size:11px;color:#6b7280;margin-bottom:8px;display:flex;align-items:center;gap:4px;" class="sm:hidden">
        ← Faites défiler pour voir toutes les colonnes
    </p>

    {{-- Tableau --}}
    <div class="-mx-4 lg:mx-0 lg:rounded-2xl lg:border lg:border-border overflow-hidden"
        style="background:white;border-top:1px solid #c4c5d5;border-bottom:1px solid #c4c5d5;">
        <div id="tableau-wrapper">
            <table style="width:max-content;min-width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#00288e;">
                        <th style="text-align:center;padding:10px 12px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:52px;">Rang</th>
                        <th style="text-align:left;padding:10px 12px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:150px;">Prénom & Nom</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:48px;">Sexe</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:64px;">Moy. T1</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:64px;">Moy. T2</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:64px;">Moy. T3</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:72px;">Moy. Ann.</th>
                        <th style="text-align:center;padding:10px 8px;font-size:10px;font-weight:700;color:white;text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;min-width:90px;">Observation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resultats as $r)
                    @php
                        $estAdmis = $r['decision'] == 'Passe en classe supérieure';
                        $initiales = strtoupper(substr($r['eleve']->prenom,0,1).substr($r['eleve']->nom,0,1));
                        $couleurs = ['blue','pink','orange','purple','green','red','indigo','amber'];
                        $couleur = $couleurs[$r['eleve']->id % count($couleurs)];
                        $avatarMap = [
                            'blue'  => 'background:#dbeafe;color:#1d4ed8;',
                            'pink'  => 'background:#fce7f3;color:#9d174d;',
                            'orange'=> 'background:#ffedd5;color:#c2410c;',
                            'purple'=> 'background:#f3e8ff;color:#6b21a8;',
                            'green' => 'background:#d1fae5;color:#065f46;',
                            'red'   => 'background:#fee2e2;color:#991b1b;',
                            'indigo'=> 'background:#e0e7ff;color:#3730a3;',
                            'amber' => 'background:#fef3c7;color:#92400e;',
                        ];
                        $avatarStyle = $avatarMap[$couleur] ?? 'background:#e5e7eb;color:#374151;';
                        $rowBg = $estAdmis ? '#ffffff' : '#fff5f5';
                    @endphp
                    <tr style="background:{{ $rowBg }};border-bottom:1px solid #e2e8f0;">
                        <td style="padding:8px 12px;text-align:center;">
                            <span style="width:26px;height:26px;border-radius:50%;background:#dbeafe;color:#00288e;font-size:11px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;">
                                {{ $r['rang'] }}
                            </span>
                        </td>
                        <td style="padding:8px 12px;">
                            <div style="display:flex;align-items:center;gap:7px;">
                                <div style="width:26px;height:26px;border-radius:50%;{{ $avatarStyle }}font-size:9px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    {{ $initiales }}
                                </div>
                                <span style="font-size:12px;font-weight:500;color:#1e293b;white-space:nowrap;">
                                    {{ $r['eleve']->prenom }} {{ $r['eleve']->nom }}
                                </span>
                            </div>
                        </td>
                        <td style="padding:8px;text-align:center;">
                            @if($r['eleve']->sexe == 'M')
                                <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;background:#dbeafe;color:#1d4ed8;">M</span>
                            @else
                                <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;background:#fce7f3;color:#9d174d;">F</span>
                            @endif
                        </td>
                        @foreach([1,2,3] as $t)
                        <td style="padding:8px;text-align:center;font-size:11px;font-weight:600;color:#00288e;white-space:nowrap;">
                            {{ $r['moyennes'][$t] !== null ? number_format($r['moyennes'][$t], 2).'/10' : '—' }}
                        </td>
                        @endforeach
                        <td style="padding:8px;text-align:center;white-space:nowrap;">
                            <span style="font-size:12px;font-weight:700;color:#00288e;">
                                {{ $r['moyAnnuelle'] !== null ? number_format($r['moyAnnuelle'], 2).'/10' : '—' }}
                            </span>
                        </td>
                        <td style="padding:8px;text-align:center;">
                            @if($estAdmis)
                                <span style="font-size:9px;font-weight:600;padding:2px 8px;border-radius:999px;background:#dcfce7;color:#166534;white-space:nowrap;">Passe en sup.</span>
                            @else
                                <span style="font-size:9px;font-weight:600;padding:2px 8px;border-radius:999px;background:#fee2e2;color:#991b1b;white-space:nowrap;">Redouble</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection