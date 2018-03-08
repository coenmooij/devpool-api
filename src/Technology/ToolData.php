<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

class ToolData extends AbstractTechnologyData
{
    public const DOCKER = 'docker';
    public const KUBERNETES = 'kubernetes';
    public const JENKINS = 'jenkins';
    public const MAVEN = 'maven';
    public const PHPSTORM = 'phpstorm';
}
