<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required(),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required(),
            Forms\Components\TextInput::make('pos_pin')
                ->password()
                ->maxLength(4),
            Forms\Components\Toggle::make('two_factor_secret')
                ->label('2FA Enabled')
                ->disabled(),

            // Campo de selección para los roles
            Select::make('roles')
                ->label('Roles')
                ->multiple() // Permite seleccionar múltiples roles
                ->options(function () {
                    return Role::all()->pluck('name', 'id'); // Obtiene todos los roles
                })
                ->reactive() // Hace que el campo se actualice dinámicamente si es necesario
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('email'),
            BadgeColumn::make('roles.name')
                ->label('Role')
                ->colors(['primary']),
            Tables\Columns\BooleanColumn::make('two_factor_secret')
                ->label('2FA'),

            BadgeColumn::make('roles.name')
                ->label('Role')
                ->colors(['primary']),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
