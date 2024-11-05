<?php

declare(strict_types=1);

namespace App\Repository;

use App\Db\Database;
use App\Entity\User;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct(Database $database)
    {
        $this->db = $database->getConnection();
    }

    public function findByName(string $username): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new User($data['id'], $data['username']) : null;
    }

    public function complexCheckAccessByIds(int $userId, int $functionId): bool
    {
        $stmt = $this->db->prepare(
            "SELECT 1
            FROM users u
            JOIN functions f ON (
                -- User to function
                EXISTS (
                    SELECT 1
                    FROM user_function_access ufa
                    WHERE ufa.user_id = u.id AND ufa.function_id = f.id
                )
                OR
                -- User to module with the function
                EXISTS (
                    SELECT 1
                    FROM user_module_access uma
                    WHERE uma.user_id = u.id AND uma.module_id = f.module_id
                )
                OR
                -- User through his group to function
                EXISTS (
                    SELECT 1
                    FROM group_function_access gfa
                    JOIN `groups` g ON gfa.group_id = g.id
                    WHERE g.id = u.group_id AND gfa.function_id = f.id
                )
                OR
                -- User through his group to module with function
                EXISTS (
                    SELECT 1
                    FROM group_module_access gma
                    JOIN `groups` g ON gma.group_id = g.id
                    WHERE g.id = u.group_id AND gma.module_id = f.module_id
                )
            )
            WHERE u.id = :userId AND f.id = :functionId;"
        );

        $stmt->execute(['userId' => $userId, 'functionId' => $functionId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return (bool)$data;
    }
}
