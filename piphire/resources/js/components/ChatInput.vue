<script setup>
import { ref } from "vue";

const text = ref("");
const props = defineProps({
  addMessage: Function,
});

function addNewMessage() {
  if (text.value != "") {
    props.addMessage({
      message: text.value,
      timestamp: null,
      type: "right",
    });
    text.value = "";
  }
}
</script>


<template>
  <div class="input-container">
    <input
      placeholder="Enter your message..."
      v-model="text"
      v-on:keyup.enter="addNewMessage"
      class="rounded input-field"
    />
    <button @click="addNewMessage" class="send-button rounded">
      <img class="send-img" src="../assets/send.png" alt="send" />
    </button>
  </div>
</template>



<style scoped>
.rounded {
  border-radius: 20px;
}
.input-container {
  display: flex;
  flex-direction: row;
  height: 100%;
  justify-content: space-between;
}
.send-img {
  width: 25px;
  height: 20px;
  /* height: 25px; */
  /* height: 70%; */
  /* padding: 10px; */
}
.send-button {
  height: 100%;
  background-color: white;
  border: 1px solid rgb(227, 227, 227);
  padding: 2px;
}

.input-field {
  width: 100%;
  /* height: 100%; */
  border: 1px solid rgb(189, 189, 189);
  padding-left: 15px;
  margin-right: 10px;
}
</style>