<?php

namespace App\Http\Controllers\Operation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Estate;
use App\Models\Attribute;
use App\Models\ItemAttributeValue;
use App\Models\ItemUserAssignment;
use App\Models\P2HLog;
use App\Models\P2HLogValue;
use Illuminate\Support\Facades\DB;
use DataTables;

class TaskMonitorController extends Controller
{
    /* =========================
       ITEMS SECTION
    ==========================*/

    public function index()
    {
        $this->dataLoad['sectionTitle'] = 'P2H Handler';
        $this->dataLoad['tableTitle'] = 'Data Task P2H';
        $this->dataLoad['showDatatablesSetting'] = true;
        $this->dataLoad['addBtnConfig'] = 'hidden';

        return view('contents.partials.taskMonitorOperation', $this->dataLoad);
    }

    public function detail($id)
    {
        $data = Item::withCount('assignments')->find($id);

        $this->dataLoad['sectionTitle'] = 'P2H Handler';
        $this->dataLoad['tableTitle'] = 'Task Assigment ['. $data->name.']';
        $this->dataLoad['showDatatablesSettingDetails'] = true;
        $this->dataLoad['item'] = $data;

        return view('contents.partials.taskMonitorOperation', $this->dataLoad);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_uuid' => 'required|exists:items,uuid',
            'user_id' => 'required|exists:users,id'
        ]);

        ItemUserAssignment::updateOrCreate(
            [
            'item_uuid'      => $request->item_uuid,
            'user_id' => $request->user_id
        ],
            $request->except(['item_uuid', 'user_id'])
        );

        return redirect()->back()
        ->with('message', 'Value berhasil ditambahkan')
        ->with('info', 'success');
    }

    public function edit($id)
    {
        $item = ItemUserAssignment::findOrFail($id);
        $fields = ItemUserAssignment::getFormSettings();
        
        $fields['item_uuid']['options'] = Item::where('category','task')->pluck('name', 'uuid')->toArray();
        $fields['user_id']['options'] = User::whereHas('role', function ($query) {
            $query->where('name', 'Operator');
        })->pluck('name', 'id')->toArray();
        $fields['estate_uuid']['options'] = Estate::pluck('name', 'uuid')->toArray();
        
        foreach ($fields as $key => $config) {
            if($fields[$key]['type'] == 'date'){
                $fields[$key]['value'] = date('Y-m-d', strtotime($item->$key));
            }else{
                $fields[$key]['value'] = $item->$key;
            }
        }

        $this->dataLoad['showFormSettings'] = true;
        $this->dataLoad['fields'] = $fields;
        $this->dataLoad['sectionTitle'] = 'Edit Assigment Task';
        $this->dataLoad['formTitle'] = 'Edit Assigment Task';
        $this->dataLoad['formRoute'] = route('operation.p2h.task.update', ['id'=> $id]);
        
        return view('contents.partials.taskMonitorOperation', $this->dataLoad);
    }


    public function add()
    {
        $fields = ItemUserAssignment::getFormSettings();
        $fields['item_uuid']['options'] = Item::where('category','task')->pluck('name', 'uuid')->toArray();
        $fields['user_id']['options'] = User::whereHas('role', function ($query) {
            $query->where('name', 'Operator');
        })->pluck('name', 'id')->toArray();
        $fields['estate_uuid']['options'] = Estate::pluck('name', 'uuid')->toArray();

        $this->dataLoad['showFormSettings'] = true;
        $this->dataLoad['fields'] = $fields;
        $this->dataLoad['sectionTitle'] = 'Assigment Task';
        $this->dataLoad['formTitle'] = 'Tambah Assigment Task';
        $this->dataLoad['formRoute'] = route('operation.p2h.task.store');

        return view('contents.partials.taskMonitorOperation', $this->dataLoad);
    }

    public function update(Request $request, $id)
    {
        $item = ItemUserAssignment::findOrFail($id);

        $item->update($request->all());

        return redirect()->back()
        ->with('message', 'Value berhasil diupdate')
        ->with('info', 'success');
    }

    public function delete($od,$id)
    {
        $rows = ItemAttributeValue::findOrFail($id);
        $rows->delete();

        return redirect()->back()->with([
            'message' => 'Value berhasil dihapus',
            'info'    => 'error'
        ]);

    }

    public function json()
    {
        $data = Item::where('category','task')->withCount('assignments')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getParamaters($id)
    {
        $data = ItemUserAssignment::with('item','user')->where('item_uuid',$id)->active()->get();

        foreach($data as $row)
        {
            $row->mulai = date('d F Y', strtotime($row->start_date));
            $row->berakhir = date('d F Y', strtotime($row->end_date));
        }
        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($od, $id)
    {
        $data = ItemUserAssignment::with('attribute')->where('uuid', $id)->first();
        $data->dataTitle = 'Update Attribute Values';
        return json_encode($data);
    }

}
