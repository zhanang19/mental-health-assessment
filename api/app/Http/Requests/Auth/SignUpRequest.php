<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserRoles;
use App\Repository\UserRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class SignUpRequest extends FormRequest
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $userId
     * @return User
     */
    public function persist($userId = null)
    {
        $user = null;

        if ($this->method() == "POST") {
            $user = $this->userRepository->create($this->all());
        } else if ($this->method() == "PUT") {
            $user = $this->userRepository->update($userId, $this->all());
        }

        return $user;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            // 'middle_name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required|confirmed',
        ];

        if ($this->method() == "PUT") {
            $rules = Arr::except($rules, [
                'password'
            ]);
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'username' => 'required',
            'first_name' => 'first name',
            'last_name' => 'last name',
            'middle_name' => 'middle name',
            'contact_number' => 'contact number',
            'role' => 'role',
            'type' => 'user type',
            'date_joined' => 'date joined',
        ];
    }
}
