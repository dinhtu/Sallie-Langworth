@php
use App\Components\SearchQueryComponent;
use Carbon\Carbon;
@endphp
@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <label>Match List</label>
                        </div>
                        <div class="card-body">
                            @if (!$matchs->isEmpty())
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-12 group-select-page d-flex">
                                        <limit-page-option :limit-page-option="{{ json_encode([20, 50, 100]) }}"
                                            :new-size-limit="{{ $newSizeLimit }}"></limit-page-option>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12 group-paginate">
                                        {{ $matchs->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
                                    </div>
                                </div>
                                <table class="table table-responsive-sm table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>
                                                @sortablelink('match_day', 'match day')
                                            </th>
                                            <th class="text-center">
                                                country
                                            </th>
                                            <th class="text-center" style="width:150px">
                                                dự đoán
                                            </th>
                                            <th class="text-center" style="width:150px">
                                                @sortablelink('result', 'kết quả')
                                            </th>
                                            <th class="text-center">
                                                country
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($matchs as $match)
                                            <tr class="{{ $match->result && ($match->predictUser ? $match->predictUser->predict : '') != $match->result ? 'row-error' : '' }} {{ $match->result && ($match->predictUser ? $match->predictUser->predict : '') == $match->result ? 'row-success' : '' }}">
                                                <td>
                                                    {{ Carbon::parse($match->match_day)->format('Y/m/d H:i') }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $match->country_1_name }}
                                                </td>
                                                <td class="text-center">
                                                    <sel-guess :data="{{json_encode([
                                                        'result' => $match->predictUser ? $match->predictUser->predict : '',
                                                        'urlAction' => route('predict.update', $match->id),
                                                        'disabled' => true
                                                    ])}}"></sel-guess>
                                                </td>
                                                <td class="text-center">
                                                    <sel-guess :data="{{json_encode([
                                                        'result' => $match->result,
                                                        'urlAction' => route('predict.update', $match->id),
                                                        'disabled' => true
                                                    ])}}"></sel-guess>
                                                </td>
                                                <td class="text-center">
                                                    {{ $match->country_2_name }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="group-paginate">
                                    {{ $matchs->appends(SearchQueryComponent::alterQuery($request))->links('pagination.admin') }}
                                </div>
                            @else
                                <data-empty></data-empty>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
