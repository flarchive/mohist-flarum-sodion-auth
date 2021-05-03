<?php


namespace Mohist\SodionAuthFlarum\Provider;


use Flarum\User\User;
use Flarum\User\UserRepository;
use Mohist\SodionAuth\Result\EmailExistResult;
use Mohist\SodionAuth\Result\NameIncorrectResult;
use Mohist\SodionAuth\Result\NoSuchUserResult;
use Mohist\SodionAuth\Result\PasswordIncorrectResult;
use Mohist\SodionAuth\Result\Result;
use Mohist\SodionAuth\Result\SuccessResult;
use Mohist\SodionAuth\Result\UnknownResult;
use Mohist\SodionAuth\Result\UserExistResult;

class UserProvider extends \Mohist\SodionAuth\Provider\UserProvider
{
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

    public function getByName($username)
    {
        /** @var User $user */
        $user = User::where('username', $username)->first();
        if (!$user) {
            return new NoSuchUserResult();
        }
        return new SuccessResult([
            'username' => $user->username,
            'email' => $user->email
        ]);
    }

    public function getByEmail($email)
    {
        /** @var User $user */
        $user = User::where('email', $email)->first();
        if (!$user) {
            return new NoSuchUserResult();
        }
        return new SuccessResult([
            'username' => $user->username,
            'email' => $user->email
        ]);
    }

    public function loginByName($username, $password)
    {
        /** @var User $user */
        $user = User::where('username', $username)->first();
        if (!$user) {
            return new NoSuchUserResult();
        }
        if($user->username != $username){
            return new NameIncorrectResult([
                'correct' => $user->username,
            ]);
        }
        if ($user->checkPassword($password)) {
            return new SuccessResult();
        }else {
            return new PasswordIncorrectResult();
        }
    }

    public function loginByEmail($email, $password)
    {
        /** @var User $user */
        $user = User::where('email', $email)->first();
        if (!$user) {
            return new NoSuchUserResult();
        }
        if ($user->checkPassword($password)) {
            return new SuccessResult([
                'correct' => $user->username,
            ]);
        }else {
            return new PasswordIncorrectResult();
        }
    }
}
