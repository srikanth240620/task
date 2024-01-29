<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }
   public function get_project(Request $req)
   {
       $user=DB::table('project')
       ->join('users','users.id','=','project.user_id')
       ->select('project.*','users.name as user_name')
       ->orderby('project.id','desc')
       ->get();
       return $user;
      
   }

   public function add_project(Request $req)
   {
       $validated = Validator::make($req->all(), [
           'name' => 'required|max:355',
           'user_id' => 'required',
           'start_date' => 'required',
           'end_date' => 'required',

       ]);
       if ($validated->fails()) {
           $error_message = $validated->errors()->all();
           return response()->json([
               'success'=>false,
               'message'=>$error_message,
           ]);
       }

$input=[
   'name'=>$req->name,
   'user_id'=>$req->user_id,
   'status'=>'pending',
   'start_date'=>$req->start_date,
   'end_date'=>$req->end_date,
   'admin_id'=>Auth::user()->id,
];
$add =DB::table('project')->insertGetId($input);
if($add){
return response()->json([
   'success'=>true,
   'message'=>'Project Added successfully'
]);
}else{
return response()->json([
   'success'=>false,
   'message'=>'Project Added falied',
]);

}
   }


   public function edit_project(Request $req)
   {
       $validated = Validator::make($req->all(), [
        'name' => 'required|max:355',
        'user_id' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
           'edit_id'=>'required',
       ]);
       if ($validated->fails()) {
           $error_message = $validated->errors()->all();
           return response()->json([
               'success'=>false,
               'message'=>$error_message,
           ]);
       }

       $input=[
        'name'=>$req->name,
        'user_id'=>$req->user_id,
        'status'=>'pending',
        'start_date'=>$req->start_date,
        'end_date'=>$req->end_date,
     ];
$update =DB::table('project')->where('id',$req->edit_id)->update($input);
if($update){
return response()->json([
   'success'=>true,
   'message'=>'Project Updated successfully'
]);
}else{
return response()->json([
   'success'=>false,
   'message'=>'Project Updated falied',
]);

}
   }

   public function delete_project(Request $req)
   {
       $validated = Validator::make($req->all(), [
           'id'=>'required',
       ]);
       if ($validated->fails()) {
           $error_message = $validated->errors()->all();
           return response()->json([
               'success'=>false,
               'message'=>$error_message,
           ]);
       }
$delete =DB::table('project')->where('id',$req->id)->delete();
if($delete){
return response()->json([
   'success'=>true,
   'message'=>'Project Deleted successfully'
]);
}else{
return response()->json([
   'success'=>false,
   'message'=>'Project Deleted falied',
]);

}
   }


   public function view_project(Request $req)
   {
       
$task =DB::table('task')->where('project_id',$req->project_id)->where('user_id',$req->user_id)->get();
return response()->json($task);
   }



}
