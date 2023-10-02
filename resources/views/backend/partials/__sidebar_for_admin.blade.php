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
                href="{{ route('report.index')}}"
                class="nav-link @if($commons['current_menu'] == 'Activity-report') active @endif"
            >
                <i class="fa fa-sticky-note" style="font-size: 15px"></i>
                <p>
                    <span class="badge badge-success">Task -></span>
                    Report
                </p>
            </a> 
        </li>


    </ul>
</li>

<!-- SBU SECTION -->
<li class="nav-header">SBU</li>

<li class="nav-item @if($commons['main_menu'] == 'activity') menu-open @endif">
    <a
        href=""
        class="nav-link @if($commons['current_menu'] == 'activity_create') active @endif"
    >
        <i class="nav-icon fas fa-plus"></i>
        <p> Add SBU</p>
    </a>
</li>

<li class="nav-item @if($commons['main_menu'] == 'activity') menu-open @endif">
    <a
        href="{{ route('sbu.index') }}"
        class="nav-link @if($commons['current_menu'] == 'activity_index') active @endif"
    >
        <i class="nav-icon fas fa-list"></i>
        <p>List</p>
    </a>
</li>

<!-- TASK CREATE SECTION -->

<li class="nav-item @if($commons['main_menu'] == 'trainer') menu-open @endif">
    <a
        href="#"
        class="nav-link @if($commons['main_menu'] == 'trainer') active @endif"
    >
        <i class="nav-icon fas fa-user-tie"></i>
        <p>
            Task
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a
                href="{{ route('task.create') }}"
                class="nav-link @if($commons['current_menu'] == 'trainer_create') active @endif"
            >
                <i class="fas fa-plus nav-icon"></i>
                <p>Add</p>
            </a>
        </li>
        <li class="nav-item">
            <a
                href="{{ route('task.index')}}"
                class="nav-link @if($commons['current_menu'] == 'trainer_index') active @endif"
            >
                <i class="fas fa-list nav-icon"></i>
                <p>List</p>
            </a>
        </li>
    </ul>
</li>





