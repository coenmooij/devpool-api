<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\CRM;

use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class CommentController extends AbstractController
{
    private const COMMENTS_KEY = 'comments';
    private const COMMENT_KEY = 'comment';
    private const TYPE_KEY = 'type';
    private const MESSAGE_KEY = 'message';
    private const MESSAGE_COMMENT_DELETED = 'Comment successfully deleted';

    private const CREATE_RULES = [
        self::TYPE_KEY => 'required|max:255',
        self::MESSAGE_KEY => 'required|max:255',
    ];
    private const UPDATE_RULES = [
        self::MESSAGE_KEY => 'required|max:255',
    ];

    /**
     * @var CommentServiceInterface
     */
    private $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    public function getByDeveloper(int $id): JsonResponse
    {
        $comments = $this->commentService->getByDeveloper($id);

        return self::createResponse(Response::HTTP_OK, [self::COMMENTS_KEY => $comments]);
    }

    public function getOne(int $id): JsonResponse
    {
        $comment = $this->commentService->getOne($id);

        return self::createResponse(Response::HTTP_OK, [self::COMMENT_KEY => $comment]);
    }

    public function create(Request $request, int $id): JsonResponse
    {
        $this->validate($request, self::CREATE_RULES);
        $comment = $this->commentService->create(
            $id,
            $request->request->get(self::TYPE_KEY),
            $request->request->get(self::MESSAGE_KEY)
        );

        return self::createResponse(Response::HTTP_CREATED, [self::COMMENT_KEY => $comment]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, self::UPDATE_RULES);
        $comment = $this->commentService->update($id, $request->request->get(self::MESSAGE_KEY));

        return self::createResponse(Response::HTTP_ACCEPTED, [self::COMMENT_KEY => $comment]);
    }

    public function delete(int $id): JsonResponse
    {
        $this->commentService->delete($id);

        return self::createResponse(Response::HTTP_ACCEPTED, null, self::MESSAGE_COMMENT_DELETED);
    }
}
