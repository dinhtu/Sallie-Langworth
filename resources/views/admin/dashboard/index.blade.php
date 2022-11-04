@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="fade-in">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <label>Money</label>
            </div>
            <div class="card-body">
                <div class="mb-2 text-center" style="    font-size: 25px;
                color: red;
                font-weight: bold;
                display: flex;
                justify-content: center;">
                    Total Money:<count-up :end-val="{{ $totalMoney }}"></count-up>
                </div>
                <dashboard :data="{{ json_encode([
                    'userNames' => $userNames,
                    'money' => $money,
                    'totalMoney' => $totalMoney,
                ]) }}"></dashboard>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
