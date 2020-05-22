<template>
    <div>
        <v-row>
            <v-col>
                <v-card>
                    <v-card-title primary-title>
                        Customer List
                    </v-card-title>
                    <v-card-text>
                        <v-card>
                           <v-card-text>
                               <div v-for="h in datas" :key="h.id">
                                 <br>Name {{h.name}}
                                 <br>Email   {{h.email}}
                                <br>Address {{h.address}}
                                 <br>Phone  {{h.phone}}
                               </div>
                           </v-card-text>
                        </v-card>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>
import Ax from 'axios'
export default {
    data:()=>({
          datas:''
    }),
    mounted(){
        Ax.get('api/coslist/').then((resp)=>{
            this.datas=resp.data
        })
    },
    methods: {

    },
}
</script>
