<?php

namespace App\Filament\Tenant\Pages;

use App\Models\Tenant\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static \UnitEnum|string|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Settings';

    protected string $view = 'filament.tenant.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getSettings());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->icon('heroicon-m-building-office')
                            ->schema([
                                Forms\Components\Section::make('Company Information')
                                    ->schema([
                                        Forms\Components\TextInput::make('company_name')
                                            ->label('Company Name')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('company_email')
                                            ->label('Company Email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('company_phone')
                                            ->label('Company Phone')
                                            ->tel()
                                            ->maxLength(50),

                                        Forms\Components\Textarea::make('company_address')
                                            ->label('Company Address')
                                            ->rows(3)
                                            ->maxLength(500),

                                        Forms\Components\TextInput::make('website')
                                            ->label('Website')
                                            ->url()
                                            ->maxLength(255),

                                        Forms\Components\FileUpload::make('company_logo')
                                            ->label('Company Logo')
                                            ->image()
                                            ->directory('logos')
                                            ->visibility('public')
                                            ->maxSize(2048),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Tickets')
                            ->icon('heroicon-m-ticket')
                            ->schema([
                                Forms\Components\Section::make('Ticket Configuration')
                                    ->schema([
                                        Forms\Components\TextInput::make('ticket_prefix')
                                            ->label('Ticket Number Prefix')
                                            ->default('HLP')
                                            ->required()
                                            ->maxLength(10)
                                            ->helperText('Prefix for ticket numbers (e.g., HLP-000001)'),

                                        Forms\Components\Select::make('default_ticket_status')
                                            ->label('Default Ticket Status')
                                            ->options([
                                                'open' => 'Open',
                                                'pending' => 'Pending',
                                            ])
                                            ->default('open')
                                            ->required(),

                                        Forms\Components\Select::make('default_ticket_priority')
                                            ->label('Default Ticket Priority')
                                            ->options([
                                                'low' => 'Low',
                                                'normal' => 'Normal',
                                                'high' => 'High',
                                                'urgent' => 'Urgent',
                                            ])
                                            ->default('normal')
                                            ->required(),

                                        Forms\Components\Toggle::make('auto_close_solved_tickets')
                                            ->label('Auto-close Solved Tickets')
                                            ->helperText('Automatically close tickets after they are marked as solved')
                                            ->default(false),

                                        Forms\Components\TextInput::make('auto_close_after_days')
                                            ->label('Auto-close After (Days)')
                                            ->numeric()
                                            ->default(7)
                                            ->minValue(1)
                                            ->maxValue(90)
                                            ->visible(fn (Forms\Get $get) => $get('auto_close_solved_tickets')),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Email')
                            ->icon('heroicon-m-envelope')
                            ->schema([
                                Forms\Components\Section::make('Email Settings')
                                    ->schema([
                                        Forms\Components\TextInput::make('email_from_name')
                                            ->label('From Name')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('email_from_address')
                                            ->label('From Email Address')
                                            ->email()
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\Toggle::make('email_notifications_enabled')
                                            ->label('Enable Email Notifications')
                                            ->default(true),

                                        Forms\Components\Toggle::make('email_new_ticket_customer')
                                            ->label('Notify Customer on New Ticket')
                                            ->default(true),

                                        Forms\Components\Toggle::make('email_new_ticket_agent')
                                            ->label('Notify Agent on New Ticket Assignment')
                                            ->default(true),

                                        Forms\Components\Toggle::make('email_new_message_customer')
                                            ->label('Notify Customer on New Message')
                                            ->default(true),

                                        Forms\Components\Textarea::make('email_signature')
                                            ->label('Default Email Signature')
                                            ->rows(4)
                                            ->maxLength(1000)
                                            ->helperText('Default signature for outgoing emails'),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Knowledge Base')
                            ->icon('heroicon-m-book-open')
                            ->schema([
                                Forms\Components\Section::make('Knowledge Base Settings')
                                    ->schema([
                                        Forms\Components\Toggle::make('kb_enabled')
                                            ->label('Enable Knowledge Base')
                                            ->default(true),

                                        Forms\Components\Toggle::make('kb_public')
                                            ->label('Make Knowledge Base Public')
                                            ->helperText('Allow non-authenticated users to view articles')
                                            ->default(false),

                                        Forms\Components\Toggle::make('kb_search_enabled')
                                            ->label('Enable Search')
                                            ->default(true),

                                        Forms\Components\Toggle::make('kb_feedback_enabled')
                                            ->label('Enable Article Feedback')
                                            ->helperText('Allow users to rate articles as helpful or not')
                                            ->default(true),

                                        Forms\Components\TextInput::make('kb_articles_per_page')
                                            ->label('Articles Per Page')
                                            ->numeric()
                                            ->default(20)
                                            ->minValue(5)
                                            ->maxValue(100),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('SLA')
                            ->icon('heroicon-m-clock')
                            ->schema([
                                Forms\Components\Section::make('SLA Settings')
                                    ->schema([
                                        Forms\Components\Toggle::make('sla_enabled')
                                            ->label('Enable SLA Tracking')
                                            ->default(false),

                                        Forms\Components\Select::make('business_hours_timezone')
                                            ->label('Business Hours Timezone')
                                            ->options(collect(timezone_identifiers_list())->mapWithKeys(fn ($tz) => [$tz => $tz]))
                                            ->searchable()
                                            ->default('UTC')
                                            ->required(),

                                        Forms\Components\TimePicker::make('business_hours_start')
                                            ->label('Business Hours Start')
                                            ->default('09:00'),

                                        Forms\Components\TimePicker::make('business_hours_end')
                                            ->label('Business Hours End')
                                            ->default('18:00'),

                                        Forms\Components\CheckboxList::make('business_days')
                                            ->label('Business Days')
                                            ->options([
                                                'monday' => 'Monday',
                                                'tuesday' => 'Tuesday',
                                                'wednesday' => 'Wednesday',
                                                'thursday' => 'Thursday',
                                                'friday' => 'Friday',
                                                'saturday' => 'Saturday',
                                                'sunday' => 'Sunday',
                                            ])
                                            ->default(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'])
                                            ->columns(3),
                                    ])
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function getSettings(): array
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        // Decode JSON values
        foreach ($settings as $key => $value) {
            if (is_string($value) && json_validate($value)) {
                $settings[$key] = json_decode($value, true);
            }
        }

        return $settings;
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            // Encode arrays as JSON
            if (is_array($value)) {
                $value = json_encode($value);
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Notification::make()
            ->success()
            ->title('Settings saved successfully')
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label('Save Settings')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }
}
