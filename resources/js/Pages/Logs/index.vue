<template>

    <AuthenticatedLayout>
  
  
      <!-- breadcrumb-->
      <div class="pagetitle">
        <h1>Logs</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <Link class="nav-link" :href="route('dashboard')">
              Home
              </Link>
            </li>
            <li class="breadcrumb-item active">Logs</li>
  
          </ol>
        </nav>
      </div>
      <!-- End breadcrumb-->
  
      <section class="section dashboard">
        <div class="card">

            <div class="card-header">
            <div class="d-flex">

            </div>
          </div>
          <div class="card-body">
          
  
            <div class="table-responsive">
            <table class="table text-center">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Module</th>
                  <th scope="col">action</th>
                  <th scope="col">affected record</th>
                  <th scope="col"> at</th>
                  <th scope="col">Details</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(log, index)   in logs.data" :key="log.id">
                  <th scope="row">{{ index + 1 }}</th>
                  <td>{{ log.module_name }}</td>
                  <td>
                    <span :class="['badge', 'bg-' + log.badge]"> {{ log.action }}</span>
                  </td>
                  <td>{{ log.affected_record_id }}</td>
                  <td>{{ log.created_at }}</td>
                  <td>
                  <a class="btn btn-primary" :href="route('logs.view', { log: log.id })">
                    <i class="bi bi-eye"></i>
                  </a>
                </td>
                  <td> <button type="button" class="btn btn-danger" @click="Delete(log.id)">
                      <i class="bi bi-trash"></i>
                    </button>
  
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
  import { Link } from '@inertiajs/vue3'
  import Swal from 'sweetalert2';
  import { router } from '@inertiajs/vue3'
  
  defineProps({ logs: Object })
  
  
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
  