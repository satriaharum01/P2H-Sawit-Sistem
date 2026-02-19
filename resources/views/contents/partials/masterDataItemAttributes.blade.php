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
        <th rowspan="2"></th>
        <th rowspan="2">Attribute</th>
        <th colspan="4">Values</th>
        <th rowspan="2" width="15%">Actions</th>
    @endsection
    @section('tableHeader-2')
        <tr>
            <th>Text</th>
            <th>Number</th>
            <th>Boolean</th>
            <th>Date</th>
        </tr>
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
        <th>Attributes Count</th>
        <th width="15%">Actions</th>
    @endsection
@endisset

@isset($showDatatablesSettingDetails)
    @push('partials')
        <div class="modal fade" id="compose" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="compose-form" action="" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="edit_id" name="id">

                            <div class="mb-3">
                                <label class="form-label">Attribute Name</label>
                                <input type="text" class="form-control" id="attribute_name" name="attribute_name" disabled>
                            </div>
                            <div class="mb-3">
                                @error('value_string')
                                    <div class="invalid-feedback float-end w-auto d-block">{{ $message }}</div>
                                @enderror
                                <label class="form-label">Value Text</label>
                                <input type="text" class="form-control" id="value_string" name="value_string">
                            </div>
                            <div class="mb-3">
                                @error('value_number')
                                    <div class="invalid-feedback float-end w-auto d-block">{{ $message }}</div>
                                @enderror
                                <label class="form-label">Value Number</label>
                                <input type="number" class="form-control" id="value_number" name="value_number">
                            </div>
                            <div class="mb-3">
                                @error('value_boolean')
                                    <div class="invalid-feedback float-end w-auto d-block">{{ $message }}</div>
                                @enderror
                                <label class="form-label">Value Boolean</label>
                                <input type="text" class="form-control" id="value_boolean" name="value_boolean">
                            </div>
                            <div class="mb-3">
                                @error('value_date')
                                    <div class="invalid-feedback float-end w-auto d-block">{{ $message }}</div>
                                @enderror
                                <label class="form-label">Value Date</label>
                                <input type="date" class="form-control" id="value_date" name="value_date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endpush
@endisset
@include('contents.js.masterDataItemAttributes')
