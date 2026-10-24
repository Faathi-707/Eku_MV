<?php

namespace App\Models;

use App\Enums\DisruptionCategory;
use App\Enums\DisruptionReportStatus;
use Database\Factories\DisruptionReportFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DisruptionReport extends Model
{
    /** @use HasFactory<DisruptionReportFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'category' => DisruptionCategory::class,
            'status' => DisruptionReportStatus::class,
            'geojson' => 'array',
            'clear_by' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
