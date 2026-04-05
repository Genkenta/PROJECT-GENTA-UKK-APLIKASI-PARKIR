<?php
namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard Admin';

    public function getHeaderWidgetsColumns(): int | array
{
    return [
        'default' => 1,
        'md' => 2,
        'xl' => 3,
    ];
}
}

