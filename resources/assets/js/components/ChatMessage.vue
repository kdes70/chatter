<template>

</template>

<script>
    export default {
        name: "message",
        props: [
            'color',
            'time'
        ],
        computed:{
            className(){
                return 'item-'+this.color;
            },
        },
        mounted() {
            console.log('Component Messages mounted.')
        }
    }
</script>

<style scoped>

</style>