<style scoped>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
nav {
  padding: 30px;
}
nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
nav a{
  padding: 10px;
}

</style>
<template>
    <div id="app">
        <nav>
            <router-link to="/">Home</router-link> 
            <router-link v-if="userType === 'admin' || userType === 'productOwn'" to="/product">Products</router-link>
            <router-link v-if="userType === 'admin' || userType === 'categoryOwn'" to="/category">Category</router-link>  
            <router-link v-if="userType === 'admin'" to="/user">Users</router-link>  
            <router-link v-if="userType === 'admin'" to="/category-list">CategoryList</router-link>  
            <router-link id="logout" to="/logout">Log Out</router-link>
        </nav>
    </div>
</template>
<script>
import { useUserStore } from '@/store/useUser';
export default {
    name: 'HeaderSection',

    data(){
      return{
        userType:'',
      }
    },
    computed:{
      userStore(){
        return useUserStore();
      }
    },
    mounted(){
      this.userType=this.userStore.type;
    }
}
</script>