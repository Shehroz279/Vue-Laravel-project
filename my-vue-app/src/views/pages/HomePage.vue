<style scoped>
div{
    justify-content: center;
    align-items: center;
    flex-direction: column;
    display: flex;
}
</style>
<template>

    <div>
        <HeaderSection/>
        <h2>Home Page</h2>
    </div>
</template>
<script>
// import axios from 'axios';
import HeaderSection from '../../components/HeaderSection.vue';
import { useUserStore } from '@/store/useUser';
export default{
    name:'HomePage',
    components:{
        HeaderSection
    },
    data(){
        return{
        }
    },
    mounted(){
  },
  computed: {
    userStore() {
      return useUserStore(); // Retrieve and return the userStore
    }
    },
  methods: {
}
}

</script>