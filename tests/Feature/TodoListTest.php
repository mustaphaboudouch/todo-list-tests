<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    public function test_todolist_is_created_on_user_register(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd12345',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $this->assertTrue(!!$user->todoList);
    }

    public function test_user_has_one_todolist(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd12345',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $this->assertDatabaseCount('todo_lists', 1);
    }
}
