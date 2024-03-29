<?php

namespace Src\Middleware;

use Exception;
use Src\Contracts\UserRepositoryInterface;

class BasicAuthMiddleware
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws Exception
     */
    public function handle($next)
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Website"');
            header('HTTP/1.0 401 Unauthorized');
            throw new Exception('Access denied', 401);
        } else {
            $user = $this->userRepository->findByEmail($_SERVER['PHP_AUTH_USER']);
            if ($user->getPassword() !== md5($_SERVER['PHP_AUTH_PW'])) {
                throw new Exception('Access denied', 401);
            }
        }

        return $next;
    }
}