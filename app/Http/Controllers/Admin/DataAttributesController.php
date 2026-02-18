<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estate;
use App\Models\Attribute;
use Illuminate\Support\Facades\DB;
use DataTables;

class DataAttributesController extends Controller
{
    /* =========================
       ATTRIBUTES SECTION
    ==========================*/

    public function index()
    {
        $this->dataLoad['sectionTitle'] = 'Master Data Management';
        $this->dataLoad['tableTitle'] = 'Data Attributes';
        $this->dataLoad['showDatatablesSetting'] = true;

        return view('contents.partials.masterDataAttributes', $this->dataLoad);
    }

    public function store(Request $request)
    {
        $request->validate([
            'estate_id' => 'required|exists:estates,id',
            'name' => 'required',
            'code' => 'required|unique:attributes,code',
            'data_type' => 'required|in:string,number,boolean,date,image',
            'category_scope' => 'required|in:unit,inventory,task'
        ]);

        Attribute::create($request->all());

        return redirect()->back()->with('success', 'Attribute berhasil ditambahkan');
    }

    public function add()
    {
        $fields = Attribute::getFormSettings();
        $fields['estate_id']['options'] = Estate::pluck('name', 'id')->toArray();

        $this->dataLoad['fields'] = $fields;
        $this->dataLoad['sectionTitle'] = 'Tambah Data Attributes';
        $this->dataLoad['formTitle'] = 'Tambah Data Attributes';
        $this->dataLoad['formRoute'] = route('master.data.attributes.store');

        return view('contents.partials.masterDataAttributesForm', $this->dataLoad);
    }

    public function edit($id)
    {
        $Attribute = Attribute::findOrFail($id);
        $fields = Attribute::getFormSettings();
        $fields['estate_id']['options'] = Estate::pluck('name', 'id')->toArray();

        foreach ($fields as $key => $config) {
            $fields[$key]['value'] = $Attribute->$key;
        }

        $this->dataLoad['fields'] = $fields;
        $this->dataLoad['sectionTitle'] = 'Edit Data Attributes';
        $this->dataLoad['formTitle'] = 'Edit Data Attributes';
        $this->dataLoad['formRoute'] = route('master.data.attributes.update',['id'=> $id]);

        return view('contents.partials.masterDataAttributesForm', $this->dataLoad);
    }

    public function update(Request $request, $id)
    {
        $Attribute = Attribute::findOrFail($id);

        $request->validate([
            'estate_id' => 'required|exists:estates,id',
            'name' => 'required',
            'code' => 'required|unique:attributes,code,' . $attribute->id,
            'data_type' => 'required|in:string,number,boolean,date,image',
            'category_scope' => 'required|in:unit,inventory,task'
        ]);

        $Attribute->update($request->all());

        return redirect()->back()->with('info', 'Attribute berhasil diupdate');
    }

    public function delete($id)
    {
        $rows = Attribute::findOrFail($id);
        $rows->delete();

        return redirect()->back()->with('danger', 'Attribute berhasil dihapus');

    }

    public function json()
    {
        $data = Attribute::with('estate')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function find($id)
    {
        $data = Attribute::select('*')->where('id', $id)->first();
        $data->dataTitle = 'Update Attributes';
        return json_encode($data);
    }
}
