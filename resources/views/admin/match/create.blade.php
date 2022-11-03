@extends('layouts.admin')
@section('content')
<match-form :data="{{ json_encode([
    'urlStore' => route('match.store'),
    'countries' => $countries,
    'urlBack' => route('match.index')
]) }}"></match-form>
@endsection
