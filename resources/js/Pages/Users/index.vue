<template>

  <AuthenticatedLayout :translations="translations" >
    <!-- breadcrumb-->
    <div class="pagetitle">
      <h1>{{ translations.users }}</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <Link class="nav-link" :href="route('dashboard')">
            {{ translations.Home }} 
            </Link>
          </li>
          <li class="breadcrumb-item active">{{ translations.users }} </li>

        </ol>
      </nav>
    </div>
    <!-- End breadcrumb-->

    <section class="section dashboard">
      <div class="card">

        <div class="card-body">

          <form @submit.prevent="Filter">
            <div class="row filter_form">
              <div class="col-md-3">
                <input type="text" class="form-control search_box" v-model="filterForm.name" :placeholder="translations.name"   /> 
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control search_box" v-model="filterForm.email" :placeholder="translations.email" />
              </div>
              <div class="col-md-2">
                <select class="form-select" aria-label="Default select example" v-model="filterForm.is_active">
                  <option value="" selected disabled> {{ translations.status }}</option>
                  <option :value="1">{{ translations.active }}</option>
                  <option :value="0">{{ translations.not_active }} </option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary">{{ translations.search }}  &nbsp; <i class="bi bi-search"></i> </button>
              </div>
              <div class="col-md-2">
                <Link class="btn btn-primary ms-auto" :href="route('users.create')">{{ translations.create }}  &nbsp; <i
                  class="bi bi-plus-circle"> </i></Link>
              </div>
            </div>

          </form>


          <div class="table-responsive">
            <table class="table text-center">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col"> {{ translations.name }}</th>
                  <th scope="col"> {{ translations.avatar }}</th>
                  <th scope="col"> {{ translations.role }}</th>
                  <th scope="col"> {{ translations.email }}</th>
                  <th scope="col"> {{ translations.created_at }}</th>
                  <th scope="col"> {{ translations.status }}</th>
                  <th scope="col">{{ translations.edit }}</th>
                  <th scope="col">{{ translations.delete }}</th>
                </tr>
              </thead>
              <tbody class=" text-center">
                <tr v-for="(user, index)   in users.data" :key="user.id">
                  <th scope="row">{{ index + 1 }}</th>
                  <td>{{ user.name }}</td>
                  <td>
                    <img :src="user.avatar" alt="Avatar" class="avatar" width="45px"  />
                  </td>
                  <td>
                    <span v-for="role in user.roles" :key="role.id" class="badge bg-secondary">
                      {{ role.name }}
                    </span>
                  </td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.created_at }}</td>
                  <td>

                    <div>
                      <label class="inline-flex items-center me-5 cursor-pointer">
                        <input type="checkbox" class="sr-only peer" :checked="user.is_active"
                          @change="Activate(user.id)">
                        <div
                          class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                        </div>
                      </label>
                    </div>
                  </td>
                  <td>
                    <a class="btn btn-primary" :href="route('users.edit', { user: user.id })">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                  </td>
                  <td>

                    <button type="button" class="btn btn-danger" @click="Delete(user.id)">
                      <i class="bi bi-trash"></i>
                    </button>

                  </td>
                </tr>

              </tbody>
            </table>
          </div>

        </div>


      </div>
      <Pagination :links="users.links" />
    </section>

  </AuthenticatedLayout>
</template>



<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link } from '@inertiajs/vue3'
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'

defineProps({ users: Object,translations:Array })



const filterForm = reactive({
  name: '',
  email: '',
  is_active: '',
})

const Filter = () => {
  router.get(
    route('users.index'),
    filterForm,
    { preserveState: true, preserveScroll: true },
  )
}


const Activate = (id) => {
  Swal.fire({
    title: 'Are you sure?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#7066e0',
    confirmButtonText: 'Yes, change status'
  }).then((result) => {
    if (result.isConfirmed) {
      router.post(`/users/${id}/activate`, {
        onSuccess: () => {
          Swal.fire(
            'Updated !',
            'user stuaus item has been updated.',
            'success'
          );
        },
        onError: () => {
          Swal.fire(
            'Error!',
            'There was an issue updating user status.',
            'error'
          );
        }
      });
    }
  });
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