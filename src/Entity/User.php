<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface {

    public function __construct(
        #[Assert\Email]
		#[Assert\NotBlank]
        private string $email,
        #[Assert\NotBlank]
        #[Assert\Length(min: 4)]
        private string $password,
        private string $role = '',
        private ?int $id = null
    ) {}


	/**
	 * @return 
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @param  $id 
	 * @return self
	 */
	public function setId(?int $id): self {
		$this->id = $id;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getEmail(): string {
		return $this->email;
	}
	
	/**
	 * @param string $email 
	 * @return self
	 */
	public function setEmail(string $email): self {
		$this->email = $email;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getPassword(): string {
		return $this->password;
	}
	
	/**
	 * @param string $password 
	 * @return self
	 */
	public function setPassword(string $password): self {
		$this->password = $password;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getRole(): string {
		return $this->role;
	}
	
	/**
	 * @param string $role 
	 * @return self
	 */
	public function setRole(string $role): self {
		$this->role = $role;
		return $this;
	}

    public function getUserIdentifier():string {
        return $this->email;
    }
    public function getRoles():array {
        return [$this->role];
    }

    public function eraseCredentials(){}
}