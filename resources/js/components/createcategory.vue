<template>
    <div>
        <v-row no-gutters>
      <v-col cols="12" sm="12">
        <v-card
         color="#363D46"
         style="margin:10px;"
         class="pa-2"
        >
        <v-list-item>
             <v-list-item-content>
        <v-list-item-title ><h2>Create Category</h2></v-list-item-title>


      </v-list-item-content>
        </v-list-item>
        <v-card-text>
              <v-form
    ref="form"
    v-model="valid"
    lazy-validation
  >
    <v-text-field
      v-model="name"
      :counter="10"
      :rules="nameRules"
      label="Category Name"
      required
    ></v-text-field>

    <v-text-field
      v-model="discription"
      :rules="nameRules"
      label="Discription"
      required
    ></v-text-field>

  </v-form>
        </v-card-text>
        <v-card-actions>
            <v-btn
      color="#ff6363"
      @click="save()">
 Save
    </v-btn>
        </v-card-actions>

        </v-card>
      </v-col>
       <v-col
       cols="12"
       sm="12"
      >
        <v-card color="#363D46"

         style="

        margin:10px;
       "
      class="pa-2"


        >
        <v-card-text  color="#363D46">
              <v-simple-table  color="#363D46">
    <template  color="#363D46" v-slot:default>
      <thead>
        <tr>
          <th class="text-left">Category</th>
          <th class="text-left">Description</th>
           <th class="text-left">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in datas" :key="item.id">
          <td>{{ item.name }}</td>
          <td>{{ item.discription }}</td>
          <td>
              <v-btn small v-on:click="del(item.id)"><v-icon small >mdi-delete</v-icon></v-btn>
          </td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
        </v-card-text>

        </v-card>

       </v-col>
    </v-row>

    </div>
</template>
<script>

import Ax from 'axios';
  export default {
    data: () => ({
      valid: true,
      name: '',
      nameRules: [
        v => !!v || 'Name is required',
        v => (v && v.length <= 20) || 'Name must be less than 10 characters',
      ],
      discription: '',
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],

      datas:''
    }),
    created() {
          var y =localStorage.getItem("token")
     Ax.get(`api/h?api_token=${y}`).then((resp)=>{
         console.log('loged')
     }).catch((err)=>{
         alert('notloged')
         this.$router.push({ name: 'login' })
     })

        this.dat()
         setInterval(() => {
            Ax.get('/api/r_category').then((res)=>{
            this.datas=res.data
            console.log(res.data)
            }).catch((err)=>{
            console.log(err.response)
        })
                   }, 25000);
    },
    methods: {
      save(){
          var y=this;

         if (this.$refs.form.validate()) {
              Ax.post('/api/c_category',{

              name:this.name,
              discription:this.discription
          }).then(function(res) {
              alert('success')
              y.dat()
              console.log(res.data)
          }).catch(function(err) {
               alert('fail')
               console.log(err.response)
          })
         }

      },
      del(id){

          Ax.delete(`/api/d_category/${id}`).then((res)=>{
              alert('Success');
              this.dat()
              console.log(res.data);
          }).catch((err)=>{
              alert('Error');
              console.log(err.response)
          })
      },
      dat(){
          Ax.get('/api/r_category').then((res)=>{
            this.datas=res.data
            console.log(res.data)
            }).catch((err)=>{
            console.log(err.response)
             })
      }
    },
  }
</script>
