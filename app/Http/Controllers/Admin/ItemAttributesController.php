<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Estate;
use App\Models\Attribute;
use App\Models\ItemAttributeValue;
use Illuminate\Support\Facades\DB;
use DataTables;

class ItemAttributesController extends Controller
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
            'estate_id' => 'required|exists:estates,id',
            'code' => 'required|unique:items,code',
            'name' => 'required',
            'category' => 'required|in:unit,inventory,task'
        ]);

        Item::create($request->all());

        return redirect()->back()->with('success', 'Item berhasil ditambahkan');
    }

    public function add()
    {
        $fields = Item::getFormSettings();
        $fields['estate_id']['options'] = Estate::pluck('name', 'id')->toArray();
        
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
        $fields['estate_id']['options'] = Estate::pluck('name', 'id')->toArray();
        
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
            'estate_id' => 'required|exists:estates,id',
            'code' => 'required|unique:items,code,' . $item->id,
            'name' => 'required',
            'category' => 'required|in:unit,inventory,task'
        ]);

        $item->update($request->all());

        return redirect()->back()->with('info', 'Item berhasil diupdate');
    }

    public function delete($id)
    {
        $rows = Item::findOrFail($id);
        $rows->delete();

        return redirect()->back()->with('danger', 'Item berhasil dihapus');

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
    
    public function attachAttribute(Request $request, $itemId)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id'
        ]);

        ItemAttributeValue::create([
            'item_id' => $itemId,
            'attribute_id' => $request->attribute_id
        ]);

        return back()->with('success', 'Attribute berhasil ditambahkan ke item');
    }
}
