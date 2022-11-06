<?php
namespace App\Models;

use TypeRocket\Models\WPPost;

class Video extends WPPost
{
    public const POST_TYPE = 'video';


    protected $fillable = [
        'title',
        'json',
        'version',
        'slug'
    ];

}
