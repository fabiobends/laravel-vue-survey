<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $casts = [
        'options' => 'array',
        'votes' => 'array',
    ];

    protected $fillable = [
        'poll_description',
        'views',
        'votes',
        'options',
    ];

    protected $attributes = [
        'options' => '[
            {
                "option_id": 1,
                "option_description": ""
            },
            {
                "option_id": 2,
                "option_description": ""
            },
            {

                "option_id": 3,
                "option_description": ""
            }
        ]',
        'votes' => '[
            {
                "option_id": 1,
                "qty": 0
            },
            {
                "option_id": 2,
                "qty": 0
            },
            {

                "option_id": 3,
                "qty": 0
            }
        ]',
        
    ];
}
