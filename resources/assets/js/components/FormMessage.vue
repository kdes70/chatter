<template>
    <div class="row reply">
        <div class="col-sm-1 col-xs-1 reply-emojis">
            <i class="fa fa-smile-o fa-2x"></i>
        </div>
        <div class="col-sm-10 col-xs-9 reply-main">
            <textarea class="form-control"
                      rows="1"
                      placeholder="Start typing your message..."
                      v-model="messageText"
                      @keyup.enter="sendMessage">
            </textarea>
        </div>
        <!-- <div class="col-sm-1 col-xs-1 reply-recording">
             <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
         </div>-->
        <div class="col-sm-1 col-xs-1 reply-send" @click="sendMessage">
            <i class="fa fa-send fa-2x" aria-hidden="true"></i>
        </div>
    </div>
</template>

<script>
    export default {
        name: "form-message",
        data() {
            return {
                messageText: ''
            }
        },
        methods: {
            sendMessage(type) {
                this.$emit('send', {message: this.messageText,});
                this.messageText = '';
            },
        },
    }
</script>

<style scoped>

</style>