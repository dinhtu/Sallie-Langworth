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
                <dashboard :data="{{ json_encode([
                    'userNames' => $userNames,
                    'money' => $money,
                ]) }}"></dashboard>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
