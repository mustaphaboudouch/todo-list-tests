<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'todo_list_id',
        'name',
        'content',
    ];

    /**
     * Get the todo list that this item belongs to.
     */
    public function todoList()
    {
        return $this->belongsTo(TodoList::class);
    }
}
