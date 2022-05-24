<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_books_index_page_rendered_properly()
    {
        $this->withoutExceptionHandling();
        // We want to create a user
        $createdUser = User::factory()->create();

        // we want to hit the books page
        $redirectPage = $this->get('/books');

        // We want to assert what we get status 200
        $redirectPage->assertStatus(200);
    }

    public function test_users_can_create_books() {
        $this->withoutExceptionHandling();
        // We want to create a user
        $user = User::factory()->create();

        // act as the user
        $this->actingAs($user);

        // We want to hit the books url with a post request
        $response = $this->post('/books', [
           'name' => 1984,
           'price' => 29
        ]);

        $response->assertStatus(200);

        $book = Book::first();

        // Only have one book in the database table
        $this->assertEquals(1, Book::count());

        // We want to assert the book has the proper data
        $this->assertEquals(1984, $book->name);
        $this->assertEquals(29, $book->price);
        $this->assertEquals(0, $book->copies_sold);

    }
}
