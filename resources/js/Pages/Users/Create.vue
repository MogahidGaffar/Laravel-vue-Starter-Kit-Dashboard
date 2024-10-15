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
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Add New User </h5>

              <!-- General Form Elements -->
              <form @submit.prevent="store" class="row g-3">
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="user name" v-model="form.name">
                    <InputError :message="form.errors.name" />
                  </div>

                </div>
                <div class="row mb-3">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" v-model="form.email" placeholder="user Email">
                    <InputError :message="form.errors.email" />
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" v-model="form.password" placeholder="Password">
                    <InputError :message="form.errors.password" />
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Roles</label>
                  <div class="col-sm-10">
                    <select name="roles[]" class="form-control" multiple v-model="form.selectedRoles">
                      <option value="" disabled>Select Role</option>
                      <option v-for="role in roles" :key="role" :value="role">
                        {{ role }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">Profle</label>
                  <div class="col-sm-10">
                    <input type="file" @input="form.avatar = $event.target.files[0]" />
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                      {{ form.progress.percentage }}%
                    </progress>
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Save &nbsp; <i class="bi bi-save"
                      v-if="!show_loader"></i>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                      v-if="show_loader"></span>
                  </button>
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
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';

const show_loader = ref(false);


const props = defineProps({
  roles: Object,
})


const form = useForm({
  name: "",
  email: "",
  password: "",
  selectedRoles: "",
  avatar: null,
})


const store = () => {
  show_loader.value = true;
  form.post(route('users.store'), {
    onSuccess: () => {
      show_loader.value = false;
    },
    onError: () => {
      show_loader.value = false;
    },
  });
};



</script>