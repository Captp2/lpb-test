<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Answer extends Model
{
    use HasFactory;

    /**
     * @return BelongsToMany
     */
    public function intents(): BelongsToMany
    {
        return $this->belongsToMany(Intent::class, 'answers_intents');
    }
}
