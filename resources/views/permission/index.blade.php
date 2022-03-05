@extends('layouts.app')
@section('title','PERMISSION')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @can('create_permission')
            <a href="{{route('permission.create')}}" class="btn btn-theme ml-0 p-3">
                <div class="fas fa-plus mr-3"></div>
                 Create Permission
             </a>
            @endcan

            <div class="card">
                <div class="card-body">
                    <table id="permission-table" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Created At</th>
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


@section('custom-script')
    <script>
        $(document).ready(function() {
            let datatable = $('#permission-table').DataTable({
                order: [[3, 'desc']],
                ajax: "{{route('permission.allData')}}",
                columns: [
                    { data: 'plus-sign', name: 'plus-sign' , class : 'text-center'},
                    { data: 'name', name: 'name' , class : 'text-center'},
                    { data: 'created_at', name: 'created_at' , class : 'text-center'},
                    { data: 'updated_at', name: 'updated_at' , class : 'text-center'},
                    { data: 'action', name: 'action', class : 'text-center' },

                ],
                columnDefs: [
                    {
                        targets: [ 3 ],
                        // visible: false,
                        searchable: false
                    },{
                        class: 'dtr-control',
                        orderable: false,
                        targets:   0,
                    },
                    {
                        targets : [4],
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
                            url: `permission/${id}`,
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
