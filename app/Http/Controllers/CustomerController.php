<?php

namespace App\Http\Controllers;

use App\Customer;
use DataTables;
use Alert;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $head = "<title>Customers</title>";
        if ($request->ajax()) {
            $data = Customer::latest()->get();
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

        return view('customer', ['head' => $head]);
    }

    public function edit($id)
    {
        $user = Customer::find($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        if ($request->code == '') {
            return response()->json(['error' => 'Code Required.']);
        } elseif ($request->name == '') {
            return response()->json(['error' => 'Name Required.']);
        } else {
            $user = Customer::where('id', [$request->id])->first();
            if ($user && ($user->id != $request->user_id)) {
                return response()->json(['error' => 'Customer Not Found']);
            } else {
                Customer::updateOrCreate(['id' => $request->user_id],
                    ['code' => $request->code, 
                    'name' => $request->name, ]);
            }
        }
        Alert::success('Success', 'Success Message');
        return response()->json(['success' => 'Customer saved successfully.']);
    }

    public function destroy($id)
    {
        Customer::find($id)->delete();
        return response()->json(['success' => 'Customer deleted successfully.']);
    }
}
