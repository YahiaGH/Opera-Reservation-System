@extends('layouts.app')

@section('content')
    <h1>Customers</h1>
    @if(count($customers)>1)

    @else
        <p>NO customers</p>
    @endif
@endsection
