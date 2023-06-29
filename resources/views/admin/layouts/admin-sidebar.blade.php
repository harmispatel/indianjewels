<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('admin.dashboard') }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#catalogue-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Catelogue</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="catalogue-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('tags')}}">
                        <i class="bi bi-circle"></i><span>Tags</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories') }}">
                        <i class="bi bi-circle"></i><span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sliders') }}">
                        <i class="bi bi-circle"></i><span>Sliders</span>
                    </a>
                </li> 
                    <li>  
                    <a href="{{ route('designs') }}">
                        <i class="bi bi-circle"></i><span>Designs</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-circle"></i><span>Data Tables</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
  </aside>
