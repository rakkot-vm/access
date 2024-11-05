<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\FunctionNotFoundException;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;
use App\Repository\GroupRepository;
use App\Repository\ModuleRepository;
use App\Repository\FunctionRepository;

class AccessService
{
    private UserRepository $userRepository;
    private FunctionRepository $functionRepository;

    public function __construct(
        UserRepository $userRepository,
        FunctionRepository $functionRepository
    ) {
        $this->userRepository = $userRepository;
        $this->functionRepository = $functionRepository;
    }

    public function checkAccess(string $username, string $functionName): bool
    {
        $user = $this->userRepository->findByName($username);
        if (!$user) {
            throw new UserNotFoundException();
        }

        $function = $this->functionRepository->findByName($functionName);
        if (!$function) {
            throw new FunctionNotFoundException();
        }

        return $this->userRepository->complexCheckAccessByIds($user->id, $function->id);
    }
}
