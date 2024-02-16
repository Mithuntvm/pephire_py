<script setup>
import ChatMessage from "./components/ChatMessage.vue";
import ChatInput from "./components/ChatInput.vue";
import ChatHeader from "./components/ChatHeader.vue";
import {onMounted, onUpdated} from 'vue'
// import { ref } from 'vue'


//hlooo


defineProps({
  messages: Object,
  addMessage: Function,
  toggle: Function,
  name: String,
});

const scrollTopFunc = () => {
  var element = document.getElementById("whatsapp-content-main");
  element.scrollTop = element.scrollHeight;
}

onMounted(() => {
  scrollTopFunc()
})

onUpdated(() => {
  scrollTopFunc()
})
// defineProps({
//   msg: String
// })

// const count = ref(0)
</script>

<template>
  <div class="whatsapp-container">
    <div class="whatsapp-header">
      <ChatHeader :toggle="toggle" :title="name" />
    </div>
    <div id="whatsapp-content-main" class="whatsapp-content">
      <ChatMessage
        v-for="(msg, index) in messages"
        :msg="msg.message"
        :floatRight="msg.type == `right`"
        :key="index"
      />
      <!-- <ChatMessage msg="Hello there!" />
      <ChatMessage msg="Hey!" :floatRight="true" /> -->
    </div>
    <div class="whatsapp-input">
      <ChatInput :addMessage="addMessage" />
    </div>
  </div>
</template>

<style scoped>
.whatsapp-input {
  width: 100%;
  height: 60px;
  padding: 10px;
  box-sizing: border-box;
   background: #efe7dd
    url("https://cloud.githubusercontent.com/assets/398893/15136779/4e765036-1639-11e6-9201-67e728e86f39.jpg")
    repeat;
  background-color: rgb(231, 252, 227);
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
  
}
.whatsapp-content {
  width: 100%;
  height: 100%;
  padding: 10px;
  box-sizing: border-box;
   background: #efe7dd
    url("https://cloud.githubusercontent.com/assets/398893/15136779/4e765036-1639-11e6-9201-67e728e86f39.jpg")
    repeat;
  background-color: rgb(231, 252, 227);
  overflow-y: scroll;
  overflow-x: hidden;

  
}

.whatsapp-header {
  width: 100%;
  height: 70px;
  padding: 10px;
  box-sizing: border-box;
  background-color: #005e54;
  border-top-left-radius: 20px;
  border-top-right-radius: 20px;
}
.relative {
  display: relative;
}

.whatsapp-container {
  width: 400px;
  height: 480px;
  display: flex;
  background-color: white;
  box-sizing: border-box;
  flex-direction: column;
}
</style>
