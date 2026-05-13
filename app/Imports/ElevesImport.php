<?php

namespace App\Imports;

use App\Models\Eleve;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ElevesImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected int $userId;
    protected int $classeId;

    public function __construct(int $userId, int $classeId)
    {
        $this->userId   = $userId;
        $this->classeId = $classeId;
    }

    public function model(array $row): ?Eleve
    {
        if (empty($row['nom']) || empty($row['prenom'])) {
            return null;
        }

        $sexe = strtoupper($row['sexe'] ?? '');
        if (!in_array($sexe, ['M', 'F'])) {
            return null;
        }

        return new Eleve([
            'user_id'        => $this->userId,
            'classe_id'      => $this->classeId,
            'nom'            => $row['nom'],
            'prenom'         => $row['prenom'],
            'sexe'           => $sexe,
            'date_naissance' => !empty($row['date_naissance']) ? $row['date_naissance'] : null,
            'matricule'      => !empty($row['matricule']) ? $row['matricule'] : null,
        ]);
    }
}