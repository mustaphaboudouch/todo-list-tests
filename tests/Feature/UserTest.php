<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_is_displayed(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_must_have_firstname(): void
    {
        $response = $this->post('/register', [
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd12345',
            'is_adult' => true,
        ]);

        $this->assertGuest();
    }

    public function test_user_must_have_lastname(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'email' => 'test@example.com',
            'password' => 'Abcd12345',
            'is_adult' => true,
        ]);

        $this->assertGuest();
    }

    public function test_user_must_have_email(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'password' => 'Abcd12345',
            'is_adult' => true,
        ]);

        $this->assertGuest();
    }

    public function test_user_email_must_be_unique(): void
    {
        User::create([
            'firstname' => 'Steve',
            'lastname' => 'Jobs',
            'email' => 'test@example.com',
            'password' => 'Hello1234',
            'is_adult' => true,
        ]);

        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd12345',
            'is_adult' => true,
        ]);

        $this->assertGuest();
    }

    public function test_user_must_have_password(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'is_adult' => true,
        ]);

        $this->assertGuest();
    }

    public function test_user_password_must_be_greater_than_8(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abc1',
            'is_adult' => true,
        ]);

        $this->assertGuest();
    }

    public function test_user_password_must_be_lower_than_40(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abc12345678901234567890123456789012345678',
            'is_adult' => true,
        ]);

        $this->assertGuest();
    }

    public function test_user_password_must_have_lowercase(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'ABCD12345',
            'is_adult' => true,
        ]);

        $this->assertGuest();
    }

    public function test_user_password_must_have_uppercase(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'abcd12345',
            'is_adult' => true,
        ]);

        $this->assertGuest();
    }

    public function test_user_password_must_have_digit(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'ABCDabcd',
            'is_adult' => true,
        ]);

        $this->assertGuest();
    }

    public function test_user_must_be_13_yo_or_more(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => false,
        ]);

        $this->assertGuest();
    }

    public function test_login_page_is_displayed(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_can_login(): void
    {
        $user = User::create([
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_insert_correct_credentials(): void
    {
        $user = User::create([
            'firstname' => 'Mustapha',
            'lastname' => 'Boudouch',
            'email' => 'test@example.com',
            'password' => 'Abcd1234',
            'is_adult' => true,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Hello1234',
        ]);

        $this->assertGuest();
    }
}
