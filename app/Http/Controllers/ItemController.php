<?php

namespace App\Http\Controllers;

use App\Item;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $head = "<title>Item</title>";
        if ($request->ajax()) {
            $data = Item::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteCust">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('item', ['head' => $head]);
    }

    public function edit($id)
    {
        $item = Item::find($id);
        return response()->json($item);
    }

    public function store(Request $request)
    {
        if ($request->code == '') {
            Alert::success('Success', 'Success Message');
            return response()->json(['error' => 'Code Required.']);
        } elseif ($request->name == '') {
            return response()->json(['error' => 'Name Required.']);
        } else {
            $user = Item::where('id', [$request->id])->first();
            if ($user && ($user->id != $request->user_id)) {
                return response()->json(['error' => 'Customer Not Found']);
            } else {
                Item::updateOrCreate(['id' => $request->user_id],
                    ['code' => $request->code, 
                    'name' => $request->name, ]);
                Alert::success('Success', 'Success Message');
                return response()->json(['success' => 'Item saved successfully.']);
            }
        }
    }

    public function destroy($id)
    {
        Item::find($id)->delete();
        return response()->json(['success' => 'Item deleted successfully.']);
    }
}
