<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Advertisement extends Model
{

    const WITHOUT_EXPERIENCE = 'Without experience';
    const LESS_THAN_ONE_YEAR = 'Less than one year';
    const ONE_THREE_YEAR = '1-3 year';
    const THREE_FIVE_YEAR = '3-5 year';
    const FIVE_TEN_YEAR = '5-10 year';
    const MORE_THAN_TEN_YEAR = 'More than ten year';

    const FULL_TIME = "Full Time";
    const PART_TIME = "Part Time";
    const REMOTE = "Remote";
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position',
        'status',
        'title',
        'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
