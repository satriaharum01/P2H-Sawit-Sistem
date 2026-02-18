@extends('contents.tableStriped')

@section('tableHeader')
    <th></th>
    <th>Setting</th>
    <th>Value</th>
    <th width="15%">Actions</th>
@endsection

@pushIf($showDatatablesSetting, 'partials')
<div class="modal fade" id="compose" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="compose-form">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">

                    <div class="mb-3">
                        <label class="form-label">Setting</label>
                        <input type="text" class="form-control" id="config_key" name="config_key" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Value</label>
                        <input type="text" class="form-control" id="config_value" name="config_value" required>
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
@endpushIf
@include('contents.js.generalSetting')
