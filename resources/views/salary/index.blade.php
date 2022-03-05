@extends('layouts.app')
@section('title','SALARY')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <a href="{{route('salary.create')}}" class="btn btn-theme ml-0 p-3">
               <div class="fas fa-plus mr-3"></div>
                Create Salary
            </a>

            <div class="card">
                <div class="card-body">
                    <table id="salary-table" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Amount</th>
                                <th>Action</th>
                                {{--<th>Updated At</th> --}}
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Month</th>
                                <th>Year</th>
                                 <th>Amount</th>
                                <th>Action</th>
                                {{--<th>Updated At</th> --}}
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
    let datatable = $('#salary-table').DataTable({
        // order: [[3, 'desc']],
        ajax: "{{route('salary.allData')}}",
        columns: [
            { data: 'plus-sign', name: 'plus-sign' , class : 'text-center'},
            { data: 'user_id', name: 'user_id' , class : 'text-center'},
            { data: 'month', name: 'month', class : 'text-center' },
            { data: 'year', name: 'year', class : 'text-center' },
            { data: 'amount', name: 'amount', class : 'text-center' },
            { data: 'action', name: 'action', class : 'text-center' },
            // { data: 'updated_at', name: 'updated_at', class : 'text-center' },
        ],
        columnDefs: [
            // {
            //     targets: [ 3 ],
            //     visible: false,
            //     searchable: false
            // },
            {
                class: 'dtr-control',
                orderable: false,
                targets:   0,
            },
            // {
            //     targets : [2],
            //     sortable: false
            // },
        ]
    });

})
</script>

@endsection
