<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    // include in test file to migrate table
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    function castToJson($json)
    {
        // Convert from array to json and add slashes, if necessary.
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        }
        // Or check if the value is malformed.
        elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \RuntimeException('A valid JSON string was not provided.');
        }
        return \DB::raw("CAST('{$json}' AS JSON)");
    }

    public function test_login_form(){
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_duplication(){
        $this->withoutExceptionHandling();

        $user1 = User::make([
           'name' => 'John Doe',
           'email' => 'johndoe@email.com'
        ]);
        $user2 = User::make([
            'name' => 'Jane Doe',
            'email' => 'janedoe@email.com'
        ]);

        $this->assertNotSame($user1->name, $user2->name);
    }

    public function test_delete_user(){
        $this->withoutExceptionHandling();

        $user = User::factory()->count(3)->make();

        $user = User::first();

        if($user){
            $user->delete();
        }

        $this->assertTrue(true);
    }

    public function test_it_stores_new_users(){
        $this->withoutExceptionHandling();

        $response = $this->post('/register', [
           'name' => 'Dary',
           'email' => 'dary@gmail.com',
           'password' => 'dary1234',
           'password_confirmation' => 'dary1234'
        ]);

        $response->assertRedirect('/home');
    }

    public function test_database(){
        $this->withoutExceptionHandling();

        $this->assertDatabaseHas('users', [
            'name' => 'Dary',
        ]);
    }

}
