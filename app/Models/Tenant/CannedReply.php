<?php

declare(strict_types=1);

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class CannedReply extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'body',
        'is_shared',
        'user_id',
    ];

    protected $casts = [
        'is_shared' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
