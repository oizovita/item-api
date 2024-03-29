<?php

namespace Src\Controllers;

use Core\Request;
use Core\JsonResponse;
use Src\Contracts\UserRepositoryInterface;
use Exception;

/**
 * Class AuthController
 */
class AuthController
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * ItemController constructor.
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return false|string
     * @throws Exception
     */
    public function register(Request $request): false|string
    {
        $data = $request->getJSON();
        if (!empty($this->userRepository->findByEmail($data['login']))) {
            return JsonResponse::toJson(['Error' => 'Login must be unique', 'status' => 422]);
        }
        $data['password'] = md5($data['password']);
        $user = $this->userRepository->create($data);

        return JsonResponse::toJson($user->toArray(), 201);

    }
}