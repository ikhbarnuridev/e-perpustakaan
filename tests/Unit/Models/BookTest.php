<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function it_calculates_available_stock_correctly()
    {
        // Arrange
        $book = Book::factory()->create(['stock' => 5]);
        Borrowing::factory()->count(2)->create([
            'book_id' => $book->id,
            'status' => Borrowing::STATUS_BORROWED,
        ]);

        // Act
        $availableStock = $book->availableStock();

        // Assert
        $this->assertEquals(3, $availableStock);
    }

    public function it_returns_true_if_user_has_active_borrowing()
    {
        // Arrange
        $user = User::factory()->create();
        $book = Book::factory()->create();
        Borrowing::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => Borrowing::STATUS_APPROVED,
        ]);

        // Act
        $result = $book->isBorrowedBy($user);

        // Assert
        $this->assertTrue($result);
    }

    public function it_returns_false_if_user_cannot_borrow_due_to_existing_borrowing()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);
        $book = Book::factory()->create(['stock' => 2]);
        Borrowing::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => Borrowing::STATUS_BORROWED,
        ]);

        // Act
        $canBeBorrowed = $book->canBeBorrowed();

        // Assert
        $this->assertFalse($canBeBorrowed);
    }

    public function it_returns_false_if_no_stock_is_available()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);
        $book = Book::factory()->create(['stock' => 1]);
        Borrowing::factory()->create([
            'book_id' => $book->id,
            'status' => Borrowing::STATUS_BORROWED,
        ]);

        // Act
        $canBeBorrowed = $book->canBeBorrowed();

        // Assert
        $this->assertFalse($canBeBorrowed);
    }

    public function it_returns_true_if_user_can_borrow_and_stock_is_available()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);
        $book = Book::factory()->create(['stock' => 3]);

        // Act
        $canBeBorrowed = $book->canBeBorrowed();

        // Assert
        $this->assertTrue($canBeBorrowed);
    }

    public function it_has_many_categories_through_pivot()
    {
        // Arrange
        $book = Book::factory()->create();
        $categories = Category::factory()->count(3)->create();

        // Hubungkan kategori dengan buku
        $book->categories()->attach($categories->pluck('id'));

        // Act
        $loadedCategories = $book->categories;

        // Assert
        $this->assertCount(3, $loadedCategories);
        $this->assertTrue($loadedCategories->contains($categories[0]));
        $this->assertTrue($loadedCategories->contains($categories[1]));
        $this->assertTrue($loadedCategories->contains($categories[2]));
    }
}
