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
                        <input id="searchText" type="text" class="form-control" name="searchText"
                               placeholder="Search">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div>
            </div>

            <div class="sideBar">

                <div v-for="user in conversations_user">
                    <div class="row sideBar-body" v-on:click="currentConversation(user)">

                        <div class="col-sm-3 col-xs-3 sideBar-avatar">
                            <div class="avatar-icon">
                                <img v-if="user.avatar" :src="user.avatar" alt="">
                                <img v-else src="https://bootdey.com/img/Content/avatar/avatar1.png">
                            </div>
                        </div>
                        <div class="col-sm-9 col-xs-9 sideBar-main">
                            <div class="row">
                                <div class="col-sm-8 col-xs-8 sideBar-name">
                                    <span class="name-meta">{{user.username}}</span>
                                </div>
                                <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                                    <span class="time-meta pull-right">18:18</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      <!--  <div class="chat-side&#45;&#45;two">
            <div class="row newMessage-heading">
                <div class="row newMessage-main">
                    <div class="col-sm-2 col-xs-2 newMessage-back">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </div>
                    <div class="col-sm-10 col-xs-10 newMessage-title">
                        New Chat
                    </div>
                </div>
            </div>

            <div class="row composeBox">
                <div class="col-sm-12 composeBox-inner">
                    <div class="form-group has-feedback">
                        <input id="composeText" type="text" class="form-control" name="searchText"
                               placeholder="Search People">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div>
            </div>

            <div class="row compose-sideBar">
                <div class="row sideBar-body">
                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                        <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png">
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-name">
                   <span class="name-meta">John Doe
                 </span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                   <span class="time-meta pull-right">18:18
                 </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row sideBar-body">
                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                        <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar2.png">
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-name">
                   <span class="name-meta">John Doe
                 </span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                   <span class="time-meta pull-right">18:18
                 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row sideBar-body">
                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                        <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar3.png">
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-name">
                   <span class="name-meta">John Doe
                 </span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                   <span class="time-meta pull-right">18:18
                 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row sideBar-body">
                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                        <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar4.png">
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-name">
                   <span class="name-meta">John Doe
                 </span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                   <span class="time-meta pull-right">18:18
                 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row sideBar-body">
                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                        <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar5.png">
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-name">
                   <span class="name-meta">John Doe
                 </span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                   <span class="time-meta pull-right">18:18
                 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row sideBar-body">
                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                        <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar6.png">
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-name">
                   <span class="name-meta">John Doe
                 </span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                   <span class="time-meta pull-right">18:18
                 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row sideBar-body">
                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                        <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar2.png">
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-name">
                   <span class="name-meta">John Doe
                 </span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                   <span class="time-meta pull-right">18:18
                 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row sideBar-body">
                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                        <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar3.png">
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-name">
                   <span class="name-meta">John Doe
                 </span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                   <span class="time-meta pull-right">18:18
                 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row sideBar-body">
                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                        <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar4.png">
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-name">
                   <span class="name-meta">John Doe
                 </span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                   <span class="time-meta pull-right">18:18
                 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row sideBar-body">
                    <div class="col-sm-3 col-xs-3 sideBar-avatar">
                        <div class="avatar-icon">
                            <img src="https://bootdey.com/img/Content/avatar/avatar5.png">
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-9 sideBar-main">
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 sideBar-name">
                   <span class="name-meta">John Doe
                 </span>
                            </div>
                            <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
                   <span class="time-meta pull-right">18:18
                 </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
</template>

<script>
    export default {
        name: "conversations",
        props: ['conversations'],
        data() {
            return {
                conversations_user: [],
                current: [],
            }
        },
        ready: function () {
            this.created();
        },
        created() {
            this.conversations_user = this.conversations.user
            // axios.get('/message/conversations')
            //     .then(response => {
            //         this.conversations_user = response.data.data; //we are putting data into our posts array
            //     })
            //     .catch(function (error) {
            //         console.log(error); // run if we have error
            //     });
        },
        methods: {
            currentConversation(user) {
                this.current = user;
                this.$emit('messages', {conversation_id: user.conversation_id, receiver: user})
            }
        }
    }
</script>

<style scoped>

</style>