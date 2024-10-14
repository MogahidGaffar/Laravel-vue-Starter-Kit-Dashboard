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
          <li class="breadcrumb-item active">Edit</li>
        </ol>
        </nav>
      </div>
      <!-- End breadcrumb-->
  
      <section class="section dashboard">

        <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit User info</h5>

              <!-- General Form Elements -->
              <form @submit.prevent="update" class="row g-3">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="user name"  v-model="form.name" >
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control"  v-model="form.email"  placeholder="user Email">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control"  v-model="form.password"  placeholder="Password">
                  </div>
                </div>
            
                <!-- <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="formFile">
                  </div>
                </div> -->
                <div class="row mb-3">
                  <label for="inputDate" class="col-sm-2 col-form-label">Joined Date</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control"  v-model="form.created_at" disabled>
                  </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update &nbsp; <i class="bi bi-save"></i> </button>
                </div>


              </form>
              <!-- End Edit User From -->
            </div>
          </div>

        </div>

      </div>


        
      </section>
  
    </AuthenticatedLayout>
  </template>
  
  
  
  <script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from  '@inertiajs/vue3'

const props = defineProps({
    user: Object,
  })

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: props.user.password,
    created_at: props.user.created_at,
  })

  const update = () => form.put(
  route('users.update', { user: props.user.id }),
)
  
  </script>
  