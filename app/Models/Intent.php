<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Intent extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'status',
    ];

    /**
     * @return HasMany
     */
    public function trainingPhrases(): HasMany
    {
        return $this->hasMany(TrainingPhrase::class);
    }

    /**
     * @return BelongsToMany
     */
    public function answers(): BelongsToMany
    {
        return $this->belongsToMany(Answer::class, 'answers_intents');
    }
}
