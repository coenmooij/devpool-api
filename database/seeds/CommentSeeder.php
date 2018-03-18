<?php

use CoenMooij\DevpoolApi\CRM\Comment;
use CoenMooij\DevpoolApi\Profile\CommentType;
use Illuminate\Database\Seeder;

final class CommentSeeder extends Seeder
{
    private const COMMENTS = [
        [1, 8, CommentType::TECHNICAL, 'Smart guy, knows a lot of stuff about programming'],
        [1, 5, CommentType::SOCIAL, 'Wants to earn a lot of money'],
        [1, 9, CommentType::TECHNICAL, 'Has some good code on his profile'],
        [1, 6, CommentType::TECHNICAL, 'This guy would fit in our company culture'],
    ];

    public function run(): void
    {
        if (Comment::count() === 0) {
            $this->addComments(self::COMMENTS);
        }
    }

    private function addComments(array $comments): void
    {
        foreach ($comments as $comment) {
            $this->addComment(...$comment);
        }
    }

    private function addComment(int $userId, int $authorId, string $type, string $message): void
    {
        $comment = new Comment();
        $comment->{Comment::USER_ID} = $userId;
        $comment->{Comment::AUTHOR_ID} = $authorId;
        $comment->{Comment::TYPE} = CommentType::get($type);
        $comment->{Comment::MESSAGE} = $message;
        $comment->save();
    }
}
