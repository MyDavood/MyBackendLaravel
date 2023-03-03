<template>
  <BackendListPage
    pageTitle="مدیریت مدیران"
    pageIcon="fa fa-user"
    deleteMessage="آیا از حذف این مدیر مطمئن هستید ؟"
    deleteSuccessMessage="مدیر با موفقیت حذف گردید."
    :actions="actions"
    :searchFields="searchFields"
    :dataTable="dataTable">
    <template #topActions v-if="hasAccess.can('users.create').value">
      <ButtonLink
        color="primary"
        startIcon="fa-add"
        href="/backend/users/create">
        درج مدیر جدید
      </ButtonLink>
    </template>
    <template #rowItem="{ item, openActionsModal, editLink }">
      <td class="text-center">{{ enToFa(item.id) }}</td>
      <td>
        <i class="fa fa-lock text-danger me-2" v-if="item.twoFa"></i>
        <Link :href="editLink" :data="{'backTo': $page.url}">
          {{ item.name }}
        </Link>
      </td>
      <td class="text-center">
        <b v-if="item.isAdmin" class="text-danger">
          مدیر کل
        </b>
        <span v-else>مدیر محدود</span>
      </td>
      <td class="text-center">
        <b>{{ enToFa(item.created_at_date) }}</b><br />
        {{ enToFa(item.created_at_time) }}
      </td>
      <td class="text-center">
        <template v-if="item.updated_at">
          <b>{{ enToFa(item.updated_at_date) }}</b><br />
          {{ enToFa(item.updated_at_time) }}
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
  enToFa,
  BackendListPage,
  useBackendUser,
  useHasAccess,
} from "@backend/frontend"
import {usePage, Link} from '@inertiajs/vue3'
import Backend from "@/layouts/backend.vue"

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

const actions = (hide, item, onDelete, editLink) => [
  {
    show: hasAccess.can('users.update').value,
    title: 'ویرایش',
    icon: 'fa fa-pencil',
    href: editLink,
    data: {'backTo': page.url},
  },
  {
    show: hasAccess.can('users.delete').value,
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
