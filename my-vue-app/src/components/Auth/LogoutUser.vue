
<script>
import { LogoutApi } from '@/API/Auth';
import { useUserStore } from '@/store/useUser';
import router from '@/router';

export default {
    name:'LogoutUser',
    mounted() {
    this.submitRequest(); 
    // Call the submitRequest method when the component is mounted
  },

  computed: {
    userStore() {
      return useUserStore();
    }
  },
    methods: {
      async submitRequest(){  
          try {
            await LogoutApi()
            .then(response => {
            // Call the fetchData function defined in api.js
              const message=response.message;
              const toastTitle='Success!';
              const toastIcon='success';
              this.Toast(message,toastTitle,toastIcon);
              console.log("hello");
              this.userStore.logout()//logout from Store
              router.push('login');

      }). catch (error =>{
        const errorData = error.response.data.message;
          console.log(errorData);
          const toastTitle='Error!';
          const toastIcon='error';
          this.Toast(errorData,toastTitle,toastIcon);
          router.push('/');
      })
    }
    catch(error){
      console.log(error);
    }  
      
    },
    Toast(Messages,toastTitle,toastIcon) {
          this.$swal({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            icon: toastIcon, // Use 'error' icon for error notifications
            title: toastTitle,
            text: Messages,
          });
        }
    },
};
// submitRequest();
</script>
