import axios from "axios";
import { useUserStore } from "@/store/useUser";
// import { error } from "jquery";
// import { globalEval } from "jquery";


export async function LoginApi(data){
    return await axios.post("/login", data,  {
        headers: {
          "content-type": "text/json",
        },
      });
}

export function LogoutApi(){
    var token=useUserStore().token;
    console.log("token   ",token);
    return axios.post("/logout", {},  {
        headers: {
          "content-type": "text/json",
          "Authorization":"Bearer "+token
        },
      })
    .then(response=>{
        return response.data;
    })
    .catch(error=>{
        throw error;
    })
}
// export function RegisterUserApi(){
//     return axios.post("uel",data)
//     .then(response=>{
//         return response.data;
//     })
//     .catch(error=>{

//     });
// }
