<?php

declare(strict_types=1);

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number',
        'subject',
        'status',
        'priority',
        'source',
        'customer_id',
        'mailbox_id',
        'assigned_to',
        'team_id',
        'sla_policy_id',
        'first_response_at',
        'resolved_at',
        'closed_at',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'first_response_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (! $ticket->number) {
                $ticket->number = static::generateTicketNumber();
            }
        });
    }

    public static function generateTicketNumber(): string
    {
        $lastTicket = static::latest('id')->first();
        $nextId = $lastTicket ? $lastTicket->id + 1 : 1;

        return 'HLP-'.str_pad((string) $nextId, 6, '0', STR_PAD_LEFT);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function mailbox()
    {
        return $this->belongsTo(Mailbox::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function slaPolicy()
    {
        return $this->belongsTo(SlaPolicy::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }
}
