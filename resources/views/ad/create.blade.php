@extends('layouts.main.main')

@if (isset($ad))
    @section('title', 'Edit: ' . $ad->title)
    @section('metaTitle', 'Edit your Ad')
@else
    @section('title', 'Hi ' . auth()->user()->username . ', lets create your own ad')
    @section('metaTitle', 'Creat your own Ad')
@endif

@section('content')
    @if (isset($ad))
        <form action="{{ route('ad.update', $ad->id) }}" method="post">
        {{ method_field('PATCH') }}
    @else
        <form action="{{ route('ad.store') }}" method="post">
    @endif
        <fieldset>
            @csrf
            <div class="mb-3">
                <label for="title">Title</label>
                <input 
                    class="form-control"
                    type="text"
                    name="title"
                    id="title"
                    max="75"
                    value="@if (isset($ad)){{ old('title') ?? $ad->title }}@else{{ old('title') }}@endif" 
                required>
                @error('title')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10" required>@if (isset($ad)){{ old('description') ?? $ad->description }}@else{{ old('description') }}@endif</textarea>
                @error('description')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btnbtn btn-outline-success">
                @if (isset($ad))
                    Save
                @else
                    Create ad
                @endif
            </button>
        </fieldset>
    </form>
@endsection