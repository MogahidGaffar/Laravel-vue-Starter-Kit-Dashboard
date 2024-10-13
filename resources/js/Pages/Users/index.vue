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
              <ul class="nav nav-pills card-header-pills">
                <l class="nav-item">
                  <Link class="nav-link active"  :href="route('users.create')"  >Create new &nbsp; <i class="bi bi-plus-circle"> </i></Link>
                </l>
              </ul>
            </div>
          
           
              <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">E-mail</th>
              <th scope="col">Created at</th>
              <th scope="col">Edit</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <th scope="row">1</th>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.created_at }}</td>
              <td>
                <a class="btn btn-info" :href="route('users.edit', { user: user.id })" >
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


      <div class="row">
      

      </div>
    </section>

  </AuthenticatedLayout>
</template>



<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3'
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'

defineProps({ users: Object })


const Delete = (id) =>{
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
