@extends('layout')
@section('css')
@endsection
@section('header')
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-plus"></i> Microposts / Create </h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('questions.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group @if($errors->has('question')) has-error @endif">
                       <label for="body-field">Question</label>
                    <textarea class="form-control" id="question-field" rows="3" name="question">{{ old("question") }}</textarea>
                       @if($errors->has("question"))
                        <span class="help-block">{{ $errors->first("question") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a class="btn btn-link pull-right" href="{{ route('questions.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('scripts')

@endsection
