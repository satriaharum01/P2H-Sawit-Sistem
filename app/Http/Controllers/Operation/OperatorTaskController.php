<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\P2HLog;
use App\Models\Attribute;
use App\Models\P2HLogValue;
use App\Models\ItemUserAssignment;
use DataTables;

class OperatorTaskController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD - Task Hari Ini
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $this->dataLoad['sectionTitle'] = 'Task Hari Ini';
        $this->dataLoad['tableTitle']   = 'Daftar Task Aktif';
        $this->dataLoad['showDatatablesSetting'] = true;
        $this->dataLoad['addBtnConfig'] = 'hidden';
        $assignment = ItemUserAssignment::with('item.attributeValues.attribute')->where('user_id', Auth::id())->active()->today()->get();

        foreach ($assignment as $row) {

            $log = P2HLog::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'operator_name' => auth()->user()->name,
                    'task_uuid' => $row->item_uuid,
                    'log_date' => today(),
                ],
                [
                    'task_uuid' => $row->item_uuid,
                    'status' => 'normal'
                ]
            );

            $total = $row->item->attributeValues->where('attribute.is_required', 1)->count();
            $filled = $log->values()->count();
            $row->percent = $total > 0 ? round(($filled / $total) * 100) : 0;
        }

        $this->dataLoad['data'] = $assignment;
        return view('contents.partials.taskOperation', $this->dataLoad);
    }

    /*
    |--------------------------------------------------------------------------
    | LIST TASK MILIK OPERATOR
    |--------------------------------------------------------------------------
    */

    public function json()
    {
        $data = ItemUserAssignment::with('item')
            ->where('user_id', Auth::id())
            ->active()
            ->today()
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL TASK (FORM CHECKLIST)
    |--------------------------------------------------------------------------
    */

    public function detail(Request $request, $uuid)
    {

        $log = P2HLog::with('assignment.attributeValues.attribute')
            ->where('task_uuid', $uuid)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($request->input('job') || $request->input('id')) {
            return $this->jobForm($request->input('job'), $log->id, $request->input('id'));
        }

        $data = Item::with('attributes')->find($log->task_uuid);
        // Ambil semua nilai log sekaligus di luar loop untuk menghemat database
        $logValues = P2HLogValue::where('p2h_log_id', $log->id)->get()->keyBy('attribute_uuid');

        foreach ($data->attributes as $row) {
            // Cari di koleksi hasil query tadi berdasarkan uuid
            $comparison = $logValues->get($row->uuid);

            if (!$comparison) {
                $row->status = 'draft';
            } else {
                $row->status = $comparison->status;
                $row->photo_path = $comparison->photo_path;
            }
        }

        $this->dataLoad['tableTitle'] = 'Task Assigment ['. $log->assignment->name.']';
        $this->dataLoad['sectionTitle'] = 'Kerjakan Task';
        $this->dataLoad['showDatatablesSettingDetails'] = true;
        $this->dataLoad['addBtnConfig'] = 'hidden';
        $this->dataLoad['item']   = $log->assignment;
        $this->dataLoad['data']   = $data->attributes;


        return view('contents.partials.taskOperation', $this->dataLoad);
    }

    private function jobForm($attrib, $p2h, $id)
    {
        $attribute = Attribute::find($attrib);
        $fields = P2HLogValue::getFormSettings();
        $val = P2HLogValue::where('attribute_uuid', $attrib)->where('p2h_log_id', $p2h)->first();
   
        if ($val) {
            foreach ($fields as $key => $config) {
                $fields[$key]['value'] = $val->$key;
            }
        }

        foreach ($fields['attribute_uuid'] as $index => $uuid) {
            // 1. Ambil tipe data asli dari database/model
            $currentValueColumn = "value_" . $attribute->data_type;
            // 2. Unset kolom value yang TIDAK cocok dengan tipenya
            foreach ($this->allValueColumns as $col) {
                if ($col !== $currentValueColumn) {
                    unset($fields[$col]);
                }
            }
        }

        $fields['attribute_uuid']['value'] = $attrib;
        $fields['p2h_log_id']['value'] = $p2h;

        $this->dataLoad['fields'] = $fields;
        $this->dataLoad['showFormSettings'] = true;
        $this->dataLoad['sectionTitle'] = 'Mengerjakan Task';
        $this->dataLoad['formTitle'] = 'Task ['.$attribute->name.']';
        $this->dataLoad['formRoute'] = route('operation.task.submit');

        return view('contents.partials.taskOperation', $this->dataLoad);
    }
    /*
    |--------------------------------------------------------------------------
    | SUBMIT TASK (P2H)
    |--------------------------------------------------------------------------
    */
    public function submit(Request $request)
    {
        $request->validate([
            'p2h_log_id'     => 'required|exists:p2h_logs,id',
            'attribute_uuid' => 'required',
            'photo_path'     => 'required|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        $log = P2HLog::where('id', $request->p2h_log_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $photoPath = null;

        if ($request->hasFile('photo_path')) {
            $file = $request->file('photo_path');
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('photo_path'));

            $image->scaleDown(width: 1600);

            $quality = 85;

            do {
                $encoded = $image->toJpeg($quality);
                $size = strlen($encoded);
                $quality -= 5;
            } while ($size > 1000000 && $quality > 40);

            $fileName = uniqid().'.jpg';

            $destinationPath = public_path('static/images');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);

            $photoPath = 'static/images/'.$fileName;
        }
        $model = new P2HLogValue();
        $data = $request->only($model->getFillable());
        if ($photoPath) {
            $data['photo_path'] = $photoPath;
        }
        // set status otomatis
        $data['status'] = 'submited';
        P2HLogValue::updateOrCreate(
            [
                'p2h_log_id'     => $request->p2h_log_id,
                'attribute_uuid' => $request->attribute_uuid
            ],
            $data
        );

        return redirect()->route('operation.task.index')
            ->with('message', 'Task berhasil disubmit')
            ->with('info', 'success');
    }
    /*
    |--------------------------------------------------------------------------
    | RIWAYAT OPERATOR
    |--------------------------------------------------------------------------
    */

    public function history()
    {
        $this->dataLoad['sectionTitle'] = 'Riwayat Task';

        return view('contents.partials.operatorTaskHistory', $this->dataLoad);
    }

    public function historyJson()
    {
        $data = P2HLog::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
