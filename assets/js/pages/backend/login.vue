<template>
  <div class="login-layout">
    <div class="form-parent">
      <AutoForm
        @submit="onSubmit"
        :form="form">
        <TextInput
          name="username"
          dir="ltr"
          align="left"
          title="نام کاربری"
          v-model="form.username" />
        <TextInput
          class="mt-2"
          name="password"
          password
          dir="ltr"
          align="left"
          title="رمز عبور"
          v-model="form.password" />
        <TextInput
          name="password2"
          class="mt-2"
          v-if="needPassword2"
          intOnly
          autoFocus
          valueEn
          dir="ltr"
          align="left"
          title="رمز یکبار مصرف"
          v-model="form.password2" />
        <div class="row mt-2 align-items-center">
          <div class="col-7">
            <CheckBox
              label="ورود به مدت ۱ ماه"
              v-model="form.remember" />
          </div>
          <div class="col-5">
            <Button
              endIcon="fa-sign-in"
              type="submit"
              color="primary"
              class="w-100">
              ورود
            </Button>
          </div>
        </div>
      </AutoForm>
    </div>
  </div>
</template>

<script setup>
import {
  AutoForm,
  TextInput,
  CheckBox,
  Button,
} from "@backend/frontend"
import {useForm} from '@inertiajs/vue3'
import {ref} from "vue"

const needPassword2 = ref(false)

const form = useForm({
  username: '',
  password: '',
  password2: '',
  remember: false,
})

const onSubmit = () => {
  form.post('/backend/login', {
      onError: (errors) => {
          if (errors.needPassword2 !== undefined) {
            needPassword2.value = true
          }
      }
  })
}
</script>
