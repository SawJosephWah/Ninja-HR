@extends('layouts.app')
@section('title','DEPARTMENT')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @can('create_department')
            <a href="{{route('department.create')}}" class="btn btn-theme ml-0 p-3">
               <div class="fas fa-plus mr-3"></div>
                Create Department
            </a>
            @endcan
            <div class="card">
                <div class="card-body">
                    <table id="departments-table" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Action</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Name</th>
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
            let datatable = $('#departments-table').DataTable({
                order: [[3, 'desc']],
                ajax: "{{route('department.allData')}}",
                columns: [
                    { data: 'plus-sign', name: 'plus-sign' , class : 'text-center'},
                    { data: 'title', name: 'title' , class : 'text-center'},
                    { data: 'action', name: 'action', class : 'text-center' },
                    { data: 'updated_at', name: 'updated_at', class : 'text-center' },
                ],
                columnDefs: [
                    {
                        targets: [ 3 ],
                        visible: false,
                        searchable: false
                    },{
                        class: 'dtr-control',
                        orderable: false,
                        targets:   0,
                    },
                    {
                        targets : [2],
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
                            url: `department/${id}`,
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
