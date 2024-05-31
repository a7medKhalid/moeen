<?php

namespace App\Filament\Monset\Resources\Monset\ClipResource\Pages;

use App\Filament\Monset\Resources\Monset\ClipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClip extends EditRecord
{
    protected static string $resource = ClipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
