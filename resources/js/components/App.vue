<template>
    <router-view></router-view>
</template>

<script>

import {mapActions, mapGetters} from 'vuex';

export default {
    name: 'app',
    computed: {
        ...mapGetters(['getUser', 'getInitiated']),
    },
    data: function() {
        return {
        }
    },
    beforeMount() {

    },
    mounted() {
        // console.log('App is mounted');
        this.Init().then(result => {
            // console.log(this.getUser);
        
            if(this.getUser === null) {
                this.$router.push('/Login');
            } else {
                // console.log('go to home');
                this.$router.push('/Home');
            }
        });
    },
    methods: {
        ...mapActions(['Init'])
    }
}
</script>
<style scoped>

</style>