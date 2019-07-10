<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Supplier;
use App\Person;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $search = $request->search;
        $criterion = $request->criterion;
         
        if ($search==''){
            $suppliers = Supplier::join('people', 'suppliers.id', '=', 'people.id')
            ->select('people.id', 'people.name', 'people.document_type', 'people.document_num',
             'people.address', 'people.phone', 'people.email', 'suppliers.contact', 'suppliers.contact_phone')
            ->orderBy('people.id', 'desc')->paginate(3);
        }
        else{
            $suppliers = Supplier::join('people', 'suppliers.id', '=', 'people.id')
            ->select('people.id', 'people.name', 'people.document_type', 'people.document_num',
             'people.address', 'people.phone', 'people.email', 'suppliers.contact', 'suppliers.contact_phone')
            ->where('people.'.$criterion, 'like', '%'. $search . '%')->orderBy('personas.id', 'desc')->paginate(3);
        }
         
 
        return [
            'pagination' => [
                'total'        => $suppliers->total(),
                'current_page' => $suppliers->currentPage(),
                'per_page'     => $suppliers->perPage(),
                'last_page'    => $suppliers->lastPage(),
                'from'         => $suppliers->firstItem(),
                'to'           => $suppliers->lastItem(),
            ],
            'suppliers' => $suppliers
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $person = new Person();
            $person->name = $request->name;
            $person->document_type = $request->document_type;
            $person->document_num = $request->document_num;
            $person->address = $request->address;
            $person->phone = $request->phone;
            $person->email = $request->email;
            $person->save();

            $supplier = new Supplier();
            $supplier->contact = $request->contact;
            $supplier->contact_phone = $request->contact_phone;
            $supplier->id= $person->id;
            $supplier->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();

            //Search for the supplier to be modificated
            $supplier= Supplier::findOrFail($request->id);

            $person = Person::findOrFail($supplier->id);

            $person->name = $request->name;
            $person->document_type = $request->document_type;
            $person->document_num = $request->document_num;
            $person->address = $request->address;
            $person->phone = $request->phone;
            $person->email = $request->email;
            $person->save();
            
            $supplier->contact = $request->contact;
            $supplier->contact_phone = $request->contact_phone;
            $supplier->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
