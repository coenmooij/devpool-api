<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Form;

use CoenMooij\DevpoolApi\Infrastructure\AbstractController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class FormController extends AbstractController
{
    private const FORM_KEY = 'form';
    private const FORMS_KEY = 'forms';
    private const FORM_ID_KEY = 'form_id';
    private const ANSWERS_KEY = 'answers';

    private const RULES = [
        self::FORM_ID_KEY => 'required|numeric',
        self::ANSWERS_KEY => 'required',
        self::ANSWERS_KEY . '.*' => 'required|max:255',
    ];

    /**
     * @var FormServiceInterface
     */
    private $formService;

    public function __construct(FormServiceInterface $formService)
    {
        $this->formService = $formService;
    }

    public function getLatestDeveloperForm(): JsonResponse
    {
        $form = $this->formService->getLatestDeveloperForm();

        return self::createResponse(Response::HTTP_OK, [self::FORM_KEY => $form]);
    }

    public function getDeveloperForm(int $id): JsonResponse
    {
        $form = $this->formService->getDeveloperForm($id);

        return self::createResponse(Response::HTTP_OK, [self::FORM_KEY => $form]);
    }

    public function getByDeveloper(int $id): JsonResponse
    {
        $forms = $this->formService->getByDeveloper($id);

        return self::createResponse(Response::HTTP_OK, [self::FORMS_KEY => $forms]);
    }

    public function addToDeveloper(Request $request, int $id): JsonResponse
    {
        $this->validate($request, self::RULES);
        $form = $this->formService->addToDeveloper(
            $id,
            $request->request->get(self::FORM_ID_KEY),
            ...$request->request->get('answers')
        );

        return self::createResponse(Response::HTTP_OK, [self::FORM_KEY => $form]);
    }

}
