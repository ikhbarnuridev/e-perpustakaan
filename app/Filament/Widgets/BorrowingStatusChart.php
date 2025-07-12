<?php

namespace App\Filament\Widgets;

use App\Models\Borrowing;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class BorrowingStatusChart extends ChartWidget
{
    use HasWidgetShield;

    protected static ?string $maxHeight = '274px';

    public function getHeading(): string|Htmlable|null
    {
        return __('Borrowing Status Chart');
    }

    protected function getData(): array
    {
        return [
            'labels' => [
                ucfirst(Borrowing::STATUS_PENDING),
                ucfirst(Borrowing::STATUS_APPROVED),
                ucfirst(Borrowing::STATUS_REJECTED),
                ucfirst(Borrowing::STATUS_BORROWED),
                ucfirst(Borrowing::STATUS_RETURNED),
            ],
            'datasets' => [[
                'label' => 'My First Dataset',
                'data' => [
                    Borrowing::where('status', Borrowing::STATUS_PENDING)->count(),
                    Borrowing::where('status', Borrowing::STATUS_APPROVED)->count(),
                    Borrowing::where('status', Borrowing::STATUS_REJECTED)->count(),
                    Borrowing::where('status', Borrowing::STATUS_BORROWED)->count(),
                    Borrowing::where('status', Borrowing::STATUS_RETURNED)->count(),
                ],
                'backgroundColor' => [
                    'rgb('.Color::Gray[400].')',
                    'rgb('.Color::Green[400].')',
                    'rgb('.Color::Red[400].')',
                    'rgb('.Color::Amber[400].')',
                    'rgb('.Color::Indigo[400].')',
                ],
                'hoverOffset' => 4,
            ]],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
