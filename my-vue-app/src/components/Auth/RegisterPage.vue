<style scoped>
.form {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 500px;
}

td {
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
              Register
            </span>
            <div class="wrap-input100 validate-input" data-validate="Enter Name"
              :class="nameIsEmpty ? 'alert-validate' : '' ">
              <input type="text" v-model="formData.name" 
                :class="{ 'input100': true, 'has-val': formData.name !== '' }" name="name">
              <span class="focus-input100" data-placeholder="Name"></span>
            </div>
            <div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c"
              :class="{ 'alert-validate': emailError }">
              <input type="text" v-model.trim="formData.email" @focus="hideValidate('email')"
                :class="{ 'input100': true, 'has-val': formData.email !== '' }" name="email">
              <span class="focus-input100" data-placeholder="Email"></span>
            </div>

            <div class="wrap-input100 validate-input" data-validate="Enter password"
              :class="passwordisEmpty ? 'alert-validate' : ''">
              <span class="btn-show-pass" @click="togglePasswordVisibility">
                <i :class="!showPass ? 'zmdi zmdi-eye' : 'zmdi zmdi-eye-off'"></i>
              </span>
              <input :class="{ 'input100': true, 'has-val': formData.password !== '' }"
                :type="showPass ? 'text' : 'password'" v-model="formData.password">
              <span class="focus-input100" data-placeholder="Password"></span>
            </div>
            <div class="container-login100-form-btn">
              <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <button class="login100-form-btn" type="submit">Login</button>
              </div>
            </div>

            <div class="text-center p-t-115">
              <span class="txt1">Already have an account?</span>
              <router-link class="txt2" to="login">Log In</router-link>
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
  name: 'RegisterPage',
  data() {
    return {
      formData: {
        name: '',
        email: '',
        password: '',
        userType: 'categoryOwn',
      },  
      passwordisEmpty:false,

      nameIsEmpty:false,
    password: '',
    showPass: false,
    email: ''

    }
  },
  computed: {
    userStore() {
      return useUserStore();
    }
  },
  methods: {
    validateForm() {
    this.formData.password==="" ? this.passwordisEmpty=true : this.passwordisEmpty=false;
    this.formData.name==="" ? this.nameIsEmpty=true : this.nameIsEmpty=false;
    if (!this.validateEmail(this.formData.email)) {
      // this.showValidate('email');
      this.emailError = true;
    }
    else {
      this.emailError = false;
      console.log('Email:', this.formData.email);
      console.log('Password:', this.formData.password);
      if(this.passwordisEmpty===false && this.nameIsEmpty===false){
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
    submitRequest() {
      axios.post('/register', this.formData, {
        headers: {
          "content-type": "text/json",
        },
      })
        .then(response => {
          if (response.status == 200) {
            const verificationToken = response.data.token;
            this.userStore.verificationToken(verificationToken);
            router.push('tokenVerified');
            console.log(response.data.message);
            const messages = response.data.message;
            const toastTitle = 'Success!';
            const toastIcon = 'success';
            this.Toast(messages, toastTitle, toastIcon);
          }
        })
        .catch(error => {
          console.log('Error: ' + error);
          const errorData = error.response.data.error;
          const errorMessages = Object.values(errorData).flatMap(messageArray => messageArray[0]);
          // console.log(errorMessages);
          const errorMessage = errorMessages.join(', ');
          const toastTitle = 'Error!';
          const toastIcon = 'error';
          this.Toast(errorMessage, toastTitle, toastIcon);
        });

    },
    Toast(errorMessages, toastTitle, toastIcon) {
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
