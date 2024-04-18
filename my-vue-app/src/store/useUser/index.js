import {defineStore} from 'pinia';

const userData=JSON.parse(localStorage.getItem('user')) ?? {};
const userVerifiedToken=localStorage.getItem('verifiedToken') ?? {}  ;
export const useUserStore = defineStore('user', {
    state: () => ({ token:userData.token, name: userData.name,type:userData.type,isLogin:userData.login,verifiedToken:userVerifiedToken}),
    getters: {
      getUserLogin: (state) => state.isLogin,
    },
    actions: {
      login(userToken,userName,userType) {
        this.isLogin=true;
        this.token=userToken;
        this.name=userName;
        this.type=userType;
        var userInformation={
          'name':userName,
          'type':userType,
          'token':userToken,
          'login':true
        };
        localStorage.setItem('user',JSON.stringify(userInformation));
      },
      logout(){
        this.token='';
        this.type='';
        this.name='';
        this.isLogin=false;
        var userInformation={
          'name':'',
          'type':'',
          'token':'',
          'login':false
        };
        localStorage.setItem('user',JSON.stringify(userInformation));
      },
      verificationToken(verifiedToken){
        this.verifiedToken=verifiedToken;
        localStorage.setItem("verifiedToken",verifiedToken);
      }
    },
  })