<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'class_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Enrollment::class, 'class_id', 'user_id')
            ->where('role', 'student')->withTimestamps();
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Enrollment::class, 'class_id', 'user_id')
            ->where('users.role', 'teacher')->withTimestamps();
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Enrollment::class, 'class_id', 'user_id');
    }
}
