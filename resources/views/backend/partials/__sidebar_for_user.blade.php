
<li class="nav-header">My Task Section</li>

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
