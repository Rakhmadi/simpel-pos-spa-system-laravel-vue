<template>
    <div>
        <v-row>
            <v-col cols="12" sm="12">
             <v-card  dark>
                 <v-card-title primary-title>

                 </v-card-title>
                 <v-card-text>
                     <v-form>
                         <v-text-field
                             name="email"
                             label="Email"
                             :rules="required"
                             type="email"
                             v-model="email"
                         ></v-text-field>
                         <v-text-field
                             name="name"
                             label="Name"
                             :rules="required"
                             v-model="name"
                         ></v-text-field>
                         <v-text-field
                             name="Address"
                             label="Address"
                             :rules="required"
                             v-model="address"
                         ></v-text-field>
                         <v-text-field
                             name="Phone"
                             label="Phone"
                             type="number"
                             id="id"
                             :rules="required"
                             v-model="phone"
                         ></v-text-field>
                     </v-form>
                 </v-card-text>
                 <v-card-actions>
                     <v-btn @click="save()" color="primary">Add</v-btn>
                 </v-card-actions>
             </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
import Ax from 'axios'
export default {
   data:()=>({
       email:'',
       name:'',
       address:'',
       phone:'',
       required: [
        v => !!v || 'required',
      ],
   }),
   methods: {
       save(){
           Ax.post('api/addcos',{
               email:this.email,
               name:this.name,
               address:this.address,
               phone:this.phone
           }).then((resp)=>{
               alert('success')
               console.log(resp.data)
               this.$router.push({path:'/order'})
           }).catch((err)=>{
               alert(err)
               console.log(err.response.data,this.name)
               if (err.response.status == 400) {
                   alert('field required')
               }
           })
       }
   },
}
</script>
