<?php

namespace CoenMooij\DevpoolApi\Authentication;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeveloperRegistrationCompleteMailer extends Mailable
{
    use Queueable, SerializesModels;

    public const SUBJECT = 'Welcome to Caspar Coding Developers!';

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build(): self
    {
        return $this->subject(self::SUBJECT)
            ->view(
                'mail.DeveloperRegistrationCompleteMail',
                ['firstName' => $this->user->{User::FIRST_NAME}, 'email' => $this->user->{User::EMAIL}]
            );
    }
}
