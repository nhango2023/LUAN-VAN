<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Styling for the table */
        .table-responsive {
            margin-top: 30px;
        }

        .status-success {
            color: green;
            font-weight: bold;
        }

        .status-failed {
            color: red;
            font-weight: bold;
        }

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
        }

        /* Make the status indicator more readable */
        .status-success {
            background-color: #d4edda;
        }

        .status-failed {
            background-color: #f8d7da;
        }

        .status-pending {
            background-color: #fff3cd;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="text-center my-5">Payment History</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Subscription Package</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>22/06/23 08:08</td>
                        <td>Monthly</td>
                        <td>Card payment</td>
                        <td>NGN 2,500.00</td>
                        <td><span class="status status-success">Success</span></td>
                    </tr>
                    <tr>
                        <td>22/06/23 08:08</td>
                        <td>Monthly</td>
                        <td>Card payment</td>
                        <td>NGN 2,500.00</td>
                        <td><span class="status status-success">Success</span></td>
                    </tr>
                    <tr>
                        <td>22/06/23 08:08</td>
                        <td>Monthly</td>
                        <td>Card payment</td>
                        <td>NGN 2,500.00</td>
                        <td><span class="status status-failed">Failed</span></td>
                    </tr>
                    <tr>
                        <td>22/06/23 08:08</td>
                        <td>Monthly</td>
                        <td>Card payment</td>
                        <td>NGN 2,500.00</td>
                        <td><span class="status status-pending">Pending</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
