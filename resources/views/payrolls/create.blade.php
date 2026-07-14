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
                    <h3>payroll</h3>
                    <p class="text-subtitle text-muted">Handle payroll data</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item " aria-current="page">Payrolls</li>
                            <li class="breadcrumb-item active" aria-current="page">New</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Payroll Create
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

                    <form action="{{ Route('payrolls.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select class="form-control" name="employee_id" required>
                                <option value="">Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" class="form-control" name="salary" required>
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deductions" class="form-label">Deductions</label>
                            <input type="number" class="form-control" id="deductions" name="deductions">
                            @error('deductions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bonuses" class="form-label">Bonuses</label>
                            <input type="number" class="form-control" id="bonuses" name="bonuses">
                            @error('bonuses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pay_date" class="form-label">Pay Date</label>
                            <input type="date" class="form-control date" id="pay_date" name="pay_date">
                            @error('pay_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ Route('payrolls.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

        </section>
    </div>
@endsection
