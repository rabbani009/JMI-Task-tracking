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
                class="nav-link @if($commons['current_menu'] == 'page_report') active @endif"
            >
                <i class="nav-icon fas fa-copy" style="font-size: 15px"></i>
                <p>
                    All Report
                </p>
            </a> 
        </li>


    </ul>
</li>

<!-- SBU SECTION -->
<li class="nav-header">SBU Section</li>

<li class="nav-item @if($commons['main_menu'] == 'sbu_create') menu-open @endif">
    <a
        href="{{ route('sbu.create') }}"
        class="nav-link @if($commons['current_menu'] == 'create_sbu') active @endif"
    >
        <i class="nav-icon far fa-plus-square"></i>
        <p> Add SBU</p>
    </a>
</li>

<li class="nav-item @if($commons['main_menu'] == 'sbu') menu-open @endif">
    <a
        href="{{ route('sbu.index') }}"
        class="nav-link @if($commons['current_menu'] == 'page_sbu') active @endif"
    >
        <i class="nav-icon fas fa-list"></i>
        <p>All List</p>
    </a>
</li>

<!-- TASK CREATE SECTION -->

<li class="nav-item @if($commons['main_menu'] == 'main_task') menu-open @endif">
    <a
        href="#"
        class="nav-link @if($commons['main_menu'] == 'main_task') active @endif"
    >
        <i class="nav-icon fas fa-user-tie"></i>
        <p>
            Task Section
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a
                href="{{ route('task.create') }}"
                class="nav-link @if($commons['current_menu'] == 'task_create') active @endif"
            >
                <i class="nav-icon far fa-plus-square"></i>
                <p>Add</p>
            </a>
        </li>
        <li class="nav-item">
            <a
                href="{{ route('task.index')}}"
                class="nav-link @if($commons['current_menu'] == 'task_all') active @endif"
            >
                <i class="fas fa-list nav-icon"></i>
                <p>All List</p>
            </a>
        </li>
    </ul>
</li>





