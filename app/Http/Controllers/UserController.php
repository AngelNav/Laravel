<?php

namespace App\Http\Controllers;
use App\User;
use App\Person;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $search = $request->search;
        $criterion = $request->criterion;
         
        if ($search==''){
            $people = User::join('people', 'users.id', '=', 'people.id')
            ->join('roles', 'users.idrol', '=', 'roles.id')
            ->select('people.id', 'people.name', 'people.document_type', 'people.document_num',
             'people.address', 'people.phone', 'people.email', 'users.user', 'users.password',
             'users.condition', 'users.idrol', 'roles.name as rol')
            ->orderBy('people.id', 'desc')->paginate(3);
        }
        else{
            $people = User::join('people', 'users.id', '=', 'people.id')
            ->join('roles', 'users.idrol', '=', 'roles.id')
            ->select('people.id', 'people.name', 'people.document_type', 'people.document_num',
             'people.address', 'people.phone', 'people.email', 'users.user', 'users.password',
             'users.condition', 'users.idrol', 'roles.name as rol')
            ->where('people.'.$criterion, 'like', '%'. $search . '%')
            ->orderBy('personas.id', 'desc')->paginate(3);
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

            $user = new User();
            $user->user = $request->user;
            $user->password = bcrypt($request->password);
            $user->condition = '1';
            $user->idrol = $request->idrol;
            $user->id = $person->id;
            $user->save();

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

            $user= User::findOrFail($request->id);

            $person = Person::findOrFail($user->id);

            $person->name = $request->name;
            $person->document_type = $request->document_type;
            $person->document_num = $request->document_num;
            $person->address = $request->address;
            $person->phone = $request->phone;
            $person->email = $request->email;
            $person->save();
            
            $user->user = $request->user;
            $user->password = bcrypt($request->password);
            $user->condition = '1';
            $user->idrol = $request->idrol;
            $user->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function deactivate(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condition = '0';
        $user->save();
    }
 
    public function activate(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condition = '1';
        $user->save();
    }
}
