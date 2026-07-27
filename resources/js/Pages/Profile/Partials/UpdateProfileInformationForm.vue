<script setup>
import InputError from '@/Components/InputError.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    translations: Array,
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <form @submit.prevent="form.patch(route('profile.update'))" class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">{{ translations.name }}</label>
            <input id="name" type="text" class="form-control" v-model="form.name" required autofocus
                autocomplete="name">
            <InputError class="mt-1" :message="form.errors.name" />
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">{{ translations.email }}</label>
            <input id="email" type="email" class="form-control" v-model="form.email" required
                autocomplete="username">
            <InputError class="mt-1" :message="form.errors.email" />
        </div>

        <div class="col-12" v-if="mustVerifyEmail && user.email_verified_at === null">
            <p class="mb-2">
                Your email address is unverified.
                <Link :href="route('verification.send')" method="post" as="button"
                    class="btn btn-link p-0 align-baseline">
                Click here to re-send the verification email.
                </Link>
            </p>

            <div v-show="status === 'verification-link-sent'" class="text-success fw-bold small">
                A new verification link has been sent to your email address.
            </div>
        </div>

        <div class="col-12 d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary" :disabled="form.processing">{{ translations.save }}</button>

            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                <span v-if="form.recentlySuccessful" class="text-success small">{{ translations.data_updated_successfully }}</span>
            </Transition>
        </div>
    </form>
</template>
