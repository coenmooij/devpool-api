<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

final class ToolData extends AbstractTechnologyData
{
    public const DOCKER = 'Docker';
    public const KUBERNETES = 'Kubernetes';
    public const JENKINS = 'Jenkins';
    public const MAVEN = 'Maven';
    public const PHPSTORM = 'PHPStorm';
    public const GITHUB = 'GitHub';
    public const JIRA = 'Jira';
    public const BITBUCKET = 'Bitbucket';
    public const TRELLO = 'Trello';
    public const SUBLIME = 'Sublime';
    public const NETBEANS = 'Netbeans';
    public const VS_CODE = 'VS Code';
    public const ANDROID = 'Android';
    public const IOS = 'iOS';
    public const MAC_OS = 'Mac OS';
    public const LINUX = 'Linux';
    public const WINDOWS = 'Windows';
    public const AWS = 'AWS';
    public const GOOGLE_CLOUD = 'Google Cloud';
    public const AZURE = 'Azure';
    public const HEROKU = 'Heroku';
    public const DIGITAL_OCEAN = 'DigitalOcean';
    public const DIRECT_ADMIN = 'DirectAdmin';

    /**
     * @var string
     */
    protected $type = 'Tool';

    /**
     * @var string[]
     */
    protected $parents = [
        self::HEROKU => TechniqueData::DEVOPS,
        self::AZURE => TechniqueData::DEVOPS,
        self::DIGITAL_OCEAN => TechniqueData::DEVOPS,
        self::AWS => TechniqueData::DEVOPS,
    ];
}
