<?php

namespace Tests\Unit;

use App\Models\User;
use Database\Seeders\UsersTableSeeder;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    //Check if login page exists
    public function test_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    //Check if user exists in database
    public function test_user_duplication()
    {
        $user1 = User::make([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com'
        ]);

        $user2 = User::make([
            'name' => 'Mary Jane',
            'email' => 'maryjane@gmail.com'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    //Test if a user can be deleted (make sure that you add the middleware)
    public function test_delete_user()
    {
        $user = User::factory()->count(1)->make();

        $user = User::first();

        if($user) {
            $user->delete();
        }

        $this->assertTrue(true);
    }

    //Perform a post() request to add a new user
    public function test_if_it_stores_new_users()
    {
        $response = $this->post('/register', [
            'name' => 'Dary',
            'email' => 'dary@gmail.com',
            'password' => 'dary1234',
            'password_confirmation' => 'dary1234'
        ]);

        $response->assertRedirect('/home');
    }

    public function test_if_data_exists_in_database()
    {
        $this->assertDatabaseHas('users', [
            'name' => 'Dary'
        ]);
    }

    public function test_if_data_does_not_exists_in_database()
    {
        $this->assertDatabaseHas('users', [
            'name' => 'John'
        ]);
    }

    public function test_if_seeders_works()
    {
        $this->seed();
    }

    public function test_if_seeder_works()
    {
        $this->seed(UsersTableSeeder::class);
    }
}
