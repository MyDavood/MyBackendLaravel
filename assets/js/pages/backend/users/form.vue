<template>
  <BackendFormPage
    pageTitle="کاربر"
    :form="form"
    :isEdit="props.item != null"
    path="/backend/users"
    pageIcon="fa fa-user">
    <div class="form-list">
      <TextInput
        title="نام و نام خانوادگی"
        name="name"
        :selectAll="props.item != null"
        v-model="form.name" />
      <TextInput
        title="نام کاربری"
        name="username"
        :selectAll="props.item != null"
        v-model="form.username" />
      <TextInput
        title="رمز عبور"
        :placeholder="(props.item != null) ? `در صورتی که تمایل به تغییر رمز عبور ندارید، این فیلد را خالی بگذارید.` : ``"
        name="password"
        password
        v-model="form.password" />
      <TextInput
        title="تکرار رمز عبور"
        name="password_confirmation"
        password
        v-model="form.password_confirmation" />
      <FormRow
        title="دسترسی ها">
        <BackendPermissions
          :allPermissions="allPermissions"
          v-model:isAdmin="form.isAdmin"
          v-model:permissions="form.permissions" />
      </FormRow>
    </div>
  </BackendFormPage>
</template>

<script setup>
import {
  BackendFormPage,
  BackendPermissions,
  TextInput,
  FormRow,
} from "@backend/frontend"
import {useForm} from '@inertiajs/vue3'
import Backend from "@/layouts/backend"

defineOptions({
  layout: Backend,
})

const props = defineProps({
  item: {
    type: Object,
  },
  allPermissions: Array,
  backTo: String,
})

const defaultItem = {
  type: '',
  name: '',
  username: '',
  password: '',
  password_confirmation: '',
  isAdmin: false,
  permissions: {},
  backTo: props.backTo,
}

const _item = {...defaultItem, ...props.item}

const form = useForm(_item)
</script>
