@extends('layout')

@section('title')
    Examen {{ $exam->id}}
@stop
@section('content')
    @include('management.exams.images_form', ['exam', $exam])
    @each('management.exams.slot_list_partial', $exam->slots, 'slot')
    @include('management.crud.modal_partial')

@endsection

<script src="https://cdn.jsdelivr.net/gh/enyo/dropzone@master/dist/dropzone.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/enyo/dropzone@master/dist/dropzone.css">
