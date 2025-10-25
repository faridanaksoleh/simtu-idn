<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | TailAdmin</title>
    <link rel="stylesheet" href="{{ asset('tailadmin/css/style.css') }}">
    <script src="{{ asset('tailadmin/js/main.js') }}" defer></script>
  </head>


  <body
    x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    @include('partials.tailadmin.preloader')
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      @include('partials.tailadmin.sidebar')
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div
        class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
      >
        <!-- Small Device Overlay Start -->
        @include('partials.tailadmin.overlay')
        <!-- Small Device Overlay End -->

        <!-- ===== Header Start ===== -->
        @include('partials.tailadmin.header')
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            <div class="grid grid-cols-12 gap-4 md:gap-6">
              <div class="col-span-12 space-y-6 xl:col-span-7">
                <!-- Metric Group One -->
                @include('partials.tailadmin.metric-group.metric-group-01')
                <!-- Metric Group One -->

                <!-- ====== Chart One Start -->
                @include('partials.tailadmin.chart.chart-01')
                <!-- ====== Chart One End -->
              </div>
              <div class="col-span-12 xl:col-span-5">
                <!-- ====== Chart Two Start -->
                @include('partials.tailadmin.chart.chart-02')
                <!-- ====== Chart Two End -->
              </div>

              <div class="col-span-12">
                <!-- ====== Chart Three Start -->
                @include('partials.tailadmin.chart.chart-03')
                <!-- ====== Chart Three End -->
              </div>

              <div class="col-span-12 xl:col-span-5">
                <!-- ====== Map One Start -->
                @include('partials.tailadmin.map-01')
                <!-- ====== Map One End -->
              </div>

              <div class="col-span-12 xl:col-span-7">
                <!-- ====== Table One Start -->
                @include('partials.tailadmin.table.table-01')
                <!-- ====== Table One End -->
              </div>
            </div>
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
  </body>
