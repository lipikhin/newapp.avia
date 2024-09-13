@extends('layouts.base')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>{{__('Select Unit')}}</h4>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.trainings.store') }}">
                    @csrf
                    <div class="form-group mt-2">
                        <label for="cmm_id">{{ __('Unit PN') }}</label>
                        <select id="cmm_id" name="cmm_id" class="form-control" required>
                            <option value="">{{ __('Select Unit PN') }}</option>
                            @foreach ($cmms as $cmm)
                                <option value="{{ $cmm->id }}">{{ $cmm->title }} ({{ $cmm->units_pn }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">{{ __('Add Unit') }}</button>
                </form>

            </div>
        </div>

    </div>

@endsection
