<?php
// app/Models/Tag.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}