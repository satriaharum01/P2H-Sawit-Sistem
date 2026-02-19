<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estate;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use DataTables;

class DataItemController extends Controller
{
    /* =========================
       ITEMS SECTION
    ==========================*/

    public function index()
    {
        $this->dataLoad['sectionTitle'] = 'Master Data Management';
        $this->dataLoad['tableTitle'] = 'Data Items ';
        $this->dataLoad['showDatatablesSetting'] = true;

        return view('contents.partials.masterDataItems', $this->dataLoad);
    }

    public function store(Request $request)
    {
        $request->validate([
            'estate_uuid' => 'required|exists:estates,uuid',
            'code' => 'required|unique:items,code',
            'name' => 'required',
            'category' => 'required|in:unit,inventory,task'
        ]);

        Item::create($request->all());

        return redirect()->back()->with('message', 'Item berhasil ditambahkan')->with('info', 'success');
    }

    public function add()
    {
        $fields = Item::getFormSettings();
        $fields['estate_uuid']['options'] = Estate::pluck('name', 'uuid')->toArray();
        
        $this->dataLoad['fields'] = $fields;
        $this->dataLoad['sectionTitle'] = 'Tambah Data Items';
        $this->dataLoad['formTitle'] = 'Tambah Data Items';
        $this->dataLoad['formRoute'] = route('master.data.items.store');
        
        return view('contents.partials.masterDataItemsForm', $this->dataLoad);
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $fields = Item::getFormSettings();
        $fields['estate_uuid']['options'] = Estate::pluck('name', 'uuid')->toArray();
        
        foreach ($fields as $key => $config) {
            $fields[$key]['value'] = $item->$key;
        }
        
        $this->dataLoad['fields'] = $fields;
        $this->dataLoad['sectionTitle'] = 'Edit Data Items';
        $this->dataLoad['formTitle'] = 'Edit Data Items';
        $this->dataLoad['formRoute'] = route('master.data.items.update', ['id'=> $id]);
        
        return view('contents.partials.masterDataItemsForm', $this->dataLoad);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'estate_uuid' => 'required|exists:estates,uuid',
            'code' => 'required|unique:items,code,' . $item->id,
            'name' => 'required',
            'category' => 'required|in:unit,inventory,task'
        ]);

        $item->update($request->all());

        return redirect()->back()->with('message', 'Item berhasil diupdate')->with('info', 'info');
    }

    public function delete($id)
    {
        $rows = Item::findOrFail($id);
        $rows->delete();

        return redirect()->back()->with('message', 'Item berhasil dihapus')->with('info', 'danger');

    }

    public function json()
    {
        $data = Item::with('estate')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function find($id)
    {
        $data = Item::select('*')->where('id', $id)->first();
        $data->dataTitle = 'Update Items'; 
        return json_encode($data);
    }
}
