<?php

namespace CoenMooij\DevpoolApi\Authentication;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class DeveloperBackofficeRegistrationMailer extends Mailable
{
    use Queueable, SerializesModels;

    public const SUBJECT = 'Welcome to Caspar Coding Developers!';

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    public function __construct(User $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build(): self
    {
        return $this->subject(self::SUBJECT)
            ->view(
                'mail.DeveloperBackofficeRegistrationMail',
                [
                    'name' => $this->user->{User::FIRST_NAME},
                    'email' => $this->user->{User::EMAIL},
                    'password' => $this->password,
                ]
            );
    }
}
