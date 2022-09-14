<?php

namespace App\Models;

use App\App;
use App\DB;

class Report
{
    protected DB $db;

    // construct the database connection to reduce code duplication
    // in create and then fetchRecords method.
    public function __construct()
    {
        $this->db = App::db();
    }

    public function create($title, $date): int
    {
        // create report
        $rptQuery = 'INSERT INTO reports (title, date)
                        VALUES (?, ?)';

        $newRptStmt = $this->db->prepare($rptQuery);

        $newRptStmt->execute([$title, $date]);

        return (int) $this->db->lastInsertId();
    }

    public function fetchRecords(): array
    {
        // there are other ways of writing the query, this one neglects reports that
        // have no expenses
        return $this->db->query(
            'SELECT report_id, title, sum(amount) as amount, count(*) as count, date
            FROM expenses 
            LEFT JOIN reports ON expenses.report_id = reports.id
            GROUP BY report_id'
        )->fetchAll();
    }
}