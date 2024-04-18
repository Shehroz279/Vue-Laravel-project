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
        <div class="wrap-input100 validate-input" data-validate="Enter OTP"
              :class="otpIsEmpty ? 'alert-validate' : '' ">
              <input type="text" v-model="formData.otp" 
                :class="{ 'input100': true, 'has-val': formData.otp !== '' }" name="otp">
              <span class="focus-input100" data-placeholder="OTP"></span>
        </div>

        <div class="container-login100-form-btn">
          <div class="wrap-login100-form-btn">
            <div class="login100-form-bgbtn"></div>
            <button class="login100-form-btn" type="submit">submit</button>
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
    name:'TokenVerifiedPage',
  data() {
      return {
        formData:{
            otp:'',
        },
        otpIsEmpty:false,
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
    this.formData.otp==="" ? this.otpIsEmpty=true : this.otpIsEmpty=false;
    if(this.otpIsEmpty===false){
      this.submitRequest();
    }
      },
       submitRequest(){    
        const verificationToken=this.userStore.verifiedToken;
         axios.post('/tokenVerfied', this.formData,  {
            headers: {
              "content-type": "text/json",
              'Authorization': 'Bearer ' + verificationToken
            },
          })
        .then(response => {
          // var message=response.data.message;
          console.log(response.data.message);
          const messages=response.data.message;
          const token=response.data.token;
          const userType=response.data.user.userType;
          const name=response.data.user.name;

          this.userStore.login(token,name,userType);
          this.userStore.verificationToken('');
          const toastTitle='Success!';
          const toastIcon='success';
          this.Toast(messages,toastTitle,toastIcon);
          router.push('/')
        })
        .catch(error => {
          console.log('Error: ' + error);
          const errorData = error.response.data.error;
          console.log(errorData);
          // const errorMessages = Object.values(errorData).flatMap(messageArray => messageArray[0]);
          // console.log(errorMessages);
          // const errorMessage = errorMessages.join(', ');
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