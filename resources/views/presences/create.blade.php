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
                    <h3>Presence</h3>
                    <p class="text-subtitle text-muted">Handle presence information</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item " aria-current="page">Presences</li>
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
                        Presence Create
                    </h5>
                </div>
                <div class="card-body">

                    @if (session('role') == 'HR')
                        <form action="{{ Route('presences.store') }}" method="POST">
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
                                <label for="check_in" class="form-label">Check In</label>
                                <input type="datetime-local" class="form-control" name="check_in" required>
                                @error('check_in')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="check_out" class="form-label">Check Out</label>
                                <input type="datetime-local" class="form-control" id="check_out" name="check_out">
                                @error('check_out')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control date" id="date" name="date">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label ">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="leave">Leave</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ Route('presences.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    @else
                        <form action="{{ Route('presences.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="employee_id" value="{{ session('employee_id') }}">
                            <div class="mb-3"><b>Note</b> : Mohon izinkan akses lokasi, supaya sistem dapat mendeteksi
                                lokasi Anda saat melakukan check in dan check out.</div>
                            <div class="mb-3">
                                <label for="" class="form-label">Latitude</label>
                                <input type="text" class="form-control" name="latitude" id="latitude" required>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" required>
                            </div>

                            <div class="mb-3">
                                <iframe width="500" height="300" frameborder="0" marginheight="0" marginwidth="0"
                                    src=""></iframe>
                            </div>

                            <button type="submit" class="btn btn-primary" id="btn-present" >Present</button>
                        </form>
                    @endif

                </div>
            </div>

        </section>
    </div>

    <script>
        const iframe = document.querySelector('iframe');

        const officeLat = -6.8911104;
        const officeLon = 107.544576;
        const threshold = 0.01;

        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            iframe.src = `https://maps.google.com/maps?q=${lat},${lon}&z=15&output=embed`;
        });

        document.addEventListener('DOMContentLoaded', (event) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    // 1. Mengisi input text latitude & longitude otomatis
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lon;

                    // 2. Menghitung jarak ke kantor
                    const distance = Math.sqrt(Math.pow(lat - officeLat, 2) + Math.pow(lon - officeLon, 2));

                    // 3. Perbaikan Logika: Jika distance LEBIH KECIL atau SAMA DENGAN threshold (Di dalam kantor)
                    if (distance <= threshold) {
                        alert('Anda berada di dalam area kantor. Silakan melakukan check in.');
                        document.getElementById('btn-present').removeAttribute('disabled'); // Tombol aktif
                    } else {
                        alert('Anda berada di luar area kantor. Silakan kembali ke kantor untuk melakukan check in.');
                    }
                });
            }
        });
    </script>
@endsection
