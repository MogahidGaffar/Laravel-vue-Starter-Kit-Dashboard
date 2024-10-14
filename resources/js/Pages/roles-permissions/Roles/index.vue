<template>

    <AuthenticatedLayout>
  
  
      <!-- breadcrumb-->
      <div class="pagetitle">
        <h1>Roles</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <Link class="nav-link" :href="route('dashboard')">
              Home
              </Link>
            </li>
            <li class="breadcrumb-item active">Roles</li>
  
          </ol>
        </nav>
      </div>
      <!-- End breadcrumb-->
      <section class="section dashboard">
        <div class="card">
          <div class="card-body">
            <div class="card-header">
              <div class="d-flex">
  
                <Link class="btn btn-primary ms-auto" :href="route('roles.create')">Add new &nbsp; <i
                  class="bi bi-plus-circle"> </i></Link>
              </div>
            </div>
  
  
            <table class="table text-center">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Permissions</th>
                  <th scope="col">Edit</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
                  <tr v-for="(role, index)   in roles" :key="role.id">
                    <th scope="row">{{ index+1 }}</th>

                  <td>{{ role.name }}</td>
                  <td>
                    <a class="btn btn-dark" :href="'roles/'+role.id+'/give-permissions'">
                      <i class="bi bi-lock"></i>
                    </a>
                  </td>
                 
                  <td>
                    <a class="btn btn-primary" :href="route('roles.edit', { role: role.id })">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                  </td>
                  <td>
  
                    <button type="button" class="btn btn-danger" @click="Delete(role.id)">
                      <i class="bi bi-trash"></i>
                    </button>
  
                  </td>
                </tr>
  
              </tbody>
            </table>
  
          </div>
  
  
        </div>
      </section>
  
    </AuthenticatedLayout>
  </template>
  
  
  
  <script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import Pagination from '@/Components/Pagination.vue';
  import { Link } from '@inertiajs/vue3'
  import Swal from 'sweetalert2';
  import { router } from '@inertiajs/vue3'
  
  defineProps({ roles: Object })
  

  
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
        router.delete('roles/' + id, {
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
  