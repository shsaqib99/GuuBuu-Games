@extends('layouts.master')
@section('title')
    Settings
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Fill Shopify A credentials</h3>
                    </div>
                    <form action="{{ route('settings.store') }}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="shopifyA_host">Host</label>
                                        <input type="text" class="form-control" id="shopifyA_host" name="shopifyA_host" value="{{ $data->shopifyA_host ?? '' }}" placeholder="Enter Host">
                                    </div>
                                    <div class="form-group">
                                        <label for="shopifyA_api_version">API Version</label>
                                        <input type="text" class="form-control" id="shopifyA_api_version" name="shopifyA_api_version" value="{{$data->shopifyA_api_version ?? ''}}" placeholder="Enter API Version">
                                    </div>
                                    <div class="form-group">
                                        <label for="shopifyA_access_token">Access Token</label>
                                        <input type="text" class="form-control" id="shopifyA_access_token" name="shopifyA_access_token" value="{{$data->shopifyA_access_token ?? ''}}" placeholder="Enter Access Token">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="shopifyB_host">Host</label>
                                        <input type="text" class="form-control" id="shopifyB_host" name="shopifyB_host" value="{{$data->shopifyB_host ?? ''}}" placeholder="Enter Host">
                                    </div>
                                    <div class="form-group">
                                        <label for="shopifyB_api_version">API Version</label>
                                        <input type="text" class="form-control" id="shopifyB_api_version" name="shopifyB_api_version" value="{{$data->shopifyB_api_version ?? ''}}" placeholder="Enter API Version">
                                    </div>
                                    <div class="form-group">
                                        <label for="shopifyB_access_token">Access Token</label>
                                        <input type="text" class="form-control" id="shopifyB_access_token" name="shopifyB_access_token" value="{{$data->shopifyB_access_token ?? ''}}" placeholder="Enter Access Token">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </section>
            <!-- /.Left col -->
        </div>
        <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
@endsection
