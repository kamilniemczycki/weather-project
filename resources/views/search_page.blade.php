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
                                       value="{{ isset($result) ? ($result->getCity() ?? '') : '' }}" required autofocus>
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
                        @if(isset($result) && $result)
                        <div class="found">
                            <h1>{{ $result->getCity() ?? 'undefined' }}</h1>
                            @if($result->getCountry())
                            <ul>
                                <li>Country: {{ $result->getCountry() ?? 'undefined' }}</li>
                                <li>Weather: {{ $result->getWeatherDesc() ?? 'undefined' }}</li>
                                <li>{{ $result->getTempC() ?? 'undefined' }} °C ({{ $result->getTempF() ?? 'undefined' }} °F)</li>
                            </ul>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::check())
                            <form action="{{ route('bookmark.update', ['slug' => $city]) }}" method="POST">
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
