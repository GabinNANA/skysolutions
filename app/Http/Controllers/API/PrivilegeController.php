<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Privilege;
use App\Models\PrivilegeRole;
use Validator;

class PrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $privileges = Privilege::all();
        return response()->json($privileges);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'privilege' => 'required|max:255',
            'lib_privilege' => 'required|max:255',
            'groupe' => 'required|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        $privilege = new Privilege([
            'privilege' => $request->get('privilege'),
            'lib_privilege' => $request->get('lib_privilege'),
            'groupe' => $request->get('groupe')
        ]);
      
        $privilege->save();

        return response()->json([
            'message' => 'Privilege successfully created',
            'privilege' => $privilege
        ], 201);
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $privilege = Privilege::findOrFail($id);
        return response()->json($privilege);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $privilege = Privilege::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'privilege' => 'required|max:255',
            'lib_privilege' => 'required|max:255',
            'groupe' => 'required|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        $privilege = new Privilege([
            'privilege' => $request->get('privilege'),
            'lib_privilege' => $request->get('lib_privilege'),
            'groupe' => $request->get('groupe')
        ]);
      
        $privilege->save();

        return response()->json([
            'message' => 'Privilege successfully created',
            'privilege' => $privilege
        ], 201);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = explode(",", $id);
        Privilege::whereIn('id', $ids)->delete();
        return response()->json(Privilege::all());
    }

    public function addrole(Request $request){
        try {
            $privilege = Privilege::findorfail($request->get('privilege_id'));
            $privilege->roles()->attach($request->get('role_id'));
            
            return response()->json([
                'message' => 'Privilege successfully add to the role',
                'privilege' => $privilege
            ], 201);

        } catch (Exception $e){
            return response()->json($e->getmessage(), 400);
        }
    }
    
    public function removerole(Request $request){
        try {
            
            PrivilegeRole::where('privilege_id','=',$request->get('privilege_id'))
                        ->where('role_id','=',$request->get('role_id'))->delete();
            return response()->json(PrivilegeRole::all());

        } catch (Exception $e){
            return response()->json($e->getmessage(), 400);
        }
    }
    public function verifyrole(Request $request){
        if(PrivilegeRole::where('privilege_id','=',$request->get('privilege_id'))->where('role_id','=',$request->get('role_id'))->count()!=0){
            return response()->json(true);
        }else{
            return response()->json(false);
        } 
    }
}
