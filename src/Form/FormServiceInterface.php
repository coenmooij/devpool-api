<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Form;

use Illuminate\Database\Eloquent\Collection;

interface FormServiceInterface
{
    /**
     * @return Form[]|Collection
     */
    public function getAllDeveloperForms(): Collection;

    public function getLatestDeveloperForm(): Form;

    public function getDeveloperForm(int $formId): Form;

    /**
     * @return Form[]|Collection
     */
    public function getByDeveloper(int $developerId): Collection;

    public function addToDeveloper(int $developerId, int $formId, string ...$answers): Form;
}
