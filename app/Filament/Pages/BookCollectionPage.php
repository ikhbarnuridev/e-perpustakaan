<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MemberResource;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class BookCollectionPage extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static string $view = 'filament.pages.book-collection-page';

    protected static ?string $slug = 'book-collection';

    public static function getNavigationSort(): ?int
    {
        return MemberResource::getNavigationSort() + 1;
    }

    public static function getNavigationLabel(): string
    {
        return __('Book Collection');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Book Collection');
    }
}
