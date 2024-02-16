
<script setup>
defineProps({
  title: String,
  toggle: Function
});
</script>

<template>
  <div class="header-container">
    <div class="chat-pic"></div>
    <div class="chat-name">{{ title }}</div>
    <button class="chat-minimize">
      <img @click="toggle" src="../assets/minus.png" alt="minus" />
    </button>
  </div>
</template>

<style scoped>
.header-container {
  display: flex;
  flex-direction: row;
  width: 100%;
  height: 100%;
}
.chat-pic {
  height: 50px;
  width: 50px;
  border-radius: 50%;
  background-color: white;
}
.chat-name {
  display: flex;
  padding: 5%;
  width: 80%;
  color: white;
  flex-direction: row;
  justify-content: start;
  align-items: center;
}
.chat-minimize {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  width: 30px;
  height: 100%;
  background-color: rgba(39, 22, 22, 0);
  border: 0px white;
}
.chat-minimize img {
  height: 55px;
  width: 25px;
}
</style>
