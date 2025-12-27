<?php

declare(strict_types=1);

namespace App\Models\Central;

use Database\Factories\Central\TenantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'email',
        'status',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'slug',
            'email',
            'status',
            'data',
        ];
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->latest();
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): TenantFactory
    {
        return TenantFactory::new();
    }
}
