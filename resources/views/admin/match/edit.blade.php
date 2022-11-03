@extends('layouts.admin')

@section('content')
<match-form :data="{{ json_encode([
    'urlStore' => route('match.update', $match->id),
    'countries' => $countries,
    'match' => $match,
    'isEdit' => true,
    'urlBack' => route('match.index')
]) }}"></match-form>
@endsection

