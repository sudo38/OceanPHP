<header class="navbar sticky-top flex-md-nowrap p-0" data-bs-theme="dark">
   <a class="circle" href="{{ aurl('profile') }}">
      {{ substr(auth(ADMIN)->name, 0, 1) }}
   </a>
   <ul class="nav">
      @if(session('locale') == 'ar')
         <li class="nav-item"><a href="{{ url('lang?lang=en') }}" class="nav-link">En</a></li>
      @else
         <li class="nav-item"><a href="{{ url('lang?lang=ar') }}" class="nav-link">ع</a></li>
      @endif
   </ul>
</header>
