<?php

namespace App\Filament\Monset\Resources\Monset\ClipResource\Pages;

use App\Filament\Monset\Resources\Monset\ClipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClips extends ListRecords
{
    protected static string $resource = ClipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
