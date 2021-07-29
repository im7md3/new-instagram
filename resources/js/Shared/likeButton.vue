<template>
    <div class="flex flex-row items-center">
        <button class="text-xl ml-3 focus:outline-none" title="Like" @click="toggleLike">
            <i :class="{'text-red-500':isLiked}" class="far fa-heart"></i>
        </button>
        <button class="text-xl ml-3 focus:outline-none" title="comment" @click="focus()"><i class="far fa-comment "></i></button>
        
        <button class="text-xl ml-3 focus:outline-none" title="Share" @click="share(post.id)" :id="post.id">
            <i class="far fa-share-square"></i>
        </button>
    </div>
        <div class="ml-3 text-sm" v-show="likeCount>0">{{__('Liked by')}} {{likeCount}}</div>
</template>

<script>
    export default {
        props: {
            post: Object,
            liked: Boolean
        },
        data() {
            return {
                isLiked: this.liked,
                likeCount:this.post.liked_by_users_count,
            }
        },
        methods: {
            toggleLike() {
                if (this.$page.props.user) {
                    axios.post(route('toggle.like'), {
                        post_id: this.post.id,
                    }).then(e => {
                        this.isLiked = e.data.isLiked
                        this.likeCount= e.data.likeCount
                    })
                }
            },

            share(id){
                var postlink = document.getElementById(id);
                navigator.clipboard.writeText(window.location.hostname +':8000/posts/'+this.post.id);
                alert("The shareable link: " + window.location.hostname +':8000/posts/'+this.post.id);
            },

            focus(){
                document.getElementById('comment'+this.post.id).focus()
            
        },
        },
    mounted(){
        
    }
        }

</script>
