<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_all_books()
    {
        $response = $this->get('api/books');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'data'=> [
                            'type',
                            'book_id',
                            'attributes'=> [
                                'isbn',
                                'authors',
                                'publisher',
                                'numberOfPages',
                                'country',
                                "mediaType",
                                "released"
                            ]
                        ]
                    ]
                ]
            ]);
    }

    public function test_user_can_view_one_book()
    {
        $response = $this->get('api/books/2');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'book_id',
                    'attributes'=> [
                        'isbn',
                        'authors',
                        'publisher',
                        'numberOfPages',
                        'country',
                        "mediaType",
                        "released"
                    ]
                ]
            ]);
    }

    public function test_book_resource_comes_with_comments_collection()
    {
        $book_id = 4;
        $comment = Comment::factory()->create(['book_id'=>$book_id]);
        $response = $this->get('api/books/' . $book_id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type'=>'books',
                    'attributes'=> [
                        'comments'=> [
                            'data'=> [
                                [
                                    'data'=> [
                                        'type'=>'comments',
                                        'comment_id'=> $comment->id,
                                        'attributes' => [
                                            'text' => $comment->text,
                                            'ip_address' => $comment->ip_address
                                        ]
                                    ]
                                ]
                            ],
                            'meta' => [
                                'comment_count' => Comment::count()
                            ]
                        ],
                    ],
                ]
            ]);
    }
}
