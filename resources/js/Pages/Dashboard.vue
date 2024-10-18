<template>
  <AuthenticatedLayout :translations="translations">
    <!-- breadcrumb-->
    <div class="pagetitle">
      <h1>{{ translations.dashboard }}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <Link class="nav-link" :href="route('dashboard')">
            {{ translations.Home }}
            </Link>
          </li>
        </ol>
      </nav>
    </div>
    <!-- End breadcrumb-->
    <section class="section dashboard">




      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <!-- Users Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">
                    {{ translations.users }}
                    <!-- <span>| This Year</span> -->
                  </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ userCount }}</h6>
                      <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Customers Card -->

            <!-- Products Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">
                    {{ translations.products }}
                    <!-- <span>| Today</span> -->
                  </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>145</h6>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Products Card -->

            <!-- Rules Card -->
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">
                    {{ translations.roles }}
                    <!-- <span>| This Month</span> -->
                  </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-lock"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ rolesCount }}</h6>
                      <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Rules Card -->
          </div>
        </div>
        <!-- End Left side columns -->
      </div>


      <div class="col-12">
        <div class="card">

          <div class="card-body">
            <h5 class="card-title">{{ translations.statistics }} </h5>


            <div class="row canv_row">
              <div class="col-md-6">
                <h1>{{ translations.users_by_role }} </h1>
                <Chart :chartData="UserPerRolechartData" chartId="chart" chartType="bar" />

              </div>
              <div class="col-md-6">
                <h2>{{ translations.users_by_status }} </h2>
                <Chart :chartData="statusChartData" chartId="statusChart" chartType="pie" />
              </div>
            </div>


      <div class="row canv_row">
        <div class="col-md-6">
          <h2>{{ translations.logs_by_module }} </h2>
          <Chart :chartData="modulesChartData" chartId="modulesChart" chartType="bar" />
        </div>
        <div class="col-md-6">
          <h2>{{ translations.logs_by_user }} </h2>
          <Chart :chartData="usersChartData" chartId="usersChar" chartType="bar" />
        </div>
      </div>


        <div class="row canv_row">
          <div class="col-md-6">
            <h2>{{ translations.logs_by_action}} </h2>
            <Chart :chartData="actionsChartData" chartId="actionsChart" chartType="pie" />
          </div>
        </div>
      </div>

          </div>

        </div>





    </section>
  </AuthenticatedLayout>
</template>


<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Chart from '@/Components/Chart.vue';

defineProps({
  userCount: Number,
  rolesCount: Number,
  translations: Array,
  UserPerRolechartData: Object,
  actionsChartData: Object,
  modulesChartData: Object,
  usersChartData: Object,
  statusChartData: Object,
});
</script>
