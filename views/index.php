<html>
    <head>
        <title>Final Test</title>
    </head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        table tr th, table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }
        tfoot tr th, tfoot tr td {
            font-size: 20px;
        }
        tfoot tr th {
            text-align: right;
        }
    </style>
    <body>
        <h2>Claim Reports</h2>
        <hr>
        <form action="/" method="post" style="display: flex; flex-direction: row; gap: 1rem">
                <div style="display: flex; flex-direction: column; gap: 1rem">
                    <label for="title">Title
                        <input name="title" type="text" placeholder="Title">
                    </label>
                    <label for="date">Date
                        <input name="date" type="date" placeholder="Date">
                    </label>
                </div>
                <div style="display: flex; flex-direction: column; gap: 1rem">
                    <label for="expense_1">Expense 1
                        <input name="expense_1" type="number" placeholder="Amount">
                    </label>
                    <label for="expense_2">Expense 2
                        <input name="expense_2" type="number" placeholder="Amount">
                    </label>
                    <label for="expense_3">Expense 3
                        <input name="expense_3" type="number" placeholder="Amount">
                    </label>
                </div>
            <button>Create</button>
        </form>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>No of Expenses</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($reports)) : ?>
                <?php foreach($reports as $report): ?>
                    <tr>
                        <td><?= $report['report_id'] ?></td>
                        <td><?= $report['title'] ?></td>
                        <td><?= $report['count'] ?></td>
                        <td><?= $report['amount'] ?></td>
                        <td><?= date( 'd, M Y' , strtotime($report['date']))  ?></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
            </tbody>
        </table>
    </body>
</html>