@extends('layouts.main.main')

@section('title', 'Ads list')

@section('content')
    <div class="row row-cols-1 row-cols-md-2 g-4 pb-4" role="list" data-masonry='{"percentPosition": true }'>
        @foreach ($ads as $ad)
            <div class="col-12 col-md-6 col-lg-4" role="listitem">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('ad.show', $ad->id) }}" title="{{ $ad->title }}">
                                {{ $ad->title }}
                            </a>
                        </h5>
                        <p class="card-text">
                            {{ Str::limit($ad->description, 255) }}
                        </p>
                        @can('update', $ad)
                            <a href="{{ route('ad.edit', $ad->id) }}" class="card-link" title="edit ad"><i class="bi bi-pencil-square"></i></a>
                        @endcan
                        @can('delete', $ad)
                            <a href="{{ route('ad.delete', $ad->id) }}" class="card-link" title="delete ad"><i class="bi bi-trash3"></i></a>
                        @endcan
                        <small class="text-muted card-link">
                            <em>
                                {{ $ad->created_at }}
                            </em>
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $ads->links() }}
@endsection

@push('bottomJs')
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
@endpush
