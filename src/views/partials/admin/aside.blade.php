<aside id="app-aside" data-simplebar>
    <nav>
        <ul class="list-unstyled mb-0 mh-100 accordion">
            @foreach(app('nav')->backend() as $nav)
                <li id="submenu-heading-{{ $loop->iteration }}"
                    class="nav-item{{ app('router')->currentRouteNamed($nav->compare) ? ' is-active' : '' }}">
                    @isset($nav->unread)
                        <div class="unread">{{ $nav->unread }}</div>
                    @endisset
                    <a href="{!! route($nav->route) !!}" class="d-flex align-items-center">
                        <i class="nav-icon i-{{ $nav['icon'] }} mr-3"></i>
                        {{ $nav['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>
