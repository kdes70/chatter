<template>

    <div class="row chat-one">

        <conversations
                v-on:messages="getMessages">
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

                <div class="row message"  id="conversation">

                    <div class="row message-previous">
                        <div class="col-sm-12 previous">
                            <!--onclick="previous(this)"-->
                            <a :id="conversation_id" name="20">
                                Show Previous Message!
                            </a>
                        </div>
                    </div>

                    <div  class="row message-body">
                        <item-messages v-if="chat.messages" v-for="item in chat.messages"
                                       :key=item.index
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
                    <div class="col-sm-1 col-xs-1 reply-send" @click="send">
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

        props: ['current_user'],

        data() {
            return {
                chat: {
                    messages: [],
                    user: [],
                    channel_name: '',
                    conversation_id: '',
                },
                conversation_id: 0,
                receiver_id: '',
                sender_id: '',
                message: '',
                numberOfUsers: '',

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

        },
        methods: {

            addMessage(chat) {
                console.log('listen', chat);
                this.chat.push(chat);
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
                        console.log(error); // run if we have error
                    });

                //TODO event
                // this.channel().listen('ChatSent', (chat) => {
                //     this.addMessage(chat.message)
                // })

                // this.chat.user.push(e.user);
                // this.chat.color.push('warning');
                // this.chat.time.push(this.getTime());

                // axios.post('/message/chat/store', {
                //     chat: this.chat
                // })
                // .then(response => {
                //     console.log(response);
                // })
                // .catch(error => {
                //     console.log(error);
                // });
                // console.log(e);
                //    })
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
                        .then(response => {
                            console.log(response.data.data);

                            // if (response.status === 201) {
                            this.addMessage(response.data.data);
                        })
                        .catch(error => {
                            console.log(error);
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

            console.log(this.chat.messeges);

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

            //  this.getOldMessages();

            //console.log(this.user.id);
            //  console.log('ChatMessages.' + this.conversation_id);


        }
    }
</script>