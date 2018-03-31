<?php

use CoenMooij\DevpoolApi\Authentication\AuthenticationServiceInterface;
use CoenMooij\DevpoolApi\Authentication\User;
use CoenMooij\DevpoolApi\Authentication\UserType;
use CoenMooij\DevpoolApi\Developer\Developer;
use CoenMooij\DevpoolApi\Profile\Link;
use CoenMooij\DevpoolApi\Profile\LinkType;
use Illuminate\Database\Seeder;

final class DeveloperSeeder extends Seeder
{
    private const DEFAULT_PASSWORD = '123456';
    private const DEVELOPERS = [
        ['Coen', 'Mooij', 'coenmooij@gmail.com'],
        ['Kevin', 'Barasa', 'kevin.barasa001@gmail.com'],
        ['Coen', 'Mooij', 'coen.mooij@casparcoding.com'],
        ['Kevin', 'Barasa', 'kevin.barasa@casparcoding.com'],
    ];

    private const DEVELOPERS_TECHNOLOGIES = [
        1 => [47, 81, 49, 85],
        2 => [48, 82],
        3 => [50, 80],
        4 => [48, 79, 78],
    ];
    private const LINKS = [
        1 => [
            [Link::TYPE => LinkType::GITHUB, Link::VALUE => 'coenmooij'],
            [Link::TYPE => LinkType::LINKEDIN, Link::VALUE => 'coenmooij'],
            [Link::TYPE => LinkType::WEBSITE, Link::VALUE => 'https://coenmooij.nl'],
            [Link::TYPE => LinkType::AVATAR, Link::VALUE => 'https://pbs.twimg.com/profile_images/884149785883791361/l-Cj6OUq_400x400.jpg'],
        ],
        2 => [
            [Link::TYPE => LinkType::GITLAB, Link::VALUE => 'bqevin'],
            [Link::TYPE => LinkType::TWITTER, Link::VALUE => 'kev_barasa'],
            [Link::TYPE => LinkType::GITHUB, Link::VALUE => 'bqevin'],
            [Link::TYPE => LinkType::BITBUCKET, Link::VALUE => 'bqevin'],
            [Link::TYPE => LinkType::AVATAR, Link::VALUE => 'https://pbs.twimg.com/profile_images/786965786405502976/9RjdcD-b_400x400.jpg'],
        ],
        3 => [
            [Link::TYPE => LinkType::FACEBOOK, Link::VALUE => 'coenmooij'],
            [Link::TYPE => LinkType::TWITTER, Link::VALUE => 'coenmooij'],
            [Link::TYPE => LinkType::INSTAGRAM, Link::VALUE => 'coenmooij'],
        ],
    ];

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function run(): void
    {
        $this->registerDevelopers(self::DEVELOPERS);
        $this->addDevelopersTechnologies(self::DEVELOPERS_TECHNOLOGIES);
        $this->addLinksForDevelopers(self::LINKS);
    }

    private function registerDevelopers($developers): void
    {
        foreach ($developers as $developer) {
            $this->registerDeveloper(...$developer);
        }
    }

    private function registerDeveloper(string $firstName, string $lastName, string $email): void
    {
        if ($this->getUserByEmail($email) === null) {
            $this->authenticationService->registerUser(
                $email,
                self::DEFAULT_PASSWORD,
                $firstName,
                $lastName,
                UserType::DEVELOPER
            );
        }
    }

    private function getUserByEmail(string $email): ?User
    {
        return User::where(User::EMAIL, $email)->first();
    }

    private function addDevelopersTechnologies(array $developers_technologies): void
    {
        foreach ($developers_technologies as $developer => $technologies) {
            $this->addTechnologies($developer, $technologies);
        }
    }

    private function addTechnologies(int $developerId, array $technologies): void
    {
        /**
         * @var Developer $developer
         */
        $developer = Developer::find($developerId);
        if ($developer->technologies()->count() === 0) {
            foreach ($technologies as $technologyId) {
                $developer->technologies()->attach($technologyId);
            }
        }

        $developer->save();
    }

    private function addLinksForDevelopers($developers_links): void
    {
        foreach ($developers_links as $developer => $links) {
            $this->addLinksForDeveloper($developer, $links);
        }
    }

    private function addLinksForDeveloper($developerId, $linkData): void
    {
        if (Link::where(Link::USER_ID, $developerId)->count() === 0) {
            foreach ($linkData as $data) {
                $link = new Link();
                $link->{Link::USER_ID} = $developerId;
                $link->{Link::TYPE} = LinkType::get($data[Link::TYPE]);
                $link->{Link::VALUE} = $data[Link::VALUE];
                $link->save();
            }
        }
    }
}
