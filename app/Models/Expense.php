<?php

namespace App\Models;

use App\DB;
use App\App;

class Expense
{
    protected DB $db;

    public function __construct()
    {
        $this->db = App::db();
    }

    // we can take in an array of expenses instead of one expense at a time
    // this lets us run the prepare statement once for a number of expenses
    // otherwise the prepare statement will be run x times for x number of expenses
    public function createMany(array $expenses, int $reportId): int
    {
        $expQuery = 'INSERT INTO expenses (amount, report_id)
                            VALUES (?, ?)';

        $newExpStmt = $this->db->prepare($expQuery);

        foreach ($expenses as $amount) {
            $newExpStmt->execute([$amount, $reportId]);
        }

        return $this->db->lastInsertId();
    }
}