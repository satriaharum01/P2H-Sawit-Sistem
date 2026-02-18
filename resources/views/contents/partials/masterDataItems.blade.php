@extends('contents.tableStriped')

@section('tableHeader')
    <th></th>
    <th>Setting</th>
    <th>Value</th>
    <th width="15%">Actions</th>
@endsection

@pushIf($showDatatablesSetting, 'partials')

@endpushIf
@include('contents.js.generalSetting')
