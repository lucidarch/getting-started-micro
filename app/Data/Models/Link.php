<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Abed Halawi <abed.halawi@vinelab.com>
 *
 * @property-read string url
 * @property-read string title
 * @property-read string description
 */
class Link extends Model
{
    protected $fillable = ['url', 'title', 'description'];
}
