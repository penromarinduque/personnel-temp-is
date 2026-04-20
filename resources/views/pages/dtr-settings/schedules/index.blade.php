@extends('layouts.main.master')
@section('content')
    <div class="container-fluid">
        <div class="d-flex">
            <h5>DTR Schedules</h5>
        </div>
        <div class="card">
            <div class="card-header"> 
                <div class="d-flex justify-content-end">
                    <a href="#" class="btn btn-sm btn-primary mx-1" onclick="showAddScheduleModal({{ $personnel }})">Add Schedule</a>
                    <a href="#" class="btn btn-sm btn-primary mx-1" data-toggle="modal" data-target="#bulkCreateScheduleModal">Bulk Create</a>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="GET" class="mb-3">
                    <div class="row">
                        <div class="col col-md-6 col-lg-3">
                            <select name="personnel" id="personnel" class="form-control-sm select2 w-100">
                                <option value="">-Select Personnel-</option>
                                @foreach ($personnels as $_personnel)
                                    <option value="{{ $_personnel->userID }}" {{ old('personnel', request('personnel')) == $_personnel->userID ? 'selected' : ''}}>{{ $_personnel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <button class="btn btn-primary btn-sm">
                                View
                            </button>
                        </div>
                    </div>
                </form>
                <div class="">
                    <table>
                        <tr>
                            <td>Employee Name: </td>
                            <td>{{ $personnel->name }}</td>
                        </tr>
                    </table>
                    <div id="calendar"></div>
                    {{-- <table class="table ">
                        <thead>
                            <tr>
                                <th>DTR Option</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dtrSchedules as $schedule)
                                <td>{{ $schedule->dtrOption->description }}</td>
                                <td><i class="far fa-calendar-alt" aria-hidden="true"></i> {{ $schedule->start_date->format('F d, Y') }}</td>
                                <td><i class="far fa-calendar-alt" aria-hidden="true"></i> {{ $schedule->end_date->format('F d, Y') }}</td>
                                <td></td>
                            @empty
                                <td colspan="4" class="text-center">No DTR Schedules found</td>
                            @endforelse
                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>

    {{-- UPDATE SCHEDULE MODAL --}}
    <div class="modal fade" id="updateScheduleModal">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('dtr_schedules.update') }}" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Update Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" id="id" >
                    @error('ID', 'updateDtrSchedule')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                    <div class="mb-2">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ old('start_date') }}">
                        @error('start_date', 'updateDtrSchedule')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ old('end_date') }}">
                        @error('end_date', 'updateDtrSchedule')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="dtr_option">DTR Option</label>
                        <select name="dtr_option" id="dtr_option" class="form-control form-control-sm">
                            <option value="">-Select-</option>
                            @foreach ($dtrOptions as $dtrOption)
                                <option value="{{ $dtrOption->id }}" {{ old('dtr_option') == $dtrOption->id ? 'selected' : '' }}>{{ $dtrOption->description }}</option>
                            @endforeach
                        </select>
                        @error('dtr_option', 'updateDtrSchedule')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-dismiss="modal" >Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary btn-submit">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ADD SCHEDULE MODAL --}}
    <div class="modal fade" id="addScheduleModal">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('dtr_schedules.store') }}" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="user_info_id" id="user_info_id" value="{{ $personnel->userID }}">
                    <div class="mb-2">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ old('start_date') }}">
                        @error('start_date', 'addDtrSchedule')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ old('end_date') }}">
                        @error('end_date', 'addDtrSchedule')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="dtr_option">DTR Option</label>
                        <select name="dtr_option" id="dtr_option" class="form-control form-control-sm">
                            <option value="">-Select-</option>
                            @foreach ($dtrOptions as $dtrOption)
                                <option value="{{ $dtrOption->id }}" {{ old('dtr_option') == $dtrOption->id ? 'selected' : '' }}>{{ $dtrOption->description }}</option>
                            @endforeach
                        </select>
                        @error('dtr_option', 'addDtrSchedule')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary btn-submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- BULK CREATE SCHEDULE MODAL --}}
    <div class="modal fade" id="bulkCreateScheduleModal">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('dtr_schedules.bulkCreate') }}" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Create Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="mb-2">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ old('start_date') }}">
                        @error('start_date', 'addDtrSchedule')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ old('end_date') }}">
                        @error('end_date', 'addDtrSchedule')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="dtr_option">DTR Option</label>
                        <select name="dtr_option" id="dtr_option" class="form-control form-control-sm">
                            <option value="">-Select-</option>
                            @foreach ($dtrOptions as $dtrOption)
                                <option value="{{ $dtrOption->id }}" {{ old('dtr_option') == $dtrOption->id ? 'selected' : '' }}>{{ $dtrOption->description }}</option>
                            @endforeach
                        </select>
                        @error('dtr_option', 'addDtrSchedule')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="employment_status">Employment Status</label>
                        <select name="employment_status" id="employment_status" class="form-control form-control-sm">
                            <option value="">-Select-</option>
                            @foreach ($employmentStatuses as $_status)
                                <option value="{{ $_status->status }}" {{ old('employment_status') == $_status->status ? 'selected' : '' }}>{{ $_status->status }}</option>
                            @endforeach
                        </select>
                        @error('dtr_option', 'addDtrSchedule')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary btn-submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="viewScheduleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Shedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    sdf
                </div>
            </div>
        </div>
    </div>
