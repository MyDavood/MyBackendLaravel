<template>
  <div
    class="backend-layout"
    :class="{'is-open-desktop': desktopSideBarIsOpen, 'is-open-mobile': mobileSideBarIsOpen}">
    <div class="aside-backdrop" @click="mobileSideBarIsOpen = false" />
    <BackendAside
      :items="menuItems" />
    <main>
      <BackendNav
        @toggleDesktopSideBarOpen="toggleDesktopSideBar"
        @toggleMobileSideBarOpen="toggleMobileSideBar"
        :mobile-side-bar-is-open="mobileSideBarIsOpen"
        :desktop-side-bar-is-open="desktopSideBarIsOpen">
        <li class="nav-item">
          <UserProfile />
        </li>
      </BackendNav>
      <div class="main-wrapper fancy-scrollbar" scroll-region id="scrollParent">
        <Transition name="fade" mode="out-in" appear>
          <div :key="$page.url">
            <slot  />
          </div>
        </Transition>
      </div>
    </main>
  </div>
</template>
<script setup>
import {
  BackendNav,
  BackendAside,
  useHasAccess,
} from "@backend/frontend"
import {provide, ref} from "vue"
import { router } from '@inertiajs/vue3'
import UserProfile from "@/components/user-profile.vue"

provide('baseName', 'کنترل پنل مدیریت')
provide('uploadApi', '/backend/upload')

const access = useHasAccess()

const mobileSideBarIsOpen = ref(false)
const desktopSideBarIsOpen = ref(true)

const toggleMobileSideBar = () => {
  mobileSideBarIsOpen.value = !mobileSideBarIsOpen.value
}

const toggleDesktopSideBar = () => {
  desktopSideBarIsOpen.value = !desktopSideBarIsOpen.value
}

router.on('before', function () {
  mobileSideBarIsOpen.value = false
})

const menuItems = [
  {
    href: '/backend',
    icon: 'fa-home',
    name: 'داشبورد',
    exact: true,
    show: access.all,
  },
  {
    href: '/backend/users',
    icon: 'fa-user',
    name: 'کاربران',
    show: access.can("users.viewAny"),
  },
]
</script>
