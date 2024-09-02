@extends('layouts.base')

@section('content')
{{--    @include('includes.work_header')--}}
    <div class="container">
        <div class="row ">

                <h1>CMMs</h1>

                <a href="{{ route('admin.cmms.create') }}" style="width: 150px"
                   class="btn btn-primary justify-content-end mb-3">{{__('Create New CMM')}}</a>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Number</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Revision Date</th>
{{--                        <th>Active</th>--}}
                        <th>Library</th>
{{--                        <th>Aircraft</th>--}}
{{--                        <th>MFR</th>--}}
{{--                        <th>Scope</th>--}}
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cmms as $cmm)
                        <tr>
                            <td>{{ $cmm->number }}</td>
                            <td>{{ $cmm->title }}</td>
                            <td><img src="{{ asset('storage/' . $cmm->img) }}" alt="{{ $cmm->title }}" height="50"></td>
                            <td>{{ $cmm->revision_date }}</td>
{{--                            <td>{{ $cmm->active ? 'Yes' : 'No' }}</td>--}}
                            <td>{{ $cmm->lib }}</td>
{{--                            <td>{{ $cmm->airCraft->name }}</td>--}}
{{--                            <td>{{ $cmm->mfr->name }}</td>--}}
{{--                            <td>{{ $cmm->scope->name }}</td>--}}
                            <td>
                                <a href="{{ route('admin.cmms.edit', $cmm->id) }}"
                                   class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.cmms.destroy', $cmm->id) }}"
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

        </div>
    </div>

@endsection
