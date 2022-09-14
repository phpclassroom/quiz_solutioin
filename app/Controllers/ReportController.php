<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\View;
use App\App;
use App\Models\Report;
use App\Models\Expense;

class ReportController
{
    protected Report $report;
    protected Expense $expense;

    // initialise report and expense models
    // to remove need to recreate model whenever
    // an insert or fetch is required
    public function __construct()
    {
        $this->report = new Report();
        $this->expense = new Expense();
    }

    public function index(): View
    {
        // fetch records so that home page will display the table
        $reports = $this->report->fetchRecords();

        return View::make('index', ['reports' => $reports]);
    }

    public function store(): View
    {
        // get user input by destructuring the $_POST super global
        // there are probably better ways to dynamically retrieve all variables
        // that start with 'expense_' pattern by using string matching
        [
            'title' => $title,
            'date' => $date,
            'expense_1' => $expense1,
            'expense_2' =>  $expense2,
            'expense_3' => $expense3
        ] = $_POST;

        // map to convert to array of integers
        // filter to remove zero values
        $expenses = array_filter(
            array_map('intval', [$expense1, $expense2, $expense3]), function ($expense){
                return $expense !== 0;
        }) ;

        $db = App::db();

        try {
            $db->beginTransaction();

            // create report
            $reportId = $this->report->create($title, $date);

            // create expenses
            $this->expense->createMany($expenses, $reportId);

            $db->commit();
        } catch(\Throwable $e) {
            if ($db->inTransaction()){
                $db->rollBack();
            }
            echo $e->getMessage() . ' ' . $e->getCode();
        }

        // fetch records and return the view from the index method
        return $this->index();
    }
}