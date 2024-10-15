<template>

    <AuthenticatedLayout :translations="translations">
  
  
      <!-- breadcrumb-->
      <div class="pagetitle">
        <h1>  {{ translations.logs }} </h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <Link class="nav-link" :href="route('dashboard')">
                {{ translations.Home }}
              </Link>
            </li>
            <li class="breadcrumb-item active">  {{ translations.logs }} </li>
            <li class="breadcrumb-item active">  {{ translations.view }} </li>
  
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
          <br>
          <div class="card-body">
            <form @submit.prevent="undo" class="row g-3">

          <h5 class="card-title"  v-if="log.action != 'create'">{{ translations.before }} </h5>
          <div class="table-responsive"  v-if="log.action != 'create'">
          <table class="table table-bordered fs-13">
                <thead>
                  <tr>
                    <th scope="col" v-for="col in  Object.keys(JSON.parse(log.original_data))" :key="log.id">{{ col }}</th>
                  </tr>
                </thead>
                <tbody>

                  <tr >
                    <td v-for="val in  JSON.parse(log.original_data)" :key="log.id"> {{ val }}</td>
                  </tr>
                </tbody>
              </table>
            </div>


            <h5 class="card-title" v-if="log.action != 'delete'">  {{ translations.after }} </h5>
          <div class="table-responsive" v-if="log.action != 'delete'">
          <table class="table table-bordered fs-13">
                <thead>
                  <tr>
                    <th scope="col" v-for="col in  Object.keys(JSON.parse(log.updated_data))" :key="log.id">{{ col }}</th>
                  </tr>
                </thead>
                <tbody>

                  <tr >
                    <td v-for="val in  JSON.parse(log.updated_data)" :key="log.id"> {{ val }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="text-center">
                  <button type="submit" class="btn btn-primary">  {{ translations.undo }}  <i class="ri-refresh-line"></i> </button>
                </div>
            </form>


        </div>
        </div>
      </section>
  
    </AuthenticatedLayout>
  </template>
  
  
  
  <script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
  
  const props = defineProps({
    log: Object,
    translations:Array
  })


  const undo = () => router.post(
  route('logs.undo', { log: props.log.id }),
)

  
  </script>
  
