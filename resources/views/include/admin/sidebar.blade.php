@php
    use Illuminate\Support\Facades\Auth;
@endphp
<div class="sidebar sidebar-dark sidebar-fixed sidebar-lg-show" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img class="sidebar-brand-full" src="{{ url('images/logo.png') }}" width="55" height="46">
        <img class="sidebar-brand-narrow" src="{{ url('images/logo.png') }}" width="55" height="46">
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset">
                    <div class="simplebar-content-wrapper">
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                                    <i class="nav-icon fa fa-home" aria-hidden="true"></i>
                                    Dashboard
                                </a>
                            </li>
                        </div>
                    </div>
                    @if (Auth::guard('admin')->user()->type == 1)
                    <div class="simplebar-content-wrapper">
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.user.index') }}">
                                    <i class="nav-icon fa fa-user" aria-hidden="true"></i>
                                    ユーザー一覧
                                </a>
                            </li>
                        </div>
                    </div>
                    <div class="simplebar-content-wrapper">
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('match.index') }}">
                                    <i class="nav-icon fa fa-futbol-o" aria-hidden="true"></i>
                                    Match
                                </a>
                            </li>
                        </div>
                    </div>
                    @else
                    <div class="simplebar-content-wrapper">
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('predict.index') }}">
                                    <i class="nav-icon fa fa-futbol-o" aria-hidden="true"></i>
                                    Dự đoán
                                </a>
                            </li>
                        </div>
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('result') }}">
                                    <i class="nav-icon fa fa-money" aria-hidden="true"></i>
                                    Kết quả
                                </a>
                            </li>
                        </div>
                        <div class="simplebar-content">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('change-password.index') }}">
                                    <i class="nav-icon fa fa-key" aria-hidden="true"></i>
                                    Change Password
                                </a>
                            </li>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            {{-- <div class="simplebar-placeholder" style="width: auto; height: 841px;"></div> --}}
        {{-- </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar"
                style="height: 93px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
        </div> --}}
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
