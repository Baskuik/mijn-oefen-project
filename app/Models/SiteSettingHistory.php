<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteSettingHistory extends Model
{
    protected $table = 'site_setting_histories';

    protected $fillable = ['snapshot', 'page_label', 'saved_by'];

    protected $casts = [
        'snapshot' => 'array',
    ];

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'saved_by');
    }
}