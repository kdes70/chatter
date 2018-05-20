<template>
    <div class="col-sm-4 chat-side">
        <div class="chat-side--one">
            <div class="row heading">
                <div class="col-sm-8 col-xs-3 heading-avatar">
                    <div class="heading-avatar-icon">
                        <img v-if="current.avatar" :src="current.avatar">
                        <img v-else src="https://bootdey.com/img/Content/avatar/avatar1.png">
                        <span class="name-meta">{{current.username}}</span>
                    </div>
                </div>
                <div class="col-sm-1 col-xs-1  heading-dot  pull-right">
                    <i class="fa fa-ellipsis-v fa-2x  pull-right" aria-hidden="true"></i>
                </div>
                <div class="col-sm-2 col-xs-2 heading-compose  pull-right">
                    <i class="fa fa-comments fa-2x  pull-right" aria-hidden="true"></i>
                </div>
            </div>

            <div class="row searchBox">
                <div class="col-sm-12 searchBox-inner">
                    <div class="form-group has-feedback">
                        <input id="searchText"
                               type="text"
                               class="form-control"
                               v-model="searchText"
                               placeholder="Search">
                        <!--<span class="glyphicon glyphicon-search form-control-feedback"></span>-->
                    </div>
                </div>
            </div>

            <div class="sideBar">
                <scroll-bar classes="my-scrollbar" ref="Scrollbar">
                    <div class="scroll-me">
                        <div v-for="conversation in conversations_user">
                            <a v-bind:href="conversation.conversation_link">
                                <div class="row sideBar-body"
                                     @click="currentConversation(conversation.user)">

                                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                                        <div class="avatar-icon">
                                            <img v-if="conversation.user.avatar" :src="conversation.user.avatar" alt="">
                                            <img v-else src="https://bootdey.com/img/Content/avatar/avatar1.png">
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-xs-9 sideBar-main">
                                        <div class="row">
                                            <div class="col-sm-8 col-xs-8 sideBar-name">
                                                <span class="name-meta">{{conversation.user.username}}</span>
                                                <span v-if="conversation.message != null" class="dialog-preview">{{conversation.message.message}}</span>
                                            </div>
                                            <div v-if="conversation.message != null"
                                                 class="col-sm-4 col-xs-4 pull-right sideBar-time">
                                                <span class="time-meta pull-right">{{conversation.message.created_at}}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                </scroll-bar>
            </div>
        </div>
    </div>
</template>

<script>

    import ScrollBar from 'vue2-scrollbar' // https://github.com/BosNaufal/vue2-scrollbar

    export default {
        name: "conversations",
        data() {
            return {
                searchText: '',
                conversations_user: '',
                current: [],
            }
        },
        ready: function () {
            this.created();
        },
        components: {
            ScrollBar
        },
        created() {

            axios.get('/messages/conversations/list')
                .then(response => {
                    this.conversations_user = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {
            currentConversation(user) {
                this.current = user;
                // this.$emit('allMessages', {conversation_id: conversation_id, receiver: user})
            },

            getConversationUrl(conversation_id) {
                return '/messages/conversation/' + conversation_id;
            },

            getTimeMessage() {
                return this.conversation.message.created_at ? this.conversation.message.created_at : '';
            }
        },
        mounted() {
            console.log('conversations mounted');
        }
    }
</script>

<style scoped>
    /*The Wrapper*/
    .my-scrollbar {
        width: 35%;
        min-width: 300px;
        max-height: 500px;
    }

    /*The Content*/
    .scroll-me {
        min-width: 450px;
    }
</style>