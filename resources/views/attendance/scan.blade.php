@extends('layouts.app')
@section('title','Create Attedance')
@section('extr.css')
<style>
    .calendar-time {
        margin-right: 10px !important;
    }
</style>
@endsection
@section('content')

<div class="card mb-2 text-center">
    <div class="card-body">
        <img src="{{asset('image/scan.png')}} " style="width:220px;">
        <p>Please Scan Attendance QR</p>


        <!-- Button trigger modal -->
        <button type="button" class="btn btn-theme btn-sm" data-toggle="modal" data-target="#scanModal">
            Scan
        </button>

        <!-- Modal -->
        <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="scanModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <video id="video" width=100% height=300px></video>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="card ">
    <div class="card-body ">
    <h5>PayRoll</h5>

        <div class='row mb-3'>
            <div class="col-md-3">
                <input type="text" class="employee_name form-control" placeholder="Employee Name">
            </div>
            <div class="col-md-3">
                <select class="form-control select-month" >
                    <div class="form-group">
                        <option value="">--Please Choose--</option>
                        <option value="01" @if(now()->format('m')=="01") selected @endif>Jan</option>
                        <option value="02" @if(now()->format('m')=="02") selected @endif>Feb</option>
                        <option value="03" @if(now()->format('m')=="03") selected @endif>Mar</option>
                        <option value="04" @if(now()->format('m')=="04") selected @endif>Apr</option>
                        <option value="05" @if(now()->format('m')=="05") selected @endif>May</option>
                        <option value="06" @if(now()->format('m')=="06") selected @endif>Jun</option>
                        <option value="07" @if(now()->format('m')=="07") selected @endif>Jul</option>
                        <option value="08" @if(now()->format('m')=="08") selected @endif>Aug</option>
                        <option value="09" @if(now()->format('m')=="09") selected @endif>Sep</option>
                        <option value="10" @if(now()->format('m')=="10") selected @endif>Oct</option>
                        <option value="11" @if(now()->format('m')=="11") selected @endif>Nov</option>
                        <option value="12" @if(now()->format('m')=="12") selected @endif>Dec</option>
                    </div>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control select-year">
                    <div class="form-group">
                        <option value="">--Please Choose--</option>
                        @for($i=0;$i<15;$i++)
                            <option value="{{now()->addYears(5)->subYears($i)->format('Y')}}" @if(now()->format('Y')==now()->addYears(5)->subYears($i)->format('Y')) selected @endif>{{now()->addYears(5)->subYears($i)->format('Y')}}</option>
                        @endfor
                    </div>
                </select>
            </div>

            <div class="col-md-3">

                <button class="btn btn-theme btn-sm btn-block search-btn"><i class="fas fa-search"></i>Search</button>

            </div>

        </div>

        <div class="payroll_table">

        </div>

    </div>
    <div class="card-body">
        <table class="table table-bordered Datatable dt-responsive" style="width:100%;">
            <thead class="text-center">
                <th class="no-sort no-serch"></th>
                <th>Employee Name</th>
                <th>Date</th>
                <th>Check In Time</th>
                <th>Check Out Time</th>

            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreAttendance', '#create-form'); !!}
<script src="{{asset('js/qr-scanner.umd.min.js')}}"></script>

<script>
    $(document).ready(function(){
        var videoElem=document.getElementById('video');
        const qrScanner = new QrScanner(videoElem, function(result){
            if(result){
                $('#scanModal').modal('hide')
                qrScanner.stop();

            }

            $.ajax({
                url:'/attendance-scan-store',
                type:'POST',
                data:{"hash_value":result},

                success:function(res){

                    if(res.message=='success'){
                        const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                        });

                        Toast.fire({
                        icon: 'success',
                        title: res.data,

                        });
                         }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.data,
                            footer: '<a href="">Why do I have this issue?</a>'
                            })
                        }

                }
            })
        });

        $('#scanModal').on('shown.bs.modal', function (event) {
            qrScanner.start();
        });

        $('#scanModal').on('hidden.bs.modal', function (event) {
            qrScanner.stop();
        });
        var table= $('.Datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/my-attendance/datatable/ssd',
                columns: [
                    { data: 'plus_icon', name: 'plus_icon' ,class:'text-center'},
                    { data: 'employee_name', name: 'employee_name' ,class:'text-center'},
                    { data: 'date', name: 'date' ,class:'text-center'},
                    { data: 'checkin_time', name: 'checkin_time' ,class:'text-center'},
                    { data: 'checkout_time', name: 'checkout_time' ,class:'text-center'},


                ],
                order: [[ 2, "desc" ]],
                columnDefs: [


                    {
                        "targets": [ 0 ],
                        "class": "control"
                    },
                    {
                        "targets": 'hidden',
                        "visible": false

                    },
                    {
                        "targets": 'no-sort',
                        "orderable": false

                    },
                    {
                        "targets": 'no-search',
                        "searchable": false

                    }
                ],
                language:{

                    "paginate": {
                    "next":       "<i class='far fa-arrow-alt-circle-right'></i>",
                    "previous":   "<i class='far fa-arrow-alt-circle-left'></i>"
                    },
                    "processing":"<img src='/image/loadingone.gif' style='width:40px'/> <p>Loading...</p>  " ,

                }

        });

        payRollTable();

        function payRollTable(){
            var month=$('.select-month').val();
            var year=$('.select-year').val();
            $.ajax({

                url:`/my-payroll-table?month=${month}&year=${year}`,
                type:'GET',
                success:function(res){
                    $('.payroll_table').html(res);
                }

            })
        }

        $('.search-btn').on('click',function(event){
            event.preventDefault();
            payRollTable();

        })

    });
</script>


@endsection
