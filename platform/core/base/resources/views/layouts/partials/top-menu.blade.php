<div class="top-menu">
    <ul class="nav navbar-nav float-right">
        @auth
            <li class="dropdown">
                <form method="get" id="mt-quick-search-form">
                    <input type="text" class="mt-quick-search" id="mt-quick-search" name="quick_search" required value="{{request('order_ids')}}">
                </form>
                <script>
                    $('form#mt-quick-search-form').submit(function(e) {
                        e.preventDefault();
                        let ids = $('input#mt-quick-search').val();
                        let idsArr = ids.split(',');
                        if (idsArr.length > 1) {
                            window.location.href = "{{url('/admin/orders')}}" + '?order_ids=' + ids;
                        } else {
                            window.location.href = "{{url('/admin/orders/edit')}}" + '/' + ids;
                        }
                    });
                </script>
            </li>
            @if (BaseHelper::getAdminPrefix() != '')
                <li class="dropdown">
                    <a class="dropdown-toggle dropdown-header-name" style="padding-right: 10px" href="{{ url('/') }}"
                       target="_blank"><i class="fa fa-globe"></i> <span
                            @if (isset($themes) && setting('enable_change_admin_theme') != false) class="d-none d-sm-inline" @endif>{{ trans('core/base::layouts.view_website') }}</span>
                    </a>
                </li>
            @endif
            @if (Auth::check())
                {!! apply_filters(BASE_FILTER_TOP_HEADER_LAYOUT, null) !!}
            @endif

            @if (isset($themes) && setting('enable_change_admin_theme') != false)
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle dropdown-header-name" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <span>{{ trans('core/base::layouts.theme') }}</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right icons-right">

                        @foreach ($themes as $name => $file)
                            @if ($activeTheme === $name)
                                <li class="active"><a
                                        href="{{ route('admin.theme', [$name]) }}">{{ Str::studly($name) }}</a></li>
                            @else
                                <li><a href="{{ route('admin.theme', [$name]) }}">{{ Str::studly($name) }}</a></li>
                            @endif
                        @endforeach

                    </ul>
                </li>
            @endif


            <li class=" dropdown dropdown-user">
                @php
                    $notifications = get_user_notifications();
                @endphp
                <a href="javascript:void(0)" class="dropdown-toggle dropdown-header-name read_notification"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    {{--<img alt="{{ Auth::user()->getFullName() }}" class="rounded-circle" src="{{ Auth::user()->avatar_url }}" />--}}
                    <span class="username"><span class="badge badge-primary "
                                                 @if(!count($notifications)) hidden @endif>{{count($notifications->where('seen',0))}}</span> Notifications </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notifications-dropdown"
                     style="left: inherit; right: 0px; width:500px">
                    <span class="dropdown-item dropdown-header"><span id="notification-count"
                                                                      class="notification-count">{{count($notifications)}}</span> Notification(s)</span>
                    @if(count($notifications))
                        @foreach($notifications as $notification)
                            <div class="dropdown-divider "></div>
                            <a href="{{ $notification->notification->url }}"
                               class="dropdown-item d-flex notification_read new-notification {{($notification->seen == 0) ? 'notification-new' : ''}}"
                               style="white-space: normal" data-id="{{$notification->id}}">
                                <p style="width:73%; margin-right: 3px;"><i class="fas fa-volume-up mr-2"></i> {{ $notification->notification->message }}</p>
                                <p style="width:26%;"
                                    class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</p>
                            </a>
                        @endforeach
                    @endif
                </div>
            </li>

            <li class="dropdown dropdown-user">
                <a href="javascript:void(0)" class="dropdown-toggle dropdown-header-name" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    {{--<img alt="{{ Auth::user()->getFullName() }}" class="rounded-circle" src="{{ Auth::user()->avatar_url }}" />--}}
                    <span class="username"> {{ Auth::user()->getFullName() }} </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('users.profile.view', Auth::user()->getKey()) }}"><i
                                class="icon-user"></i> {{ trans('core/base::layouts.profile') }}</a></li>
                    <li><a href="{{ route('access.logout') }}" class="btn-logout"><i
                                class="icon-key"></i> {{ trans('core/base::layouts.logout') }}</a></li>
                </ul>
            </li>
        @endauth
    </ul>
</div>
