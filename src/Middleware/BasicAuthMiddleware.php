<?php

namespace Src\Middleware;

use Core\Request;
use Core\Response;
use Exception;
use Src\Contracts\UserRepositoryInterface;

/**
 * Class BasicAuthMiddleware
 */
class BasicAuthMiddleware
{
    private UserRepositoryInterface $userRepository;

    /**
     * BasicAuthMiddleware constructor.
     *
     * @param UserRepositoryInterface $userRepository The repository to access users.
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request The HTTP request.
     * @param callable $next The next middleware in the chain.
     * @return callable The next middleware in the chain.
     * @throws Exception If the user is not authenticated.
     */
    public function handle(Request $request, callable $next): callable
    {
        if ($request->getAuthUser() == null) {
            header('WWW-Authenticate: Basic realm="Item API"');
            header('HTTP/1.0 401 Unauthorized');
            throw new Exception('Access denied', Response::HTTP_UNAUTHORIZED);
        } else {
            $user = $this->userRepository->findByEmail($_SERVER['PHP_AUTH_USER']);
            if (!$user || $user->getPassword() !== md5($request->getAuthPw())) {
                throw new Exception('Access denied', Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next;
    }
}