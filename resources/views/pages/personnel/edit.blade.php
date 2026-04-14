@extends('layouts.main.master')
@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('personnels.index') }}" class="btn btn-sm btn-outline-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h5 class="mb-0">Edit Personnel</h5>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('personnels.update') }}" method="POST" id="editPersonnelForm" >
                    @csrf
                    <input type="hidden" name="id" value="{{ $personnel->userID }}">
                    <h6>Personal Information</h6>
                    <div class="row">
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="name">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $personnel->first_name) }}" required>
                                @error('first_name')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="name">Middle Initial <span class="text-danger">*</span></label>
                                <input type="text" name="middle_initial" id="middle_initial" class="form-control" value="{{ old('middle_initial', $personnel->middle_initial) }}" required>
                            </div>
                            @error('middle_initial')
                                <span class="small text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="name">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $personnel->last_name) }}" required>
                                @error('last_name')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="name">Ext Name</label>
                                <input type="text" name="ext_name" id="ext_name" class="form-control" value="{{ old('ext_name', $personnel->ext_name) }}">
                                @error('ext_name')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="name">Contact Number</label>
                                <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact', $personnel->contact) }}">
                                @error('contact')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="name">Birthdate</label>
                                <input type="text" name="birthday" id="birthday" class="form-control" value="{{ old('birthday', $personnel->birthday) }}">
                                @error('birthday')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="name">Address</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $personnel->address) }}">
                                @error('address')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select type="text" name="gender" id="gender" class="form-control">
                                    <option value="">-Select Gender-</option>
                                    <option value="M" {{ old('gender', $personnel->gender) == 'M' ? 'selected' : '' }}>Male</option>
                                    <option value="F" {{ old('gender', $personnel->gender) == 'F' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <h6>Biometrics & DTR Details</h6>
                    <div class="row">
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="userID">DTR ID</label>
                                <input type="text" name="userID" id="userID" class="form-control" value="{{ old('userID', $personnel->userID) }}">
                                @error('userID')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="badgeNumber">Zkteco Badge Number</label>
                                <input type="text" name="badgeNumber" id="badgeNumber" class="form-control" value="{{ old('badgeNumber', $personnel->badgeNumber) }}">
                                @error('badgeNumber')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="dahua_id">Dahua ID</label>
                                <input type="text" name="dahua_id" id="dahua_id" class="form-control" value="{{ old('dahua_id', $personnel->dahua_id) }}">
                                @error('dahua_id')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="monthly_rate">Monthly Rate</label>
                                <input type="number" name="monthly_rate" id="monthly_rate" class="form-control" value="{{ old('monthly_rate', $personnel->monthly_rate) }}">
                                @error('monthly_rate')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="daily_rate">Daily Rate</label>
                                <input type="number" name="daily_rate" id="daily_rate" class="form-control" value="{{ old('daily_rate', $personnel->daily_rate) }}">
                                @error('daily_rate')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="hourly_rate">Hourly Rate</label>
                                <input type="number" name="hourly_rate" id="hourly_rate" class="form-control" value="{{ old('hourly_rate', $personnel->hourly_rate) }}">
                                @error('hourly_rate')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="hourly_rate">PAP</label>
                                <input type="text" name="pap" id="pap" class="form-control" value="{{ old('pap', $personnel->pap) }}">
                                @error('pap')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <h6>Employment Details</h6>
                    <div class="row">
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="division">Division <span class="text-danger">*</span></label>
                                <select name="division" id="division" class="form-control" required>
                                    <option value="">-Select Division-</option>
                                    <option value="main" {{ old('division', $personnel->division) == 'main' ? 'selected' : '' }}>MSD</option>
                                    <option value="tsd" {{ old('division', $personnel->division) == 'tsd' ? 'selected' : '' }}>TSD</option>
                                    <option value="pamo" {{ old('division', $personnel->division) == 'pamo' ? 'selected' : '' }}>PAMO</option>
                                </select>
                                @error('division')
                                    <span class="small text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="SSN">SSN</label>
                                    <input type="text" name="SSN" id="SSN" class="form-control" value="{{ old('SSN', $personnel->SSN) }}">
                                    @error('SSN')
                                        <span class="small text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="SSN">Position <span class="text-danger">*</span></label>
                                    <input type="text" name="position" id="position" class="form-control" value="{{ old('position', $personnel->position) }}" required>
                                    @error('position')
                                        <span class="small text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="tin">TIN </label>
                                    <input type="text" name="tin" id="tin" class="form-control" value="{{ old('tin', $personnel->tin) }}" >
                                    @error('tin')
                                        <span class="small text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="status">Employment Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" value="{{ old('status', $personnel->status) }}" required>
                                        <option value="">-Select Status-</option>
                                        <option value="Permanent" {{ old('status', $personnel->status) == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                        <option value="COS" {{ old('status', $personnel->status) == 'COS' ? 'selected' : '' }}>COS</option>
                                        <option value="OJT" {{ old('status', $personnel->status) == 'OJT' ? 'selected' : '' }}>OJT</option>
                                        <option value="SPES" {{ old('status', $personnel->status) == 'SPES' ? 'selected' : 'SPES' }}>SPES</option>
                                        <option value="Work Immersion Student" {{ old('status', $personnel->status) == 'Work Immersion Student' ? 'selected' : 'Work Immersion Student' }}>Work Immersion Student</option>
                                    </select>
                                    @error('status')
                                        <span class="small text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="is_active">Is Active <span class="text-danger">*</span></label>
                                    <select name="is_active" id="is_active" class="form-control" required>
                                        <option value="">-Select Status-</option>
                                        <option value="1" {{ old('status', $personnel->is_active) == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('status', $personnel->is_active) == 'COS' ? '0' : '' }}>No</option>
                                    </select>
                                    @error('is_active')
                                        <span class="small text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection