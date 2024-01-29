<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

public function project_dt(Request $req){
    $project=DB::table('project')->where('project.status','!=','completed')
    ->join('users','users.id','=','project.admin_id')
    ->select('project.*','users.name as user_name')
    ->where('user_id',Auth::user()->id)->get();
    return $project;

}

   public function get_task(Request $req)
   {
       $user=DB::table('task')->where('task.user_id',Auth::user()->id)->where('project.status','!=','completed')
       ->join('project','project.id','=','task.project_id')
       ->join('users','users.id','=','project.user_id')
       ->select('project.*','users.name as user_name','task.message','task.created_at as date','task.message','task.id as task_id')
       ->orderby('task.id','desc')
       ->get();
       return $user;
      
   }

   public function add_task(Request $req)
   {
       $validated = Validator::make($req->all(), [
           'project_id' => 'required',
           'message' => 'required|max:355',
           'status' => 'required',

       ]);
       if ($validated->fails()) {
           $error_message = $validated->errors()->all();
           return response()->json([
               'success'=>false,
               'message'=>$error_message,
           ]);
       }

$input=[
   'project_id'=>$req->project_id,
//    'status'=>$req->status,
   'message'=>$req->message,
   'user_id'=>Auth::user()->id
];
$status =DB::table('project')->where('id',$req->project_id)->update([
    'status'=>$req->status
]);
$add =DB::table('task')->insertGetId($input);
if($add){
return response()->json([
   'success'=>true,
   'message'=>'Task Added successfully'
]);
}else{
return response()->json([
   'success'=>false,
   'message'=>'Task Added falied',
]);

}
   }


   public function edit_task(Request $req)
   {
       $validated = Validator::make($req->all(), [
        'project_id' => 'required',
        'message' => 'required|max:355',
        'status' => 'required',
           'edit_id'=>'required',
       ]);
       if ($validated->fails()) {
           $error_message = $validated->errors()->all();
           return response()->json([
               'success'=>false,
               'message'=>$error_message,
           ]);
       }

     $status =DB::table('project')->where('id',$req->project_id)->update([
        'status'=>$req->status
    ]);
    $update =DB::table('task')->where('id',$req->edit_id)->update([
        'message'=>$req->message,
    ]);
if($update || $status){
return response()->json([
   'success'=>true,
   'message'=>'Task Updated successfully'
]);
}else{
return response()->json([
   'success'=>false,
   'message'=>'Task Updated falied',
]);

}
   }

   public function delete_task(Request $req)
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
$delete =DB::table('task')->where('id',$req->id)->delete();
if($delete){
return response()->json([
   'success'=>true,
   'message'=>'Task Deleted successfully'
]);
}else{
return response()->json([
   'success'=>false,
   'message'=>'Task Deleted falied',
]);

}
   }




}
