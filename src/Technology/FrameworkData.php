<?php

declare(strict_types=1);

namespace CoenMooij\DevpoolApi\Technology;

final class FrameworkData extends AbstractTechnologyData
{
    public const ASP_NET = 'ASP.NET';
    public const ASP_NET_MVC = 'ASP.NET MVC';
    public const ANGULAR_JS = 'AngularJS';
    public const RUBY_ON_RAILS = 'Ruby on Rails';
    public const REACT = 'React';
    public const REACT_NATIVE = 'React-native';
    public const DJANGO = 'Django';
    public const LARAVEL = 'Laravel';
    public const SPRING = 'Spring';
    public const EXPRESS = 'Express';
    public const NODE_JS = 'Node.js';
    public const VUE_JS = 'Vue.js';
    public const METEOR = 'Meteor';
    public const FLASK = 'Flask';
    public const CODE_IGNITER = 'CodeIgniter';
    public const SYMFONY = 'Symfony';
    public const EMBER_JS = 'Ember.js';
    public const CAKE_PHP = 'CakePHP';
    public const PLAY = 'Play';
    public const SAILS_JS = 'Sails.js';
    public const ZEND = 'Zend';
    public const YII = 'Yii';
    public const TORNADO = 'Tornado';
    public const SINATRA = 'Sinatra';
    public const GRAILS = 'Grails';
    public const PHOENIX = 'Phoenix';
    public const PHALCON = 'Phalcon';
    public const RIOT_JS = 'Riot.js';

    /**
     * @var string
     */
    protected $type = 'Framework';

    /**
     * @var string[]
     */
    protected $parents = [
        self::ASP_NET => LanguageData::CS,
        self::ASP_NET_MVC => LanguageData::CS,
        self::ANGULAR_JS => LanguageData::JAVASCRIPT,
        self::REACT => LanguageData::JAVASCRIPT,
        self::REACT_NATIVE => LanguageData::JAVASCRIPT,
        self::RUBY_ON_RAILS => LanguageData::RUBY,
        self::DJANGO => LanguageData::PYTHON,
        self::LARAVEL => LanguageData::PHP,
        self::SPRING => LanguageData::JAVA,
        self::NODE_JS => LanguageData::JAVASCRIPT,
        self::EXPRESS => LanguageData::JAVASCRIPT,
        self::VUE_JS => LanguageData::JAVASCRIPT,
        self::METEOR => LanguageData::JAVASCRIPT,
        self::FLASK => LanguageData::PYTHON,
        self::CODE_IGNITER => LanguageData::PHP,
        self::SYMFONY => LanguageData::PHP,
        self::EMBER_JS => LanguageData::JAVASCRIPT,
        self::CAKE_PHP => LanguageData::PHP,
        self::PLAY => LanguageData::SCALA,
        self::SAILS_JS => LanguageData::JAVASCRIPT,
        self::ZEND => LanguageData::PHP,
        self::YII => LanguageData::PHP,
        self::TORNADO => LanguageData::PYTHON,
        self::SINATRA => LanguageData::RUBY,
        self::GRAILS => LanguageData::GROOVY,
        self::PHOENIX => LanguageData::ELIXIR,
        self::PHALCON => LanguageData::PHP,
        self::RIOT_JS => LanguageData::JAVASCRIPT,
    ];
}
