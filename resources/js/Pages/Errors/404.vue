<template>
    <div class="error-page" >
        <img src="/dashboard-assets/img/404.svg" alt="">
        <h1>404 Page not found </h1>
        <p>The page you are trying to access doesn’t exist</p>
        <a class="button" :href="route('dashboard')">
            Return to Home
            </a>
    </div>
</template>

