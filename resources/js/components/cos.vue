<template>
    <div>
        <v-row>
            <v-col>
                <div id=""></div>
                <div id="jj">
               <v-card  style="padding:50px" light>
                  <v-card-text >
                        <v-card  elevation="7" light>
                    <v-card-title primary-title>
                        Invoice No.{{hh.invoice}}
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" sm="6">
                                customer
                                <br>
                                <br>Name    :{{hh.cos.name}}
                                <br>Email   :{{hh.cos.email}}
                                <br>Address :{{hh.cos.address}}
                                <br>Phone   :{{hh.cos.phone}}
                            </v-col>
                            <v-col cols="12" sm="6">
                                <br>Employe
                               <br>
                              <br>  Employe :{{hh.usr.name}}
                              <br>  Email   :{{hh.usr.email}}
                            </v-col>


                        </v-row>
                        <v-simple-table dense>
                            <template v-slot:default>
                                <thead>
                                    <tr>
                                        <th class="text-left">Product</th>
                                        <th class="text-left">Category</th>
                                        <th class="text-left">Qty</th>
                                        <th class="text-left">Price</th>
                                        <th class="text-left">total Price</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="n in carts" :key="n.id">
                                        <td> {{n.prod[0].name}}</td>
                                         <td>{{n.prod[0].category.name}}</td>
                                          <td> {{n.qty}} </td>
                                          <td> {{n.prod[0].price}} </td>
                                          <td> {{n.price}} </td>
                                    </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                        <h3 style="margin:50px">Total {{gg}}</h3>
                    </v-card-text>

                </v-card>
                  </v-card-text>
               </v-card>
               </div>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-card>
                    <v-card-actions>
                       <v-spacer></v-spacer>
                       <v-btn @click="printDiv()" icon><v-icon>mdi-printer</v-icon></v-btn>
                       <v-btn @click="done()" color="error">Order Done</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
import jsPDF from 'jspdf'
import Ax from 'axios'
export default {
    data:()=>({
        carts:[],
        gg:'',
        hh:[]
    }),
    created() {
        this.dat()
        Ax.get('/api/hh').then((resp)=>{
            this.hh=resp.data
        }).catch((err)=>{
            alert(err.response)
        })
    },
    methods: {
         dat(){
            Ax.get('api/cart').then((res)=>{
                this.carts=res.data;
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
          printDiv(){
              window.print()
          },
           done(){
              Ax.post('api/done').then((resp)=>{
                  allert('success');
              }).catch((err)=>{
                  console.log(err)
                  alert('error')
              })
          }
    },
}
</script>
