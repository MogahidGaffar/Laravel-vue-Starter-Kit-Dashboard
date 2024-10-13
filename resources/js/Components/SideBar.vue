<template>
 

<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
        <Link  class="nav-link "  :href="route('dashboard')"   :class="{ 'collapsed': $page.url !== '/dashboard' }" >
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
               </Link>
    </li>

    <li class="nav-item">
    <Link  class="nav-link "  :href="route('users.index')"  :class="{ 'collapsed':  !$page.url.startsWith('/users') }" >
            <i class="bi bi-people"></i>
            <span>Users</span>
               </Link>
    </li>

    <!-- End Dashboard Nav -->
<!-- 
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="components-alerts.html">
                    <i class="bi bi-circle"></i><span>Alerts</span>
                </a>
            </li>
            <li>
                <a href="components-accordion.html">
                    <i class="bi bi-circle"></i><span>Accordion</span>
                </a>
            </li>
        </ul>
    </li>
     -->


</ul>

</aside>


</template>



<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({currentRouteName: String })
</script>

<script>
export default {
  name: 'Sidebar'
};
</script>