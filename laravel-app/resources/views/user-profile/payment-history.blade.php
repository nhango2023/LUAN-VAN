@extends('user-profile.layout')
@section('profile-right')
    <style>
        /* Styling for the table */
        .table-responsive {
            margin-top: 30px;
            width: 100%;
            /* Ensures the table takes up the full width */
            overflow-x: auto;
            /* Enables horizontal scroll if the table is wider */
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

    <div class="container">
        <div class="table-responsive">
            <table class="table  table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Create at</th>
                        <th>Plan name</th>
                        <th>Price</th>

                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->created_at }}</td>
                            <td>{{ $payment->name }} </td>
                            <td>{{ $payment->price }}</td>
                            <td> <span class="status status-{{ $payment->status }}">{{ $payment->status }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
