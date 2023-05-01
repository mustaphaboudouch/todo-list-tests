<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_items_list_page_is_displayed(): void
    {
        $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $response = $this->actingAs($user)->get('/items');

        $response->assertStatus(200);
    }

    public function test_items_create_page_is_displayed(): void
    {
        $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $response = $this->actingAs($user)->get('/items/create');

        $response->assertStatus(200);
    }

    public function test_user_can_create_item(): void
    {
        $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $response = $this
            ->actingAs($user)
            ->post('/items', [
                'name' => 'item1',
                'content' => 'Item content',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/items');

        $this->assertDatabaseCount('items', 1);
    }

    public function test_item_must_have_name(): void
    {
        $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $this->actingAs($user)
            ->post('/items', [
                'content' => 'Item content 1',
            ]);

        $this->assertDatabaseCount('items', 0);
    }

    public function test_item_name_must_be_unique(): void
    {
        $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        Item::create([
            'name' => 'item1',
            'content' => 'Item content 1',
            'todo_list_id' => $user->todoList->id,
        ]);

        $this->assertDatabaseCount('items', 1);

        $this->expectException(QueryException::class);

        Item::create([
            'name' => 'item1',
            'content' => 'Item content 2',
            'todo_list_id' => $user->todoList->id,
        ]);

        $this->assertDatabaseCount('items', 1);
    }

    public function test_item_must_have_content(): void
    {
        $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $this->actingAs($user)
            ->post('/items', [
                'name' => 'item1',
            ]);

        $this->assertDatabaseCount('items', 0);
    }

    public function test_item_content_must_be_lower_than_1000(): void
    {
        $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $this->actingAs($user)
            ->post('/items', [
                'name' => 'item1',
                'content' => Str::random(1001),
            ]);

        $this->assertDatabaseCount('items', 0);
    }

    public function test_items_must_be_less_than_10(): void
    {
        $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        Item::insert([
            [
                'name' => 'item1',
                'content' => 'Item content 1',
                'todo_list_id' => $user->todoList->id,
            ],
            [
                'name' => 'item2',
                'content' => 'Item content 2',
                'todo_list_id' => $user->todoList->id,
            ],
            [
                'name' => 'item3',
                'content' => 'Item content 3',
                'todo_list_id' => $user->todoList->id,
            ],
            [
                'name' => 'item4',
                'content' => 'Item content 4',
                'todo_list_id' => $user->todoList->id,
            ],
            [
                'name' => 'item5',
                'content' => 'Item content 5',
                'todo_list_id' => $user->todoList->id,
            ],
            [
                'name' => 'item6',
                'content' => 'Item content 6',
                'todo_list_id' => $user->todoList->id,
            ],
            [
                'name' => 'item7',
                'content' => 'Item content 7',
                'todo_list_id' => $user->todoList->id,
            ],
            [
                'name' => 'item8',
                'content' => 'Item content 8',
                'todo_list_id' => $user->todoList->id,
            ],
            [
                'name' => 'item9',
                'content' => 'Item content 9',
                'todo_list_id' => $user->todoList->id,
            ],
            [
                'name' => 'item10',
                'content' => 'Item content 10',
                'todo_list_id' => $user->todoList->id,
            ]
        ]);

        $this->actingAs($user)
            ->post('/items', [
                'name' => 'item11',
                'content' => 'Item content 11',
            ]);

        $this->assertDatabaseCount('items', 10);
    }

    public function test_user_must_wait_30min_before_create_item(): void
    {
        $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $this->actingAs($user)
            ->post('/items', [
                'name' => 'item1',
                'content' => 'Item content 1',
                'todo_list_id' => $user->todoList->id,
            ]);

        $this->actingAs($user)
            ->post('/items', [
                'name' => 'item2',
                'content' => 'Item content 2',
                'todo_list_id' => $user->todoList->id,
            ]);

        $this->assertDatabaseCount('items', 1);
    }
}
