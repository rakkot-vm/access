<?php

declare(strict_types=1);

namespace App\Repository;

use App\Db\Database;
use App\Entity\Func;
use PDO;

class FunctionRepository
{
    private PDO $db;

    public function __construct(Database $database)
    {
        $this->db = $database->getConnection();
    }

    public function findByName(string $functionName): ?Func
    {
        $stmt = $this->db->prepare("SELECT * FROM functions WHERE function_name = :functionName");
        $stmt->execute(['functionName' => $functionName]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Func($data['id'], $data['function_name'], $data['module_id']) : null;
    }
}
