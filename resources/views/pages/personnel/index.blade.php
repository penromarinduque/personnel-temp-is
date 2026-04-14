@extends('layouts.main.master')
@section('content')
    <div class="container-fluid">
        <div class="d-flex">
            <h5>Personnels</h5>
        </div>
        <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('personnels.create') }}" class="btn btn-sm btn-primary">Add Personnel</a>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="">Active Personnels</h6>
            </div>
            <div class="card-body">
                <div id="search-box" class="mb-2">
                    <div class="row justify-content-end">
                        <div class="col-lg-4 col-md-2 col">
                            <div class="d-flex">
                                <input type="text" name="search" id="search" class="form-control mr-2" placeholder="Search">
                                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>ZkTeco Badge No.</th>
                                <th>Dahua Id</th>
                                <th>Division</th>
                                <th>Position</th>
                                <th>Employment Status</th>
                                <th>Is Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($personnels as $personnel)
                                <tr>
                                    <td>
                                        <img style="width: 30px; height: 30px;" src="https://api.dicebear.com/9.x/identicon/svg?seed={{ $personnel->name }}" class="mr-2 img-circle" alt="User Image">
                                        {{ $personnel->name }}
                                    </td>
                                    <td>{{ $personnel->badgeNumber }}</td>
                                    <td>{{ $personnel->dahua_id }}</td>
                                    <td>{{ $personnel->division }}</td>
                                    <td>{{ $personnel->position }}</td>
                                    <td>
                                        <span class="badge badge-{{ $personnel->status == "Permanent" ? "primary" : ($personnel->status == "COS" ? "info" : "secondary") }}">{{ $personnel->status }}</span>
                                    </td>
                                    <td>
                                        @if ($personnel->is_active == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('personnels.edit', ['id' => \Illuminate\Support\Facades\Crypt::encryptString($personnel->userID)]) }}" class="btn btn-sm btn-outline-primary mr-2" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit "></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No personnels found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $personnels->links() }}
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="">Inactive Personnels</h6>
            </div>
            <div class="card-body">
                <div id="search-box" class="mb-2">
                    <div class="row justify-content-end">
                        <div class="col-lg-4 col-md-2 col">
                            <div class="d-flex">
                                <input type="text" name="search" id="search" class="form-control mr-2" placeholder="Search">
                                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>ZkTeco Badge No.</th>
                                <th>Dahua Id</th>
                                <th>Division</th>
                                <th>Position</th>
                                <th>Employment Status</th>
                                <th>Is Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inactivePersonnels as $personnel)
                                <tr>
                                    <td>
                                        <img style="width: 30px; height: 30px;" src="https://api.dicebear.com/9.x/identicon/svg?seed={{ $personnel->name }}" class="mr-2 img-circle" alt="User Image">
                                        {{ $personnel->name }}
                                    </td>
                                    <td>{{ $personnel->badgeNumber }}</td>
                                    <td>{{ $personnel->dahua_id }}</td>
                                    <td>{{ $personnel->division }}</td>
                                    <td>{{ $personnel->position }}</td>
                                    <td>
                                        <span class="badge badge-{{ $personnel->status == "Permanent" ? "primary" : ($personnel->status == "COS" ? "info" : "secondary") }}">{{ $personnel->status }}</span>
                                    </td>
                                    <td>
                                        @if ($personnel->is_active == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('personnels.edit', ['id' => \Illuminate\Support\Facades\Crypt::encryptString($personnel->userID)]) }}" class="btn btn-sm btn-outline-primary mr-2" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit "></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No inactive personnels found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $inactivePersonnels->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection