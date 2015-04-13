<?php

namespace App\Auth;
use Illuminate\Auth\GenericUser;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserProviderInterface;

class AuthUserProvider implements UserProviderInterface
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     *
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveByID($identifier)
    {
        /** @var User $user  */
        $user = $this->userService->findUserByUserIdentifier($identifier);

        if (!$user instanceof User) {
            return false;
        }

        return new GenericUser([
            'id'       => $user->getUserIdentifier(),
            'username' => $user->getUserName()
        ]);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     *
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        /** @var User $user  */
        $user = $this->userService->findUserByUserName($credentials['username']);

        if (!$user instanceof User) {
            return false;
        }

        return new GenericUser([
            'id'       => $user->getUserIdentifier(),
            'username' => $user->getUserName()
        ]);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param \Illuminate\Auth\UserInterface $user
     * @param  array  $credentials
     *
     * @return bool
     */
    public function validateCredentials(\Illuminate\Auth\UserInterface $user, array $credentials)
    {
        $validated = $this->userService->validateUserCredentials(
            $credentials['username'],
            $credentials['password']
        );

        $validated = $validated && $user->userName = $credentials['username'];

        return $validated;
    }
    public function retrieveByToken($identifier, $token)
    {
        return new \Exception('not implemented');
    }

    /**
     * Needed by Laravel 4.1.26 and above
     */
    public function updateRememberToken(UserInterface $user, $token)
    {
        return new \Exception('not implemented');
    }
}