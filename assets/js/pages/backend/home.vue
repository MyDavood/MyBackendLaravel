<template>
  <BackendPage
    title="صفحه نخست"
    icon="fa fa-home">
    <BackendHead title="صفحه نخست" />
  </BackendPage>
</template>

<script setup>
import {
  BackendPage,
  BackendHead,
} from "@backend/frontend"
import Backend from "@/layouts/backend"

defineOptions({
  layout: Backend,
})
</script>
