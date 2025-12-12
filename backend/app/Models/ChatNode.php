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

    protected $table = 'chat_node';
}
