<script setup>
import { ref, onMounted } from "vue";
import ChatMinimized from "./components/ChatMinimized.vue";
import testJson from "./testData.js";
import useMessages, { sendNewMessage } from "./useMessages";
// This starter template is using Vue 3 <script setup> SFCs
// Check out https://vuejs.org/api/sfc-script-setup.html#script-setup
import WhatsappChat from "./WhatsappChat.vue";

const phoneNumber = window.phoneNumber;
const name = window.name;
console.log(window.phoneNumber, window.name, "hlooooooo");

const [messages, messageRequest] = useMessages(phoneNumber);
console.log("Component Updated");

onMounted(() => {
  const timeout = setInterval(() => {
    messageRequest();
    console.log("Updated");
  }, 10000);
});
const min = ref(true);

const toggle = () => {
  min.value = !min.value;
};

const addNewMessage = (newMessage) => {
  messages.value = [...messages.value, newMessage];
  sendNewMessage(messages, phoneNumber, newMessage.message);
};
</script>


<template>
  <div>
    <ChatMinimized :min="min" :toggle="toggle" />
    <!-- This component will take a conversation object as input -->

    <div class="fixed">
      <div class="relative">
        <WhatsappChat
          v-if="min"
          :name="name"
          :toggle="toggle"
          :messages="messages"
          :addMessage="addNewMessage"
        />
      </div>
    </div>
  </div>
</template>

<style>
.relative {
  display: relative;
}
.fixed {
  z-index: 200;
  position: fixed;
  bottom: 10px;
  right: 10px;
}
</style>
