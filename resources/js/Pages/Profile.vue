<template>
    <app-layout>
        <template #header>
            <header>
                <div class="grid grid-cols-5 gap-4">
                    <div class="col-start-2 col-span-1 flex justify-center  w-auto mt-5">
                        <img class="w-40 h-40 rounded-full" :src="profile.profile_photo_url " :alt="profile.username">
                    </div>
                    <div class="col-start-3 col-span-2 flex justify-start items-center w-auto m-0 ">
                        <div class="grid grid-rows-2   ">
                            <div class="flex flex-row items-center ">
                                <h1 class="font-light text-3xl mr-14">{{ profile.username }}</h1>

                                <span v-if="$page.props.user && $page.props.user.name==profile.name">
                                    <inertia-link :href="route('profile.show')"
                                        class="border border-solid border-gray-300 rounded-md py-0 px-5 mr-16 whitespace-nowrap ">
                                        {{ __('Edit Profile') }}</inertia-link>
                                    <inertia-link href="/posts/create">
                                        <jet-button class="ms-8 leading-none whitespace-nowrap">
                                            {{ __('Add Post') }}
                                        </jet-button>
                                    </inertia-link>
                                </span>

                                <div v-else class="self-center">
                                    <follow-button ref="followButtonn" :profile="profile" :isFollowUser="isFollowUser" @changeFollowers="changeFollowers"></follow-button>
                                </div>
                            </div>
                            <div>
                                <ul class="flex flex-row mb-5">
                                    <li class="mr-10 cursor-pointer"><span class="font-semibold">
                                            {{ profile.posts_count }} </span> {{ __('posts') }}
                                    </li>
                                    <li class="mr-10">
                                        <inertia-link :href="route('show.followers',profile.username)">
                                            <span class="font-semibold">
                                                {{ followers_count }}
                                            </span> {{ __('followers') }}</inertia-link>
                                    </li>
                                    <li class="mr-10">
                                        <inertia-link :href=" route('show.following',profile.username)">
                                            <span class="font-semibold">
                                                {{ follows_count }} 
                                            </span> {{ __('following') }}</inertia-link>
                                    </li>
                                </ul>
                                <p class="mb-1 font-black">{{ profile.name }}</p>
                                <p>{{ profile.bio }}</p>
                                <p class="text-blue-500"><a :href="profile.url">{{ profile.url }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </template>

    <div class="max-w-4xl my-0 mx-auto">
        <hr class="mb-10">
        <!-- @if ($profile->status == "public") -->
        <div v-if="posts.length>0" class="grid grid-cols-3 gap-4 mx-0 mt-0 mb-6">

            <div v-for="post in posts" :key="post.id" class="post">
                <inertia-link  :href="route('posts.show',post)" class="w-full h-full">
                    <img :src="$page.props.asset +post.image" class="w-full h-full object-cover">
                    <div class="post-info">
                        <ul>
                            <li class="inline-block font-semibold mx-7">
                                <span class="absolute h-1 w-1 overflow-hidden">{{__('Likes:')}}</span>
                                <i class="fas fa-heart" aria-hidden="true"></i> {{post.liked_by_users_count}} 
                            </li>
                            <li class="inline-block font-semibold">
                                <span class="absolute h-1 w-1 overflow-hidden">{{__('Comments:')}}</span>
                                <i class="fas fa-comment" aria-hidden="true"></i> {{post.comments_count}}</li>
                        </ul>
                    </div>
                </inertia-link>
            </div>

            <!-- <div class="col-span-3 mt-10">
                {{ posts.links() }}
            </div> -->
        </div>
        
                <div v-else>
                    <h1 class="text-center">{{__('This account is private')}}</h1>  
                    <p class="text-center">{{__('Follow to see their posts')}}</p>   
                </div> 

    </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import jetButton from '@/Jetstream/Button'
    import followButton from '@/Shared/followButton'

    export default {
        components: {
            AppLayout,
            Welcome,
            jetButton,
            followButton
        },
        props: {
            profile: Object,
            posts:Object,
            isFollowUser:Boolean
        },
        data(){
            return{
                follows_count:this.profile.follows_count,
                followers_count:this.profile.followers_count,
            }
        },
        methods:{
            changeFollowers(s){
                this.followers_count=s
            }
        },
    created(){
       /*  console.log(this.$refs.followButtonn); */
    }
    }

</script>
