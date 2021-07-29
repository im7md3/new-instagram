<template>
    <app-layout>
        <div class="grid grid-cols-5 mt-7 gap-4 ">
            <div class="col-start-2 col-span-3 border border-solid border-gray-300 shadow-lg">
                <div class="grid grid-cols-5">
                    <div class="col-span-3">
                        <div class="flex justify-center">
                            <img :src="$page.props.asset + post[0].image" id="postImage" style="max-height: 80vh">
                        </div>
                    </div>
                    <div class="col-span-2 bg-white flex flex-col">
                        <div class="flex flex-row p-3 border-b border-solid border-gray-300 items-center justify-between"
                            id="sec1">
                            <div class="flex flex-row items-center">
                                <img :src="post[0].user.profile_photo_url" :alt="post[0].user.username" srcset=""
                                    class="rounded-full h-10 w-10 mx-3 ">
                                <inertia-link class="font-bold hover:underline"
                                    :href="route('user.profile',post[0].user.username)">{{ post[0].user.username }}
                                </inertia-link>
                            </div>



                            <div v-if="$page.props.permission && $page.props.permission.update_post"
                                class="text-gray-500">
                                <inertia-link :href="route('posts.edit',post)"><i class="fas fa-edit text-blue-500"></i>
                                </inertia-link>
                                <span class="font-bold mx-2">|</span>

                                <button @click="deletePost(post)">
                                    <i class="fa fa-trash text-red-500"></i>
                                </button>

                            </div>


                            <div v-else class="">
                                <follow-button ref="followButtonn" :profile="post[0].user" :isFollowUser="isFollowUser"></follow-button>
                            </div>
                        </div>
                        <div class="border-b border-solid border-gray-300 h-full px-3">
                            <div class="grid grid-cols-5 overflow-y-auto" id="commentArea">
                                <div class="col-span-1 m-3">
                                    <img :src="post[0].user.profile_photo_url" :alt="post[0].user.username"
                                        class="rounded-full h-10 w-10 ">
                                </div>
                                <div class="col-span-4 mt-5 ">
                                    <inertia-link class="font-bold hover:underline"
                                        :href="route('user.profile',post[0].user.username)">
                                        {{ post[0].user.username }} </inertia-link>
                                    <span class="ml-2">{{ post[0].post_caption }}</span>
                                </div>
                            </div>
                            <span class="grid grid-cols-5 overflow-y-auto" v-for="comment in post[0].comments"
                                :key="comment.id">
                                <div class="col-span-1 m-3">
                                    <img :src="comment.user.profile_photo_url" :alt="comment.user.username" srcset=""
                                        class="rounded-full h-10 w-10 ">
                                </div>
                                <div v-if="commentIsEdit==comment.id" class="col-span-3 mt-5 ">
                                    <inertia-link class="font-bold hover:underline"
                                        :href="route('user.profile',comment.user.username)">{{ comment.user.username }}
                                    </inertia-link>
                                    <input class="mt-2 p-1 border border-gray-300" v-model="commentAfterEdit">
                                    <button class="px-2 py-1 m-1 bg-blue-500 text-white text-xs shadow-md"
                                        @click="editComment(comment)">Save</button>
                                </div>
                                <div v-else class="col-span-3 mt-5 ">
                                    <inertia-link class="font-bold hover:underline"
                                        :href="route('user.profile',comment.user.username)">{{ comment.user.username }}
                                    </inertia-link>
                                    <span class="ml-2">{{ comment.comment }}</span>
                                    <div class="text-gray-500 text-xs">{{ comment.created_at }} </div>
                                </div>
                                <div v-if="$page.props.user && commentIsEdit!=comment.id" class="col-span-1 ">
                                    <button v-if="comment.user_id==$page.props.user.id" @click="deleteComment(comment)"
                                        class="text-xs mt-8 m-2 text-red-500 " type="submit">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <button v-if="comment.user_id==$page.props.user.id" @click="setEdit(comment)"
                                        class="text-xs mt-8 m-2 text-blue-500 "><i class="fas fa-edit"></i></button>
                                </div>
                            </span>

                        </div>

                        <div class="flex flex-col border-b border-solid border-gray-300" id="sec3">
                            <div class="flex flex-col items-start  pb-1"> 
                                <like-button :liked="isLikedPost" :post="post[0]" ></like-button>
                                
                                <div class="ml-3 text-xs">
                                    {{ post[0].created_at }}
                                </div>       
                            </div>  
                        </div>

                        <div class="p-4" id="sec4">

                            <add-comment :post="post[0]"></add-comment>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import followButton from '@/Shared/followButton'
    import likeButton from '@/Shared/likeButton'
    import addComment from '@/Shared/addComment'
    export default {
        components: {
            AppLayout,followButton,likeButton,addComment
        },
        props: {
            post: Object,
            isLikedPost: Boolean,
            isFollowUser:Boolean
        },
        data() {
            return {
                isFollow:this.isFollowUser,
                isLiked:this.isLikedPost,
                
                commentIsEdit: null,
                commentAfterEdit: "",
                
            }
        },
        methods: {

            deletePost(post) {
                this.$inertia.delete(route('posts.destroy', post))
            },

            setEdit(comment) {
                this.commentAfterEdit = comment.comment
                this.commentIsEdit = comment.id
            },

            editComment(comment) {
                this.$inertia.put(route('comments.update', comment.id), {
                    _method: 'PUT',
                    comment: this.commentAfterEdit
                }, {
                    preserveScroll: true
                })
                this.commentIsEdit = null
            },

            deleteComment(comment) {
                this.$inertia.delete(route('comments.destroy', comment.id), {
                    preserveScroll: true,
                })
            },


            followUser(){
                if(this.$page.props.user){
                axios.post(route('toggle.follow'),{user_id:this.post[0].user.id}).then(e=>{
                    this.isFollow=e.data.isFollow
                });
                }
            }
        }
    }

</script>
