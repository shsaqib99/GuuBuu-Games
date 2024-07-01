@extends('layouts.master')
@section('css-link')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('title')
    Products
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">List of products to be imported.</h3>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Title</th>
                                <th>Vendor</th>
                                <th>Product Type</th>
                                <th>No of Variants</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </section>
            <!-- /.Left col -->
        </div>
        <!-- /.row (main row) -->
    </div>
    <!-- /.container-fluid -->

    <button id="prev-page" disabled>Previous Page</button>
    <button id="next-page" disabled>Next Page</button>
@endsection

@section('js-link')


    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script>
        $(function () {
            let nextLink = null;
            let prevLink = null;
            function loadTable(pageUrl = null) {
                $.ajax({
                    url: "{{ route('fetchProducts') }}",
                    type: 'GET',
                    data: {
                     page_url : pageUrl
                    },
                    success: function(response) {
                        let parsed_response = JSON.parse(response);
                        let table = $('#example2').DataTable({
                            destroy: true,
                            data: parsed_response.data,
                            columns: [
                                { data: 'id' },
                                { data: 'title' },
                                { data: 'vendor' },
                                { data: 'product_type' },
                                {
                                    "render": function (data, type, full, meta) {
                                        return '<button class="import-btn btn btn-primary" data-id="' + full.id + '">Import</button>';
                                    }
                                }
                            ],
                            paginate: false,
                        });

                        nextLink = parsed_response.links.next || null;
                        prevLink = parsed_response.links.previous || null;

                        console.log(nextLink);
                        console.log(prevLink);

                        // Update pagination buttons
                        $('#next-page').prop('disabled', !nextLink);
                        $('#prev-page').prop('disabled', !prevLink);
                    },
                    error: function() {
                        alert('Failed to fetch data');
                    }
                });
            }

            $('#next-page').on('click', function() {
                if (nextLink) {
                    loadTable(nextLink);
                }
            });

            $('#prev-page').on('click', function() {
                if (prevLink) {
                    loadTable(prevLink);
                }
            });

            // Initial load
            loadTable();

            {{--$('#example2').DataTable({--}}
            {{--    "ajax": {--}}
            {{--        "url": "{{ route('fetchProducts') }}", // Your API endpoint URL--}}
            {{--        "type": "GET",--}}
            {{--        "dataSrc": ""--}}
            {{--    },--}}
            {{--    "columns": [--}}
            {{--        { "data": "id" },--}}
            {{--        { "data": "title" },--}}
            {{--        { "data": "vendor" },--}}
            {{--        { "data": "product_type" },--}}
            {{--        {--}}
            {{--            "render": function (data, type, full, meta) {--}}
            {{--                return '<button class="import-btn btn btn-primary" data-id="' + full.id + '">Import</button>';--}}
            {{--            }--}}
            {{--        }--}}
            {{--    ],--}}
            {{--    paginate: false,--}}
            {{--    "responsive": true,--}}
            {{--    "lengthChange": false,--}}
            {{--    "autoWidth": false,--}}
            {{--});--}}

            $(document).on('click', '.import-btn', function() {
                var productId = $(this).data('id');

                var rowData = $("#example2").DataTable().rows().data().filter(function (value, index) {
                    return value.id === productId;
                }).toArray()[0];

                // Example: Output ID to console
                console.log(rowData);

                $.ajax({
                    url: "{{ route('importProduct') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: rowData
                        // Add other data as needed
                    },
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

@endsection
