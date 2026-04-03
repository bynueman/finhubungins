<?php

namespace App\Enums;

enum JasaType: string
{
    case BRIEF = 'Brief';
    case FEE_TALENT = 'Fee Talent';
    case KONSUMSI = 'Konsumsi';
    case EDITING = 'Editing';
    case TRANSPORTASI = 'Transportasi';
    case TAKE_VIDEO = 'Take Video';
    case DESAIN = 'Desain';
    
    public function getLabel(): string
    {
        return $this->value;
    }
    
    public static function toArray(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->getLabel()];
        })->toArray();
    }
}
