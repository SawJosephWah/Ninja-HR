@extends('layouts.app')
@section('title','EMPLOYEE')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @can('create_employee')
            <a href="{{route('employee.create')}}" class="btn btn-theme ml-0 p-3">
                <div class="fas fa-plus mr-3"></div>
                 Create Employee
             </a>
            @endcan

            <div class="card">
                <div class="card-body">
                    <table id="employees-table" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Profile Image</th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Pin Code</th>
                                <th>Department</th>
                                <th>Role(s)</th>
                                <th>Is Present?</th>
                                <th>Action</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Profile Image</th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Pin Code</th>
                                <th>Department</th>
                                <th>Role(s)</th>
                                <th>Is Present?</th>
                                <th>Action</th>
                                <th>Updated At</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>


        </div>
    </div>

</div>


@section('custom-script')
    <script>
        $(document).ready(function() {
            let datatable = $('#employees-table').DataTable({
                order: [[10, 'desc']],
                ajax: "{{route('employee.allData')}}",
                columns: [
                    { data: 'plus-sign', name: 'plus-sign' , class : 'text-center'},
                    { data: 'image', name: 'image' , class : 'text-center'},
                    { data: 'employee_id', name: 'employee_id' , class : 'text-center'},
                    { data: 'name', name: 'name' , class : 'text-center'},
                    { data: 'phone', name: 'phone', class : 'text-center' },
                    { data: 'email', name: 'email', class : 'text-center' },
                    { data: 'pin_code', name: 'pin_code', class : 'text-center' },
                    { data: 'department_name', name: 'department_name', class : 'text-center' },
                    { data: 'roles', name: 'roles', class : 'text-center' },
                    { data: 'is_present', name: 'is_present', class : 'text-center' },
                    { data: 'action', name: 'action', class : 'text-center' },
                    { data: 'updated_at', name: 'updated_at', class : 'text-center' },
                ],
                columnDefs: [
                    {
                        targets: [ 11 ],
                        visible: false,
                        searchable: false
                    },{
                        class: 'dtr-control',
                        orderable: false,
                        targets:   0,
                    },
                    {
                        targets : [1],
                        sortable: false
                    },
                    { orderable: false, targets: 10}
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
                            url: `employee/${id}`,
                            type:"DELETE",
                            }).done(function() {
                                datatable.ajax.reload();
                            });
                    }
                    });
            });
        });

    </script>
@endsection

@endsection
