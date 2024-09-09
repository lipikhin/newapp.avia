@extends('layouts.base')

@section('content')
<style>
    .container {
        max-width: 450px;
    }
    .push-top {
        margin-top: 20px;
    }
</style>

<div class="container">
   <div class="card shadow">

       <div class="card-header">
           <div class="d-flex justify-content-between">
               <h3>{{__('Customers')}}</h3>
               <a href="{{route('admin.customers.create')}}" class="btn btn-primary mb-3">{{__('New Customer')}}</a>
           </div>
       </div>

       <div class="card-body">
           <table data-toggle="table" data-search="true" data-pagination="true" data-page-size="10" class="table table-bordered">
               <thead>
               <tr>
                   <th data-field="number" data-visible="true" data-priority="1" class="text-center">{{__('##')}}</th>
                   <th data-field="name" data-align="center" class="text-center">{{__('Name')}}</th>
                   <th data-field="action" data-align="center" class="text-center" data-formatter="actionFormatter">{{__('Action')}}</th>
               </tr>
               </thead>
               @foreach($custs as $cust)
                   <tr>
                       <td>#</td>
                       <td>{{$cust->name}}</td>
                       <td>
                           <a href="{{ route('admin.customers.edit', $cust->id) }}" class="btn btn-primary
                           btn-sm">Edit</a>
                           <form action="{{ route('admin.customers.destroy', $cust->id) }}" method="POST"
                                 style="display:inline;">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you ' +
                                'sure?');">{{__('Delete')}}</button>
                           </form>
                       </td>
                   </tr>

               @endforeach
           </table>
       </div>

   </div>
</div>
@endsection
