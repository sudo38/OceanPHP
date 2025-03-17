<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
   <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
      <div class="offcanvas-body d-md-flex flex-column p-0 overflow-y-auto">
         <ul class="nav flex-column my-3">
         <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="{{ aurl('dashboard') }}" class="nav-link">
               <i class="fa-solid fa-chart-line"></i>
               {{ trans('admin.dashboard') }}
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="{{ aurl('posts') }}" class="nav-link">
               <i class="fa-regular fa-newspaper"></i>
               {{ trans('admin.posts') }}
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="{{ aurl('tags') }}">
               <i class="fa-solid fa-tags"></i>
               {{ trans('admin.tags') }}
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="{{ aurl('categories') }}">
               <i class="fa-solid fa-layer-group"></i>
               {{ trans('admin.categories') }}
            </a>
         </li>
         <hr>
         <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="{{ aurl('settings') }}" class="nav-link">
               <i class="fa-solid fa-gear"></i>
               {{ trans('admin.settings') }}
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="{{ aurl('logout') }}" class="nav-link">
               <i class="fa-solid fa-right-from-bracket"></i>
               {{ trans('admin.logout') }}
            </a>
         </li>
         </ul>
      </div>
   </div>
</div>