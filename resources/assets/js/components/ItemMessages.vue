<template>
    <div class="col-sm-12" :class="className(sender_user_id)">
        <div :class="isType(sender_user_id)">
            <div class="message-text">
                {{message}}
            </div>
            <span class="message-time pull-right">{{created_at}}</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "item-messages",
        props: ['message', 'created_at', 'sender_user_id', 'current_user'],

        methods: {
            className(type) {
                return 'message-main-' + this.isType(type);
            },

            isType(sender) {
                return (sender === this.current_user) ? 'sender' : 'receiver';
            },
        }
    }
</script>

<style scoped>

</style>