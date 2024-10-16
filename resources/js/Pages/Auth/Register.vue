<template>
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
      <title>Laravel vue sterter kit dashboard</title>
      <meta content="" name="description">
      <meta content="" name="keywords">
    
      <!-- Favicons -->
      <link href="assets/img/favicon.png" rel="icon">
      <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    </head>
    
    <body>
    
      <main>
        <div class="container">
    
          <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
    
                  <div class="d-flex justify-content-center py-4">
                    <a href="index.html" class="logo d-flex align-items-center w-auto">
                      <img src="/dashboard-assets/img/logo.png" alt="">
                      <span class="d-none d-lg-block">Laravel Starter Kit </span>
                    </a>
                  </div><!-- End Logo -->
    
                  <div class="card mb-3">
    
                    <div class="card-body">
    
                      <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Register New  Account </h5>
                      </div>
    
                      
                      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>
    
                            <form @submit.prevent="submit" class="row g-3 needs-validation" novalidate>

                                
                        <div class="col-12">
                          <label for="yourUsername" class="form-label">Name</label>
                       
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
    
                        </div>

    
                        <div class="col-12">
                          <label for="yourUsername" class="form-label">Email</label>
                          <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
    
                        </div>
    
                        <div class="col-12">
                          <label for="yourPassword" class="form-label">Password</label>
                          <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    
                    <div class="col-12">
                          <label for="yourPassword" class="form-label"> Confirm Password</label>
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

             

                    <InputError  :message="form.errors.is_active" />
    
                        
                        <div class="col-12">
                          <button class="btn btn-primary w-100" type="submit">Register</button>
                        </div>
    
                       
                        <div class="col-12">
                          <p class="small mb-0">have account already? <a :href="route('login')">Login</a></p>
                        </div>
                      </form>
    
                    </div>
                  </div>
    
    
                </div>
              </div>
            </div>
    
          </section>
    
        </div>
      </main><!-- End #main -->
    
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    
    
    </body>
    
    </html>
    </template>


    <script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    
    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });
    
    const submit = () => {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
    </script>