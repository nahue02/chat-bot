<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatNode extends Model
{
    protected $fillable = [
        'title',
        'message',
    ];

    public function options(){
        return $this->hasMany(NodeOption::class);
    }

    public function positions(){
        return $this->hasMany(NodePosition::class);
    }

    protected $table = 'chat_node';
}
