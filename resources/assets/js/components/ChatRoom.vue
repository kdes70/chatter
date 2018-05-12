<template>

    <div class="row chat-one">

        <conversations
                v-on:allMessages="getMessages">
        </conversations>

        <div class="col-sm-8">
            <div class="conversation" v-if="conversation_id !== 0">

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

                    <div class="row message-previous">
                        <div class="col-sm-12 previous">
                            <!--onclick="previous(this)"-->
                            <a :id="conversation_id" name="20">
                                Show Previous Message!
                            </a>
                        </div>
                    </div>

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
                    <div class="col-sm-1 col-xs-1 reply-send" @click.prevent="send">
                        <i class="fa fa-send fa-2x" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <p v-else class="text-center">Пожалуйста, выберите диалог или создайте новый</p>
        </div>
    </div>


</template>


<script>

    import Conversations from "./Conversations"
    import ItemMessages from "./ItemMessages"

    Vue.use(require('vue-chat-scroll'));

    export default {

        props: {
            current_user: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                chat: {
                    channel_name: '',
                    messages: '',
                    user: '',
                    conversation_id: '',
                },
                // channel_name: '',
                conversation_id: 0,
                // receiver_id: '',
                // sender_id: '',
                message: '',
                // numberOfUsers: '',

                // typing: '',
            }
        },
        components: {
            Conversations,
            ItemMessages
        },
        // watch: {
        //     // message() {
        //     //     Echo.private('chat')
        //     //         .whisper('typing', {
        //     //             name: this.form.message
        //     //         });
        //     // }
        // },

        computed: {
            channel() {
                return window.Echo.private(this.chat.channel_name)
            }
        },

        created() {
            if (this.chat.channel_name) {
                this.channel.listen('\\Kdes70\\Chatter\\Events\\NewConversationMessage', (chat) => {
                    this.addMessage(chat)
                })
            }
        },
        methods: {

            addMessage(chat) {

                console.log('addMessage', chat);

                this.chat.push(
                    {
                        messages: {
                            message: chat.message,
                            created_at: chat.created_at,
                            sender_user_id: chat.sender,

                        },
                    }
                );

                this.message = '';
                // scroll to bottom after new message added
                this.$nextTick(() => {
                    this.scrollToEnd();
                })
            },

            getMessages: function (conversation) {

                this.conversation_id = conversation.conversation_id;

                axios.get('/messages/chat/' + conversation.conversation_id)
                    .then(response => {
                        if (response.status === 200) {
                            this.chat = response.data.data;
                        }
                    })
                    .catch(function (error) {
                        console.log('error getMessages', error); // run if we have error
                    });

                //TODO event
                if (this.chat.channel_name) {
                    this.channel.listen('\\Kdes70\\Chatter\\Events\\NewConversationMessage', (chat) => {
                        console.log('listen', chat); // run if we have error
                        this.addMessage(chat)
                    })
                }

                // .listenForWhisper('typing', (e) => {
                //     if (e.name != '') {
                //         this.typing = 'typing...'
                //     } else {
                //         this.typing = ''
                //     }
                // })
            },

            send() {
                if (this.message.length !== 0) {

                    axios.post('/messages/chat/send', {
                        message: this.message,
                        conversation_id: this.conversation_id,
                        receiver_id: this.chat.user.id
                    })
                        .then(response => this.addMessage(response.data))
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

            // getConversationId(id)
            // {
            //     return this.conversation_id === id ? this.conversation_id : id
            // }

            // messages: function (id) {
            //     axios.get('/getMessages/' + id)
            //         .then(response => {
            //             console.log(response.data); // show if success
            //             app.singleMsgs = response.data; //we are putting data into our posts array
            //             app.conID = response.data[0].conversation_id
            //         })
            //         .catch(function (error) {
            //             console.log(error); // run if we have error
            //         });
            // },

        },
        updated() {

            //  console.log(this.chat.messeges);

            this.scrollToEnd();

            // this.conversation_id = this.conversation_id;

            // window.Echo.join(this.chat.channel_name)
            //     .here((users) => {
            //         console.log('here', users);
            //         // this.numberOfUsers = users.length;
            //     })
            //     .joining((user) => {
            //         // this.numberOfUsers += 1;
            //         // console.log(user);
            //         console.log('joining', user);
            //         //  this.$toaster.success(user.name + ' is joined the chat room');
            //     })
            //     .leaving((user) => {
            //         console.log('leaving', user);
            //         // this.numberOfUsers -= 1;
            //         //this.$toaster.warning(user.name + ' is leaved the chat room');
            //     });
            //console.log('updated',this.conversation_id);
        },
        mounted() {


            console.log('Component Chat mounted.');

            // if(this.chat.channel_name)
            // {
            //     this.channel.listen('\\Kdes70\\Chatter\\Events\\NewConversationMessage', (chat) => {
            //
            //         this.addMessage(chat)
            //     })
            // }

            //  this.getOldMessages();

            //console.log(this.user.id);
            //  console.log('ChatMessages.' + this.conversation_id);


        }
    }
</script>

<style lang="scss">
    @import '../../../sass/variables.scss';
    @import '../../../sass/components/chat.scss';
</style>