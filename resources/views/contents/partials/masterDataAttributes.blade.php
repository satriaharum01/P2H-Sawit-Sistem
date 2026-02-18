@extends('contents.tableStriped')

@section('tableHeader')
    <th></th>
    <th>Code</th>
    <th>Name</th>
    <th>Data Type</th>
    <th>Scope</th>
    <th>Sub Type</th>
    <th width="15%">Actions</th>
@endsection

@pushIf($showDatatablesSetting, 'partials')

@endpushIf
@include('contents.js.masterDataAttributes')
