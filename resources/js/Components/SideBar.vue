<template>
 
<aside id="sidebar" class="sidebar">
<ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
        <Link  class="nav-link "  :href="route('dashboard')"   :class="{ 'collapsed': $page.url !== '/dashboard' }" >
            <i class="bi bi-grid"></i>
            <span> {{translations.dashboard  }}  </span>
               </Link>
    </li>

    <li class="nav-item" v-if="hasPermission('read users')">
    <Link  class="nav-link "  :href="route('users.index')"  :class="{ 'collapsed':  !$page.url.startsWith('/users') }" >
            <i class="bi bi-people"></i>
            <span>{{translations.users  }}</span>
               </Link>
    </li>


    <li class="nav-item" >
        <a class="nav-link " data-bs-target="#components-nav" data-bs-toggle="collapse" href="#"  :class="{ 'collapsed':  !$page.url.startsWith('/roles') && !$page.url.startsWith('/permissions') }" >
            <i class="bi bi-lock"></i><span>{{translations.roles_control  }}</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <Link   :href="route('roles.index')"  :class="{ 'collapsed':  !$page.url.startsWith('/roles') }" >
            <i class="bi bi-circle"></i>
            <span>{{translations.roles  }}</span>
               </Link>
            </li>
            <li>
                <Link   :href="route('permissions.index')"  :class="{ 'collapsed':  !$page.url.startsWith('/permissions') }" >
            <i class="bi bi-circle"></i>
            <span>{{translations.permissions  }}</span>
               </Link>
            </li>
        </ul>
    </li>
    
    <li class="nav-item" v-if="hasPermission('read logs')">
    <Link  class="nav-link "  :href="route('logs')"  :class="{ 'collapsed':  !$page.url.startsWith('/logs') }" >
            <i class="bi bi-database"></i>
            <span>{{translations.logs  }}</span>
               </Link>
    </li>



</ul>

</aside>


</template>



<script setup>
import { Link , usePage} from '@inertiajs/vue3'
const page = usePage()

const hasPermission = (permission) => {
  return page.props.auth_permissions.includes(permission);
}
defineProps({message: String,translations:Array})
</script>

<script>
export default {
  name: 'Sidebar'
};
</script>