<?php

declare(strict_types=1);

use CoenMooij\DevpoolApi\Technology\FrameworkData;
use CoenMooij\DevpoolApi\Technology\LanguageData;
use CoenMooij\DevpoolApi\Technology\TechniqueData;
use CoenMooij\DevpoolApi\Technology\Technology;
use CoenMooij\DevpoolApi\Technology\TechnologyDataInterface;
use CoenMooij\DevpoolApi\Technology\ToolData;
use Illuminate\Database\Seeder;

final class TechnologySeeder extends Seeder
{
    public function run(): void
    {
        $dataList = [
            new ToolData(),
            new TechniqueData(),
            new LanguageData(),
            new FrameworkData()
        ];

        foreach ($dataList as $data) {
            $this->createTechnologies($data);
        }

        foreach ($dataList as $data) {
            $this->addParents($data);
        }
    }

    private function createTechnologies(TechnologyDataInterface $data): void
    {
        foreach ($data->getAll() as $name) {
            if ($this->getTechnologyByName($name) === null) {
                $this->createTechnology($name, $data->getType());
            }
        }
    }

    private function addParents(TechnologyDataInterface $data): void
    {
        foreach ($data->getParents() as $name => $parentName) {
            $this->addParent($name, $parentName);
        }
    }

    private function createTechnology(string $name, string $type): void
    {
        $technology = new Technology();
        $technology->{Technology::NAME} = $name;
        $technology->{Technology::TYPE} = $type;
        $technology->save();
    }

    private function addParent(string $name, string $parentName): void
    {
        $technology = $this->getTechnologyByName($name);
        if ($technology->{Technology::PARENT_ID} !== null) {
            return;
        }
        $parentTechnology = $this->getTechnologyByName($parentName);
        $technology->{Technology::PARENT_ID} = $parentTechnology->{Technology::ID};
        $technology->save();
    }

    private function getTechnologyByName(string $name): ?Technology
    {
        return Technology::where(Technology::NAME, $name)->first();
    }
}
