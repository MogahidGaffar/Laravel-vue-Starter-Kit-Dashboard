<template>
    <Head title="Profile" />

    <AuthenticatedLayout :translations="translations">
        <!-- breadcrumb-->
        <div class="pagetitle">
            <h1>{{ translations.my_profile }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <Link class="nav-link" :href="route('dashboard')">
                        {{ translations.Home }}
                        </Link>
                    </li>
                    <li class="breadcrumb-item active">{{ translations.my_profile }}</li>
                </ol>
            </nav>
        </div>
        <!-- End breadcrumb-->

        <section class="section dashboard">

            <!-- Profile hero -->
            <div class="profile-hero">
                <div class="profile-hero-banner"></div>
                <div class="profile-hero-body">
                    <div class="profile-avatar-wrap">
                        <img :src="user.avatar" :alt="user.name" class="profile-avatar">
                    </div>
                    <div class="profile-hero-info">
                        <h2 class="profile-name">{{ user.name }}</h2>
                        <span v-if="user.role" class="profile-role">
                            <i class="bi bi-shield-check"></i> {{ user.role }}
                        </span>
                    </div>
                </div>
                <div class="profile-hero-stats">
                    <div class="profile-stat">
                        <div class="profile-stat-val">{{ user.notificationCount }}</div>
                        <div class="profile-stat-lbl">{{ translations.notifications }}</div>
                    </div>
                    <div class="profile-stat" v-if="user.member_since">
                        <div class="profile-stat-val">{{ user.member_since }}</div>
                        <div class="profile-stat-lbl">{{ translations.member_since }}</div>
                    </div>
                    <div class="profile-stat" v-if="user.last_login">
                        <div class="profile-stat-val">{{ user.last_login }}</div>
                        <div class="profile-stat-lbl">{{ translations.last_login }}</div>
                    </div>
                </div>

                <div class="profile-section">
                    <h5 class="profile-section-title"><i class="bi bi-person-circle"></i> {{ translations.account_information }}</h5>
                    <UpdateProfileInformationForm :translations="translations" :must-verify-email="mustVerifyEmail"
                        :status="status" />
                </div>

                <div class="profile-section">
                    <h5 class="profile-section-title"><i class="bi bi-key"></i> {{ translations.update_password }}</h5>
                    <UpdatePasswordForm :translations="translations" />
                </div>
            </div>
            <!-- End Profile hero -->

        </section>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    translations: Array,

    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = computed(() => usePage().props.auth);
</script>
