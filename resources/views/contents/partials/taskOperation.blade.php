@php
    if (isset($showFormSettings)) {
        $layouts = 'contents.formVertical';
    } else {
        $layouts = 'contents.tableContextual';
    }
@endphp

@extends($layouts)

@isset($showDatatablesSettingDetails)
    @section('tableHeader')
        <th></th>
        <th>Paramaters</th>
        <th>Status</th>
        <th>Bukti Foto</th>
        <th>Actions</th>
    @endsection

    @section('tableBody')
        <?php $no=1; foreach ($data as $row): 
            // Logika penentuan class Bootstrap
            $disabledBtn = '';
            $class = '';
            switch ($row->status) {
                case 'submited':       $class = 'table-success'; break;
                case 'rejected':      $class = 'table-danger';  break;
                case 'invalid': $class = 'table-warning'; break;
                case 'draft':     $class = 'table-info';    break;
                default:           $class = 'table-light';   break;
            }
            $disabledBtn = ($row->status === 'submited' || $row->status === 'rejected') ? false : true;
            $btnType = ($row->status === 'submited' || $row->status === 'rejected') ? 'btn-info' : 'btn-secondary';
        ?>
        <tr class="<?= $class ?>">
            <td>{{ $no++ }}</td>
            <td class="text-start"><?= $row->name ?></td>
            <td>{{ ucwords($row->status) }}</td>
            <td>
                @if ($disabledBtn)
                    <button class="btn {!! $btnType !!} btn-foto" disabled>
                        <i class="fa fa-eye"></i>
                    </button>
                @else
                    <a href="{{ asset($row->photo_path) }}" class="glightbox" data-gallery="p2h">
                        <button class="btn {!! $btnType !!} btn-foto">
                            <i class="fa fa-eye"></i>
                        </button>
                    </a>
                @endif
            </td>
            <td><button class="btn btn-primary btn-work" data-id="{{ $item->uuid }}" data-job="{{ $row->uuid }}"
                    data-handler="data"><i class="fa fa-pencil"></i> </button></td>
        </tr>
        <?php endforeach; ?>
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
                    <strong>Operator:</strong> {{ auth()->user()->name ?? '-' }}
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
        <th>Task Name</th>
        <th width="25%">Progress</th>
        <th width="15%">Actions</th>
    @endsection
    @section('tableBody')
        <?php foreach ($data as $log): 
            // Logika penentuan class Bootstrap
            $class = '';
            switch ($log->status) {
                case 'normal':       $class = 'table-info'; break;
                case 'critical':      $class = 'table-danger';  break;
            }
        ?>
        <tr class="<?= $class ?>">
            <td class="text-start"><?= $log->item->name ?></td>
            <td>
                <div class="progress mb-3">
                    <div class="progress-bar" style="width: ${item.percent}%">
                        {{ round($log->percent) }}%
                    </div>
            </td>
            <td><button class="btn btn-primary btn-detail" data-id="{{ $log->item_uuid }}" data-handler="data"><i
                        class="fa fa-pencil"></i> </button></td>
        </tr>
        <?php endforeach; ?>
    @endsection
@endisset

@include('contents.js.taskOperation')
