@extends('layouts.app')
 
@section('content')
<div class="container mt-5">
        <h4 class="text-center mb-3">Darbinieku saraksts</h4>

        <div class="d-flex justify-content-end mb-4">
            <a class="btn btn-secondary" href="{{ URL::to('/employee/pdf') }}">Eksportēt uz PDF</a>
        </div>

        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table">
                    <th scope="col">Nr</th>
                    <th scope="col">Vārds Uzvārds</th>
                    <th scope="col">E-pasts</th>
                    <th scope="col">Telefons</th>
                    <th scope="col">Amats</th>
                    <th scope="col">Pievienošanas datms</th>
                    <th scope="col">Darbības</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employee ?? '' as $data)
                <tr>
                    <th scope="row">{{ $data->id }}</th>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->phone }}</td>
                    <td>{{ $data->position }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td> 
                        @can('isAdmin')
                        <a href="{{url('/employee/edit/'.$data->id)}}" class="btn btn-secondary btn-sm">Labot</a>
                        <a href="{{url('/employee/delete/'.$data->id)}}" onclick="return confirm('Vai tiešām dzēst?')" class="btn btn-secondary btn-sm">Dzēst</a>
                        @endcan
                    </td> 
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>



@endsection
       