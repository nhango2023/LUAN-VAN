@extends('admin.layout')
@section('content')
    <style>
        .table-responsive {
            margin: 30px 0;
        }

        .table-wrapper {
            min-width: 1000px;
            background: #fff;
            padding: 20px 25px;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-wrapper .btn {
            float: right;
            color: #333;
            background-color: #fff;
            border-radius: 3px;
            border: none;
            outline: none !important;
            margin-left: 10px;
        }

        .table-wrapper .btn:hover {
            color: #333;
            background: #f2f2f2;
        }

        .table-wrapper .btn.btn-primary {
            color: #fff;
            background: #03A9F4;
        }

        .table-wrapper .btn.btn-primary:hover {
            background: #03a3e7;
        }

        .table-title .btn {
            font-size: 13px;
            border: none;
        }

        .table-title .btn i {
            float: left;
            font-size: 21px;
            margin-right: 5px;
        }

        .table-title .btn span {
            float: left;
            margin-top: 2px;
        }

        .table-title {
            color: #fff;
            background: #4b5366;
            padding: 16px 25px;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .show-entries select.form-control {
            width: 60px;
            margin: 0 5px;
        }

        .table-filter .filter-group {
            float: right;
            margin-left: 15px;
        }

        .table-filter input,
        .table-filter select {
            height: 34px;
            border-radius: 3px;
            border-color: #ddd;
            box-shadow: none;
        }

        .table-filter {
            padding: 5px 0 15px;
            border-bottom: 1px solid #e9e9e9;
            margin-bottom: 5px;
        }

        .table-filter .btn {
            height: 34px;
        }

        .table-filter label {
            font-weight: normal;
            margin-left: 10px;
        }

        .table-filter select,
        .table-filter input {
            display: inline-block;
            margin-left: 5px;
        }

        .table-filter input {
            width: 200px;
            display: inline-block;
        }

        .filter-group select.form-control {
            width: 110px;
        }

        .filter-icon {
            float: right;
            margin-top: 7px;
        }

        .filter-icon i {
            font-size: 18px;
            opacity: 0.7;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 4px 10px;
            vertical-align: middle;
        }

        table.table tr th:first-child {}

        table.table tr th:last-child {
            width: 110px;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }

        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td a {
            font-weight: bold;
            color: #566787;
            display: inline-block;
            text-decoration: none;
        }

        table.table td a:hover {
            color: #2196F3;
        }

        table.table td a.view {
            width: 30px;
            height: 30px;
            color: #2196F3;
            border: 2px solid;
            border-radius: 30px;
            text-align: center;
        }

        table.table td a.view i {
            font-size: 22px;
            margin: 2px 0 0 1px;
        }

        table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
        }

        .status {
            font-size: 30px;
            margin: 2px 2px 0 0;
            display: inline-block;
            vertical-align: middle;
            line-height: 10px;
        }

        .text-success {
            color: #10c469;
        }

        .text-info {
            color: #62c9e8;
        }

        .text-warning {
            color: #FFC107;
        }

        .text-danger {
            color: #ff5b5b;
        }

        .pagination {
            float: right;
            margin: 0 0 5px;
        }

        .pagination li a {
            border: none;
            font-size: 13px;
            min-width: 30px;
            min-height: 30px;
            color: #999;
            margin: 0 2px;
            line-height: 30px;
            border-radius: 2px !important;
            text-align: center;
            padding: 0 6px;
        }

        .pagination li a:hover {
            color: #666;
        }

        .pagination li.active a {
            background: #03A9F4;
        }

        .pagination li.active a:hover {
            background: #0397d6;
        }

        .pagination li.disabled i {
            color: #ccc;
        }

        .pagination li i {
            font-size: 16px;
            padding-top: 6px
        }

        .hint-text {
            float: left;
            margin-top: 10px;
            font-size: 13px;
        }

        table {
            table-layout: fixed;
            /* This forces the cells to have fixed widths */
            width: 100%;
            /* Ensure the table takes up full width */
        }

        table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-4">
                            <h2 style="color: white">Website <b>Config</b></h2>
                        </div>
                        <div class="col-sm-8">
                            <a href="#" class="btn btn-primary"><i class="material-icons">&#xE863;</i> <span>Refresh
                                    List</span></a>
                            <a href="#" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Export
                                    to Excel</span></a>
                        </div>
                    </div>
                </div>
                <div class="table-filter">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="show-entries">
                                <span>Show</span>
                                <select class="form-control">
                                    <option>5</option>
                                    <option>10</option>
                                    <option>15</option>
                                    <option>20</option>
                                </select>
                                <span>entries</span>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            <div class="filter-group">
                                <label>Name</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="filter-group">
                                <label>Location</label>
                                <select class="form-control">
                                    <option>All</option>
                                    <option>Berlin</option>
                                    <option>London</option>
                                    <option>Madrid</option>
                                    <option>New York</option>
                                    <option>Paris</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Status</label>
                                <select class="form-control">
                                    <option>Any</option>
                                    <option>Delivered</option>
                                    <option>Shipped</option>
                                    <option>Pending</option>
                                    <option>Cancelled</option>
                                </select>
                            </div>
                            <span class="filter-icon"><i class="fa fa-filter"></i></span>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width:4%">#</th>
                            <th style="width:5%">Logo</th>
                            <th>Title</th>
                            <th>Keyword</th>
                            <th>Web description</th>
                            <th>Address</th>

                            <th style="width: 12%">Status</th>
                            <th style="width: 13%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($configWeb as $key => $item)
                            <tr>
                                <td style="width:4%">{{ $key + 1 }}</td> <!-- Display the index starting from 1 -->
                                <td style="width:5%">
                                    <a href="#">
                                        <img style="width: 45px; height: 45px"
                                            src="{{ asset('storage/images/' . $item->logo) }}" class="avatar"
                                            alt="Avatar">
                                    </a>
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->keywords }}</td>
                                <td>{{ $item->web_description }}</td>
                                <td>{{ $item->address }}</td>

                                <td>{!! $item->isUse == 1
                                    ? '<span class="status text-success">&bull;</span> In use'
                                    : '<span class="status text-danger">&bull; </span> Not in use' !!}
                                </td>
                                <td>
                                    <a href="{{ route('admin.config-web.detail', ['id' => $item->id]) }}" class="view"
                                        title="View Details" data-toggle="tooltip">
                                        <i class="material-icons">&#xE5C8;</i>
                                    </a>
                                    <a href="#" class="view" title="Delete" data-toggle="tooltip">
                                        <span style="color: #EA3323; php" class="material-symbols-outlined">
                                            delete
                                        </span>
                                    </a>
                                    {!! $item->isUse == 1
                                        ? ''
                                        : '
                                                                                                                                                <a href="#" class="view" title="Use" data-toggle="tooltip">
                                                                                                                                                <span class="material-symbols-outlined">
                                                                                                                                                back_hand
                                                                                                                                                </span>
                                                                                                                                                </a>
                                                                                                                                                ' !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix">
                    <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                    <ul class="pagination">
                        <li class="page-item disabled"><a href="#">Previous</a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item active"><a href="#" class="page-link">4</a></li>
                        <li class="page-item"><a href="#" class="page-link">5</a></li>
                        <li class="page-item"><a href="#" class="page-link">6</a></li>
                        <li class="page-item"><a href="#" class="page-link">7</a></li>
                        <li class="page-item"><a href="#" class="page-link">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
