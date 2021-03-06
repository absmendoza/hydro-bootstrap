@extends('layouts.app')
 
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Pending Reports</div>

            <div class="panel-body">
                <table id="pending-reports" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Station Name</th>
                            <th>Location</th>
                            <th>Sensor Type</th>
                            <th>Date Assessed</th>
                            <th>Conducted By</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php $reports = DB::table('reports')->get(); ?>
                    @foreach ($reports as $report)
                        @if ($report->if_approved == '0')
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->station_name }}</td>
                            <td>{{ $report->location }}</td>
                            <td>{{ $report->sensor_type }}</td>
                            <td>{{ $report->date_assessed }}</td>
                            <td>{{ $report->conducted_by }}</td>
                            <td>
                                <a class="btn" data-toggle="modal" data-target="#viewReport-<?= $report->id?>"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        @endif

                        <!-- View Report Modal -->
                        <div id="viewReport-<?= $report->id?>" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Report #{{ $report->id }}</h4>
                                    </div>

                                    <div class="modal-body">
                                        @include('Reports/display_report')
                                    </div>

                                    <div class="modal-footer">
                                        <div class="hide">
                                            {!! Form::model($report,['method' => 'PATCH','route'=>['reports.update',$report->id]]) !!}
                                            {!! Form::text('if_approved', '1',['class'=>'form-control', 'hidden'=>'true']) !!}
                                            {!! Form::text('n_position', 'Unit Head',['class'=>'form-control', 'readonly'=>'true', 'hidden'=>'true']) !!}
                                            {!! Form::text('noted_by', Auth::user()->employee_id,['class'=>'form-control', 'readonly'=>'true', 'hidden'=>'true']) !!}

                                            <!--{!! Form::text('noted_by', Auth::user()->firstname.' '.Auth::user()->lastname,['class'=>'form-control', 'readonly'=>'true', 'hidden'=>'true']) !!}
                                            -->
                                            <?php  $time = Carbon\Carbon::now(new DateTimeZone('Asia/Singapore')); ?>
                                            {!! Form::text('sender_id', Auth::user()->employee_id,['class'=>'form-control', 'readonly'=>'true', 'hidden'=>'true']) !!}
                                            {!! Form::text('receiver_id', $report->conducted_by,['class'=>'form-control', 'readonly'=>'true', 'hidden'=>'true']) !!}
                                            {!! Form::text('message', Auth::user()->employee_id . ' approved your report',['class'=>'form-control', 'readonly'=>'true', 'hidden'=>'true']) !!}	
                                            {!! Form::text('sent_at_date', $time->toDateString(),['class'=>'form-control datepicker', 'readonly'=>'true', 'hidden'=>'true']) !!}	
                                            {!! Form::text('sent_at_time', $time->toTimeString(),['class'=>'form-control datepicker', 'readonly'=>'true', 'hidden'=>'true']) !!}	

                                            <!-- USER ACTIVITY -->
                                            {!! Form::text('employee_id', Auth::user()->employee_id,['class'=>'form-control', 'readonly'=>'true', 'hidden'=>'true']) !!}
                                            {!! Form::text('position', Auth::user()->position,['class'=>'form-control', 'readonly'=>'true', 'hidden'=>'true']) !!}
                                            {!! Form::text('employee_name', Auth::user()->firstname.' '.Auth::user()->lastname,['class'=>'form-control', 'readonly'=>'true', 'hidden'=>'true']) !!}
                                            {!! Form::text('activity', 'Approved a maintenance report submitted by '.$report->conducted_by,['class'=>'form-control', 'readonly'=>'true', 'hidden'=>'true']) !!}	
                                            {!! Form::text('sent_at_date', $time->toDateString(),['class'=>'form-control datepicker', 'readonly'=>'true', 'hidden'=>'true']) !!}	
                                            {!! Form::text('sent_at_time', $time->toTimeString(),['class'=>'form-control datepicker', 'readonly'=>'true', 'hidden'=>'true']) !!}	
                                        </div>

                                        <button class="btn btn-success" type="submit" name="action">Approve</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel-button">Cancel</button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection