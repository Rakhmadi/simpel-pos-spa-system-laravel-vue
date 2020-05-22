<template>
    <div>
        <v-row align="center" justify="center">
            <v-card dark style="width:400px">
            <v-card-title primary-title>
                login
            </v-card-title>
            <v-card-text>
  <v-form>

                    <v-text-field solo label="label" placeholder="Yourname" v-model="n" :value="n"></v-text-field>
                     <v-text-field solo type="password" placeholder="password" v-model="userPassword"></v-text-field>
  </v-form>


            </v-card-text>
            <v-card-actions>
                <v-btn @click="login()" color="primary">Login</v-btn>
            </v-card-actions>
        </v-card>
        </v-row>

    </div>
</template>
<!-- PasswordChange.vue -->
<script>
import Ax from 'axios'
  export default {
    data: () => ({
      userPassword: "",

      n:'',
      r:''
    }),methods: {
       login(){
            var t=this
           Ax.post('api/login',{
               name:t.n,
               password:t.userPassword
           }).then((resp)=>{
               console.log(resp.data)
               localStorage.setItem("token",resp.data.token);
               this.$router.push({ name: 'homedashboard' })
           })}
    },
  };
</script>
