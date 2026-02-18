<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class DataItemController extends Controller
{
    /* =========================
       ITEMS SECTION
    ==========================*/

    public function index()
    {
        $this->dataLoad['items'] = Item::orderBy('name', 'asc')
            ->get();

        return view('contents.partials.masterDataItems', $this->dataLoad);
    }

    public function itemsStore(Request $request)
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

    public function itemsEdit($id)
    {
        $item = Item::findOrFail($id);
        
        return view('contents.partials.masterDataItems', $this->dataLoad);
    }

    public function itemsUpdate(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'estate_id' => 'required|exists:estates,id',
            'code' => 'required|unique:items,code,' . $item->id,
            'name' => 'required',
            'category' => 'required|in:unit,inventory,task'
        ]);

        $item->update($request->all());

        return redirect()->back()->with('success', 'Item berhasil diupdate');
    }

}
