<template>
  <div id="app">
    <modal></modal>
    <img class="img" alt="Vue logo" src="https://brauliomateus.com/logo.png">
    <!-- <Principal/> -->
    <!-- <nav> -->
    <!-- <router-link to="/leaderboards"> LeaderBoards </router-link> -->
    <!-- </nav> -->
    <transition mode="out-in">
      <router-view></router-view>
    </transition>
    
    <!-- <Leader/> -->
  </div>
</template>

<script>
// import Principal from './components/Principal.vue'
import Modal from './components/Modal.vue'

export default {
  name: 'App',
  components: {
    // Principal,
    Modal,
  },
  mounted() {
    // this.checkData();
    // this.setData();
    //  document.getElementById('b-modal').click();
  },
  methods: {
    checkData() {
      if (localStorage.getItem('modalFAQGAME')) {   
        return;
      } else {
        document.getElementById('b-modal').click();
        localStorage.setItem('modalFAQGAME','false');
      }
    },

    setData() {
      localStorage.setItem('modalFAQGAME','false');
    }
    
  },

}
</script>

<style>
body, h1, p, span {
  font-family: Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 10px;
}
.img {
  width: 130px;
}

@media (max-width: 426px)
{
  .img {
    width: 90px;
  }
}

.v-enter, .v-leave-to {
  opacity: 0;
}

.v-enter-active, .v-leave-active {
  transition: all 0.5s;
} 
</style>
