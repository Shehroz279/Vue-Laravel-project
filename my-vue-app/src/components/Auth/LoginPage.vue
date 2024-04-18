
<template>
  <div>
    <div class="limiter">
  <div class="container-login100">
    <div class="wrap-login100">
      <form class="login100-form validate-form" @submit.prevent="validateForm">
        <span class="login100-form-title p-b-26">
          Welcome
        </span>
        <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
          <input type="email" v-model="formData.email" @focus="hideValidate('email')" :class="{ 'input100': true, 'has-val': formData.email !== '' }" name="email">
          <span class="focus-input100" data-placeholder="Email"></span>
        </div>

        <div class="wrap-input100 validate-input"  data-validate="Enter password" :class="passwordisEmpty ? 'alert-validate' : ''">
          <span class="btn-show-pass" @click="togglePasswordVisibility">
            <i :class="!showPass ? 'zmdi zmdi-eye' : 'zmdi zmdi-eye-off'"></i>
          </span>
          <input :class="{ 'input100': true, 'has-val': formData.password !== '' }" :type="showPass ? 'text' : 'password'" v-model="formData.password">
          <span class="focus-input100" data-placeholder="Password"></span>
        </div>
        <div class="p-10">
          <!-- <span class="txt1">Don’t have an account?</span> -->
          <router-link class="reset" to="verification">Forgot your password</router-link>
        </div>
        <div class="container-login100-form-btn">
          <div class="wrap-login100-form-btn">
            <div class="login100-form-bgbtn"></div>
            <button class="login100-form-btn" type="submit">Login</button>
          </div>
          
        </div>
       


        <div class="text-center p-t-115">
          <span class="txt1">Don’t have an account?</span>
          <router-link class="txt2" to="register">Sign Up</router-link>
        </div>
      </form>
    </div>
  </div>
</div>


<div id="dropDownSelect1"></div>
  </div>
</template>

<script>

// import axios from 'axios';
// import router from '@/router';
import { LoginApi } from '@/API/Auth'
import { useUserStore } from '@/store/useUser'; // Import your Pinia store

//   
// import { storeToRefs } from 'pinia';
export default {
  name:'LoginPage',
  data() {
      return {
        formData:{  
            email:"",
            password:"",
            name:null,
            UserLogIn:false,
            // userType:'admin',
        },
    passwordisEmpty:false,
    showPass: false,
    email: ''
      }
    },
    computed: {
    userStore() {
      return useUserStore(); // Retrieve and return the userStore
    }
    },
    methods: {
       submitRequest() {
      try {
        LoginApi(this.formData)
        .then(response => {
        // Call the fetchData function defined in api.js
        
        const messages=response.data.message;
        const token=response.data.token;
        const name=response.data.user.name;
        console.log("response ",name);
          const userType=response.user.userType;
          this.userStore.login(token,name,userType); //store Login
          const toastTitle='Success!';
          const toastIcon='success';
          this.Toast(messages,toastTitle,toastIcon);
          this.$router.push('/');
        

      }). catch (error =>{
        var errorMessage='';
          console.log('Error: ' + error);
          const errorData = error.response.data.error;
          if(typeof errorData !== "string"){
            const errorMessages = Object.values(errorData).flatMap(messageArray => messageArray[0]);
           errorMessage = errorMessages.join(', ');
          }
          else{
          errorMessage = errorData;
          }
          const toastTitle='Error!';
          const toastIcon='error';
          this.Toast(errorMessage,toastTitle,toastIcon);
        // Handle any errors that occurred during the API request
        console.error('Error:', error);
      })
    }
    catch(error){
      console.log(error);
    }
  }
    ,
  validateForm() {
    this.formData.password==="" ? this.passwordisEmpty=true : this.passwordisEmpty=false;
    if (!this.validateEmail(this.formData.email)) {
      this.showValidate('email');
    }
    else {
      console.log('Email:', this.formData.email);
      console.log('Password:', this.formData.password);
      if(this.passwordisEmpty===false){
        this.submitRequest();
      }
    }
  },
  validateEmail(email) {
    return /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email);
  },
  showValidate(fieldName) {
    const input = document.querySelector(`[name="${fieldName}"]`);
    input.parentElement.classList.add('alert-validate');
  },
  hideValidate(fieldName) {
    const input = document.querySelector(`[name="${fieldName}"]`);
    input.parentElement.classList.remove('alert-validate');
  },
    togglePasswordVisibility() {
    this.showPass = !this.showPass;
  },
    Toast(errorMessages,toastTitle,toastIcon) {
          this.$swal({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            icon: toastIcon, // Use 'error' icon for error notifications
            title: toastTitle,
            text: errorMessages,
          });
        }
    },
};
</script>


<style scoped>
 .form{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
        }
        td{
            padding: 8px;
        }
</style>

