@php
    if (isset($showFormSettings)) {
        $layouts = 'contents.formVertical';
    } else {
        $layouts = 'contents.tableStriped';
    }
@endphp

@extends($layouts)

@isset($showDatatablesSettingDetails)
    @section('tableHeader')
        <th></th>
        <th>Operator</th>
        <th>Frequency</th>
        <th>Mulai</th>
        <th>Berakhir</th>
        <th>Active</th>
        <th width="15%">Actions</th>
    @endsection

    @section('content-details')
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="text-muted">
                <span class="me-3">
                    <strong>Kode:</strong> {{ $item->code }}
                </span>
                <span class="me-3">
                    <strong>Kategori:</strong> {{ ucfirst($item->category) }}
                </span>
                <span class="me-3">
                    <strong>Subtype:</strong> {{ $item->subtype ?? '-' }}
                </span>
                <span>
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $item->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </span>
            </div>
        </div>
    @endsection
@endisset
@isset($showDatatablesSetting)
    @section('tableHeader')
        <th></th>
        <th>Code</th>
        <th>Name</th>
        <th>Category</th>
        <th>Assigment Count</th>
        <th width="15%">Actions</th>
    @endsection
@endisset

@include('contents.js.taskMonitorOperation')
