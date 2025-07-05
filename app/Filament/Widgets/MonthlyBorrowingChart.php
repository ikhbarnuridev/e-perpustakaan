<?php

namespace App\Filament\Widgets;

use App\Models\Borrowing;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class MonthlyBorrowingChart extends ChartWidget
{
    protected static ?string $maxHeight = '300px';

    public function getHeading(): string|Htmlable|null
    {
        return __('Borrowing Per Month Chart');
    }

    protected function getData(): array
    {
        $data = Borrowing::selectRaw('MONTH(borrowed_at) as month, COUNT(*) as total')
            ->whereYear('borrowed_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $values = [];
        $labels = [];

        foreach ($months as $monthNumber => $monthName) {
            $labels[] = $monthName;
            $values[] = $data->get($monthNumber, 0); // default 0 jika tidak ada data
        }

        return [
            'datasets' => [
                [
                    'label' => __('Total Borrowings'),
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
