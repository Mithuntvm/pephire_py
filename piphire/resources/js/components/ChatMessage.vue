<template>
  <!-- <div :class="floatRight ? `container-msg container-msg-right` : `container-msg`">
    <div :class="floatRight ? `content-msg content-right` :  `content-msg`">{{ msg }}</div>
  </div> -->


<div :class="floatRight ? `container-msg container-msg-right` : `container-msg`">
    
    <div :class="floatRight ? `content-msg content-right` :  `content-msg`">
    <div v-if="!floatRight" class="msg-name">
      <!-- Name -->
    </div>
    <div class="msg">
      {{ msg }}
    </div>
    <div class="timestamp">
      <!-- 12:04 -->
    </div>
    
    </div>
    <!-- <div >2:46 PM</div> -->

  </div>

</template>




<script setup>
defineProps({
  msg: String,
  floatRight: Boolean,
});
</script>

<!-- <script setup>
defineProps({
  msg: String,
  floatRight: Boolean,
});
</script> -->

<style scoped>
.msg-name{
  color: blue;
font-weight: 500;
}


.timestamp{
  display: flex;
  flex-direction: row;
  justify-content: end;
  font-size: 13px;
  padding-left: 40px;


}


.container-msg {
  width: 100%;
  margin-bottom: 10px;
  height: fit-content;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
}

.container-msg-right{
    justify-content: flex-end;
}
.content-float-right {
  align-items: flex-end;
}


.content-msg {
  width: fit-content;
  max-width: 80%;
  font-size: 14px;
  padding-left: 7px;
  padding-right: 7px;
  padding-top: 5px;
  padding-bottom: 5px;
  min-height: 25px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background-color: #fff;
  border-radius: 10px;
}
.content-right {
    background-color: #d2f5b4;
}

</style>