<template>
    <div class="error-page" >
        <img src="/dashboard-assets/img/403.svg" alt="">
        <h1>403 Forbidden</h1>
        <p>You do not have permission to access this page.</p>
        <a class="button" :href="route('dashboard')">
            Return to Home
            </a>
            
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
    name: 'ForbiddenPage',
}
</script>

<style scoped>
.error-page {
    /* text-align: center;
    padding: 20px; */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-content: center;
    text-align: center;
}

.error-page img{
height: 450px !important;
}

.error-page h1{
    font-size: 35px;
    font-weight: 600;
}


.error-page p{
    font-size: 20px;
    font-weight: 600;
}

</style>
