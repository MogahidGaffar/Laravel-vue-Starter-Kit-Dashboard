<template>

    <AuthenticatedLayout :translations="translations">

        <!-- breadcrumb-->
        <div class="pagetitle">
            <h1>{{ translations.roles }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <Link class="nav-link" :href="route('dashboard')">
                        {{ translations.Home }}
                        </Link>
                    </li>
                    <li class="breadcrumb-item active">{{ translations.roles }}</li>
                    <li class="breadcrumb-item active">{{ isEdit ? translations.edit : translations.create }}</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb-->

        <section class="section dashboard">

            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"> {{ isEdit ? translations.edit_role_permission : translations.add_new_role }}</h5>
                            <br>


                            <!--  Form  -->
                            <form @submit.prevent="submit" class="row g-3">
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">{{ translations.name }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" :placeholder="translations.name" v-model="form.name">
                                        <InputError :message="form.errors.name" />
                                    </div>
                                </div>

                                <div class="row roles_permissions">
                                    <div class="col-md-4" v-for="permission in permissions" :key="permission.id">
                                        <div>
                                            <label class="inline-flex items-center me-5 cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" :value="permission.name"
                                                    v-model="form.selectedPermissions">
                                                <div
                                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                </div>
                                                <span class="ms-3 text-sm font-medium text-gray-900">
                                                    {{ permission.name }} </span>

                                            </label>

                                        </div>

                                    </div>
                                </div>
                                <InputError :message="form.errors.selectedPermissions" />
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" v-bind:disabled="form.processing">{{ isEdit ? translations.update : translations.save }} &nbsp; <i
                                            class="bi bi-save" v-if="!form.processing"></i>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                            v-if="form.processing"></span>
                                    </button>
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
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    role: Object,
    permissions: Object,
    rolePermissions: Array,
    translations: Array,
})

const isEdit = !!props.role

const form = useForm({
    name: props.role?.name ?? '',
    selectedPermissions: props.rolePermissions,
})

const submit = () => {
    if (isEdit) {
        form.put(`/roles/${props.role.id}/give-permissions`);
    } else {
        form.post(route('roles.store'));
    }
}

</script>
