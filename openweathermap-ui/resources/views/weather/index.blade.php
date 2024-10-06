@extends('base')

@section('title', 'Weather?')

@section('content')
    <div>
        <h4>
            Lat: {{ $data->getLat() }}<br />
            Lon: {{ $data->getLon() }}<br />
            Last updated: {{ \Carbon\Carbon::createFromTimestamp($data->getLastUpdated())->setTimezone('Europe/London')->format('jS M Y H:i:s') }}
        </h4>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
