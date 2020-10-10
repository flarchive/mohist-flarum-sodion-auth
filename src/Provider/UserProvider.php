<?php


namespace Mohist\SodionAuthFlarum\Provider;


use Flarum\User\User;
use Flarum\User\UserRepository;
use Mohist\SodionAuth\Result\EmailExistResult;
use Mohist\SodionAuth\Result\NameIncorrectResult;
use Mohist\SodionAuth\Result\NoSuchUserResult;
use Mohist\SodionAuth\Result\PasswordIncorrectResult;
use Mohist\SodionAuth\Result\SuccessResult;
use Mohist\SodionAuth\Result\UnknownResult;
use Mohist\SodionAuth\Result\UserExistResult;

class UserProvider extends \Mohist\SodionAuth\Provider\UserProvider
{
    public function nameVerify($username)
    {
        /** @var User $user */
        $user = User::where('username', $username)->first();
        if (!$user) {
            $user = User::where('username', 'like', '%' . $this->escapeLikeString($username) . '%')
                ->first();
            if ($user) {
                return new NameIncorrectResult([
                    'correct' => $user->username
                ]);
            } else {
                return new NoSuchUserResult();
            }
        }
        return new SuccessResult();
    }

    private function escapeLikeString($string)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $string);
    }

    public function login($username, $password)
    {
        /** @var User $user */
        $user = User::where('username', $username)->first();
        if (!$user) {
            $user = User::where('username', 'like', '%' . $this->escapeLikeString($username) . '%')
                ->first();
            if ($user) {
                return new NameIncorrectResult([
                    'correct' => $user->username
                ]);
            } else {
                return new NoSuchUserResult();
            }
        }
        if ($user->checkPassword($password)) {
            return new SuccessResult();
        }
        return new PasswordIncorrectResult();
    }

    public function loginEmail($email, $password)
    {
        $user = (new UserRepository())->findByEmail($email);
        if (!$user) {
            return new NoSuchUserResult();
        }
        if ($user->checkPassword($password)) {
            return new SuccessResult([
                'correct' => $user->username
            ]);
        } else {
            return new PasswordIncorrectResult();
        }
    }

    public function register($username, $email, $password)
    {
        $user = User::where('username', $username)->first();
        if ($user) {
            return new UserExistResult();
        }
        $user = User::where('email', $email)->first();
        if ($user) {
            return new EmailExistResult();
        }
        $user = User::register($username, $email, $password);
        if (!$user) {
            return new UnknownResult();
        }
        return new SuccessResult();
    }
}
