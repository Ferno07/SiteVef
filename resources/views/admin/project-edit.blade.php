@extends('admin.layout')
@section('title', 'Modifier le projet')
@section('intro', 'Enregistrez, prévisualisez puis publiez votre projet depuis cette page.')
@section('content')<form method="post" action="{{ route('admin.projets.update',$projet) }}" enctype="multipart/form-data">
@csrf @method('PUT') @include('admin.partials.project-form')</form>
@endsection
