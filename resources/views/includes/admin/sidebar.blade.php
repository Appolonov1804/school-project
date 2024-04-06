<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">ПАНЕЛЬ АДМИНИСТРАТОРА</li>
          <li class="nav-item">
            <a href="calendar.html" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Календарь
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            @if(auth()->check())
            <a href="{{ route('admin.teacher.teacher') }}" class="nav-link">
              <i class="fa-solid fa-user"></i>
              <p>
                Учителя 

              </p>
            </a>
            @else 
            <a href="#" class="nav-link" onclick="alert('Пожалуйста, войдите в свой аккаунт.'); return false;">
              <i class="fa-solid fa-user"></i>
              <p>Учителя</p>
            </a>
            @endif 
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.roster.roster') }}" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Журналы
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
          </li>
         
          <li class="nav-item">
            <a href="{{ route('admin.report.report') }}" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Отчёты
                <i class="fas fa-angle-left right"></i>

              </p>
            </a>
          </li>

          </li>
        </ul>
      </nav>