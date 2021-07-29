<template>
    <app-layout>
        <template #header>
        </template>
    <div class="grid grid-cols-12 mt-7 gap-4">
        <div class="col-start-3 col-span-5">
          

            <span v-if="posts.length>0">
                <div v-for="post in posts" :key='post.id' class="flex flex-col border border-solid border-gray-300 mb-14 bg-white">
                    <div class="flex flex-row p-3 border-b border-solid border-gray-300 items-center">
                        <inertia-link :href="route('user.profile',post.user.username)">
                            <img :src="post.user.profile_photo_url" alt="avatar" class="rounded-full h-12 w-12 me-3 ">
                        </inertia-link>   
                        <inertia-link :href="route('user.profile',post.user.username)" class="hover:underline">{{post.user.username}}</inertia-link> 
                    </div>
                    <div>
                        <inertia-link :href="route('posts.show',post.id)"><img class="w-full" :src="$page.props.asset + post.image"> </inertia-link> 
                    </div>
                    <div class="flex flex-row items-center mt-2">
                        <div class="flex flex-col items-start  pb-1"> 
                                <like-button :liked="post.isLiked" :post="post" @toggleLike="toggleLike"></like-button>
                            </div>  
                    </div>
                    <div class="border-b border-solid border-gray-200 px-2 pb-1">
                        <div class="me-7 mb-2">
                            <inertia-link class="font-bold text-base hover:underline"
                                :href="route('user.profile',post.user.username)">{{ post.user.username }} </inertia-link>
                            <span>{{ post.post_caption }}</span> 
                        </div>
                        
                        <div v-for="comment in post.comments" :key="comment.id" class="me-7">
                            <inertia-link class="font-bold hover:underline"
                                :href="route('user.profile',post.user.username)">{{ comment.user.username }} </inertia-link>
                            <span class="ml-2">{{ comment.comment }}</span> 
                        </div>


                        <inertia-link  v-if="post.comments.length>3" class="font-sm text-gray-700"
                        :href="route('posts.show',post.id)">{{__('View all')}} {{post.comments.length}} {{__('comments')}}</inertia-link>

                        <div class="text-gray-500 text-xs">
                            {{ post.created_at }}
                        </div>
                    </div>
                    <div class="p-4">
                        <add-comment :post="post"></add-comment>
                    </div>
                </div>
            </span>

            <div v-else class="m-10">
                <p class="font-semibold">{{__('Start your journey, follow your friends!')}}</p>
            </div>

            <!-- <div class="col-span-3 mt-10">
                {{ $posts->links() }}
            </div> -->
        </div>
        <div class="col-start-8 col-span-3 ms-4">
            <div class="flex flex-row items-center">  
                <inertia-link :href="route('user.profile',profile.username)"><img :src="profile.profile_photo_url" alt="avatar" class="rounded-full h-12 w-12 me-3 "></inertia-link>
                <div class="flex flex-col">
                   <inertia-link :href="route('user.profile',profile.username)" class="text-base hover:underline">{{profile.username}}</inertia-link> 
                    <h3 class="text-sm text-gray-400 ">{{profile.bio}}</h3>
                </div>
            </div>
            
            <h3 class="mt-4 mb-4 text-gray-500 font-semibold">{{__(' People you follow:')}}</h3>
        <span v-if="iFollow.length>0">
            <div v-for="follow in iFollow" :key="follow.id" class="flex flex-col mb-3">
                <div class="flex flex-row justify-between">
                    <div class="flex flex-row ">
                       <inertia-link :href="route('user.profile',follow.username)"><img :src="follow.profile_photo_url" alt="avatar" class="rounded-full h-10 w-10 me-3"></inertia-link> 
                        <div class="flex flex-col self-center">
                           <inertia-link :href="route('user.profile',follow.username)" class="text-base hover:underline">{{follow.username}}</inertia-link>
                            <h3 class="text-sm text-gray-500 truncate" style="max-width: 25ch">{{follow.bio}}</h3>
                        </div>
                    </div>
                    <!-- <follow-button ref="followButtonn" :profile="profile" :isFollowUser="isFollowUser" ></follow-button> -->
                </div>
            </div>
            </span>
            <div v-else class="my-10">
                <p class="font-semibold">{{__('Nothing to show right now!')}}</p>
            </div>


            <h3 class="mt-4 mb-4 text-gray-500 font-semibold"> {{__('People you may like to follow:')}}</h3>
                       

            <span  v-if="toFollow.length>0">
                <div v-for="follow in toFollow" :key="follow.id" class="flex flex-col mb-3">
                <div class="flex flex-row justify-between">
                    <div class="flex flex-row ">
                       <inertia-link :href="route('user.profile',follow.username)"><img :src="follow.profile_photo_url" alt="avatar" class="rounded-full h-10 w-10 me-3"></inertia-link> 
                        <div class="flex flex-col self-center">
                           <inertia-link :href="route('user.profile',follow.username)" class="text-base hover:underline">{{follow.username}}</inertia-link>
                            <h3 class="text-sm text-gray-500 truncate" style="max-width: 25ch">{{follow.bio}}</h3>
                        </div>
                    </div>
                    <!-- <follow-button ref="followButtonn" :profile="profile" :isFollowUser="isFollowUser" ></follow-button> -->
                </div>
            </div>
            </span>

            <div v-else class="my-10">
                <p class="font-semibold">{{__('Nothing to show right now!')}}</p>
            </div>

        </div>
    </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import alert from '@/Shared/alert'
        import followButton from '@/Shared/followButton'
            import likeButton from '@/Shared/likeButton'
             import addComment from '@/Shared/addComment'
    export default {
        components: {
            AppLayout,
            JetButton,
            alert,
            followButton,
            likeButton,
            addComment
        },
        props: {
            profile: Object,
            iFollow: Object,
            toFollow: Object,
            posts:Object
        },
        data() {
            return {
                
            }
        },
        methods: {
            toggleLike(s){
                this.likeCount=s
            },
        }
    }

</script>
