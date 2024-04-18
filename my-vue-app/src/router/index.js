import Vue from 'vue';
import VueRouter from 'vue-router';
import LoginPage from '@/components/Auth/LoginPage.vue';
import RegisterPage from '@/components/Auth/RegisterPage.vue';
import TokenVerifiedPage from '@/components/Auth/TokenVerifiedPage.vue';
import VerificationByEmailPage from '@/components/Auth/VerificationByEmailPage.vue';
import ResetPasswordPage from '@/components/Auth/ResetPasswordPage.vue';
import LogoutUser from '@/components/Auth/LogoutUser.vue';
import HomePage from '@/views/pages/HomePage.vue';
import ProductPage from '@/views/pages/ProductPage.vue';
import CategoryPage from '@/views/pages/CategoryPage.vue';
import UserPage from '@/views/pages/UserPage.vue';
import NotFoundPage from '@/components/NotFoundPage.vue';
import CategoryListPage from '@/views/pages/CategoryListPage.vue';
import SpecificCategoryProducts from '@/views/pages/SpecificCategoryProducts.vue';
import { useUserStore } from '@/store/useUser'; // Import your Pinia store

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    name: 'login',
    component: LoginPage,
    meta:{requireAuth:false}
  },
  {
    path:"/register",
    name: 'register',
    component: RegisterPage,
    meta:{requireAuth:false}
   },
   {
    path:"/tokenVerified",
    name: 'tokenVerified',
    component: TokenVerifiedPage,
    meta:{requireAuth:false}
   },
   {
    path:"/verification",
    name: 'verification',
    component: VerificationByEmailPage,
    meta:{requireAuth:false}
   },
   {
    path:"/resetPassword",
    name: 'resetPassword',
    component: ResetPasswordPage,
    meta:{
      requireAuth:false
    }
   },
   {
    path:"/logout",
    name: 'logout',
    component: LogoutUser,
    meta:{
      requireAuth:true,
      userType:["productOwn","admin","categoryOwn"]
    }
   },
 
   {
    path:"/",
    name: 'home',
    component: HomePage,
    meta:{
      requireAuth:true,
      userType:["productOwn","admin","categoryOwn"]
    }
   },
   {
    path:"/product",
    name: 'product',
    component: ProductPage,
    meta:{
      requireAuth:true,
      userType:["productOwn","admin"]
    }
   },
   {
    path:"/category",
    name: 'category',
    component: CategoryPage,
    meta:{
      requireAuth:true,
      userType:["categoryOwn","admin"]
    }
   },

   {
    path:"/category-list",
    name: 'categoryList',
    component: CategoryListPage,
    meta:{
      requireAuth:true,
      userType:["admin"]
    }
   },
   {
    path:"/category/:categoryId",
    name: 'categoryProducts',
    component: SpecificCategoryProducts,
    meta:{
      requireAuth:true,
      userType:["admin"]
    }
   },
   {
    path:"/user",
    name: 'user',
    component: UserPage,
    meta:{
      requireAuth:true,
      userType:["admin"]
    }
   },
   {
    path:"*",
    name: 'NotFound',
    component: NotFoundPage,
    
   }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes:routes
})
router.beforeEach((to, from, next) => {
  const user = useUserStore(); // Access the store instance

  //  guest
  if (to.meta.requireAuth && !user.isLogin ) {
    // If user is not logged in and trying to access protected pages, redirect to login
    next({ name: 'login' });
  }
else if(((to.meta.requireAuth && user.isLogin) &&  !to.meta.userType.includes(user.type)) || (!to.meta.requireAuth && user.isLogin) )
  {
    next({name:'home'});
  } 
  else{
      next();
  }
  

    console.log("user type login ",(to.meta.requireAuth && user.isLogin) && !to.meta.userType.includes(user.type));
    console.log("userstore type login ",user.type);

console.log("userstore login ",user.isLogin);

console.log("userstore name ",user.name);

console.log("userstore token ",user.token);
console.log("userstore type ",user.type);
console.log("userstore ",JSON.parse(localStorage.getItem('user')));
});


export default router
