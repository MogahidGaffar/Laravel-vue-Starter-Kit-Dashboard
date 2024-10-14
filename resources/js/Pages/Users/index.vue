<template>

  <AuthenticatedLayout>

    
    <!-- breadcrumb-->
    <div class="pagetitle">
      <h1>Users</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <Link class="nav-link" :href="route('dashboard')">
            Home
            </Link>
          </li>
          <li class="breadcrumb-item active">Users</li>

        </ol>
      </nav>
    </div>
    <!-- End breadcrumb-->

    <section class="section dashboard">
      <div class="card">
        <div class="card-body">
          <div class="card-header">
            <div class="d-flex">

              <Link class="btn btn-primary ms-auto" :href="route('users.create')">Add new &nbsp; <i
                class="bi bi-plus-circle"> </i></Link>
            </div>
          </div>


          <table class="table table-condensed">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">E-mail</th>
                <th scope="col">Created at</th>
                <th scope="col">Active</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users.data" :key="user.id">
                <th scope="row">1</th>
                <td>{{ user.name }}</td>  
                <td>{{ user.email }}</td>
                <td>{{ user.created_at }}</td>
                <td>
                  
                  <div>
    <label class="inline-flex items-center me-5 cursor-pointer">
      <input type="checkbox" class="sr-only peer" :checked="user.is_active" @change="Activate(user.id)">
      <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
    </label>
  </div>
                </td>
                <td>
                  <a class="btn btn-info" :href="route('users.edit', { user: user.id })">
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

defineProps({ users: Object })



const Activate = (id) => {
  Swal.fire({
    title: 'Are you sure?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, change status'
  }).then((result) => {
    if (result.isConfirmed) {
      router.post('users/' + id+'/activate', {
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
