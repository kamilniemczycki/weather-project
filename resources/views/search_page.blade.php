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
                                       value="{{ $result->getCity() ?? '' }}" required autofocus>
                            </div>
                            <div class="col-md-2">
                                <button id="show" type="submit" class="btn btn-primary">
                                    {{ __('Show') }}
                                </button>
                            </div>
                        </div>
                        @if(isset($result) && $result)
                        <div class="found">
                            Country: {{ $result->getCountry() ?? 'undefined' }}
                            City: {{ $result->getCity() ?? 'undefined' }}
                            Weather: {{ $result->getWeatherDesc() ?? 'undefined' }}
                            {{ $result->getTempC() ?? 'undefined' }} °C ({{ $result->getTempF() ?? 'undefined' }} °F)
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
