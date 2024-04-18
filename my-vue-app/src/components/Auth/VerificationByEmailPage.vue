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
<template>
    <div>
    <div class="limiter">
  <div class="container-login100">
    <div class="wrap-login100">
      <form class="login100-form validate-form" @submit.prevent="validateForm">
        <span class="login100-form-title p-b-26">
          Verification
        </span>
        <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
          <input type="email" v-model="formData.email" @focus="hideValidate('email')" :class="{ 'input100': true, 'has-val': formData.email !== '' }" name="email">
          <span class="focus-input100" data-placeholder="Email"></span>
        </div>

        
        <div class="container-login100-form-btn">
          <div class="wrap-login100-form-btn">
            <div class="login100-form-bgbtn"></div>
            <button class="login100-form-btn" type="submit">Submit</button>
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

import router from '@/router';
import axios from 'axios';
import { useUserStore } from '@/store/useUser';

export default {
    name:'VerificationByEmailPage',
  data() {
      return {
        formData:{
            email:'',
        },
      post: {},
      
      }
    },
    computed:{
      userStore(){
        return useUserStore();
      }
    },
    methods: {
      validateForm() {
    if (!this.validateEmail(this.formData.email)) {
      this.showValidate('email');
    }
    else {
      console.log('Email:', this.formData.email);
      // console.log('Password:', this.formData.password);
      // if(this.passwordisEmpty===false){
        this.submitRequest();
      // }
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
       submitRequest(){    
         axios.post('/verificationByEmail', this.formData,  {
            headers: {
              "content-type": "text/json",
            },
          })
        .then(response => {
          const verifiedToken=response.data.token;
          this.userStore.verificationToken(verifiedToken);
          console.log(response.data.message);
          const messages=response.data.message;
          const toastTitle='Success!';
          const toastIcon='success';
          this.Toast(messages,toastTitle,toastIcon);
          router.push('resetPassword')
        })
        .catch(error => {
          console.log('Error: ' + error);
          const errorData = error.response.data.error;
          console.log(errorData);
          const toastTitle='Error!';
          const toastIcon='error';
          this.Toast(errorData,toastTitle,toastIcon);
      });
     
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