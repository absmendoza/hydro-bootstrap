@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"> My Reports </div>

            <div class="panel-body">
                <table id="all-users" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Station Name</th>
                            <th>Location</th>
                            <th>Sensor Type</th>
                            <th>Date Assessed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $reports = DB::table('reports')->get(); ?>
                        @foreach ($reports as $report)
                            @if(strcmp($report->conducted_by, Auth::user()->employee_id) == 0)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ $report->station_name }}</td>
                                <td>{{ $report->location }}</td>
                                <td>{{ $report->sensor_type }}</td>
                                <td>{{ $report->date_assessed }}</td>
                                <td>
                                    <a class="btn" data-toggle="modal" data-target="#viewReport-<?= $report->id?>"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></a>
                                    @if($report->if_approved == 1)
                                    <a class="btn" data-toggle="tooltip" title="Approved"><i class="fa fa-check-square fa-2x" aria-hidden="true"></i></a>
                                    @else
                                    <a class="btn" data-toggle="modal" data-target="#editReport-<?= $report->id?>"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
                                    @endif
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
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Report Modal -->
                            <div id="editReport-<?= $report->id?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Report #{{ $report->id }}</h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                            {!! Form::model($report,['method' => 'PATCH','route'=>['reports.update',$report->id]]) !!}
                                            @include('Reports/edit_report')
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-success" type="submit" name="action">Save Changes</button>
                                            {!! Form::close() !!}
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel-button">Cancel</button>
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