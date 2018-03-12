<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

final class LanguageData extends AbstractTechnologyData
{
    public const PHP = 'PHP';
    public const JAVA = 'Java';
    public const JAVASCRIPT = 'JavaScript';
    public const PYTHON = 'Python';
    public const CPP = 'C++';
    public const CS = 'C#';
    public const C = 'C';
    public const SWIFT = 'Swift';
    public const VB_NET = 'Visual Basic .NET';
    public const RUBY = 'Ruby';
    public const SQL = 'SQL';
    public const PERL = 'Perl';
    public const OBJECTIVE_C = 'Objective-C';
    public const GO = 'Go';
    public const R = 'R';
    public const KOTLIN = 'Kotlin';
    public const TYPESCRIPT = 'TypeScript';
    public const COFFEESCRIPT = 'CoffeeScript';
    public const CLOJURE = 'Clojure';
    public const ERLANG = 'Erlang';
    public const BASH = 'Bash';
    public const LISP = 'Lisp';
    public const POWER_SHELL = 'PowerShell';
    public const SCALA = 'Scala';
    public const ELIXIR = 'Elixir';
    public const HASKELL = 'Haskell';
    public const GROOVY = 'Groovy';

    /**
     * @var string
     */
    protected $type = 'Language';
}
