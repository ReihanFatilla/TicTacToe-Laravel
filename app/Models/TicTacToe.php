<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class TicTacToe extends Model
{
    protected $table = "tic_tac_toe";

    use HasFactory;

    protected $fillable = [
        'name',
        'device_token',
        'game_state'
    ];

    protected $casts = [
        'game_state' => 'json',
    ];
}
