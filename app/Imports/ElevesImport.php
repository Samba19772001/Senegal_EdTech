<?php

namespace App\Imports;

use App\Models\Eleve;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ElevesImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    protected int $userId;
    protected int $classeId;

    public array $errors = [];
    public int $successCount = 0;

    public function __construct(int $userId, int $classeId)
    {
        $this->userId   = $userId;
        $this->classeId = $classeId;
    }
    public function model(array $row): ?Eleve
    {
        $row = array_change_key_case($row, CASE_LOWER);

        $nom    = $this->getValue($row, ['nom', 'lastname', 'surname']);
        $prenom = $this->getValue($row, ['prenom', 'firstname']);

        $sexe = strtoupper(trim($this->getValue($row, ['sexe', 'gender'])));

        if (!$nom || !$prenom) {
            return null;
        }

        if (!in_array($sexe, ['M', 'F'])) {
            return null;
        }

        // clé doublon (nom + prénom + classe)
        $key = strtolower(trim($nom)) . '|' . strtolower(trim($prenom));

        static $seen = [];

        if (isset($seen[$key])) {
            return null;
        }

        $exists = Eleve::where('user_id', $this->userId)
            ->where('classe_id', $this->classeId)
            ->whereRaw('LOWER(nom) = ?', [strtolower(trim($nom))])
            ->whereRaw('LOWER(prenom) = ?', [strtolower(trim($prenom))])
            ->exists();

        if ($exists) {
            return null;
        }

        $seen[$key] = true;

        return new Eleve([
            'user_id'        => $this->userId,
            'classe_id'      => $this->classeId,
            'nom'            => trim($nom),
            'prenom'         => trim($prenom),
            'sexe'           => $sexe,
            'date_naissance' => $this->parseDate($row['date_naissance'] ?? null),
            'matricule' => !empty(trim($row['matricule'] ?? '')) ? trim($row['matricule']) : null,
        ]);
    }
    
    private function getValue($row, array $keys)
    {
        foreach ($keys as $key) {
            if (!empty($row[$key])) {
                return $row[$key];
            }
        }
        return null;
    }

    private function parseDate($value)
    {
        if (!$value) return null;

        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }

            return Carbon::parse($value)->format('Y-m-d');

        } catch (\Exception $e) {
            return null;
        }
    }
}