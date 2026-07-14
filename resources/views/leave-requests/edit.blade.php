@extends('layouts.dashboard')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Leave Request</h3>
                    <p class="text-subtitle text-muted">Handle Leave Request data</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item " aria-current="page">Leave Requests</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Leave Request Create
                    </h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ Route('leave-requests.update', $leaveRequest->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select class="form-control" name="employee_id" required>
                                <option value="">Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $leaveRequest->employee_id == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->fullname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="leave_type" class="form-label">Leave Type</label>
                            <select class="form-control" name="leave_type" id="status" required>
                                <option value="sick leave" {{ $leaveRequest->leave_type == 'sick leave' ? 'selected' : '' }}>Sick Leave</option>
                                <option value="vacation" {{ $leaveRequest->leave_type == 'vacation' ? 'selected' : '' }}>Vacation</option>
                                <option value="birth leave" {{ $leaveRequest->leave_type == 'birth leave' ? 'selected' : '' }}>Birth Leave</option>
                            </select>
                            @error('leave_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $leaveRequest->start_date) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $leaveRequest->end_date) }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ Route('leave-requests.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

        </section>
    </div>
@endsection
