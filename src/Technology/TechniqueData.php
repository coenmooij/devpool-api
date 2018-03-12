<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

final class TechniqueData extends AbstractTechnologyData
{
    public const REST = 'REST';
    public const GRAPHQL = 'GraphQL';
    public const TDD = 'Test Driven Design';
    public const BDD = 'Behaviour-Driven Development';
    public const DDD = 'Domain Driven Design';
    public const XP = 'Extreme Programming';
    public const AGILE = 'Agile';
    public const SCRUM = 'Scrum';
    public const KANBAN = 'Kanban';
    public const WATERFALL = 'Waterfall';
    public const OOP = 'Object Oriented Programming';
    public const MVC = 'MVC';
    public const UNIT_TESTING = 'Unit Testing';
    public const PAIR_PROGRAMMING = 'Pair Programming';
    public const CODE_REVIEWS = 'Code Reviews';
    public const MACHINE_LEARNING = 'Machine learning';
    public const DEEP_LEARNING = 'Deep learning';
    public const AI = 'Artificial Intelligence';
    public const DATA_SCIENCE = 'Data Science';
    public const MULTI_TENANCY = 'Multi-tenancy';
    public const CI = 'Continuous Integration';
    public const CD = 'Continuous Deployment';
    public const DEVOPS = 'DevOps';

    /**
     * @var string
     */
    protected $type = 'Technique';

    /**
     * @var string[]
     */
    protected $parents = [
        self::SCRUM => self::AGILE,
        self::KANBAN => self::AGILE,
        self::XP => self::AGILE,
        self::CI => self::DEVOPS,
        self::CD => self::DEVOPS,
    ];
}
