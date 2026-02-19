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
            'item_uuid' => 'required|exists:items,uuid',
            'attribute_uuid' => 'required|exists:attributes,uuid'
        ]);

        ItemAttributeValue::updateOrCreate(
            [
            'item_uuid'      => $request->item_uuid,
            'attribute_uuid' => $request->attribute_uuid
        ],
            $request->except(['item_uuid', 'attribute_uuid'])
        );

        return redirect()->back()
        ->with('message', 'Value berhasil ditambahkan')
        ->with('info', 'success');
    }

    public function add()
    {
        $fields = ItemAttributeValue::getFormSettings();
        $fields['item_uuid']['options'] = Item::pluck('name', 'uuid')->toArray();
        $fields['attribute_uuid']['options'] = Attribute::pluck('name', 'uuid')->toArray();

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

    public function getParamaters($id)
    {
        $data = ItemAttributeValue::with('attribute')->where('item_uuid',$id)->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($od, $id)
    {
        $data = ItemAttributeValue::with('attribute')->where('uuid', $id)->first();
        $data->dataTitle = 'Update Attribute Values';
        return json_encode($data);
    }

    public function attachAttribute(Request $request, $itemId)
    {
        $request->validate([
            'attribute_uuid' => 'required|exists:attributes,uuid'
        ]);

        ItemAttributeValue::create([
            'item_uuid' => $itemId,
            'attribute_uuid' => $request->attribute_uuid
        ]);

        return redirect()->back()->with([
            'message' => 'Attribute berhasil ditambahkan ke item',
            'info'    => 'success'
        ]);
    }
}
