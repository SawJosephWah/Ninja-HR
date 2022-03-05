@extends('layouts.app')
@section('title','ATTENDANCE')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @can('create_attendance')
            <a href="{{route('attendance.create')}}" class="btn btn-theme ml-0 p-3">
                <div class="fas fa-plus mr-3"></div>
                Create Attendance
            </a>
            @endcan
            <div class="card">
                <div class="card-body">

                    <table id="attendance-table" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Check_in_time</th>
                                <th>Check_out_time</th>
                                <th>Date</th>
                                <th>Updated At</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Employee Name</th>
                                <th>Check_in_time</th>
                                <th>Check_out_time</th>
                                <th>Date</th>
                                <th>Updated At</th>
                                <th>Action</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(function() {
            let datatable = $('#attendance-table').DataTable({
                order: [[1, 'desc']],
                ajax: "{{route('attendance.allData')}}",
                columns: [

                    { data: 'user_id', name: 'user_id' , class : 'text-center'},
                    { data: 'check_in_time', name: 'check_in_time' , class : 'text-center'},
                    { data: 'check_out_time', name: 'check_out_time' , class : 'text-center'},
                    { data: 'date', name: 'date' , class : 'text-center'},
                    { data: 'updated_at', name: 'updated_at' , class : 'text-center'},
                    { data: 'action', name: 'action' , class : 'text-center'},


                ],
                "columnDefs": [
                {
                    "targets": [ 4 ],
                    "visible": false,
                    "searchable": false
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

                // console.log($(this).data("id"));
                swal({
                    title: "Are you sure to delete?",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        let id = $(this).data("id");

                        $.ajax({
                            url: `/attendance/${id}`,
                            type:"DELETE",
                            }).done(function(res) {
                                // console.log(res);
                                datatable.ajax.reload();
                            });
                    }
                    });
            });
        });

    </script>
@endsection
