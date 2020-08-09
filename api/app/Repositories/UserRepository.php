<?php

namespace App\Repositories;

use App\User;

class UserRepository {
	protected $user;
	
	public function __construct(User $user)
	{	
		$this->user = $user;	
	}
	
	public function all()
	{
		return $this->user->get();
	}

	public function findById($id)
	{
		if (! isset($id)) {
			return null;
		}

		return $this->user->findOrFail($id);
	}
}