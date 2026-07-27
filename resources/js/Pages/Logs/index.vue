<template>

  <AuthenticatedLayout :translations="translations">


    <!-- breadcrumb-->
    <div class="pagetitle">
      <h1>   {{ translations.logs }} </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <Link class="nav-link" :href="route('dashboard')">
              {{ translations.Home }} 
            </Link>
          </li>
          <li class="breadcrumb-item active">   {{ translations.logs }} </li>
        </ol>
      </nav>
    </div>
    <!-- End breadcrumb-->

    <section class="section dashboard">
      <div class="card bordered">

        <div class="card-header">
          <div class="d-flex">

          </div>
        </div>
        <div class="card-body">

          <form @submit.prevent="Filter">
            <div class="row filter_form">
              <div class="col-md-3">
                <div class="position-relative">
                  <select class="form-select" aria-label="Default select example" v-model="filterForm.module">
                    <option value="" selected disabled>  {{ translations.module }}  </option>
                    <option v-for="module in modules" :key="module.id" :value="module">{{ translations['module_' + module] || module }}</option>
                  </select>
                  <i class="bi bi-chevron-down select-chevron-icon"></i>
                </div>
              </div>
              <div class="col-md-3">
                <div class="position-relative">
                  <select class="form-select" aria-label="Default select example" v-model="filterForm.action">
                    <option value="" selected disabled> {{ translations.action }} </option>
                    <option v-for="action in actions" :key="action.id" :value="action">{{ translations['action_' + action] || action }}</option>
                  </select>
                  <i class="bi bi-chevron-down select-chevron-icon"></i>
                </div>
              </div>
              <div class="col-md-3">
                <div class="position-relative">
                  <select class="form-select" aria-label="Default select example" v-model="filterForm.by_user_id">
                    <option value="" selected disabled>  {{ translations.by }} </option>
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                  </select>
                  <i class="bi bi-chevron-down select-chevron-icon"></i>
                </div>
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-primary">  {{ translations.search }}  &nbsp; <i class="bi bi-search"></i> </button>
              </div>
            </div>

          </form>

          <div class="table-responsive">
            <table class="table text-center">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col"> {{ translations.by }} </th>
                  <th scope="col"> {{ translations.module }} </th>
                  <th scope="col"> {{ translations.action }}</th>
                  <th scope="col"> {{ translations.at  }}</th>
                  <th scope="col">{{ translations.details  }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(log, index)   in logs.data" :key="log.id">
                  <th scope="row">{{ getRowNumber(index) }}</th>
                  <td>{{ log.user ? log.user.name : translations['auto'] }}</td>
                  <td>{{ translations['module_' + log.module_name] || log.module_name }}</td>
                  <td>
                    <span :class="['badge', 'bg-' + log.badge]"> {{ translations['action_' + log.action] || log.action }}</span>
                  </td>
                  <td>{{ log.created_at }}</td>
                  <td>
                    <a class="btn btn-primary" :href="route('logs.view', { log: log.id })">
                      <i class="bi bi-eye"></i>
                    </a>
                  </td>

                </tr>

              </tbody>
            </table>

          </div>
        </div>


      </div>
      <Pagination :links="logs.links" />
    </section>

  </AuthenticatedLayout>
</template>



<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link,usePage } from '@inertiajs/vue3'
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
const page = usePage()

const props = defineProps({ logs: Object, users: Object, modules: Array, actions: Array,translations:Array })

// Function to calculate row number based on current page
const getRowNumber = (index) => {
  const currentPage = props.logs.current_page || 1;
  const perPage = props.logs.per_page || 10;
  return (currentPage - 1) * perPage + index + 1;
};

const filterForm = reactive({
  module: '',
  action: '',
  by_user_id: '',
})

const Filter = () => {
  router.get(
    route('logs'),
    filterForm,
    { preserveState: true, preserveScroll: true },
  )
}
const hasPermission = (permission) => {
  return page.props.auth_permissions.includes(permission);
}

const Delete = (id) => {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete('users/' + id, {
        onSuccess: () => {
          Swal.fire(
            'Deleted!',
            'Your item has been deleted.',
            'success'
          );
        },
        onError: () => {
          Swal.fire(
            'Error!',
            'There was an issue deleting the item.',
            'error'
          );
        }
      });
    }
  });
}

</script>