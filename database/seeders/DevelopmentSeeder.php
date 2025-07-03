<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use App\Models\Category;
use Database\Factories\BookFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin
        $admin = UserFactory::new()->create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('admin');

        // Create librarian
        $librarian = UserFactory::new()->create([
            'username' => 'librarian',
            'email' => 'librarian@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $librarian->assignRole('librarian');

        // Create members
        $startNis = 1930511000;

        for ($i = 0; $i < 15; $i++) {
            $nis = $startNis + $i;

            $member = UserFactory::new()->create([
                'username' => (string) $nis,             // atau bisa diganti "member{$i}" jika ingin pakai teks
                'nis' => (string) $nis,
                'email' => "member{$i}@gmail.com",
                'password' => Hash::make('password'),
            ]);

            $member->assignRole('member');
        }

        // Create categories
        $categories = [
            'Fiksi',
            'Non-Fiksi',
            'Pendidikan',
            'Anak-Anak & Remaja',
            'Komik & Manga',
            'Bahasa',
            'Seni & Desain',
            'Komputer & Teknologi',
            'Bisnis & Ekonomi',
            'Kesehatan & Kedokteran',
            'Hobi & Gaya Hidup',
        ];

        foreach ($categories as $category) {
            CategoryFactory::new()->create([
                'name' => $category,
            ]);
        }

        // Create books
        $books = [
            [
                'title' => 'Introduction to Laravel',
                'cover' => null,
                'author' => 'Taylor Otwell',
                'publisher' => 'Laravel Press',
                'year_published' => 2021,
                'stock' => 10,
            ],
            [
                'title' => 'Mastering PHP 8',
                'cover' => null,
                'author' => 'John Doe',
                'publisher' => 'TechWorld',
                'year_published' => 2020,
                'stock' => 15,
            ],
            [
                'title' => 'Data Structures with C++',
                'cover' => null,
                'author' => 'Bjarne Stroustrup',
                'publisher' => 'CodeBooks',
                'year_published' => 2018,
                'stock' => 8,
            ],
            [
                'title' => 'Clean Code',
                'cover' => null,
                'author' => 'Robert C. Martin',
                'publisher' => 'Prentice Hall',
                'year_published' => 2008,
                'stock' => 12,
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'cover' => null,
                'author' => 'Andy Hunt',
                'publisher' => 'Addison-Wesley',
                'year_published' => 1999,
                'stock' => 6,
            ],
            [
                'title' => 'You Don’t Know JS',
                'cover' => null,
                'author' => 'Kyle Simpson',
                'publisher' => 'O\'Reilly Media',
                'year_published' => 2015,
                'stock' => 10,
            ],
            [
                'title' => 'Design Patterns in OOP',
                'cover' => null,
                'author' => 'Erich Gamma',
                'publisher' => 'Pearson',
                'year_published' => 1994,
                'stock' => 9,
            ],
            [
                'title' => 'Modern Web Development',
                'cover' => null,
                'author' => 'Adam Freeman',
                'publisher' => 'Apress',
                'year_published' => 2019,
                'stock' => 5,
            ],
            [
                'title' => 'Deep Learning with Python',
                'cover' => null,
                'author' => 'François Chollet',
                'publisher' => 'Manning',
                'year_published' => 2017,
                'stock' => 7,
            ],
            [
                'title' => 'Database Systems',
                'cover' => null,
                'author' => 'Thomas Connolly',
                'publisher' => 'Pearson Education',
                'year_published' => 2015,
                'stock' => 13,
            ],
            [
                'title' => 'Artificial Intelligence: A Modern Approach',
                'cover' => null,
                'author' => 'Stuart Russell',
                'publisher' => 'Pearson',
                'year_published' => 2010,
                'stock' => 4,
            ],
            [
                'title' => 'Refactoring',
                'cover' => null,
                'author' => 'Martin Fowler',
                'publisher' => 'Addison-Wesley',
                'year_published' => 2012,
                'stock' => 11,
            ],
            [
                'title' => 'Operating System Concepts',
                'cover' => null,
                'author' => 'Abraham Silberschatz',
                'publisher' => 'Wiley',
                'year_published' => 2014,
                'stock' => 10,
            ],
            [
                'title' => 'Networking Fundamentals',
                'cover' => null,
                'author' => 'James Kurose',
                'publisher' => 'Pearson',
                'year_published' => 2011,
                'stock' => 14,
            ],
            [
                'title' => 'Learning Vue.js',
                'cover' => null,
                'author' => 'Evan You',
                'publisher' => 'Packt Publishing',
                'year_published' => 2022,
                'stock' => 9,
            ],
            [
                'title' => 'Pro Git',
                'cover' => null,
                'author' => 'Scott Chacon',
                'publisher' => 'Apress',
                'year_published' => 2009,
                'stock' => 6,
            ],
            [
                'title' => 'Python Crash Course',
                'cover' => null,
                'author' => 'Eric Matthes',
                'publisher' => 'No Starch Press',
                'year_published' => 2016,
                'stock' => 17,
            ],
            [
                'title' => 'Fluent Python',
                'cover' => null,
                'author' => 'Luciano Ramalho',
                'publisher' => 'O\'Reilly Media',
                'year_published' => 2015,
                'stock' => 8,
            ],
            [
                'title' => 'Code Complete',
                'cover' => null,
                'author' => 'Steve McConnell',
                'publisher' => 'Microsoft Press',
                'year_published' => 2004,
                'stock' => 6,
            ],
            [
                'title' => 'Cracking the Coding Interview',
                'cover' => null,
                'author' => 'Gayle Laakmann McDowell',
                'publisher' => 'CareerCup',
                'year_published' => 2015,
                'stock' => 20,
            ],
        ];

        $categories = Category::all();

        foreach ($books as $book) {
            $book = BookFactory::new()->create($book);

            // Add 1-3 random category
            $randomCategories = $categories->random(rand(1, 3));

            foreach ($randomCategories as $category) {
                BookCategory::create([
                    'book_id' => $book->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
