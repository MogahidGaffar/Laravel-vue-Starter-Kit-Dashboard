<template>

    <AuthenticatedLayout :translations="translations">
      <!-- breadcrumb-->
      <div class="pagetitle">
        <h1>{{ translations.notifications }}</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <Link class="nav-link" :href="route('dashboard')">
              {{ translations.Home }}
              </Link>
            </li>
            <li class="breadcrumb-item active">{{ translations.notifications }} </li>
  
          </ol>
        </nav>
      </div>
      <!-- End breadcrumb-->
  
      <section class="section dashboard">
    
        <div class="row">
            <div class="col-lg-8 " style="margin: auto">
<div class="card">


    <div class="card-body">
        <h5 class="card-title"> {{ translations.recent_notifications }}</h5>

        <div class="activity">
    <div class="activity-item d-flex" v-for="notification in notifications" :key="notification.id">
        <div class="activite-label">{{ notification.created_at }}</div>
        <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
        <div class="activity-content" style="text-align: left;">
            {{ notification.data.message }}
            <a v-if="notification.data.file_path" :href="notification.data.file_path" :target="_blank" class="fw-bold text-dark" target="_blank">
                Download your file here
            </a>
        </div>
    </div>
    <!-- End activity item-->
</div>


    </div>
</div>
<!-- End Recent Activity -->




</div>
</div>

                    <!-- End Notification Dropdown Items -->


        <Pagination :links="notifications.links" />
      </section>
  
    </AuthenticatedLayout>
  </template>
  
<!--   

<template>
    <h1 class="text-3xl mb-4">Your Notifications</h1>
<section v-if="notifications.data.length" class="text-gray-700 dark:text-gray-400">
  <div v-for="notification in notifications.data" :key="notification.id" class="border-b border-gray-200 dark:border-gray-800 py-4 flex justify-between items-center">
    <div>
      <span v-if="notification.type === 'App\\Notifications\\OfferMade'">
        Offer <Price :price="notification.data.amount" /> for
        <Link
          :href="route('realtor.listing.show', { listing: notification.data.listing_id })" 
          class="text-indigo-600 dark:text-indigo-400"
        >listing</Link> was made
      </span>
    </div>
    <div>
          <Link
        v-if="!notification.read_at"
        :href="route('notification.seen', { notification: notification.id })" 
        as="button"
        method="put"
        class="btn-outline text-xs font-medium uppercase"
      >
          Mark as read
      </Link>      </div>
  </div>
</section>
<section
  v-if="notifications.data.length" 
  class="w-full flex justify-center mt-8 mb-8"
>
</section>
</template> -->
<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link , usePage} from '@inertiajs/vue3'
import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'

defineProps({
notifications: Object,
translations:Array
})
</script>