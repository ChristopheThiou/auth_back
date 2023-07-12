<?php

namespace App\Repository;
use App\Entity\User;

class UserRepository {

    public function persist(User $user):void {
        $connection = Database::getConnection();
        $query = $connection->prepare('INSERT INTO user (email,password,role) VALUES (:email,:password,:role)');
        $query->bindValue(':email', $user->getEmail());
        $query->bindValue(':password', $user->getPassword());
        $query->bindValue(':role', $user->getRole());
        $query->execute();

        $user->setId($connection->lastInsertId());
    }

    public function findByEmail(string $email):?User {
        
        $connection = Database::getConnection();
        $query = $connection->prepare('SELECT * FROM user WHERE email=:email');
        $query->bindValue(':email', $email);
        $query->execute();
        foreach ($query->fetchAll() as $line) {
            return new User($line['email'], $line['password'], $line['role'], $line['id']);
        }
        return null;
   }
    /**
     * @return User[] 
     */
    public function findAll(): array
    {
        $list = [];
        $connection = Database::getConnection();

        $query = $connection->prepare("SELECT * FROM user");

        $query->execute();

        foreach ($query->fetchAll() as $line) {
            $list[] = new User($line['email'], $line['password'], $line['role'], $line['id']);
        }

        return $list;
    }
    /**
     * @param User 
     */
    public function update(User $user) {
        
        $connection = Database::getConnection();

        $query = $connection->prepare("UPDATE user SET email=:email, password=:password, role=:role WHERE id=:id");
        $query->bindValue(':email', $user->getEmail());
        $query->bindValue(':password', $user->getPassword());
        $query->bindValue(':role', $user->getRole());
        $query->bindValue(":id", $user->getId());

        $query->execute();
    }
}