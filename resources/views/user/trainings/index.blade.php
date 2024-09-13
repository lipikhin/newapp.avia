@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3>{{__('My Trainings ')}} {{Auth:: user()->name}} </h3>
                    <a href="{{route('user.trainings.create')}}" class="btn
                    btn-primary">{{__('Add Unit')}}</a>
                </div>
            </div>

            <div class="card-body">

                <table id="userCmmTable"
                       data-toggle="table"
                       data-search="true"
                       data-pagination="false"
                       data-page-size="5"
                       class="table table-bordered">
                <thead>
                <tr>
                    <th data-field="units_pn" data-visible="true"
                        data-priority="1" class="text-center">
                        {{__('Unit PN')}}
                    </th>
                    <th data-field="title" data-visible="true"
                        data-priority="2" class="text-center">
                        {{__('Description')}}
                    </th>
                    <th data-field="firstData" data-visible="true"
                        data-priority="3" class="text-center">
                        {{__('First Training Data')}}
                    </th>
                </tr>
                </thead>
                    <tbody>
                    @foreach($userCmmLists as $userCmmList)
                       <tr>
                           <td
                               class="text-center">{{$userCmmList->c_m_m_s->unit_pn}}</td>
                           <td
                               class="text-center">{{$userCmmList->c_m_m_s->title}}</td>
                           <td class="text-center"></td>

                       </tr>
                    @endforeach
                    </tbody>

                </table>








            </div>

        </div>


    </div>

@endsection
