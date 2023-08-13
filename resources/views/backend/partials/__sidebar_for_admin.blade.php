<li
    class="nav-item @if($commons['main_menu'] == 'report') menu-open @endif"
    class="nav-item"
>
    <a
        href="#"
        class="nav-link @if($commons['main_menu'] == 'report') active @endif"
    >
        <i class="nav-icon fas far fa-chart-bar"></i>
        <p>
            REPORTS
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li
            class="nav-item @if($commons['main_menu'] == 'report') menu-open @endif"
        >
             <a
                href="#"
                class="nav-link @if($commons['current_menu'] == 'Activity-report') active @endif"
            >
                <i class="fa fa-sticky-note" style="font-size: 15px"></i>
                <p>
                    <span class="badge badge-success">Monthly -></span>
                    Report
                </p>
            </a> 
        </li>


    </ul>
</li>

<li class="nav-header">Assignment Section</li>

<li class="nav-item @if($commons['main_menu'] == 'activity') menu-open @endif">
    <a
        href="{{ route('assignment.create')}}"
        class="nav-link @if($commons['current_menu'] == 'activity_create') active @endif"
    >
        <i class="nav-icon fas fa-plus"></i>
        <p> Add Assignment</p>
    </a>
</li>

<li class="nav-item @if($commons['main_menu'] == 'activity') menu-open @endif">
    <a
        href="{{ route('assignment.index')}}"
        class="nav-link @if($commons['current_menu'] == 'activity_index') active @endif"
    >
        <i class="nav-icon fas fa-list"></i>
        <p>List All Assignment</p>
    </a>
</li>

<li class="nav-header">Students Submitted Assignment</li>


<li class="nav-item @if($commons['main_menu'] == 'activity') menu-open @endif">
    <a
        href="{{ route('track.index')}}"
        class="nav-link @if($commons['current_menu'] == 'activity_create') active @endif"
    >
        <i class="nav-icon fas fa-list"></i>
        <p>Track Assignment</p>
    </a>
</li>