@endsection

@include('components.deleteConfirmationModal')
@section('script')
    <script>
        $(function(){
            @if ($errors->updateDtrSchedule->any())
                $('#updateScheduleModal').modal('show');
            @endif
            @if ($errors->addDtrSchedule->any())
                $('#addScheduleModal').modal('show');
            @endif

            initCalendar();
            // console.log("""");
            
        });

        function initCalendar() {
            var calendarEl = $('#calendar')[0];
            var calendar = new FullCalendar.Calendar(calendarEl, {
              initialView: 'multiMonthYear',
            //   themeSystem: 'bootstrap5',
              events: {!! $scheduleFcEvents !!},
              eventClick: function(info) {
                  showUpdateScheduleModal(info);
              }
            });
            calendar.render();
            
        }

        function showUpdateScheduleModal(info) {
            clearUpdateScheduleModal();
            const event = info.event.toPlainObject();
            const url = "{{ route('dtr-schedules.apiGetSchedule', ['id' => ':id']) }}".replace(':id', event.id);
            const deleteUrl = "{{ route('dtr_schedules.delete', ['id' => ':id']) }}".replace(':id', event.id);
            $('#updateScheduleModal .btn-delete').on('click', function() {
                confirmDelete(deleteUrl, 'Are you sure you want to delete this schedule?');
            });
            $.get(url, function( data ) {
                $('#updateScheduleModal #id').val(data.id);
                $('#updateScheduleModal #start_date').val(new Date(data.start_date).toISOString().split('T')[0]);
                $('#updateScheduleModal #end_date').val(new Date(data.end_date).toISOString().split('T')[0]); 
                $('#updateScheduleModal #dtr_option').val(data.dtr_option_id);
            });
            $('#updateScheduleModal').modal('show');
        }
        
        function showAddScheduleModal(personnel) {
            clearUpdateScheduleModal();
            $('#addScheduleModal #user_info_id').val(personnel.id);
            $('#addScheduleModal').modal('show');
        }

        function clearUpdateScheduleModal() {
            $('#start_date').val('');
            $('#end_date').val('');
            $('#dtr_option').val('');
        }

        // function showViewScheduleModal(info) {
        //     const event = info.event.toPlainObject();
        //     const url = "{{ route('dtr-schedules.apiGetSchedule', ['id' => ':id']) }}".replace(':id', event.id);
        //     $.get(url, function( data ) {
        //         console.log(data);
        //     })
        //     $('#updateScheduleModal').modal('show');
        // }
    </script>
@endsection