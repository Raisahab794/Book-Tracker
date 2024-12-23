<?php

// app/Models/ReadingGoal.php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ReadingGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'books_goal',
        'pages_goal',
        'year'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}