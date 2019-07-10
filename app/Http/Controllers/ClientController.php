<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $search = $request->search;
        $criterion = $request->criterion;
         
        if ($search==''){
            $people = Person::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $people = Person::where($criterion, 'like', '%'. $search . '%')->orderBy('id', 'desc')->paginate(3);
        }
         
 
        return [
            'pagination' => [
                'total'        => $people->total(),
                'current_page' => $people->currentPage(),
                'per_page'     => $people->perPage(),
                'last_page'    => $people->lastPage(),
                'from'         => $people->firstItem(),
                'to'           => $people->lastItem(),
            ],
            'people' => $people
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $person = new Person();
        $person->name = $request->name;
        $person->document_type = $request->document_type;
        $person->document_num = $request->document_num;
        $person->address = $request->address;
        $person->phone = $request->phone;
        $person->email = $request->email;
        $person->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $person = Person::findOrFail($request->id);
        $person->name = $request->name;
        $person->document_type = $request->document_type;
        $person->document_num = $request->document_num;
        $person->address = $request->address;
        $person->phone = $request->phone;
        $person->email = $request->email;
        $person->save();
    }
}
