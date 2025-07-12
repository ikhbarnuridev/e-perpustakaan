<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;
use Illuminate\Contracts\Support\Htmlable;

class AnnouncementWidget extends Widget
{
    use HasWidgetShield;

    public function getHeading(): string|Htmlable|null
    {
        return __('Announcement');
    }

    protected static string $view = 'filament.widgets.announcement-widget';
}
