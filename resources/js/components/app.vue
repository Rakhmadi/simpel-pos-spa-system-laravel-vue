<template>
  <v-app id="inspire">

    <v-navigation-drawer
      v-model="drawer"
      app
      clipped
      dark
      color="#363D46"
      id="nav"


    >

      <v-list dense >
        <v-list-item link  to="/">
          <v-list-item-action>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item-content>

        </v-list-item>
         <v-list-item link  to="/cart">
          <v-list-item-action>
            <v-badge color="#FF6363" overlap :content="cartc" :value="cartc" >
                <v-icon>mdi-cart</v-icon>

            </v-badge>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Cart</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

          <v-list-item link  to="/coslist">
          <v-list-item-action>
            <v-icon>mdi-account-multiple</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Customer List</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-list-group>
        <template v-slot:activator>
          <v-list-item-content>
            <v-list-item-title >Product</v-list-item-title>
          </v-list-item-content>
        </template>

        <v-list-item link  to="/createcategory">
          <v-list-item-action>
            <v-icon>mdi-settings</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Category</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link  to="/createproduct">
          <v-list-item-action>
            <v-icon>mdi-settings</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Product</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link  to="/showp">
          <v-list-item-action>
            <v-icon>mdi-settings</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Show Product</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>

        <v-list-item link  to="/logout">
          <v-list-item-action>
            <v-icon>mdi-logout</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item-content>
          </v-list-item>



      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      app
      clipped-left
    src="/images/sv.jpg"
    id="navbar"

    >
     <template v-slot:img="{ props }">
        <v-img
          v-bind="props"
          gradient="to top right, rgba(19,84,122,.5), rgba(128,208,199,.8)"
        ></v-img>
      </template>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>System Point Of Sales   </v-toolbar-title>
      <v-spacer></v-spacer>

  </v-app-bar>

    <v-content  style="
       background-color:#22242A;
    " >
      <v-container
      style="
       background-color:#22242A;
    "


      >

       <router-view></router-view>

      </v-container>
    </v-content>
  </v-app>
</template>

<script>

import Ax from 'axios';
  export default {
    props: {
      source: String,
      nn:String,
    },
    data: () => ({
      drawer: null,
      cartc:''
    }),
    created () {


      this.$vuetify.theme.dark = true
      this.cartcu()
      var t =this
      setInterval(()=>{
          t.cartc=localStorage.getItem("carttotal")
      },1000)
    },methods: {
        cartcu(){
            Ax.get('api/countcart').then((res)=>{
          console.log(res.data)
          if (res.data <= 0) {
              localStorage.setItem("carttotal", "");
          }else{
              localStorage.setItem("carttotal", res.data);
          }

          this.cartc=localStorage.getItem("carttotal")
      })
        }
    },
  }
</script>
