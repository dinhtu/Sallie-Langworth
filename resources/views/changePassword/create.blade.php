@extends('layouts.admin')

@section('content')
<change-pass :data="{{ json_encode([
    'urlStore' => route('change-password.store'),
    'urlBack' => route('admin.dashboard.index')
]) }}"></change-pass>
@endsection
