<style scoped>
button{
    margin: 5px
}
a{
    color: rgb(43, 43, 77);
    text-decoration: none;
}
</style>
<template>
      <div class="container"> 
        <HeaderSection/>
        <h2>Category List Page</h2>
        <b-row class="mb-3">
            <b-col md="12">
                <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Type to Search"></b-form-input>
            </b-col>
            <!-- <b-col md="9">
            </b-col> -->
        </b-row>
        <b-row>
            <b-col>
                <b-table
                striped
                hover
                outlined
                :per-page="perPage"
                :current-page="currentPage"
                :items="categories"
                :fields="fields"
                :filter="filter"
                >
                <template v-slot:cell(actions)="data">
                    <router-link :to="{ path: '/category/' + data.item.id }" >View Products</router-link>
                </template>
                </b-table>
                <b-pagination
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="my-table"
                ></b-pagination>
            </b-col>
        </b-row>
    </div>
</template>
  
<script>

import HeaderSection from '../../components/HeaderSection.vue';
import axios from 'axios';
import { useUserStore } from '@/store/useUser';
 export default {

  name:'CategoryListPage',
    components:{
        HeaderSection
    },
    computed:{
      userStore(){
        return useUserStore();
      },
      rows() {
      return this.categories.length;
    },
    },
  data() {
    return {
      filter: "",
      perPage: 10,
      currentPage: 1,
      fields: ["id", "name","actions"],
      categories:[],
      token : '',
      showAddModal: false,
      showViewModal:false,
      showEditModal:false,
      formData:{
            name:'',
        },
      specificItems:[],
      editItemsData:{
        name:'',
        _method:'put'
      }
    };
  },
  mounted(){
    this.token=this.userStore.token;
    this.GetAllCategory();
  },
  methods: {
    GetAllCategory(){
        // console.log("product token = ",this.token);
            axios.get('/category',{
                headers: {
                "content-type": "text/json",
                'Authorization': 'Bearer ' + this.token
                },
            })
            .then(response => {
                this.categories=response.data.category;

            })
            .catch(error => {
            const errorData = error.response;
            console.log(errorData);
        });
    },
   },
};
</script>
