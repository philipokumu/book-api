<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    // use DatabaseMigrations;
    use RefreshDatabase;
    
    public function test_user_can_add_comment()
    {
        $response = $this->post('api/books/2/comments',[
            'text' => 'This is a nice book',
            'ip_address' => '192.20.35.344'
        ]);

        $comment = Comment::first();

        //assertions
        $this->assertCount(1, Comment::all());
        $this->assertEquals($comment->text, 'This is a nice book');
        $this->assertEquals($comment->ip_address, '192.20.35.344');

        $response->assertStatus(201)
        ->assertJson([
            'data' => [
                'type' => 'comments',
                'comment_id' => $comment->id,
                'attributes' => [
                    'text' => $comment->text,
                    'ip_address' => $comment->ip_address,
                ]
            ]
        ]);

    }

    public function test_user_can_view_comments()
    {
        $book_id = 3;
        Comment::factory()->create(['book_id' => $book_id,'text'=>'Nice book','ip_address'=>'154.63.223.44']);
        Comment::factory()->create(['book_id' => $book_id,'text'=>'Good book','ip_address'=>'153.33.223.44']);

        $response = $this->get('api/books/'. $book_id.'/comments');

        $comments = Comment::where('book_id',$book_id)->get();

        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'comments',
                        'comment_id' => $comments->last()->id,
                        'attributes' => [
                            'text' => $comments->last()->text,
                            'created_at' => ($comments->last()->created_at)->toDateTimeString()
                        ]
                    ]
                ],
                [
                    'data' => [
                        'type' => 'comments',
                        'comment_id' => $comments->first()->id,
                        'attributes' => [
                            'text' => $comments->first()->text,
                            'created_at' => ($comments->last()->created_at)->toDateTimeString()
                        ]
                    ]
                ]
            ],
            'meta' => [
                'comment_count' => $comments->count()
            ]
        ]);
    }

    public function test_user_can_delete_a_comment()
    {        
        $book_id = 3;

        $comment = Comment::factory()->create();

        $response = $this->delete('api/books/'. $book_id.'/comments/' . $comment->id);

        $comment_after_delete = Comment::first();

        $this->assertNull($comment_after_delete);

        $response->assertNoContent();

    }

    /** VALIDATIONS */
    public function test_text_is_required_when_adding_comment()
    {
        $response = $this->post('api/books/2/comments',[
            'text' => '',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('text', $responseString['errors']['meta']);
    }

    public function test_maximum_text_is_500_when_adding_comment()
    {
        $response = $this->post('api/books/2/comments',[
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent facilisis nulla lorem, a sodales eros tempor at. Donec semper, odio in imperdiet vehicula, magna ante euismod nisl, vel dignissim elit nunc quis lectus. Proin ut sem convallis massa volutpat hendrerit. Sed molestie lorem at ultrices fermentum. Nulla sodales turpis vitae mauris euismod, sit amet dapibus massa luctus. Fusce pulvinar euismod risus quis aliquam. Donec hendrerit lacus nec justo maximus, in rutrum mauris hendrerit. Nunc dapibus, arcu eu condimentum pretium, urna nulla eleifend ipsum, lobortis sollicitudin dolor augue quis dui. Vestibulum ut ante tellus.
                Nunc tincidunt aliquet turpis, eget vulputate erat iaculis volutpat. Nulla facilisi. Aenean id leo id neque tincidunt auctor et ac turpis. Donec nunc urna, dignissim a finibus et, vestibulum at augue. Cras ut nibh ex. Vivamus sit amet dui magna. Ut at ipsum enim. Nam dapibus et nibh et venenatis. Aliquam elit lectus, pellentesque in consectetur in, semper eget nisl. Vivamus tristique sapien est, eget aliquet dui vestibulum eu.',
        ]);

        $responseString = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('text', $responseString['errors']['meta']);
    }
}
