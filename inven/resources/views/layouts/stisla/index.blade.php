@include('layouts.stisla.header')

<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ...existing head content... -->
    @stack('css')
    <style>
        .modal { overflow-y: auto !important }
        .modal-backdrop { z-index: 1040 !important; }
        .modal-dialog { z-index: 1050 !important; }
        .modal-content { z-index: 1051 !important; }
        .select2-dropdown { z-index: 1052 !important; }
        
        body.modal-open {
            overflow: hidden;
            padding-right: 0 !important;
        }
    </style>
    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- ...existing scripts... -->
    @endpush
</head>
<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        @include('layouts.stisla.navbar')

        @include('layouts.stisla.sidebar')
        <!-- Main Content -->
        <div class="main-content">
          <section class="section">
            <div class="section-header">
              <h1>{{ $page_heading ?? $title ?? 'Dashboard' }}</h1>
            </div>

            @yield('content')
          </section>
        </div>
        @include('layouts.stisla.footer')
    </div>
  </div>
  
  <!-- Move modal container here, outside main-wrapper -->
  @yield('modal')
  
  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @stack('scripts')
  @stack('js')
</body>
</html>