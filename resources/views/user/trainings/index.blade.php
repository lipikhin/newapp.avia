@extends('layouts.base')

<style>
    .card {
        max-width: 450px;
    }
    .card-body {
        max-width: 450px;
    }
    .push-top {
        margin-top: 50px;
    }
</style>

@section('content')
    <div class="container ">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3>{{__('Trainings')}}  </h3>
                    <a href="{{route('user.trainings.create')}}"
                       class="btn
                    btn-primary">{{__('Add Unit')}}</a>
                </div>
            </div>

            <div class="card-body">

                <table id="trainingsTable"
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

                </tr>
                </thead>
                    <tbody>
                    @foreach($trainingLists as $trainingList)
                       <tr>
                           <td
                               class="text-center">{{$trainingList->c_m_m_s->units_pn}}</td>
                           <td
                               class="text-center">{{$trainingList->c_m_m_s->title}}</td>
                           <td class="text-center"> </td>

                       </tr>
                    @endforeach
                    </tbody>

                </table>


            </div>

        </div>


    </div>

@endsection
