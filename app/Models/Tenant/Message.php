<?php

declare(strict_types=1);

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'ticket_id',
        'type',
        'sender_type',
        'sender_id',
        'body',
        'body_html',
        'is_internal',
        'message_id',
        'in_reply_to',
        'headers',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
        'headers' => 'array',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function sender()
    {
        if ($this->sender_type === 'customer') {
            return $this->belongsTo(Customer::class, 'sender_id');
        }

        return $this->belongsTo(User::class, 'sender_id');
    }
}
