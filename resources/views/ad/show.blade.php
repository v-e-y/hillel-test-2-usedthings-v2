@extends('layouts.main.main')

@section('metaTitle', $ad->title)

@section('content')
    <h1>{{ $ad->title }}</h1>
    <section>
        <p class="small text-muted">
            {{ $ad->created_at }} | Author: {{ $ad->user->username }}
        </p>
        {{ $ad->description }}
    </section>
    @canany(['update', 'delete'], $ad)
        <section>
            <hr>
            <ul class="list-inline">
                @can('update', $ad)
                    <li class="list-inline-item">
                        <i class="bi bi-pencil"></i> 
                        <a href="{{ route('ad.edit', $ad->id) }}" title="edit ad">edit</a>
                    </li>
                @endcan
                @can('delete', $ad)
                    <li class="list-inline-item">
                        <i class="bi bi-trash3"></i> 
                        <a href="{{ route('ad.delete', $ad->id) }}" title="delete ad">delete</a>
                    </li>
                @endcan
            </ul>
        </section>
    @endcanany
@endsection