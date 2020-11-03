@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Edit anime</h1>
                <form method="POST" action="{{route('animes.store')}}">
                    @csrf
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" id="title">
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <input type="text" class="form-control" name="rating" id="rating">
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="text" class="form-control" name="startDate" id="startDate">
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="text" class="form-control" name="endDate" id="endDate">
                    </div>
                    <div class="form-group">
                        <label>Subtype</label>
                        <input type="text" class="form-control" name="subtype" id="subtype">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" name="status" id="status">
                    </div>
                    <input type="submit" name="send" value="Add" class="btn btn-dark btn-block">
                </form>
            </div>
        </div>
    </div>
@endsection
