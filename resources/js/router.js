import Vue from 'vue'
import Home from './components/home.vue'
import cat from './components/createcategory.vue'
import po from './components/createproduct.vue'
import sp from './components/showp.vue'
import cart from './components/cart.vue'
import login from './components/login.vue'
import cos from './components/cos.vue'
import addcos from './components/addcs.vue'
import vrouter from 'vue-router'
import order from './components/order.vue'
import colist from './components/coslist.vue'
Vue.use(vrouter)
export default new vrouter({

    routes:[
        {
            path:'/',
            name:'homedashboard',
            component:Home,
        },
        {
            path:'/createcategory',
            name:'cat',
            component:cat,
        },{
            path:'/createproduct',
            name:'por',
            component:po
        },{
            path:'/showp',
            name:'sp',
            component:sp
        },{
            path:'/cart',
            name:'cart',
            component:cart,
        },{
            path:'/login',
            name:'login',
            component:login
        },{
            path:'/costumer',
            name:'cos',
            component:addcos,
        },{
            path:'/order',
            name:'order',
            component:order
        },{
            path:'/inv',
            name:'inv',
            component:cos
        }
        ,{
            path:'/coslist',
            name:'colists',
            component:colist
        }
    ]
})
