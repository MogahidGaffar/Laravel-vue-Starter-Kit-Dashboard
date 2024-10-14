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

    <!-- <li class="nav-item">
    <Link  class="nav-link "  :href="route('roles.index')"  :class="{ 'collapsed':  !$page.url.startsWith('/roles') }" >
            <i class="bi bi-lock"></i>
            <span>Roles</span>
               </Link>
    </li> -->

    <!-- <li class="nav-item">
    <Link  class="nav-link "  :href="route('permissions.index')"  :class="{ 'collapsed':  !$page.url.startsWith('/permissions') }" >
            <i class="bi bi-lock"></i>
            <span>Permissions</span>
               </Link>
    </li> -->

    <li class="nav-item">
        <a class="nav-link " data-bs-target="#components-nav" data-bs-toggle="collapse" href="#"  :class="{ 'collapsed':  !$page.url.startsWith('/roles') && !$page.url.startsWith('/permissions') }" >
            <i class="bi bi-lock"></i><span>Roles Control</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <Link   :href="route('roles.index')"  :class="{ 'collapsed':  !$page.url.startsWith('/roles') }" >
            <i class="bi bi-circle"></i>
            <span>Roles</span>
               </Link>
            </li>
            <li>
                <Link   :href="route('permissions.index')"  :class="{ 'collapsed':  !$page.url.startsWith('/permissions') }" >
            <i class="bi bi-circle"></i>
            <span>Permissions</span>
               </Link>
            </li>
        </ul>
    </li>
    


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