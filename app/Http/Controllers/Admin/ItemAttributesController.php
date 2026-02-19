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
        $this->dataLoad['tableTitle'] = 'Data Attribute Items  ';
        $this->dataLoad['showDatatablesSetting'] = true;
        $this->dataLoad['addBtnConfig'] = 'hidden';

        return view('contents.partials.masterDataItemAttributes', $this->dataLoad);
    }

    public function detail($id)
    {
        $data = Item::withCount('attributeValues')->find($id);

        $this->dataLoad['sectionTitle'] = 'Master Data Management';
        $this->dataLoad['tableTitle'] = 'Attribute Items ['. $data->name.']';
        $this->dataLoad['showDatatablesSettingDetails'] = true;
        $this->dataLoad['addBtnConfig'] = 'hidden';
        $this->dataLoad['item'] = $data;

        return view('contents.partials.masterDataItemAttributes', $this->dataLoad);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'attribute_id' => 'required|exists:attributes,id'
        ]);

        ItemAttributeValue::updateOrCreate(
            [
            'item_id'      => $request->item_id,
            'attribute_id' => $request->attribute_id
        ],
            $request->except(['item_id', 'attribute_id'])
        );

        return redirect()->back()
        ->with('message', 'Value berhasil ditambahkan')
        ->with('info', 'success');
    }

    public function add()
    {
        $fields = ItemAttributeValue::getFormSettings();
        $fields['item_id']['options'] = Item::pluck('name', 'id')->toArray();
        $fields['attribute_id']['options'] = Attribute::pluck('name', 'id')->toArray();

        $this->dataLoad['showFormSettings'] = true;
        $this->dataLoad['fields'] = $fields;
        $this->dataLoad['sectionTitle'] = 'Tambah Attribute Items';
        $this->dataLoad['formTitle'] = 'Tambah Attribute Items';
        $this->dataLoad['formRoute'] = route('master.data.itemattributes.store');

        return view('contents.partials.masterDataItemAttributes', $this->dataLoad);
    }

    public function update(Request $request, $id)
    {
        $item = ItemAttributeValue::findOrFail($id);

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
        $data = Item::withCount('attributeValues')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getParamaters()
    {
        $data = ItemAttributeValue::with('attribute')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($od, $id)
    {
        $data = ItemAttributeValue::with('attribute')->where('id', $id)->first();
        $data->dataTitle = 'Update Attribute Values';
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

        return redirect()->back()->with([
            'message' => 'Attribute berhasil ditambahkan ke item',
            'info'    => 'success'
        ]);
    }
}
