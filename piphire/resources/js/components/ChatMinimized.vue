<script setup>
const props = defineProps({
  toggle: Function,
  min: Boolean
});


</script>


<template>
  <button v-if="!min" @click="toggle" class="whatsapp-button">
    <img class="whatsapp-min" src="../assets/whatsapp.png" alt="whatsapp" />
  </button>
</template>

<style scoped>
.whatsapp-min {
  width: 35px;

  height: 35px;
}

.whatsapp-button {
  bottom: 10px;
  right: 10px;
  position: fixed;
  z-index: 100;
  background-color: #25D366;
  color: white;
  border-radius: 50%;
  padding: 10px;
  border: none;
}
</style>