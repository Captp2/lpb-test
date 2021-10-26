<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingPhrase extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function intent(): BelongsTo
    {
        return $this->belongsTo(Intent::class);
    }
}
