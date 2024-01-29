
@extends('layouts.app') @section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 sol-12">
            <!-- <div class="card">
                <div class="card-header">{{ __("Dashboard") }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session("status") }}
                    </div>
                    @endif

                    {{ __("You are logged in!") }}
                </div>
            </div> -->

            <button
                type="button"
                class="btn btn-primary mb-3"
                data-toggle="modal"
                data-target="#exampleModal"
            >
                Add Project
            </button>
<div class="overflow-auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Project Name</th>
                        <th>Status</th>
                        <th>User Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="user_dt"></tbody>
            </table>
        </div>
        </div>
    </div>

    <!-- Modal -->


    @php $user=DB::table('users')->where('role','user')->get();
    @endphp


    <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="addcrud">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label"
                                    >Project Name
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <input
                                    type="text"
                                    class="form-control"
                                    required
                                    name="name"
                                />
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >User
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <select name="user_id" class="form-control" id="">
                                    <option value="">--Select--</option>


@foreach($user as $val)
    <option value="{{$val->id}}">{{$val->name}}</option>
@endforeach

                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >Start Date
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <input type="datetime-local" name="start_date" class="form-control" id="">
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >End Date
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <input type="datetime-local" name="end_date" class="form-control" id="">
                            </div>
                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button type="submit" class="btn btn-success">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div
        class="modal fade"
        id="editModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="editModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Update Project</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="editcrud">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label"
                                    >Project Name
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <input
                                    type="text"
                                    class="form-control"
                                    required
                                    name="edit_name"
                                />
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >User
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <select name="edit_user_id" class="form-control" id="">
                                    <option value="">--Select--</option>


@foreach($user as $val)
    <option value="{{$val->id}}">{{$val->name}}</option>
@endforeach

                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >Start Date
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <input type="datetime-local" name="edit_start_date" class="form-control" id="">
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >End Date
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <input type="datetime-local" name="edit_end_date" class="form-control" id="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button type="submit" class="btn btn-success">
                            Update
                        </button>
                        <input type="hidden" id="edit_id" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="deleteModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">
                        Delete Project
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Do you want to remove this Project?</h4>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                    <form action="" id="deletecrud">
                        <button type="submit" class="btn btn-danger">
                            Delete
                        </button>
                        <input type="hidden" id="delete_id" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div
        class="modal fade"
        id="viewModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="viewModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">
                        View Project
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-12">
                            <label for="">Project Name:</label>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12"><label for="" class="view_project_name"></label></div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <label for="">Status:</label>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12"><label for="" class="view_status"></label></div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <label for="">User Name:</label>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12"><label for="" class="view_user_name"></label></div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <label for="">Start Date:</label>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12"><label for="" class="view_start_date"></label></div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <label for="">End Date:</label>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12"><label for="" class="view_end_date"></label></div>
<div class="col-md-12">
    <div class="overflow-auto">
    <table class="table">
        <thead>
                <tr>
                    <th>S.no</th>
                    <th>Date</th>
                    <th>Message</th>
                </tr>
        </thead>
        <tbody class="view_task">
           
        </tbody>
        
        
    </table>
</div>
</div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('script')
<script src="{{url('/js/jquery-3.6.4.min.js')}}"></script>
<script src="{{url('/js/moment.min.js')}}"></script>

<script src="{{url('/js/admin.js')}}">
    
</script>

@endsection