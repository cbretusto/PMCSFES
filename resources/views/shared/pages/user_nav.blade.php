<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{ asset('public/images/pricon_logo2.png') }}"
         alt="PMCSFES"
         class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">PMCSFES v2</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ url('../RapidX') }}" class="nav-link">
            <i class="nav-icon fas fa-arrow-left"></i>
            <p>
              Return to RapidX
            </p>
          </a>
        </li>

        <li class="nav-header font-weight-bold mt-3"><i class="fas fa-cogs"></i>&nbsp;PMCSFES MODULE</li>
        <li class="nav-item has-treeview userList d-none">
            <a href="{{ route('user_list') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>User List</p>
            </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="{{ route('PMCSFES_template') }}" class="nav-link">
            <i class="nav-icon fa fa-file-code"></i>
            <p>Checklist Template</p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="{{ route('pmcsfes_equipment') }}" class="nav-link">
              <i class="nav-icon fa fa-sitemap"></i>
              <p>Equipment Module</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>