<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTabelaOrigens extends Model
{
    use HasFactory;
    protected $table = "user_tabela_origens";
    public $timestamps = false;
}
