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
            <li class="breadcrumb-item active">Permissions</li>
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
                <h5 class="card-title">Edit Permission </h5>
                <br>
  
                <!-- General Form Elements -->
                <form @submit.prevent="update" class="row g-3">
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" placeholder="Permission name" v-model="form.name">
                      <InputError :message="form.errors.name" />
                    </div>
                </div>
                 
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update &nbsp; <i class="bi bi-save"></i> </button>
                  </div>
  
  
                </form>
                <!--  From -->
              </div>
            </div>
  
          </div>
  
        </div>
  
  
      </section>
    </AuthenticatedLayout>
  </template>
  
  
  
  <script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { useForm } from '@inertiajs/vue3'
  
  const props = defineProps({
    permission: Object,
  })
  
  const form = useForm({
    name: props.permission.name,
  })
  
  const update = () => form.put(
    route('permissions.update', { permission: props.permission.id }),
  )
  
  </script>