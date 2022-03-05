@extends('layouts.app')
@section('title','ATTENDANCE SCAN')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center">
                    <div class="card-body">
                        <img src="{{asset('img/qr.png')}}" alt="" width="250">
                        <h5 class="text-muted">Please Scan for Attendance</h5>
                        <p class="text-success attendance_alert success"></p>
                        <p class="text-danger attendance_alert danger"></p>
                        <!-- Model Button  -->
                        <button type="button" class="btn btn-theme" data-toggle="modal" data-target="#scanModel">
                        Sacn
                        </button>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <hr>

                        {{-- attandance overview --}}

                        <div class="row mb-3">

                            <div class="col-md-4">
                                <select name="" id="" class="form-control filter_month">
                                    <option value="">-- Select Month --</option>
                                    <option value="01"  @if(now()->format('m') == '01') selected @endif>Jan</option>
                                    <option value="02" @if(now()->format('m') == '02') selected @endif>Feb</option>
                                    <option value="03" @if(now()->format('m') == '03') selected @endif>Mar</option>
                                    <option value="04" @if(now()->format('m') == '04') selected @endif>Apr</option>
                                    <option value="05" @if(now()->format('m') == '05') selected @endif>May</option>
                                    <option value="06" @if(now()->format('m') == '06') selected @endif>Jun</option>
                                    <option value="07" @if(now()->format('m') == '07') selected @endif>July</option>
                                    <option value="08" @if(now()->format('m') == '08') selected @endif>Aug</option>
                                    <option value="09" @if(now()->format('m') == '09') selected @endif>Sep</option>
                                    <option value="10" @if(now()->format('m') == '10') selected @endif>Oct</option>
                                    <option value="11" @if(now()->format('m') == '11') selected @endif>Nov</option>
                                    <option value="12" @if(now()->format('m') == '12') selected @endif>Dec</option>
                                </select>

                            </div>
                            <div class="col-md-4">
                                <select name="" id="" class="form-control filter_year">
                                    <option value="">-- Select Year --</option>
                                    @foreach(range(now()->format('Y')-5, date('Y')) as $y)
                                        <option value="{{$y}}" @if(now()->format('Y') == $y) selected @endif>{{$y}}</option>
                                    @endforeach


                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success btn-sm btn-block m-0 search_btn">Search</button>
                            </div>
                        </div>

                        {{-- payroll --}}
                        <h6 class="mt-5">Payroll</h6>
                        <div class="my_payroll"></div>

                        {{-- attendance overview  --}}
                        <h6 class="mt-5">Attendance Overview</h6>
                        <div class="attendance_overview_table"></div>

                         {{-- attendance records datatable --}}
                        <h6 class="mt-5">Attendance Records</h6>
                        <table id="attendance-table" class="table table-bordered mt-3" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Check_in_time</th>
                                    <th>Check_out_time</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Check_in_time</th>
                                    <th>Check_out_time</th>
                                    <th>Date</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scan Modal -->
<div class="modal fade" id="scanModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Attendance Scan QR</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <video id="myScan" style="width:100%"></video>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('custom-script')
<script src="{{asset('js/qr-scanner.umd.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let videoElem =document.getElementById('myScan');
        const qrScanner = new QrScanner(videoElem, result => {
            if(result){
                $('#scanModel').modal('hide');
                qrScanner.stop();


                        $.ajax({
                            type: "POST",
                            url: '/scan-attendance-qr',
                            data: { hash_value :result },
                            success: function(response) {

                                $(".attendance_alert").each(function() {
                                        $(this).empty();
                                });
                                if(response.status == 'success'){
                                    $( ".attendance_alert.success" ).text( `${
                                        response.message
                                    }` );
                                }else{
                                    $( ".attendance_alert.danger" ).text( `${
                                        response.message
                                    }` );
                                }

                        },

                        });
                }


            });


        $('#scanModel').on('shown.bs.modal', function (e) {
            qrScanner.start();
        });
        $('#scanModel').on('hidden.bs.modal', function (e) {
            qrScanner.stop();
        });


        //datatable
        let datatable = $('#attendance-table').DataTable({
                order: [[1, 'desc']],
                ajax: "{{route('my-attendance.allData')}}",
                columns: [

                    { data: 'user_id', name: 'user_id' , class : 'text-center'},
                    { data: 'check_in_time', name: 'check_in_time' , class : 'text-center'},
                    { data: 'check_out_time', name: 'check_out_time' , class : 'text-center'},
                    { data: 'date', name: 'date' , class : 'text-center'},
                ],
            });

        //attandance overview

        $('.search_btn').click(function(){
                attendanceOverviewTable();
            });

        function attendanceOverviewTable(){

                let month = $(".filter_month").find(":selected").val();
                let year = $(".filter_year").find(":selected").val();

                            //attendance overview ajax call
                            $.ajax({
                                url: `/my-attendanceOverviewTable?month=${month}&year=${year}`,
                                type:"GET",
                                success: function(data) {
                                    console.log(data);
                                $('.attendance_overview_table').html(data);
                                }
                            })

                            //payroll ajax call ()
                            $.ajax({
                                url: `/my-payroll?month=${month}&year=${year}`,
                                type:"GET",
                                success: function(data) {
                                    console.log(data);
                                $('.my_payroll').html(data);
                                }
                            })

                            //reload the attendance records datatable with parameters together with attendance overview
                            datatable.ajax.url(`/my-attendance?month=${month}&year=${year}`).load();
            }
        attendanceOverviewTable();

        //my payroll
        // function payrollTable(){
        //         // let userName= $('.userName').val();
        //         let month = $(".filter_month").find(":selected").val();
        //         let year = $(".filter_year").find(":selected").val();
        //                     $.ajax({
        //                         url: `/my-payroll?month=${month}&year=${year}`,
        //                         type:"GET",
        //                         success: function(data) {
        //                             console.log(data);
        //                         $('.my_payroll').html(data);
        //                         }
        //                     })
        //     }
        // payrollTable();

    });


</script>

@endsection
