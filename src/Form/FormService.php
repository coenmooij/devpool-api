<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Form;

use CoenMooij\DevpoolApi\Permission\PermissionService;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class FormService implements FormServiceInterface
{
    private const ASCENDING = 'asc';

    /**
     * @var PermissionService
     */
    private $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function getLatestDeveloperForm(): Form
    {
        return Form::with(
            [
                'questions' => function (QueryBuilder $query) {
                    $query->orderBy(Question::ORDER, self::ASCENDING);
                }
            ]
        )->orderBy(Form::CREATED_AT)->first();
    }

    public function getDeveloperForm(int $id): Form
    {
        return Form::with(
            [
                'questions' => function (QueryBuilder $query) {
                    $query->orderBy(Question::ORDER, self::ASCENDING);
                }
            ]
        )->findOrFail($id);
    }

    /**
     * @return Form[]|Collection
     */
    public function getByDeveloper(int $developerId): Collection
    {
        $this->permissionService->ensureCanAccessDeveloper($developerId);

        return Form::with(
            [
                'questions' => function (QueryBuilder $query) {
                    $query->orderBy(Question::ORDER, self::ASCENDING);
                },
                'questions.answers' => function (QueryBuilder $query) use ($developerId) {
                    $query->where(Answer::DEVELOPER_ID, $developerId);
                }
            ]
        )->get();
    }

    public function addToDeveloper(int $developerId, int $formId, string ...$answers): Form
    {
        $this->permissionService->ensureCanAccessDeveloper($developerId);
        /** @var Form $form */
        $form = Form::findOrFail($formId);

        /** @var Question[]|Collection $questions */
        $questions = $form->questions()->orderBy(Question::ORDER, self::ASCENDING)->get();

        if (count($questions) !== count($answers)) {
            throw new BadRequestHttpException();
        }
        foreach ($questions as $question) {
            $answer = new Answer();
            $answer->{Answer::DEVELOPER_ID} = $developerId;
            $answer->{Answer::QUESTION_ID} = $question->{Question::ID};
            $answer->{Answer::VALUE} = array_shift($answers);
            $answer->saveOrFail();
        }

        return $this->getFormByDeveloper($formId, $developerId);
    }

    private function getFormByDeveloper(int $formId, int $developerId): Form
    {
        return Form::with(
            [
                'questions' => function (QueryBuilder $query) {
                    $query->orderBy(Question::ORDER, self::ASCENDING);
                },
                'questions.answers' => function (QueryBuilder $query) use ($developerId) {
                    $query->where(Answer::DEVELOPER_ID, $developerId);
                }
            ]
        )->findOrFail($formId);
    }
}
