<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages;
use App\Models\Order;

use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;

use Filament\Forms\Components\Select;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;

use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $slug = 'orders';

    protected static ?string $navigationLabel = 'Bestellingen';

    protected static ?string $modelLabel = 'Bestelling';

    protected static ?string $pluralModelLabel = 'Bestellingen';

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-shopping-bag';
    }

    /**
     * Formulier voor het bewerken van een bestelling.
     * Alleen de status kan worden aangepast.
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Bestelling Status')
                    ->description('Pas de status van de bestelling aan')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending'   => 'In behandeling',
                                'completed' => 'Voltooid',
                                'cancelled' => 'Geannuleerd',
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    /**
     * Infolist voor het bekijken van een bestelling (inclusief artikelen).
     */
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Bestelgegevens')
                    ->schema([
                        TextEntry::make('id')
                            ->label('Bestelling #'),

                        TextEntry::make('user.name')
                            ->label('Klant'),

                        TextEntry::make('user.email')
                            ->label('E-mailadres'),

                        TextEntry::make('total_price')
                            ->label('Totaalbedrag')
                            ->money('EUR'),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending'   => 'warning',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                                default     => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending'   => 'In behandeling',
                                'completed' => 'Voltooid',
                                'cancelled' => 'Geannuleerd',
                                default     => $state,
                            }),

                        TextEntry::make('created_at')
                            ->label('Aangemaakt op')
                            ->dateTime('d-m-Y H:i'),
                    ])
                    ->columns(2),

                Section::make('Bestelde artikelen')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                TextEntry::make('product.name')
                                    ->label('Product'),

                                TextEntry::make('quantity')
                                    ->label('Aantal'),

                                TextEntry::make('price')
                                    ->label('Prijs per stuk')
                                    ->money('EUR'),

                                TextEntry::make('line_total')
                                    ->label('Subtotaal')
                                    ->money('EUR')
                                    ->state(fn ($record) => $record->quantity * $record->price),
                            ])
                            ->columns(4),
                    ]),
            ]);
    }

    /**
     * Overzichtstabel van alle bestellingen.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Bestelling #')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Klant')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.email')
                    ->label('E-mailadres')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total_price')
                    ->label('Totaal')
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'   => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'   => 'In behandeling',
                        'completed' => 'Voltooid',
                        'cancelled' => 'Geannuleerd',
                        default     => $state,
                    })
                    ->sortable(),

                TextColumn::make('items_count')
                    ->label('Artikelen')
                    ->counts('items')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Aangemaakt')
                    ->dateTime('d-m-Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending'   => 'In behandeling',
                        'completed' => 'Voltooid',
                        'cancelled' => 'Geannuleerd',
                    ])
                    ->placeholder('Alle statussen'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Bekijken'),
                EditAction::make()
                    ->label('Bewerken'),
                DeleteAction::make()
                    ->label('Verwijderen')
                    ->requiresConfirmation()
                    ->modalHeading('Bestelling permanent verwijderen?')
                    ->modalDescription('Deze actie kan niet ongedaan worden gemaakt.')
                    ->modalSubmitActionLabel('Ja, verwijderen'),
            ])
            ->groupedBulkActions([
                BulkAction::make('markCompleted')
                    ->label('Markeren als voltooid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn ($records) => $records->each->update(['status' => 'completed']))
                    ->deselectRecordsAfterCompletion(),

                BulkAction::make('markCancelled')
                    ->label('Markeren als geannuleerd')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($records) => $records->each->update(['status' => 'cancelled']))
                    ->deselectRecordsAfterCompletion(),

                BulkAction::make('delete')
                    ->label('Permanent verwijderen')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Bestellingen permanent verwijderen?')
                    ->modalDescription('Deze actie kan niet ongedaan worden gemaakt.')
                    ->action(fn ($records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([25, 50, 100])
            ->striped()
            ->deferLoading();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view'  => Pages\ViewOrder::route('/{record}'),
            'edit'  => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}