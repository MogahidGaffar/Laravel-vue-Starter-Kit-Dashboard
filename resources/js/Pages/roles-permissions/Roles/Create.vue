<template>

    <AuthenticatedLayout :translations="translations">
  
      <!-- breadcrumb-->
      <div class="pagetitle">
        <h1>Roles</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <Link class="nav-link" :href="route('dashboard')">
              {{ translations.Home }}
              </Link>
            </li>
            <li class="breadcrumb-item active"> {{ translations.roles }}</li>
          </ol>
        </nav>
      </div>
      <!-- End breadcrumb-->
  
      <section class="section dashboard">
  
        <div class="row">
          <div class="col-lg-12">
  
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"> {{ translations.add_new_role }} </h5>
                <!-- General Form Elements -->
                <form @submit.prevent="store" class="row g-3">
                  <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">{{ translations.name }} </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" :placeholder="translations.name" v-model="form.name">
                      <InputError :message="form.errors.name" />
                    </div>
                  </div>
  
                 
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" v-bind:disabled="show_loader"> {{ translations.save }} &nbsp; <i class="bi bi-save"
                      v-if="!show_loader"></i>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                      v-if="show_loader"></span>
                  </button>
                </div>


  
                </form>
                <!-- End From -->
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
  import InputError from '@/Components/InputError.vue';
 import { ref } from 'vue';

 const show_loader = ref(false);
  
  defineProps({translations:Array})
  
  
  const form = useForm({
    name: "",
  })
  
  
  
const store = () => {
  show_loader.value = true;
  form.post(route('roles.store'), {
    onSuccess: () => {
      show_loader.value = false;
    },
    onError: () => {
      show_loader.value = false;
    },
  });
};


  
  </script>