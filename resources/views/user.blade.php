
@extends('layouts.app') @section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-12">
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
                class="btn btn-primary mb-3 project_value_click"
                data-toggle="modal"
                data-target="#exampleModal"
            >
                Add Task
            </button>
<div class="overflow-auto">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Project Name</th>
                        <th>team members</th>
                        <th>Status</th>
                        <th>Message</th>
                        <th>Date</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
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
                            
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >Project
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <select name="project_id" class="form-control project" onchange="project_change(this)">
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label"
                                    >Project Start Date</label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label project_start_date"
                                ></label
                            >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label"
                                    >Project End Date</label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label project_end_date"
                                ></label
                            >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label"
                                    >Team Member Name</label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label project_user_name"
                                ></label
                            >
                            </div>

                            
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >Status
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">

                                <input type="radio" id="completed" class="" name="status" value="completed">
                                <label for="completed">Completed</label><br>
                                <input type="radio" id="not_completed" class="" name="status" value="not_completed">
<label for="not_completed">Not Completed</label><br>

                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >Message
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <textarea name="message" class="form-control" cols="30" rows="4"></textarea>
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
                    <h5 class="modal-title" id="editModalLabel">Update Task</h5>
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
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >Project
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <select name="edit_project_id" class="form-control project" onchange="project_change(this)">
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label"
                                    >Project Start Date</label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label project_start_date"
                                ></label
                            >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label"
                                    >Project End Date</label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label project_end_date"
                                ></label
                            >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label"
                                    >Team Member Name</label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <label for="" class="col-form-label project_user_name"
                                ></label
                            >
                            </div>

                            
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >Status
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">

                                <input type="radio" id="edit_completed" class="" name="edit_status" value="completed">
                                <label for="edit_completed">Completed</label><br>
                                <input type="radio" id="edit_not_completed" class="" name="edit_status" value="not_completed">
<label for="edit_not_completed">Not Completed</label><br>

                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <label for="" class="col-form-label"
                                    >Message
                                    <span class="text-danger">*</span></label
                                >
                            </div>
                            <div class="col-md-6 col-sm-6 col-12 mt-3">
                                <textarea name="edit_message" class="form-control" cols="30" rows="4"></textarea>
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
                        Delete Task
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
                    <h5>Do you want to remove this Task?</h4>
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

   
</div>
@endsection @section('script')
<script src="{{url('/js/jquery-3.6.4.min.js')}}"></script>
<script src="{{url('/js/moment.min.js')}}"></script>
<script src="{{url('/js/user.js')}}"></script>


@endsection