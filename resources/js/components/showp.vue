<template >
    <div>
        <v-row no-gutters>
            <v-col cols="12" sm="12">
                <v-toolbar color="#363D46">
      <v-text-field
        hide-details

        single-line
      ></v-text-field>

      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

    </v-toolbar>
            </v-col>
        </v-row>
       <v-row>
           <v-col cols="12" sm="3" v-for="item in datas" v-bind:key="item.id">
               <v-card
     class="mx-auto"

         color="#363D46"
  >
    <v-img
      v-bind:src="`/images/${item.photo}`"
      height="200px"
    ></v-img>

    <v-card-title>
      {{item.name}}
    </v-card-title>

    <v-card-subtitle>
      {{item.category.name}}
    </v-card-subtitle>

    <v-card-actions>
       Rp.{{item.price}}


      <v-spacer></v-spacer>

      <v-btn @click.stop="addmodal(item.id),dialog=true" icon>
        <v-icon>mdi-cart</v-icon>
      </v-btn>

      <v-btn @click="dele(item.id)" icon>
        <v-icon>mdi-delete</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>

           </v-col>
       </v-row>



       <v-dialog
      v-model="dialog"
      max-width="290"
    >
      <v-card color="#363D46">
        <v-card-title class="headline"><v-icon>mdi-cart</v-icon> &nbsp; Add To Cart</v-card-title>

        <v-card-text>
          <v-text-field
           label="Qty"
           v-model="qty"
          >
           <v-icon @click="p" slot="append" color="red">mdi-plus</v-icon>
           <v-icon @click="m" slot="prepend" color="green">mdi-minus</v-icon>

          </v-text-field>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="green darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>

          <v-btn
            color="green darken-1"
            text
            @click="addcart(),dialog = false"
          >
          Add
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </div>
</template>
<script>
import Ax from 'axios'
import s from './app'
export default {
    created() {
          var y =localStorage.getItem("token")
        Ax.get(`api/h?api_token=${y}`).then( (resp)=>{
         console.log('loged')
     }).catch((err)=>{
         alert('notloged')
         this.$router.push({ name: 'login' })
     })
    },
    data:()=>({
        datas:[],
        dialog:'',
        qty:1,
        idcart:'',
        cartc:''
    }),
    mounted() {
       this.load()
    },

    methods: {
        dele(id){
            Ax.delete(`/api/d_product/${id}`).then((res)=>{
                console.log(res.data)
                alert('success')
                this.load()
            }).catch((err)=>{
                alert(err.response)
            })
        },
        load(){
             Ax.get('/api/r_product').then((res)=>{
            this.datas=res.data;
            console.log(res.data)
        })
        },
        p(){
            this.qty++
        },
        m(){
           if (this.qty <= 1 ) {
               this.qty=1
           }else{
                this.qty--
           }
        },addcart(){
            Ax.post(`/api/addcart/${this.idcart}`,{
                 qty:this.qty
            }).then((resp)=>{
                console.log(resp.data)
                alert('success');
                this.cartcu()
                this.$router.push({ name: 'cart' })
            }).catch((err)=>{
                console.log(err.response)
                alert('fails')
            })
        },addmodal(id){
            this.idcart=id;
            console.log(this.idcart)
        },
        cartcu(){
            Ax.get('api/countcart').then((res)=>{
          console.log(res.data)
          if (res.data <= 0) {
              localStorage.setItem("carttotal", "");
          }else{
              localStorage.setItem("carttotal", res.data);
          }
      })
    },
    },
}
</script>
