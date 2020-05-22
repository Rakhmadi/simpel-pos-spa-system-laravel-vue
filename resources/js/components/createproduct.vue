<template>
    <div>
     <v-row no-gutters>
      <v-col
       cols="12"
       sm="12"
      >
        <v-card
         style="margin:10px;"
         class="pa-2"
         color="#363D46"
        >
        <v-list-item>
             <v-list-item-content>
        <v-list-item-title ><h2>Create Product</h2></v-list-item-title>

      </v-list-item-content>
        </v-list-item>
        <v-card-text>
              <v-form
    ref="form"
    v-model="valid"
    lazy-validation
  >
   <v-row>
          <v-col cols="12" sm="3">
     <v-text-field
      v-model="code"
      :rules="required"
      label="Code"
      required
    ></v-text-field>
    </v-col>
     <v-col cols="12" sm="3">
     <v-text-field
      v-model="name"

      :rules="required"
      label="Name"
      required
    ></v-text-field>
    </v-col>

     <v-col cols="12" sm="3">
     <v-select
     v-model="category"
      label="category"
      item-value='id'
      item-text="name"
      :rules="required"
     :items="cat">


     </v-select>
    </v-col>
    <v-col cols="12" sm="3">
     <v-text-field
      v-model="discription"
      :counter="10"
      :rules="required"
      label="Discription"
      required
    ></v-text-field>

    </v-col>
    <v-col cols="12">
          <v-subheader class="pl-0">Stock</v-subheader>
        <v-slider
          max="1000"
          v-model="sto"
          :thumb-size="24"
          thumb-label="always"
        >
        <template v-slot:prepend>
          <v-icon

            @click="d"
          >
            mdi-minus
          </v-icon>
        </template>

        <template v-slot:append>
          <v-icon

            @click="i"
          >
            mdi-plus
          </v-icon>
        </template></v-slider>

    </v-col>
    <v-col cols="12" sm="6">
        <v-text-field
        v-model="price"
          label="Amount"
          value="1000"
          prefix="Rp"
          type="number"
        ></v-text-field>
    </v-col>
<v-col cols="12" sm="6">
   <v-file-input

   v-on:change="rrt()"
    id="file"
    name="file"
    :rules="required"
    accept="image/png, image/jpeg, image/bmp"
    placeholder="Image"
    prepend-icon="mdi-camera"
    label="Photo"

  ></v-file-input>
    </v-col>

   </v-row>



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
               </v-row>

    </div>
</template>
<script>
import Ax from 'axios'

export default {
    created() {
          var y =localStorage.getItem("token")
     Ax.get(`api/h?api_token=${y}`).then((resp)=>{
         console.log('loged')
     }).catch((err)=>{
         alert('notloged')
         this.$router.push({ name: 'login' })
     })
    },
    data:()=>({
         required: [
        v => !!v || 'is required',
      ],
      sto:500,
      name:'',
      valid:'',
      cat:[],
      code:'',
      discription:'',
      stock:'',
      price:'',
      ph:null,
      category:'',
      catname:''


    }),
    mounted() {


        Ax.get('/api/r_category').then((res)=>{
            this.cat=res.data
            console.log(res.data)
            }).catch((err)=>{
            console.log(err.response)
            })
    },
    methods: {
        d(){
            this.sto--
        },
        i(){
            this.sto++
        },
         save(){
             var t=this
             const formData = new FormData();
             formData.append('code', this.code);
             formData.append('name', this.name);
             formData.append('discription', this.discription);
             formData.append('stock', this.sto);
             formData.append('price', this.price);
             formData.append('category_id', this.category);
             formData.append('photo', this.ph);
             if (this.$refs.form.validate()) {
              Ax.post('/api/c_product',
             formData
          ,{
               headers: {
                    'Content-Type': 'multipart/form-data'
                }
          }).then(function(res) {
              alert('success')
              console.log(res.data)
              t.r();
          }).catch(function(err) {
               alert('fail')
               console.log(err.response)
          });

         }
        }, rrt(){
        this.ph =  event.target.files[0];
      },
      r(){
          this.$router.push({ name: 'sp' })
      }
    },
}
</script>
