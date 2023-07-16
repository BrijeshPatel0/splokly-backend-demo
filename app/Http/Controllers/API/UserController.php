<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\API\BecomeTeacherRequest;

class UserController extends Controller
{

    private UserRepositoryInterface $orderRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * @param BecomeTeacherRequest $request
     * @return void
     */
    public function becomeTeacher(BecomeTeacherRequest $request): void
    {
        $validated = $request->validated();

        $this->userRepository->updateUserRole($validated['user_id'], 'teacher');
    }
}
