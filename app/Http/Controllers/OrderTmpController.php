<?php

namespace App\Http\Controllers;

use App\OrderTmp;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class OrderTmpController extends Controller
{
    public function index(Request $request)
    {
        $head = "<title>Order Item</title>";
        if ($request->ajax()) {
            $data = OrderTmp::latest()->get();
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

        return view('order_item', ['head' => $head]);
    }

}
