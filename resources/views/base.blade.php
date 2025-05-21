<!DOCTYPE html>
<html lang="en">

<head>
    <title>Navadarshana Education Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords"
        content="Navadarshana Education Portal.">
    <meta name="author" content="Cybernetics">
    <meta name="robots" content="index, follow">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, minimal-ui, viewport-fit=cover">
    <meta name="description"
        content="Navadarshana Education Portal">
    <meta property="og:title" content="Navadarshana Educations">
    <meta property="og:description"
        content="Navadarshana Education Portal">
    <meta property="og:image" content="">
    <meta name="format-detection" content="telephone=no">
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('/assets/images/favicon.png') }}">
    <link href="{{ asset('/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/vendor/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/select2/css/select2.min.css') }}">
    <link href="{{ asset('/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/vendor/summernote/summernote-bs5.css') }}" rel="stylesheet">
    @if(in_array(Route::current()->getName(), array('notes.create', 'notes.edit')))
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css" crossorigin>
    @endif
    <!-- Style css -->
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/css/mystyle.css') }}" rel="stylesheet">

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper" class="wallet-open">
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{ route('dashboard') }}" class="brand-logo">
                <img src="{{ asset('/assets/images/logo/nava-gold.png') }}" width="80%" />
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.2047 14.6015C15.3496 14.4598 15.4221 14.2941 15.4221 14.1042C15.4221 13.9143 15.3496 13.7485 15.2047 13.6069L11.577 9.97917L15.2256 6.35146C15.3705 6.20985 15.4386 6.04756 15.43 5.86458C15.4214 5.68161 15.3463 5.51932 15.2047 5.37771C15.0631 5.23611 14.8982 5.16531 14.7099 5.16531C14.5217 5.16531 14.3551 5.23611 14.2102 5.37771L10.106 9.48188C10.0299 9.55797 9.97548 9.63656 9.94272 9.71763C9.90995 9.7987 9.89357 9.88588 9.89357 9.97917C9.89357 10.0725 9.90995 10.1631 9.94272 10.2511C9.97548 10.3391 10.0299 10.4212 10.106 10.4973L14.231 14.6223C14.3759 14.7639 14.5399 14.8312 14.7228 14.8243C14.9058 14.8173 15.0664 14.7431 15.2047 14.6015ZM9.88905 14.6015C10.034 14.4598 10.1064 14.2941 10.1064 14.1042C10.1064 13.9143 10.034 13.7485 9.88905 13.6069L6.26134 9.97917L9.90989 6.35146C10.0548 6.20985 10.123 6.04756 10.1144 5.86458C10.1058 5.68161 10.0307 5.51932 9.88905 5.37771C9.74744 5.23611 9.58251 5.16531 9.39426 5.16531C9.20601 5.16531 9.03942 5.23611 8.89449 5.37771L4.79032 9.48188C4.71422 9.55797 4.6598 9.63656 4.62705 9.71763C4.59429 9.7987 4.57791 9.88588 4.57791 9.97917C4.57791 10.0725 4.59429 10.1631 4.62705 10.2511C4.6598 10.3391 4.71422 10.4212 4.79032 10.4973L8.91532 14.6223C9.06025 14.7639 9.2242 14.8312 9.40716 14.8243C9.59013 14.8173 9.75076 14.7431 9.88905 14.6015Z"
                                fill="var(--primary)" />
                        </svg>
                    </span>

                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Chat box start
        ***********************************-->
        <div class="chatbox" id="notBox">
            <div class="chatbox-close"></div>
            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#notes">Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#alerts">Alerts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#chat">Chat</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="chat">
                        <div class="card mb-sm-3 mb-md-0 contacts_card dz-chat-user-box">
                            <div class="card-header chat-list-header text-center">
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                            <rect fill="#000000" opacity="1.0"
                                                transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                                x="4" y="11" width="16" height="2" rx="1" />
                                        </g>
                                    </svg></a>
                                <div>
                                    <h6 class="mb-1">Chat List</h6>
                                    <p class="mb-0">Show All</p>
                                </div>
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="5" cy="12" r="2" />
                                            <circle fill="#000000" cx="12" cy="12" r="2" />
                                            <circle fill="#000000" cx="19" cy="12" r="2" />
                                        </g>
                                    </svg></a>
                            </div>
                            <div class="card-body contacts_body p-0 dz-scroll  " id="DZ_W_Contacts_Body">
                                <ul class="contacts">
                                    <li class="name-first-letter">A</li>
                                    <li class="active dz-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="{{ asset('/assets/images/avatar/1.jpg') }}" class="rounded-circle user_img" alt="">
                                                <span class="online_icon"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Archie Parker</span>
                                                <p>Kalid is online</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="alerts">
                        <div class="card mb-sm-3 mb-md-0 contacts_card">
                            <div class="card-header chat-list-header text-center">
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="5" cy="12" r="2" />
                                            <circle fill="#000000" cx="12" cy="12" r="2" />
                                            <circle fill="#000000" cx="19" cy="12" r="2" />
                                        </g>
                                    </svg></a>
                                <div>
                                    <h6 class="mb-1">Notications</h6>
                                    <p class="mb-0">Show All</p>
                                </div>
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="1" />
                                            <path
                                                d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg></a>
                            </div>
                            <div class="card-body contacts_body p-0 dz-scroll" id="DZ_W_Contacts_Body1">
                                <ul class="contacts">
                                    <li class="name-first-letter">SEVER STATUS</li>
                                    <li class="active">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont primary">KK</div>
                                            <div class="user_info">
                                                <span>David Nester Birthday</span>
                                                <p class="text-primary">Today</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="notes">
                        <div class="card mb-sm-3 mb-md-0 note_card">
                            <div class="card-header chat-list-header text-center">
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                                            <rect fill="#000000" opacity="1.0"
                                                transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                                x="4" y="11" width="16" height="2" rx="1" />
                                        </g>
                                    </svg></a>
                                <div>
                                    <h6 class="mb-1">Notes</h6>
                                    <p class="mb-0">Add New Nots</p>
                                </div>
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="1" />
                                            <path
                                                d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg></a>
                            </div>
                            <div class="card-body contacts_body p-0 dz-scroll" id="DZ_W_Contacts_Body2">
                                <ul class="contacts">
                                    <li class="active">
                                        <div class="d-flex bd-highlight">
                                            <div class="user_info">
                                                <span>New order placed..</span>
                                                <p>10 Aug 2020</p>
                                            </div>
                                            <div class="ms-auto">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-primary btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-xs sharp"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Chat box End
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <form>
                                <div class="input-group search-area">
                                    <span class="input-group-text"><button>
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.25 14.25C12.5637 14.25 15.25 11.5637 15.25 8.25C15.25 4.93629 12.5637 2.25 9.25 2.25C5.93629 2.25 3.25 4.93629 3.25 8.25C3.25 11.5637 5.93629 14.25 9.25 14.25Z"
                                                    stroke="#6F767E" stroke-width="1.75" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M16.75 15.75L13.4875 12.4875" stroke="#6F767E"
                                                    stroke-width="1.75" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </button></span>
                                    <input type="text" class="form-control" placeholder="Search">
                                </div>
                            </form>
                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                        fill="none">
                                        <path
                                            d="M5.05384 11.75C4.58544 11.75 4.18446 11.5832 3.85091 11.2495C3.51736 10.9159 3.35059 10.5129 3.35059 10.0407V5.05379C3.35059 4.58376 3.51736 4.18138 3.85091 3.84664C4.18446 3.51191 4.58544 3.34454 5.05384 3.34454H10.0468C10.5152 3.34454 10.9161 3.51191 11.2497 3.84664C11.5833 4.18138 11.75 4.58376 11.75 5.05379V10.0407C11.75 10.5129 11.5833 10.9159 11.2497 11.2495C10.9161 11.5832 10.5152 11.75 10.0468 11.75H5.05384ZM5.05384 21.6494C4.58544 21.6494 4.18446 21.4827 3.85091 21.1491C3.51736 20.8156 3.35059 20.4146 3.35059 19.9462V14.9533C3.35059 14.4849 3.51736 14.0839 3.85091 13.7503C4.18446 13.4168 4.58544 13.25 5.05384 13.25H10.0468C10.5152 13.25 10.9161 13.4168 11.2497 13.7503C11.5833 14.0839 11.75 14.4849 11.75 14.9533V19.9462C11.75 20.4146 11.5833 20.8156 11.2497 21.1491C10.9161 21.4827 10.5152 21.6494 10.0468 21.6494H5.05384ZM14.9593 11.75C14.4871 11.75 14.0842 11.5832 13.7505 11.2495C13.4169 10.9159 13.25 10.5129 13.25 10.0407V5.05379C13.25 4.58376 13.4169 4.18138 13.7505 3.84664C14.0842 3.51191 14.4871 3.34454 14.9593 3.34454H19.9462C20.4163 3.34454 20.8186 3.51191 21.1534 3.84664C21.4881 4.18138 21.6555 4.58376 21.6555 5.05379V10.0407C21.6555 10.5129 21.4881 10.9159 21.1534 11.2495C20.8186 11.5832 20.4163 11.75 19.9462 11.75H14.9593ZM14.9593 21.6494C14.4871 21.6494 14.0842 21.4827 13.7505 21.1491C13.4169 20.8156 13.25 20.4146 13.25 19.9462V14.9533C13.25 14.4849 13.4169 14.0839 13.7505 13.7503C14.0842 13.4168 14.4871 13.25 14.9593 13.25H19.9462C20.4163 13.25 20.8186 13.4168 21.1534 13.7503C21.4881 14.0839 21.6555 14.4849 21.6555 14.9533V19.9462C21.6555 20.4146 21.4881 20.8156 21.1534 21.1491C20.8186 21.4827 20.4163 21.6494 19.9462 21.6494H14.9593ZM5.05384 10.0407H10.0468V5.05379H5.05384V10.0407ZM14.9593 10.0407H19.9462V5.05379H14.9593V10.0407ZM14.9593 19.9462H19.9462V14.9533H14.9593V19.9462ZM5.05384 19.9462H10.0468V14.9533H5.05384V19.9462Z"
                                            fill="black" />
                                    </svg>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div id="DZ_W_Notification1" class="widget-media dz-scroll">
                                        <div class="card ms-3">
                                            <div class="card-header">
                                                <div class="clearfix">
                                                    <h4 class="card-title mb-0">Switch Branch</h4>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @forelse(branches()->where('id', '!=', Session::get('branch')) as $key => $branch)
                                                <div class="d-flex align-items-center border-bottom py-3">
                                                    <div class="avatar avatar-md rounded d-flex align-items-center justify-content-center bg-white">
                                                        <img src="{{ asset('/assets/images/blue-tick.png') }}" alt="">
                                                    </div>
                                                    <div class="clearfix ms-2">
                                                        <h6 class="mb-0 fw-semibold"><a href="{{ route('switch.branch', encrypt($branch->id)) }}">{{ $branch->name }}</a></h6>
                                                        <span class="fs-13">Switch to this branch</span>
                                                    </div>
                                                </div>
                                                @empty
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell-link" href="javascript:void(0);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                        fill="none">
                                        <path
                                            d="M7.25004 14.525H13.575C13.7875 14.525 13.9657 14.4527 14.1094 14.3081C14.2532 14.1635 14.325 13.9844 14.325 13.7706C14.325 13.5569 14.2532 13.3792 14.1094 13.2375C13.9657 13.0958 13.7875 13.025 13.575 13.025H7.25004C7.03754 13.025 6.85941 13.0973 6.71566 13.2419C6.57191 13.3865 6.50004 13.5656 6.50004 13.7794C6.50004 13.9931 6.57191 14.1708 6.71566 14.3125C6.85941 14.4542 7.03754 14.525 7.25004 14.525ZM7.25004 11.275H17.75C17.9625 11.275 18.1407 11.2027 18.2844 11.0581C18.4282 10.9135 18.5 10.7344 18.5 10.5206C18.5 10.3069 18.4282 10.1292 18.2844 9.98749C18.1407 9.84583 17.9625 9.77499 17.75 9.77499H7.25004C7.03754 9.77499 6.85941 9.84729 6.71566 9.99187C6.57191 10.1365 6.50004 10.3156 6.50004 10.5294C6.50004 10.7431 6.57191 10.9208 6.71566 11.0625C6.85941 11.2042 7.03754 11.275 7.25004 11.275ZM7.25004 8.02499H17.75C17.9625 8.02499 18.1407 7.9527 18.2844 7.80812C18.4282 7.66352 18.5 7.48435 18.5 7.27062C18.5 7.05687 18.4282 6.87916 18.2844 6.73749C18.1407 6.59583 17.9625 6.52499 17.75 6.52499H7.25004C7.03754 6.52499 6.85941 6.59729 6.71566 6.74187C6.57191 6.88647 6.50004 7.06564 6.50004 7.27937C6.50004 7.49312 6.57191 7.67083 6.71566 7.81249C6.85941 7.95416 7.03754 8.02499 7.25004 8.02499ZM6.35059 18.6494L3.80494 21.1951C3.53572 21.4643 3.22603 21.5264 2.87586 21.3813C2.52568 21.2363 2.35059 20.9773 2.35059 20.6043V4.05379C2.35059 3.59218 2.51946 3.1919 2.85721 2.85297C3.19498 2.51402 3.59385 2.34454 4.05384 2.34454H20.9462C21.4079 2.34454 21.8081 2.51402 22.1471 2.85297C22.486 3.1919 22.6555 3.59218 22.6555 4.05379V16.9462C22.6555 17.4062 22.486 17.8051 22.1471 18.1428C21.8081 18.4806 21.4079 18.6494 20.9462 18.6494H6.35059ZM4.05384 16.9462H20.9462V4.05379H4.05384V16.9462Z"
                                            fill="black" />
                                    </svg>
                                </a>
                            </li>
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link dz-fullscreen" href="javascript:void(0);">
                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.56896 18.5C1.26722 18.5 1.01362 18.3973 0.808174 18.1918C0.602725 17.9864 0.5 17.7328 0.5 17.431V13.1751C0.5 12.8734 0.603248 12.6198 0.809743 12.4143C1.01624 12.2089 1.27114 12.1062 1.57445 12.1062C1.87774 12.1062 2.1308 12.2089 2.33364 12.4143C2.53647 12.6198 2.63789 12.8734 2.63789 13.1751V16.3621H5.8249C6.12664 16.3621 6.38024 16.4654 6.58569 16.6719C6.79111 16.8784 6.89383 17.1333 6.89383 17.4366C6.89383 17.7399 6.79111 17.9929 6.58569 18.1957C6.38024 18.3986 6.12664 18.5 5.8249 18.5H1.56896ZM1.56344 6.90133C1.26015 6.90133 1.00709 6.79861 0.804251 6.59319C0.601417 6.38774 0.5 6.13414 0.5 5.8324V1.57646C0.5 1.27472 0.602725 1.01987 0.808174 0.811908C1.01362 0.603969 1.26722 0.5 1.56896 0.5H5.8249C6.12664 0.5 6.38024 0.604504 6.58569 0.813509C6.79111 1.02249 6.89383 1.27864 6.89383 1.58195C6.89383 1.88524 6.79111 2.1383 6.58569 2.34114C6.38024 2.54397 6.12664 2.64539 5.8249 2.64539H2.63789V5.8324C2.63789 6.13414 2.53464 6.38774 2.32814 6.59319C2.12165 6.79861 1.86675 6.90133 1.56344 6.90133ZM13.1676 18.5C12.8659 18.5 12.6123 18.3968 12.4068 18.1903C12.2014 17.9838 12.0987 17.7289 12.0987 17.4256C12.0987 17.1223 12.2014 16.8692 12.4068 16.6664C12.6123 16.4635 12.8659 16.3621 13.1676 16.3621H16.3546V13.1751C16.3546 12.8734 16.4579 12.6198 16.6644 12.4143C16.8709 12.2089 17.1258 12.1062 17.4291 12.1062C17.7324 12.1062 17.9867 12.2089 18.192 12.4143C18.3973 12.6198 18.5 12.8734 18.5 13.1751V17.431C18.5 17.7328 18.396 17.9864 18.1881 18.1918C17.9801 18.3973 17.7253 18.5 17.4235 18.5H13.1676ZM17.4181 6.90133C17.1148 6.90133 16.8617 6.79861 16.6589 6.59319C16.456 6.38774 16.3546 6.13414 16.3546 5.8324V2.64539H13.1676C12.8659 2.64539 12.6123 2.54214 12.4068 2.33564C12.2014 2.12915 12.0987 1.87424 12.0987 1.57093C12.0987 1.26765 12.2014 1.01333 12.4068 0.807986C12.6123 0.602662 12.8659 0.5 13.1676 0.5H17.4235C17.7253 0.5 17.9801 0.603969 18.1881 0.811908C18.396 1.01987 18.5 1.27472 18.5 1.57646V5.8324C18.5 6.13414 18.3955 6.38774 18.1865 6.59319C17.9775 6.79861 17.7214 6.90133 17.4181 6.90133Z"
                                            fill="black" />
                                    </svg>
                                </a>
                            </li>
                            <li class="nav-item ps-3">
                                <div class="dropdown header-profile2">
                                    <a class="nav-link p-0" href="javascript:void(0);" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="header-info2 d-flex align-items-center">
                                            <div class="header-media">
                                                <img src="{{ asset('/assets/images/avatar.png') }}" alt="">
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <div class="card border-0 mb-0">
                                            <div class="card-header py-2">
                                                <div class="products">
                                                    <img src="{{ asset('/assets/images/avatar.png') }}" class="avatar avatar-md" alt="">
                                                    <div>
                                                        <h6>{{ Auth::user()->name }}</h6>
                                                        <span>{{ Auth::user()->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body px-0 py-2">
                                                <a href="{{ route('user.edit', encrypt(Auth::user()->id)) }}" class="dropdown-item ai-icon ">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M11.9848 15.3462C8.11714 15.3462 4.81429 15.931 4.81429 18.2729C4.81429 20.6148 8.09619 21.2205 11.9848 21.2205C15.8524 21.2205 19.1543 20.6348 19.1543 18.2938C19.1543 15.9529 15.8733 15.3462 11.9848 15.3462Z"
                                                            stroke="var(--primary)" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M11.9848 12.0059C14.5229 12.0059 16.58 9.94779 16.58 7.40969C16.58 4.8716 14.5229 2.81445 11.9848 2.81445C9.44667 2.81445 7.38857 4.8716 7.38857 7.40969C7.38 9.93922 9.42381 11.9973 11.9524 12.0059H11.9848Z"
                                                            stroke="var(--primary)" stroke-width="1.42857"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <span class="ms-2">Profile </span>
                                                </a>
                                            </div>
                                            <div class="card-footer px-0 py-2">
                                                <a href="{{ route('dashboard') }}" class="dropdown-item ai-icon ">
                                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M20.8066 7.62355L20.1842 6.54346C19.6576 5.62954 18.4907 5.31426 17.5755 5.83866V5.83866C17.1399 6.09528 16.6201 6.16809 16.1307 6.04103C15.6413 5.91396 15.2226 5.59746 14.9668 5.16131C14.8023 4.88409 14.7139 4.56833 14.7105 4.24598V4.24598C14.7254 3.72916 14.5304 3.22834 14.17 2.85761C13.8096 2.48688 13.3145 2.2778 12.7975 2.27802H11.5435C11.0369 2.27801 10.5513 2.47985 10.194 2.83888C9.83666 3.19791 9.63714 3.68453 9.63958 4.19106V4.19106C9.62457 5.23686 8.77245 6.07675 7.72654 6.07664C7.40418 6.07329 7.08843 5.98488 6.8112 5.82035V5.82035C5.89603 5.29595 4.72908 5.61123 4.20251 6.52516L3.53432 7.62355C3.00838 8.53633 3.31937 9.70255 4.22997 10.2322V10.2322C4.82187 10.574 5.1865 11.2055 5.1865 11.889C5.1865 12.5725 4.82187 13.204 4.22997 13.5457V13.5457C3.32053 14.0719 3.0092 15.2353 3.53432 16.1453V16.1453L4.16589 17.2345C4.41262 17.6797 4.82657 18.0082 5.31616 18.1474C5.80575 18.2865 6.33061 18.2248 6.77459 17.976V17.976C7.21105 17.7213 7.73116 17.6515 8.21931 17.7821C8.70746 17.9128 9.12321 18.233 9.37413 18.6716C9.53867 18.9488 9.62708 19.2646 9.63043 19.5869V19.5869C9.63043 20.6435 10.4869 21.5 11.5435 21.5H12.7975C13.8505 21.5 14.7055 20.6491 14.7105 19.5961V19.5961C14.7081 19.088 14.9088 18.6 15.2681 18.2407C15.6274 17.8814 16.1154 17.6806 16.6236 17.6831C16.9451 17.6917 17.2596 17.7797 17.5389 17.9393V17.9393C18.4517 18.4653 19.6179 18.1543 20.1476 17.2437V17.2437L20.8066 16.1453C21.0617 15.7074 21.1317 15.1859 21.0012 14.6963C20.8706 14.2067 20.5502 13.7893 20.111 13.5366V13.5366C19.6717 13.2839 19.3514 12.8665 19.2208 12.3769C19.0902 11.8872 19.1602 11.3658 19.4153 10.9279C19.5812 10.6383 19.8213 10.3981 20.111 10.2322V10.2322C21.0161 9.70283 21.3264 8.54343 20.8066 7.63271V7.63271V7.62355Z"
                                                            stroke="var(--primary)" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <circle cx="12.175" cy="11.889" r="2.63616"
                                                            stroke="var(--primary)" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>

                                                    <span class="ms-2">Settings </span>
                                                </a>
                                                <a href="{{ route('logout') }}" class="dropdown-item ai-icon text-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 24 24" fill="none" stroke="#E55555"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                                        <polyline points="16 17 21 12 16 7"></polyline>
                                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                                    </svg>
                                                    <span class="ms-2">Logout </span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
        @if(Auth::user()->roles->first()->name == 'Student')
        @include("nav-student")
        @else
        @include("nav")
        @endif

        @yield("content")
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © {{ date('Y') }} Navadarshana Educations Pvt. Ltd. Developed & Maintained by <a href="https://cybernetics.me/" target="_blank">Cybernetics Tech.</a> </p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('/assets/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    @if(in_array(Route::current()->getName(), array('dashboard.student', 'dashboard.finance', 'dashboard.student.all', 'dashboard.finance.all')))
    <script src="{{ asset('/assets/vendor/apexchart/apexchart.js') }}"></script>
    <script src="{{ asset('/assets/vendor/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('/assets/js/chart.js') }}"></script>
    @endif
    @if(in_array(Route::current()->getName(), array('dashboard')))
    <script>
        $(function() {
            $("#branchSelector").modal('show');
        })
    </script>
    @endif
    <!-- Dashboard 1 -->

    <script src="{{ asset('/assets/vendor/draggable/draggable.js') }}"></script>
    <script src="{{ asset('/assets/vendor/swiper/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins-init/datatables.init.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/js/plugins-init/select2-init.js') }}"></script>
    @if(in_array(Route::current()->getName(), array('notes.create', 'notes.edit')))
    <script src="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.umd.js" crossorigin></script>
    <script src="{{ asset('/assets/ckeditor5/main.js') }}"></script>
    @endif
    <script src="{{ asset('/assets/js/custom.js') }}"></script>
    <script src="{{ asset('/assets/js/deznav-init.js') }}"></script>
    <script src="{{ asset('/assets/js/script.js') }}"></script>
    @include("message")
</body>

</html>