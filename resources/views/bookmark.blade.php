@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bookmarks') }}</div>
                @forelse($allBookmarks as $bookmark)
                <div class="found">
                    <h1>{{ $bookmark->getCity() ?? 'undefined' }}</h1>
                    <ul>
                        <li>Country: {{ $bookmark->getCountry() ?? 'undefined' }}</li>
                        <li>Weather: {{ $bookmark->getWeatherDesc() ?? 'undefined' }}</li>
                        <li>{{ $bookmark->getTempC() ?? 'undefined' }} °C ({{ $bookmark->getTempF() ?? 'undefined' }} °F)</li>
                    </ul>
                    @if(\Illuminate\Support\Facades\Auth::check())
                    <form action="{{ route('bookmark.update', ['slug' => Str::slug($bookmark->getCity())]) }}" method="POST">
                        @csrf
                        <input type="submit" value="Remove from bookmarks">
                    </form>
                    @endif
                </div>
                @empty
                    Not found
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
