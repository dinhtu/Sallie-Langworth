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
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="searchFrom pull-right">
                                        <form action="{{ route('admin.user.index') }}" class="form-inline">
                                            {{-- <div>
                                                <input name="search_input" class="form-control" placeholder="検索"
                                                    value="{{ $request->search_input }}" autocomplete="off" type="control"
                                                    id="search_input">
                                                <button type="submit" class="btn btn-primary w-100"><i
                                                        class="fa fa-search"></i> &nbsp; 検索</button>
                                            </div> --}}
                                            <a href="{{ route('match.create') }}" class="btn btn-primary btn-action-create">
                                                <i class="fa fa-plus"></i>新規登録
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                                                @sortablelink('result', 'kết quả')
                                            </th>
                                            <th class="text-center">
                                                country
                                            </th>
                                            <th class="w-100">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($matchs as $match)
                                            <tr class="{{ Carbon::parse($match->match_day)->format('Y/m/d') == Carbon::now()->format('Y/m/d') ? 'row-success' : '' }}">
                                                <td>
                                                    {{ Carbon::parse($match->match_day)->format('Y/m/d H:i') }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $match->country_1_name }}
                                                </td>
                                                <td class="text-center">
                                                    @if (Carbon::now() > Carbon::parse($match->match_day))
                                                    <sel-guess :data="{{json_encode([
                                                        'result' => $match->result,
                                                        'urlAction' => route('match.update-guess', $match->id)
                                                    ])}}"></sel-guess>
                                                    @else
                                                    ---
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ $match->country_2_name }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" id="action" type="button" data-coreui-toggle="dropdown" aria-expanded="false">操作選択</button>
                                                        <ul class="dropdown-menu" aria-labelledby="action">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('match.edit', $match->id) }}"
                                                                    class="dropdown-item">
                                                                    <i class="fa fa-eye"></i>確認・編集
                                                                </a>
                                                            </li>
                                                            <li class="dropdown-divider"></li>
                                                            <li>
                                                                <btn-delete-confirm
                                                                    :message-confirm="{{ json_encode('このユーザーを削除しますか？') }}"
                                                                    :delete-action="{{ json_encode(route('match.destroy', $match->id)) }}">
                                                                </btn-delete-confirm>
                                                            </li>
                                                        </ul>
                                                    </div>
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
