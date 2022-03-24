<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Item;
use App\Customer;
use App\OrderTmp;
use DataTables;
use DB;
use Alert;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $head = "<title>Orders</title>";
        if ($request->ajax()) {
            $data = Order::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="/order/edit/' . $row->no . '" class="edit btn btn-primary btn-sm editUser">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteOrder">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('order', ['head' => $head]);

    }

    public function add()
    {
        $data = "<title>Orders</title>";
        $item = Item::All();
        $customer = Customer::All();
        return view('add_order', compact('data', 'item', 'customer'));
    }

    public function edit($no)
    {
        $order = Order::Where('no', $no)->first();
        $item = Item::All();
        $customer = Customer::All();
        return view('edit_order', compact('order','item','customer'));;
    }

    public function store(Request $request)
    {
        if ($request->no == '') {
            return response()->json(['error' => 'No Required.']);
        } elseif ($request->customer_id == '') {
            return response()->json(['error' => 'Customer Required.']);
        } else {
            $user = Order::where('id', [$request->id])->first();
            if ($user && ($user->id != $request->user_id)) {
                return response()->json(['error' => 'Customer Not Found']);
            } else {
                Order::updateOrCreate([
                    'no' => $request->no, 
                    'date' => $request->date, 
                    'customer_id' => $request->customer_id,
                    'subtotal' => $request->subtotals, 
                    'discount' => $request->discount, 
                    'total' => $request->totals
                ]);
                $temp = OrderTmp::All();
                foreach ($temp as $row) {
                    OrderItem::create([
                        'order' => $request->no,
                        'item' => $row->item,
                        'qty' => $row->qty,
                        'price' => $row->price,
                        'total' => $row->total,
                    ]);
                };
                DB::table('order_tmp')->delete();
                
            }
        }
        Alert::success('Success', 'Success Message');
        return redirect('/order');
    }

    public function destroy($id)
    {
        Order::find($id)->delete();
        return response()->json(['success' => 'Order deleted successfully.']);
    }

    public function laporan()
    {
        $title = 'Laporan Order';
        $lap = DB::table('order as O')
            ->leftjoin('customer as C', 'O.customer_id', '=', 'C.code')
            ->leftjoin('order_item as I', 'O.no', '=', 'I.order')
            ->GET();
        return view('laporan', compact('title', 'lap'));
    }

    public function lapCustomer(Request $request)
    {
        $title = 'Laporan Customer';
        $laporan = DB::table('order as O')
            ->leftjoin('customer as C', 'O.customer_id', '=', 'C.code')
            ->leftjoin('order_item as I', 'O.no', '=', 'I.order')
            ->GET();
        $cust = Customer::All();
        
        return view('laporan_customer', compact('title', 'laporan', 'cust'));
    }

    public function filter(Request $request)
    {
        $title = 'Laporan Customer';
        $tanggal = date('Y-m-d',strtotime($request->tanggal));
        $lapor = DB::table('order as O')
            ->leftjoin('customer as C', 'O.customer_id', '=', 'C.code')
            ->leftjoin('order_item as I', 'O.no', '=', 'I.order');
        $cust = Customer::All();
        if (!empty($request->customer) && empty($tanggal == null)) {
            $lapor->where('C.code', $request->customer);
        }
        if (!empty($tanggal) && empty($request->customer)) {
            $lapor->where('O.date', $tanggal);
        }
        $laporan = $lapor->GET();
        return view('laporan_customer', compact('title', 'laporan', 'cust'));
    }

    public function lapItem()
    {
        $title = 'Laporan Item';
        $laporan = DB::table('item as O')
            ->leftjoin('order_item as I', 'O.code', '=', 'I.item')
            ->GET();
        $item = Item::All();
        
        return view('laporan_item', compact('title', 'laporan', 'item'));
    }

    public function filterItem(Request $request)
    {
        $title = 'Laporan Item';
        $lapor = DB::table('item as O')
            ->leftjoin('order_item as I', 'O.code', '=', 'I.item');
        $item = Item::All();
        if (!empty($request->item)) {
            $lapor->where('O.code', $request->item);
        }
        $laporan = $lapor->GET();
        return view('laporan_item', compact('title', 'laporan', 'item'));
    }
}
