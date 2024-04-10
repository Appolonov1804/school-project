<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">ПАНЕЛЬ АДМИНИСТРАТОРА</li>
          
          
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

          </li>
        </ul>
      </nav>