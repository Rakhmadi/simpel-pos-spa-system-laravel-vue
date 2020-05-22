<template>
    <div>
        <v-row>
            <v-col>
                <v-card class="pa-7" color="#363D46">
                    <v-card-title class="headline"><v-icon>mdi-cart</v-icon> Cart List  </v-card-title>
                   <v-card-text>

                         <v-card v-for="i in carts" :key="i.id"
        elevation="4"
         color="#363D46"
          style="margin:10px;"
            dark
          >
            <div class="d-flex flex-no-wrap justify-space-between">
              <div>
                <v-card-title class="headline">{{i.prod[0].name}}</v-card-title>
                <v-card-subtitle >{{i.prod[0].category.name}}</v-card-subtitle>
                <v-card-text>
                    Qty {{i.qty}}  Subtotal Rp. {{i.price}}
                </v-card-text>
                <v-card-actions>

                    <v-btn @click="dele(i.id)" icon><v-icon>mdi-delete</v-icon></v-btn>
                </v-card-actions>
              </div>

              <v-avatar
                class="ma-3"
                size="90"

              >
                <v-img  v-bind:src="`/images/${i.prod[0].photo}`"></v-img>
              </v-avatar>
            </div>
          </v-card>
                   </v-card-text>
          <v-card-actions>
              <h3>Total Rp.{{gg}}</h3>
              <v-spacer></v-spacer>
              <v-btn @click="order()" color="primary">Order</v-btn>
          </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

    </div>
</template>
<script>
import Ax from 'axios'
export default {
    props:['n'],
    created() {
     var y =localStorage.getItem("token")
     Ax.get(`api/h?api_token=${y}`).then((resp)=>{
         console.log('loged')
     }).catch((err)=>{
         alert('notloged')
         this.$router.push({ name: 'login' })
     })
    },
    mounted() {
        this.dat()


    },
    data:()=>({
        carts:[],
        gg:'',
        vl:''
    }),

    methods: {
        dat(){
            Ax.get('api/cart').then((res)=>{
                this.carts=res.data;
                this.vl=res.data
                console.log(this.carts)
            }).catch((err)=>{
                alert('err');
            })

            Ax.get('api/totalcart').then((resp)=>{
                this.gg=resp.data
            }).catch((err)=>{
                alert(err)
            })
        },
        dele(id){
            Ax.delete(`api/d_cart/${id}`).then((resp)=>{
                console.log(resp.data)
                 this.dat()
                alert('success')
            }).catch((err)=>{
                console.log(err.response)
                alert('fail')
            })
        }, cartcu(){
            Ax.get('api/countcart').then((res)=>{
          console.log(res.data)
          if (res.data <= 0) {
              localStorage.setItem("carttotal", "");
          }else{
              localStorage.setItem("carttotal", res.data);
          }
      }).catch((err)=>{
          console.log(err)
      })
    },
    order(){
        console.log(this.vl)
         this.$router.push({ path:'/order'})
    }
    }
}
</script>
