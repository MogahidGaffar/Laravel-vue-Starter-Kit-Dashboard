
<template>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <Link class="logo d-flex align-items-center" :href="route('dashboard')">
            <img src="/dashboard-assets/img/app_logo.jpg" alt="">
            <span class="d-none d-lg-block">StarterKit</span>
            </Link>
            <i class="bi bi-list toggle-sidebar-btn" @click="toggleBodyClass"></i>
        </div>
        <!-- End Logo -->
   

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <!-- <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li> -->
                <!-- End Search Icon-->
                <li class="nav-item dropdown">
                    <select class="form-control changeLang" @change="changeLanguage">
                        <option value="" selected> {{translations.language  }} 🌍 </option>
                        <option value="en"> English</option>
                        <option value="ar">Arabic</option>
                    </select>
                </li>

                <li class="nav-item dropdown">
                    <Link
                    class="nav-link nav-icon" 
            :href="route('notification.index')"
          >
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">{{ notificationCount }}</span>
                 </Link>
                    <!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul>
                    <!-- End Notification Dropdown Items -->

                </li>
                <!-- End Notification Nav -->
<!-- 
                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="/dashboard-assets/img/messages-1.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>Maria Hudson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>4 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="/dashboard-assets/img/messages-2.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>Anna Nelson</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>6 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <a href="#">
                                <img src="/dashboard-assets/img/messages-3.jpg" alt="" class="rounded-circle">
                                <div>
                                    <h4>David Muldon</h4>
                                    <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                    <p>8 hrs. ago</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="dropdown-footer">
                            <a href="#">Show all messages</a>
                        </li>

                    </ul>

                </li> -->
                <!-- End Messages Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img :src="user.avatar" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ user.name }}</span>
                    </a>
                    <!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ user.name }}</h6>
                            <span>{{ user.email }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" :href="route('profile.edit')">
                                <i class="bi bi-person"></i>
                                <span>{{translations.my_profile }} </span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <Link :href="route('logout')" method="post" as="button"
                                class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>{{translations.log_out  }}</span>
                            </Link>



                        </li>

                    </ul>
                    <!-- End Profile Dropdown Items -->
                </li>
                <!-- End Profile Nav -->

            </ul>
        </nav>
        <!-- End Icons Navigation -->




    </header>

    <!-- Include the Sidebar here -->
    <Sidebar :translations="translations" :permissions=" page.props.Permissions" />

    <!-- Include the main content here -->

    <main id="main" class="main" >
        <div v-if="flashSuccess" class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
            role="alert">
             {{flashSuccess }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <main>
            <slot />
        </main>
    </main>



</template>


<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
defineProps({translations:Array })

const showingNavigationDropdown = ref(false);
</script>


<script>
import Sidebar from '@/Components/SideBar.vue';
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const flashSuccess = computed(
    () => page.props.flash.success,
)

const page = usePage()

const user = computed(
    () => page.props.auth,
)

const notificationCount = computed(
  () => Math.min(page.props.auth.notificationCount, 9),
)



const changeLanguage = (event) => {
    const selectedLanguage = event.target.value;
    const currentUrl = window.location.origin; // Get the current app URL
    const newUrl = `${currentUrl}/lang/change?lang=${selectedLanguage}`; // Construct the new URL
    window.location.href = newUrl; // Redirect to the new URL
};



const isBodyActive = ref(false);

const toggleBodyClass = () => {
    // alert(1);
      isBodyActive.value = !isBodyActive.value;

      if (isBodyActive.value) {
        document.body.classList.add('toggle-sidebar');

      } else {
        document.body.classList.remove('toggle-sidebar');
      }
    };


    
export default {
    components: {
        Sidebar,
    },
  data() {
    return {
      parentMessage: 'Hello from Parent',
    };
  },
};
</script>
