<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $location_slug
 * @property int user_id
 */
class Bookmark extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
}
