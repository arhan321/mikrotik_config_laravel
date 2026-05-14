<?php

namespace App\Filament\Admin\Resources\ConfigurationTemplates\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ConfigurationTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Template')
                    ->schema([
                        Select::make('created_by')
                            ->label('Pembuat')
                            ->relationship('creator', 'name')
                            ->default(fn (): ?int => Auth::id())
                            ->searchable()
                            ->preload(),

                        TextInput::make('name')
                            ->label('Nama Template')
                            ->placeholder('Set Identity dan DNS')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set): void {
                                if (filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'identity' => 'Identity',
                                'dns' => 'DNS',
                                'ip-address' => 'IP Address',
                                'firewall' => 'Firewall / NAT',
                                'backup' => 'Backup',
                                'other' => 'Lainnya',
                            ])
                            ->searchable(),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Isi Script Template')
                    ->description('Gunakan variable seperti {{router_name}}, {{dns_server}}, {{interface}}, dan lainnya.')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('script_content')
                            ->label('Script Content')
                            ->required()
                            ->rows(14)
                            ->columnSpanFull()
                            ->placeholder('/system identity set name={{router_name}}' . PHP_EOL . '/ip dns set servers={{dns_server}} allow-remote-requests=yes'),

                        TagsInput::make('variables')
                            ->label('Daftar Variable')
                            ->placeholder('router_name')
                            ->helperText('Untuk tahap awal bisa diisi manual. Nanti kita buat auto-detect dari script_content.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
