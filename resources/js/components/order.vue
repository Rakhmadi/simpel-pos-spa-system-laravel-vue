<template>
    <div>
        <v-row align="center" justify="center">
            <v-col cols="12" sm="6">
                  <v-card>
                <v-card-title primary-title>
                    Find Costomer  or Create
                </v-card-title>
                <v-card-text>

                    <v-form>
                        <v-text-field
                        label="Email"
                        name="name"
                        type="email"
                        v-model="em"
                    ></v-text-field>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="order()" color="primary">Order</v-btn>
                    <v-btn @click="cs()" color="primary">Add Cs</v-btn>
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
        gg:'',
        em:''
    }),
    created() {

    },
    methods: {
        order(){
            var tokens =localStorage.getItem("token");
            Ax.post(`api/addorder/`,{
                token:tokens,
                email_cos:this.em
            }).then((resp)=>{
                this.gg=resp.data
                console.log(resp.data)
                this.$router.push({path:'/inv'})
            }).catch((err)=>{
                console.log(err.response)
                if (err.response.data.msg == 'email') {
                    this.$router.push({path:'/costumer'})
                } else {
                     this.$router.push({path:'/costumer'})
                }
            })
        },
        cs(){

        }
    },
}
</script>
