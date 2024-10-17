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
                    <li class="breadcrumb-item active">{{ translations.roles }}</li>
                    <li class="breadcrumb-item active">{{ translations.edit }}</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb-->

        <section class="section dashboard">

            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"> {{ translations.edit_role_permission }}</h5>
                            <br>


                            <!--  Form  -->
                            <form @submit.prevent="update" class="row g-3">
                                <div class="row roles_permissions">
                                    <div class="col-md-4" v-for="permission in permissions" :key="permission.id">
                                        <div>
                                            <label class="inline-flex items-center me-5 cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" :value="permission.name"
                                                    v-model="form.selectedPermissions">
                                                <div
                                                    class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                                </div>
                                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                    {{ permission.name }} </span>

                                            </label>

                                        </div>

                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">{{ translations.update }} &nbsp; <i
                                            class="bi bi-save"></i> </button>
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
import { router } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    role: Object,
    permissions: Object,
    rolePermissions: Array,
    translations:Array

})

const form = useForm({
    selectedPermissions: props.rolePermissions,
})
const update = () => {
    router.put(`/roles/${props.role.id}/give-permissions`, {
        selectedPermissions: form.selectedPermissions
    });


}

</script>
