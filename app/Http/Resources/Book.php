<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $comments = Comment::where('book_id',intval(substr($this->url,40)))
                        ->orderBy('id','desc')
                        ->get();

        return [
            'data'=>[
                'type'=>'books',
                'book_id'=>$this->url,
                'attributes'=>[
                    'isbn'=>$this->isbn,
                    'comments'=> empty($comments) ? [] : new CommentCollection($comments),
                    'authors' => $this->authors,
                    'publisher' => $this->publisher,
                    'numberOfPages' => $this->numberOfPages,
                    'country' => $this->country,
                    'mediaType' => $this->mediaType,
                    'released' => $this->released
                ]
            ]
        ];
    }
}
