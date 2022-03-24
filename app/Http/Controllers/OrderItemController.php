<?php

namespace App\Http\Controllers;

use App\OrderItem;
use App\OrderTmp;
use DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        $head = "<title>Order Item</title>";
        if ($request->ajax()) {
            $data = OrderItem::where('order', $request->id)
            ->get();
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

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = OrderItem::Where('order', $request->id);
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

    }

    public function edit($id)
    {
        $user = OrderTmp::find($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        if ($request->item == '') {
            return response()->json(['error' => 'Item Required.']);
        } elseif ($request->qty == '') {
            return response()->json(['error' => 'Qty Required.']);
        } else {
            $user = OrderTmp::where('id', [$request->id])->first();
            if ($user && ($user->id != $request->user_id)) {
                return response()->json(['error' => 'OrderItem Not Found']);
            } else {
                OrderTmp::updateOrCreate(['id' => $request->user_id],
                    [
                        // 'order' => $request->order, 
                        'item' => $request->item, 
                        'qty' => $request->qty, 
                        'price' => $request->price, 
                        'total' => $request->total, 
                    ]);
                Alert::success('Success', 'Success Message');
                return response()->json(['success' => 'OrderItem saved successfully.']);
            }
        }
    }

    public function destroy($id)
    {
        OrderItem::find($id)->delete();
        return response()->json(['success' => 'OrderItem deleted successfully.']);
    }
}
