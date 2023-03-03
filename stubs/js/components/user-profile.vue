<template>
  <a href=""
     @click.prevent="showProfile"
     class="nav-link isProfile">
    <div class="avatar"></div>
    <span v-text="user.name"></span>
    <i class="fa fa-caret-down"></i>
    <ModalMenu
      ref="profileModal"
      :title="user.name"
      bottom
      :items="profileItems" />
    <Modal
      :width="450"
      ref="editProfileModal"
      title="ویرایش پروفایل">
      <div class="modal-tabs">
        <ul class="nav nav-pills nav-fill">
          <li class="nav-item">
            <a class="nav-link" href="#" :class="{'active': editProfileTab === 0}" @click.prevent="editProfileTab = 0">تغییر نام</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" :class="{'active': editProfileTab === 1}" @click.prevent="editProfileTab = 1">تغییر رمز عبور</a>
          </li>
        </ul>
      </div>
      <AutoForm
        @onSubmit="onSubmit"
        browserSave
        :form="form">
        <div class="modal-content">
          <transition name="fade" mode="out-in">
            <div class="form-list" v-if="editProfileTab === 0">
              <TextInput
                title="نام و نام خانوادگی"
                name="name"
                v-model="form.name" />
            </div>
            <div class="form-list" v-else>
              <TextInput
                title="رمز عبور فعلی"
                name="current_password"
                password
                v-model="form.current_password" />
              <TextInput
                title="رمز عبور جدید"
                name="password"
                password
                v-model="form.password" />
              <TextInput
                title="تکرار رمز عبور جدید"
                name="password_confirmation"
                password
                v-model="form.password_confirmation" />
            </div>
          </transition>
        </div>
        <div class="modal-footer">
          <div class="d-flex p-3">
            <Button
              type="submit"
              color="purple"
              startIcon="fa fa-save"
              class="form-button ms-auto">
              ذخیره
            </Button>
          </div>
        </div>
      </AutoForm>
    </Modal>
    <Modal
      ref="twoFactorModal"
      :width="450"
      title="رمز دوم">
      <AutoForm
        key="twoFactorSet"
        @onSubmit="submitSetTwoFactor"
        v-if="!twoFactorStatus"
        :form="twoFactorSetForm">
        <div class="modal-content">
          <div class="text-center">
            <VueQrcode :value="twoFactorQr" />
            <Alert color="info" class="mt-2">
              لطفا بارکد ایجاد شده را در اپلیکیشن Google Authenticator اسکن کرده سپس رمز یکبار مصرف تولید شده را وارد کنید.
            </Alert>
            <TextInput
              title="رمز یکبار مصرف"
              name="password"
              intOnly
              autoFocus
              valueEn
              v-model="twoFactorSetForm.password" />
          </div>
        </div>
        <div class="modal-footer">
          <div class="d-flex p-3">
            <Button
              type="submit"
              color="purple"
              startIcon="fa fa-save"
              class="form-button ms-auto">
              ذخیره
            </Button>
          </div>
        </div>
      </AutoForm>
      <AutoForm
        v-else
        key="twoFactorRemove"
        @onSubmit="submitRemoveTwoFactor"
        :form="twoFactorRemoveForm">
        <div class="modal-content">
          <Alert color="info">
            برای حذف رمز دوم، لطفا رمز یکبار مصرف تولید شده را وارد کنید.
          </Alert>
          <TextInput
            title="رمز یکبار مصرف"
            name="password"
            intOnly
            autoFocus
            valueEn
            v-model="twoFactorRemoveForm.password" />
        </div>
        <div class="modal-footer">
          <div class="d-flex p-3">
            <Button
              type="submit"
              color="purple"
              startIcon="fa fa-save"
              class="form-button ms-auto">
              حذف رمز دوم
            </Button>
          </div>
        </div>
      </AutoForm>
    </Modal>
  </a>
</template>

<script setup>
import {
  ModalMenu,
  Modal,
  TextInput,
  Button,
  AutoForm,
  Alert,
  useBackendUser,
} from "@backend/frontend"
import {ref} from "vue"
import axios from "axios"
import { useForm, router } from '@inertiajs/vue3'
import VueQrcode from '@chenfengyuan/vue-qrcode'

const profileModal = ref()
const editProfileModal = ref()
const editProfileTab = ref(0)

const user = useBackendUser()

const form = useForm({
  name: user.value.name,
  current_password: '',
  password: '',
  password_confirmation: '',
})

const showProfile = () => profileModal.value?.show()

const twoFactorModal = ref()
const twoFactorStatus = ref(false)
const twoFactorQr = ref()
const showTwoFactor = () => twoFactorModal.value?.show()

const twoFactorSetForm = useForm({
  secret: null,
  password: null,
})

const twoFactorRemoveForm = useForm({
  password: null,
})

const profileItems = (hide) => [
  {
    title: 'ویرایش پروفایل',
    icon: 'fa fa-user-pen',
    action: async () => {
      hide()
      editProfileModal.value?.show()
    },
  },
  {
    title: 'رمز دوم',
    icon: 'fa fa-lock',
    action: async () => {
      const { data } = await axios.get('/backend/auth/2fa/status')
      twoFactorStatus.value = data.status
      if (!twoFactorStatus.value) {
        const { data } = await axios.get('/backend/auth/2fa/qr')
        twoFactorSetForm.secret = data.secret
        twoFactorQr.value = data.qrData
        twoFactorSetForm.password = ''
      } else {
        twoFactorRemoveForm.password = ''
      }
      hide()
      showTwoFactor()
    },
  },
  {
    title: 'خروج از کنترل پنل',
    icon: 'fa-solid fa-right-from-bracket',
    action: async () => {
      try {
        await axios.post('/backend/auth/logout')
        await hide()
        router.visit('/backend/login')
      } catch (e) {}
    },
  }
]

const submitRemoveTwoFactor = () => {
  twoFactorRemoveForm.put('/backend/auth/2fa', {
    onSuccess: () => {
      twoFactorModal.value?.hide()
    }
  })
}

const submitSetTwoFactor = () => {
  twoFactorSetForm.post('/backend/auth/2fa', {
    onSuccess: () => {
      twoFactorModal.value?.hide()
    }
  })
}

const onSubmit = () => {
  const options = {
    onSuccess: () => {
      editProfileModal.value?.hide()
    },
  }

  form.post('/backend/auth/profile', options)
}
</script>
