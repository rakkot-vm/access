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
    private GroupRepository $groupRepository;
    private ModuleRepository $moduleRepository;
    private FunctionRepository $functionRepository;

    public function __construct(
        UserRepository $userRepository,
        GroupRepository $groupRepository,
        ModuleRepository $moduleRepository,
        FunctionRepository $functionRepository
    ) {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->moduleRepository = $moduleRepository;
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

        die(var_dump( $this->userRepository->complexCheckAccessByIds($user->id, $function->id)));
    }
}
