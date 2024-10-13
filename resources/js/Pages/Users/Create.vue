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
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </nav>
      </div>
      <!-- End breadcrumb-->
  
      <section class="section dashboard">
        <div class="row">
  
            
                <form @submit.prevent="store" class="row g-3">

                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text"  v-model="form.name"  class="form-control" id="floatingName" placeholder="Your Name">
                    <label for="floatingName">Your Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="email"  v-model="form.email"  class="form-control" id="floatingEmail" placeholder="Your Email">
                    <label for="floatingEmail">Your Email</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="password"  v-model="form.password"  class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                  </div>
                </div>
              
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Save &nbsp; <i class="bi bi-save"></i> </button>
                </div>
              </form>
              
        </div>
      </section>
  
    </AuthenticatedLayout>
  </template>
  
  
  
  <script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from  '@inertiajs/vue3'



const form = useForm({
    name: "",
    email: "",
    password: "",
  })

  
  const store = () => form.post(
  route('users.store'),
)
  
  </script>
  