<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Idea extends Model
{
  const PAGINATION_COUNT = 10;

  use HasFactory, Sluggable;

  protected $guarded = [];

  public function sluggable(): array
  {
    return [
        'slug' => [
            'source' => 'title',
        ],
    ];
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }

  public function status(): BelongsTo
  {
    return $this->belongsTo(Status::class);
  }

    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'votes');
    }
}
