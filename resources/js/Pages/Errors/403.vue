<template>
    <div class="error-page" >
        <img src="/dashboard-assets/img/403.svg" alt="">
        <h1>403 Forbidden</h1>
        <p>You do not have permission to access this page or do this action.</p>
        <a class="button" :href="route('dashboard')">
            Return to Home
            </a>
    </div>
</template>
