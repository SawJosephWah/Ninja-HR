@extends('layouts.app')
@section('title','PROJECTS')
@section('content')
@section('custom_css')
<style>
    .project_leaders_img_prototype{
        width: 35px;
        height: 35px;
    border-radius: 10px;
    margin-right: 3px;
    margin-bottom: 3px
    }
</style>
@endsection
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- @can('create_department') --}}
            <a href="{{route('projects.create')}}" class="btn btn-theme ml-0 p-3">
               <div class="fas fa-plus mr-3"></div>
                Create Project
            </a>
            {{-- @endcan --}}
            <div class="card">
                <div class="card-body">
                    <table id="departments-table" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Project Leaders</th>
                                <th>Project Members</th>
                                <th>Start Date</th>
                                <th>Deadline Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>


        </div>
    </div>

</div>


@section('custom-script')
    <script>
        $(document).ready(function() {
            let datatable = $('#departments-table').DataTable({
                order: [[10, 'desc']],
                ajax: "{{route('my_projects.allData')}}",
                columns: [
                    { data: 'plus-sign', name: 'plus-sign' , class : 'text-center'},
                    { data: 'title', name: 'title' , class : 'text-center'},
                    { data: 'description', name: 'description' , class : 'text-center'},
                    { data: 'project_leaders', name: 'project_leaders' , class : 'text-center'},
                    { data: 'project_members', name: 'project_members' , class : 'text-center'},

                    { data: 'start_date', name: 'start_date' , class : 'text-center'},
                    { data: 'deadline', name: 'deadline' , class : 'text-center'},
                    { data: 'priority', name: 'priority' , class : 'text-center'},
                    { data: 'status', name: 'status' , class : 'text-center'},
                    { data: 'action', name: 'action', class : 'text-center' },
                    { data: 'updated_at', name: 'updated_at', class : 'text-center' },
                ],
                columnDefs: [
                    {
                        targets: [ 10 ],
                        visible: false,
                        searchable: false
                    },{
                        class: 'dtr-control',
                        orderable: false,
                        targets:   0,
                    },
                    {
                        targets : [9],
                        sortable: false
                    },
                ]
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on("click",".delete_btn",function(e) {
                e.preventDefault();

                swal({
                    title: "Are you sure to delete?",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        let id = $(this).data("id");

                        $.ajax({
                            url: `/projects/${id}`,
                            type:"DELETE",
                            }).done(function(res) {
                                datatable.ajax.reload();
                            });
                    }
                    });
            });
        });

    </script>
@endsection

@endsection
