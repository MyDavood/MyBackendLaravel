<template>
  <BackendListPage
    pageTitle="مدیریت کاربران"
    pageIcon="fa fa-user"
    deleteMessage="آیا از حذف این کاربر مطمئن هستید ؟"
    deleteSuccessMessage="کاربر با موفقیت حذف گردید."
    :actions="actions"
    :searchFields="searchFields"
    :dataTable="dataTable">
    <template #topActions v-if="hasAccess.can('users', 'create')">
      <ButtonLink
        color="primary"
        startIcon="fa-add"
        href="/backend/users/create">
        درج کاربر جدید
      </ButtonLink>
    </template>
    <template #rowItem="{ item, openActionsModal }">
      <td class="text-center">{{ enToFa(item.id) }}</td>
      <td>{{ item.name }}</td>
      <td class="text-center">
        <b v-if="item.isAdmin" class="text-danger">
          مدیر کل
        </b>
        <span v-else>کاربر</span>
      </td>
      <td class="text-center">
        <b>{{ jalali(item.created_at, 'YYYY/MM/DD', true) }}</b><br />
        {{ jalali(item.created_at, 'HH:mm', true) }}
      </td>
      <td class="text-center">
        <template v-if="item.updated_at">
          <b>{{ jalali(item.updated_at, 'YYYY/MM/DD', true) }}</b><br />
          {{ jalali(item.updated_at, 'HH:mm', true) }}
        </template>
        <span v-else>هرگز</span>
      </td>
      <td class="text-center clickable">
        <a href="" @click.prevent="openActionsModal">
          <i class="fa fa-ellipsis-h text-primary"></i>
        </a>
      </td>
    </template>
  </BackendListPage>
</template>

<script setup>
import {
  ButtonLink,
  jalali,
  enToFa,
  BackendListPage,
  useBackendUser,
  useHasAccess,
} from "@backend/frontend"
import {usePage} from '@inertiajs/vue3'
import Backend from "@/layouts/backend"

defineOptions({
  layout: Backend,
})

const user = useBackendUser()
const page = usePage()
const hasAccess = useHasAccess()

const props = defineProps({
  dataTable: {
    type: Object,
    required: true,
  },
  searchFields: {
    type: Array,
    required: true,
  }
})

const actions = (hide, item, onDelete) => [
  {
    show: hasAccess.can('users', 'update').value,
    title: 'ویرایش',
    icon: 'fa fa-pencil',
    href: `/backend/users/${item.id}/edit`,
    data: {'backTo': page.url},
  },
  {
    show: hasAccess.can('users', 'delete').value,
    disabled: item.id === user.value.id,
    title: 'حذف',
    icon: 'fa fa-trash',
    action: () => {
      hide()
      onDelete(item)
    }
  },
]
</script>
