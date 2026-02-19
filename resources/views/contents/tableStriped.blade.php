@extends('layouts.app')

@section('title', $sectionTitle)

@section('content')

    <div class="row mx-0">
        <!-- Striped Rows -->
        <div class="card">
            <div class="card-header">
                <div class="float-end" {!! $addBtnConfig ?? '' !!}>
                    <button class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Tambah</button>
                </div>
                <h5 class="card-title mt-2">{{ $tableTitle ?? '' }}</h5>
            </div>

            @yield('content-details')

            <div class="table-responsive text-nowrap">
                <table id="data-width" class="table table-striped text-center" width="100%">
                    <thead>
                        <tr>
                            @yield('tableHeader')
                        </tr>
                        @yield('tableHeader-2')
                    </thead>
                    <tbody class="table-border-bottom-0">

                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Striped Rows -->
    </div>

@endsection
