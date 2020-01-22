@extends('layouts.template')

@section('title', 'Shop')

@section('main')
    <h1>Shop - Alternative Listing</h1>
    <hr>

    @foreach($genres as $genre)
        <h3>

            {{$genre->name}}

        </h3>
    @endforeach


@endsection
