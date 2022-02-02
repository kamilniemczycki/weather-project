@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Search weather') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="location"
                                   class="col-md-2 col-form-label text-md-right">{{ __('Location') }}</label>
                            <div class="col-md-6">
                                <input id="location"
                                       type="text"
                                       class="form-control"
                                       name="location"
                                       value="{{ $weather->city ?? '' }}" required autofocus>
                            </div>
                            <div class="col-md-2">
                                <button id="show" type="submit" class="btn btn-primary">
                                    {{ __('Show') }}
                                </button>
                            </div>
                        </div>
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif
                        @if(isset($weather) && $weather)
                        <div class="found">
                            <h1>{{ $weather->city ?? 'undefined' }}</h1>
                            @if($weather->country)
                            <ul>
                                <li>Country: {{ $weather->country ?? 'undefined' }}</li>
                                <li>Weather: {{ $weather->weather_desc ?? 'undefined' }}</li>
                                <li>{{ $weather->temp_c ?? 'undefined' }} °C ({{ $weather->temp_f ?? 'undefined' }} °F)</li>
                            </ul>
                            @else
                                Not found
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::check() && $bookmark)
                            <form action="{{ route('bookmark.update', ['slug' => Str::slug($weather->city_slug)]) }}" method="POST">
                                @csrf
                                <input type="submit" value="{{ $bookmark }}">
                            </form>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/search.js') }}"></script>
@endpush
