<style scoped>
dataGroup{
  display: flex;
  justify-content: flex-start;
  align-items: center;
}

.bodyModal{
  flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    display: flex;
  padding: 0px 10px 0px 10px;
}
button{
    margin: 5px
}
  .modal {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .modal-content {
    background-color: #fefefe;
    padding: 20px;
    border-radius: 8px;
    max-width: 450px; /* Set maximum width */
    max-height: 600px; /* Set maximum height */
    width: 100%;
    box-sizing: border-box;
    overflow: auto; /* Enable scrolling if content exceeds max-height */
  }
  
  .close {
    color: #aaa;
    /* float: right; */
    padding-bottom:15px ;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
  }
  .headModal{
    display:flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: flex-start;
  }
  
  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
  }
  
  /* Form Styles */
  .form-group {
    margin-bottom: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
  }
  
  label {
    display: block;
  }
  input,select
  {
    width: 100%;
    padding: 0.5rem;
    margin-top: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  
</style>
<template>
      <div class="container"> 
        <HeaderSection/>
        <h2>User Page</h2>
        <b-row class="mb-3">
            <b-col md="12">
                <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Type to Search"></b-form-input>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-table
                striped
                hover
                outlined
                :per-page="perPage"
                :current-page="currentPage"
                :items="users"
                :fields="fields"
                :filter="filter"
                >
                
                <template v-slot:cell(actions)="data">
                    <b-button variant="warning" @click="ViewItem(data.item.id)">View</b-button>
                    <b-button variant="primary" @click="editItem(data.item.id)">Edit</b-button>
                    <b-button variant="danger" @click="deleteItem(data.item.id)">Delete</b-button>
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
        <div class="modal" v-show="showViewModal">
            <div class="modal-content">
                <div class="headModal">
                    <h3>User Details</h3>
                    <span class="close" @click="showViewModal = false">&times;</span>
                </div>
                <data class="bodyModal">
                  <div class="dataGroup">
                    <p>ID: {{specificItems.id}}</p>
                    
                </div>
                <div class="dataGroup">
                    <p>Name: {{specificItems.name}}</p>
                </div>
                <div class="dataGroup">
                    <p>Email : {{specificItems.email}}</p>
                </div> 
                <div class="dataGroup">
                    <p>User Type: {{specificItems.userType}}</p>
                </div> 
            </data>
        </div>
        </div>
        <div class="modal" v-show="showEditModal">
            <div class="modal-content">
                <div class="headModal">
                    <h3>User Details</h3>
                    <span class="close" @click="showEditModal = false">&times;</span>
                </div>
            <form @submit.prevent="updateItem">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" v-model="editItemsData.name">
                </div>
                <div class="form-group">
                    <label for="name">Email:</label>
                    <input type="email" id="email" v-model="editItemsData.email">
                </div>
                <div class="form-group">
                    <label for="name">UserType:</label>
                    <select name="userType" id="userType" v-model="editItemsData.userType">
                      <option value="productOwn">Product Owner</option>
                      <option value="categoryOwn">Category Owner</option>
                    </select>
                </div>
                
                <b-button variant="success" type="submit" >Update</b-button>
            </form>
        </div>
        </div>
    </div>
</template>
  
<script>

import HeaderSection from '../../components/HeaderSection.vue';
  import axios from 'axios';
import { useUserStore } from '@/store/useUser';
 export default {

    name:'UserPage',
    components:{
        HeaderSection
    },
  data() {
    return {
      filter: "",
      perPage: 10,
      currentPage: 1,
      fields: ["id", "name","email", "userType","actions"],
      users: [],
      specificItems:[],
      token : '',
      showAddModal: false,
      showViewModal:false,
      showEditModal:false,
      editItemsData:{}
    };
  },
  computed: {
    rows() {
      return this.users.length;
    },
    userStore(){
      return useUserStore();
    }
  },
  mounted(){
    this.token=this.userStore.token;
    this.GetAllUser();
  },
  methods: {
    GetAllUser(){   
            // console.log("product token = ",this.token);
            axios.get('/user',{
                headers: {
                "content-type": "text/json",
                'Authorization': 'Bearer ' + this.token
                },
            })
            .then(response => {
                console.log(response.data);
                this.users=response.data.user;
            })
            .catch(error => {
                const errorData = error.response;
                console.log(errorData);
        });
    },
    getSpecificItem(id) {
        return new Promise((resolve, reject) => {
          axios.get('/user/' + id, {
              headers: {
                "content-type": "text/json",
                'Authorization': 'Bearer ' + this.token,
              },
            })
            .then(response => {
              if (response.status === 200) {
                // Resolve the promise with the data
      
                resolve(response.data.user);
              } else {
                // Reject the promise if the response status is not 200
                reject('Error: Unexpected status code ' + response.status);
              }
            })
            .catch(error => {
              // Reject the promise with the error
              reject('Error: ' + error);
                    });
        });
      },
      ViewItem(id){
      this.getSpecificItem(id)
        .then(users => {
          this.specificItems=users;
          this.showViewModal=true;
        })
        .catch(error => {
          console.log(error);
        });

    },
    editItem(id){
      this.getSpecificItem(id)
        .then(users => {
          this.editItemsData=users;
          this.showEditModal=true;
        })
        .catch(error => {
          console.log(error);
        });
    },
    updateItem() {
      const id=this.editItemsData.id;
      const name=this.editItemsData.name;
      const email=this.editItemsData.email;
      const userType=this.editItemsData.userType;
          axios.put('/user/'+id,
          {
         'name':name,
         'email':email,
         'userType':userType
        }, 
          {
                headers: {
                  "content-type": "text/json",
                  'Authorization': 'Bearer ' + this.token,
                },
              
          }).then(response => {
            if(response.status == 200){
            console.log(response.data.message);
            this.showEditModal = false;
            this.GetAllUser();
            const messages=response.data.message;
            const toastTitle='Success!';
            const toastIcon='success';
            this.Toast(messages,toastTitle,toastIcon);
            }
          })
          .catch(error => {
            console.log(error);
          const errorData = error.response.data.error;
          const errorMessages = Object.values(errorData).flatMap(messageArray => messageArray[0]);
          console.log(errorMessages);
          const errorMessage = errorMessages.join(', ');
          const toastTitle='Error!';
          const toastIcon='error';
          this.Toast(errorMessage,toastTitle,toastIcon);
          });
    },
    deleteItem(id){
      console.clear();
      console.log(id);
      axios.delete('/user/'+id,  {
            headers: {
              "content-type": "text/json",
              'Authorization': 'Bearer ' + this.token
            },
          })
        .then(response => {
          if(response.status == 200){
            console.log(response.data.message);
            this.GetAllUser();
            const messages=response.data.message;
            const toastTitle='Success!';
            const toastIcon='success';
            this.Toast(messages,toastTitle,toastIcon);
          }
        })
        .catch(error => {
          console.log('Error: ' + error);
          const errorData = error.response.data.error;
          console.log(errorData);
        //   const errorMessages = Object.values(errorData).flatMap(messageArray => messageArray[0]);
        //   console.log(errorMessages);
        //   const errorMessage = errorMessages.join(', ');
          const toastTitle='Error!';
          const toastIcon='error';
          this.Toast(errorData,toastTitle,toastIcon);
      });
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
</script>
