<template>
    <div>
    <v-row no-gutters>
      <v-col
        cols="12"
        sm="3"
      >
        <v-card
         style="
        margin:10px
       background: rgb(111,134,214);
background: linear-gradient(137deg, rgba(111,134,214,1) 0%, rgba(80,167,194,1) 97%);"
           class="pa-2"

        >
        <v-list-item>
             <v-list-item-content>
        <v-list-item-title >Employe</v-list-item-title>
        <v-list-item-subtitle style="font-size:40px;color:white;">{{datas.usr}}</v-list-item-subtitle>
      </v-list-item-content>
        </v-list-item>
        </v-card>
      </v-col>
       <v-col
        cols="12"
        sm="3"
      >
        <v-card
         style="
        margin:10px
        background: rgb(102,126,234);
background: linear-gradient(137deg, rgba(102,126,234,1) 0%, rgba(118,75,162,1) 97%);"
                  class="pa-2"
        >
        <v-list-item>
             <v-list-item-content>
        <v-list-item-title >Customer</v-list-item-title>
        <v-list-item-subtitle style="font-size:40px;color:white;">{{datas.cos}}</v-list-item-subtitle>
      </v-list-item-content>
        </v-list-item>
        </v-card>
      </v-col>
       <v-col
        cols="12"
        sm="3"
      >
        <v-card
         style="
        margin:10px
        background: rgb(255,175,189);
background: linear-gradient(137deg, rgba(255,175,189,1) 0%, rgba(118,75,162,1) 97%);"
                  class="pa-2"
        >
        <v-list-item>
             <v-list-item-content>
        <v-list-item-title >Product</v-list-item-title>
        <v-list-item-subtitle style="font-size:40px;color:white;">{{datas.product}}</v-list-item-subtitle>
      </v-list-item-content>
        </v-list-item>
        </v-card>
      </v-col>
       <v-col
        cols="12"
        sm="3"
      >
        <v-card
         style="
        margin:10px
        background: rgb(183,248,219);
background: linear-gradient(137deg, rgba(183,248,219,1) 0%, rgba(80,167,194,1) 97%);"
                  class="pa-2"
        >
        <v-list-item>
             <v-list-item-content>
        <v-list-item-title >Cart</v-list-item-title>
        <v-list-item-subtitle style="font-size:40px;color:white;">{{datas.cart}}</v-list-item-subtitle>
      </v-list-item-content>
        </v-list-item>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
        <v-col cols="12" sm="12">
            <v-card>
                <v-card-title primary-title>
                    title
                </v-card-title>
                <v-card-text>
                     <canvas id="my-chart" height="100vh" />
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
    </div>
</template>
<script>
import Chart from 'chart.js';
import Ax from 'axios'
export default {
    data:()=>({
        datas:[],
        labels:[],
        datable:[]

    }),
    mounted() {
        Ax.get('api/ch').then((resp)=>{
            this.labels=resp.data.map(list=>{
                return list.date

            })
            console.log(this.labels)
            this.datable=resp.data.map(list=>{
                return list.totals
            })
             console.log(this.labels)
           new Chart(document.getElementById('my-chart'), {
  type: 'line',
  data: {
    labels:this.labels,
    datasets: [
      {
        label: 'Order',
        data: this.datable,
         backgroundColor:'#6D3AD2',
         borderColor: '#6D3AD2'
      }
    ]
  }
});

        })


          var y =localStorage.getItem("token")
     Ax.get(`api/h?api_token=${y}`).then((resp)=>{
         console.log('loged')
     }).catch((err)=>{
         alert('notloged')
         this.$router.push({ name: 'login' })
     })
      Ax.get('api/dash').then((resp)=>{
            console.log(resp.data)
            this.datas=resp.data
        }).catch((err)=>{
            alert(err)
        })
    },
}
</script>
