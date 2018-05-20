<template>

    <div class="conversation">
        <!--heading-->
        <div class="row heading">
            <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                <div class="heading-avatar-icon">
                    <img :src="avatarUrl()" alt="">
                </div>
            </div>
            <div class="col-sm-8 col-xs-7 heading-name">
                <a class="heading-name-meta"> {{ getUser().username }}</a>
                <span class="heading-online">Online</span>
            </div>
            <div class="col-sm-1 col-xs-1  heading-dot pull-right">
                <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
            </div>
        </div>

        <div class="row message" id="conversation">
            <!--message-previous-->
            <div class="row message-previous">
                <div class="col-sm-12 previous">
                    <!--onclick="previous(this)"-->
                    <a :id="conversation_id" name="20">
                        Show Previous Message!
                    </a>
                </div>
            </div>

            <!--item-messages-->
            <div class="row message-body">
                <item-messages v-if="chat" v-for="(item, index) in chat.messages"
                               :key=index
                               :message=item.message
                               :created_at=item.created_at
                               :sender_user_id=item.sender_user_id
                               :current_user=getUser().id
                >
                </item-messages>
            </div>

        </div>

        <div class="row reply">
            <div class="col-sm-1 col-xs-1 reply-emojis">
                <i class="fa fa-smile-o fa-2x"></i>
            </div>
            <div class="col-sm-10 col-xs-9 reply-main">
                <input type="hidden" v-model="conversation_id">
                <textarea class="form-control" rows="1"
                          v-model="message"
                          @keyup.enter="send">
            </textarea>
            </div>
            <!-- <div class="col-sm-1 col-xs-1 reply-recording">
                 <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
             </div>-->
            <div v-if="is_senf" class="col-sm-1 col-xs-1">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
            </div>
            <div v-else class="col-sm-1 col-xs-1 reply-send" @click="send">
                <i class="fa fa-send fa-2x" aria-hidden="true"></i>
            </div>
        </div>
    </div>

</template>


<script>

    import ItemMessages from "./ItemMessages"

    Vue.use(require('vue-chat-scroll'));

    export default {

        props: {
            current_user: {
                type: Object,
                required: true
            },
            conversation_id:{
                type: Number,
                required: true
            }
        },

        data() {
            return {
                chat: {
                    channel_name: '',
                    messages: [],
                    user: {},
                    conversation_id: '',
                },
                message: '',
                is_senf:false,
            }
        },
        components: {
            ItemMessages
        },
        computed: {
            channel() {
                return window.Echo.private('chat-room-'+  this.conversation_id )
            }
        },
        created() {

            this.getMessages(this.conversation_id);

            this.channel.listen('\\Kdes70\\Chatter\\Events\\NewConversationMessage', ({message}) => {

                this.chat.messages.push(message);
                console.log('created listen', message);
                console.log('created listen channel',this.channel);
                // this.addMessage(data);
            });

            console.log( this.channel);
        },
        methods: {

            getMessages: function (conversation_id) {

                axios.get('/messages/' + conversation_id)
                    .then(response => {
                        if (response.status === 200) {
                            this.chat = response.data.data;
                        }
                    })
                    .catch(function (error) {
                        console.log('error getMessages', error); // run if we have error
                    });
            },

            send() {
                if (this.message.length !== 0) {

                    this.is_senf=true;

                    axios.post('/messages/chat/send', {
                        message: this.message,
                        conversation_id: this.conversation_id,
                        receiver_id: this.chat.user.id
                    })
                        .then(response => {

                            // console.log('send', response);

                            this.chat.messages.push(response.data.data);

                            this.message = '';
                            this.is_senf=false;
                            // scroll to bottom after new message added
                            this.$nextTick(() => {
                                this.scrollToEnd();
                            })
                        })
                        .catch(error => {
                            console.log('error send', error);
                        });
                }
            },

            scrollToEnd() {
                let container = document.querySelector("#conversation");
                container.scrollTop = container.scrollHeight;
            },
            avatarUrl() {
                let avatar = this.getUser().profile.avatar;
                return (avatar !== 'no_avatar.jpg') ? '/storage/avatar/' + avatar : '/img/' + avatar;
            },

            getTime() {
                let time = new Date();
                return time.getHours() + ':' + time.getMinutes();
            },

            getUser() {
                return this.current_user;
            },

            check(id) {
                return id === this.getUser;
            },

            isConversationId(id)
            {
                return this.conversation_id == id
            }

        },
        updated() {

            this.scrollToEnd();

        },
        mounted() {
            console.log('Component Chat mounted.');

        }
    }
</script>

<style lang="scss">
    @import '../../../sass/variables.scss';
    @import '../../../sass/components/chat.scss';
</style>