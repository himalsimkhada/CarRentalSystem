@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
    <div class="wrapper">
        @include('layouts.dashboard-sidebar')
        <div class="content">
            <p class="text-center h1 title">Add/Edit Location</p>
            <div class="row">
                <div class="col">
                    @if (Route::is('company.create.location'))
                        <form action="{{ route('company.store.location') }}" method="post" enctype="multipart/form-data"
                            class="needs-validation" novalidate>
                        @elseif (Route::is('company.edit.location'))
                            <form action="{{ route('company.update.location') }}" method="post"
                                enctype="multipart/form-data" class="needs-validation" novalidate>
                    @endif
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Informations</h4>
                            <hr>
                            <div class="form-group">
                                <input type="hidden" value="{{ Crypt::encrypt($location->id) }}" name="id">
                                <label class="">Location Name</label>
                                <input type="text" class="form-control" name="location" value="{{ $location->name }}"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="text-danger">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
