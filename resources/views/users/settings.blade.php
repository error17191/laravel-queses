@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Settings</div>

                    <div class="card-body">
                        <form action="{{route('update_user_settings')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <div class="col text-center">
                                    <input class="form-control-file" type="file" name="image" id="image">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col text-center">
                                    <button class="btn btn-light" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
