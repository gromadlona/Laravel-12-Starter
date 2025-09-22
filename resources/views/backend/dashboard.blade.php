@extends('backend.layouts.master')

@section('content')
    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit" class="btn btn-neutral">
            Logout
        </button>
    </form>
@endsection
